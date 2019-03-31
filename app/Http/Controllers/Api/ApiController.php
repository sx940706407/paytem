<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Rsa;
use App\Services\XRsa;

use Validator, Config;

use App\Http\Controllers\system\ThridPayController;

use App\Models\Third\ShopModels;
use App\Models\Third\PayInfoModels;
use App\Models\Third\BankInfo;

/**
 * 1.商家使用的API接口，统一下单，查询 ，回调进行封装。
 *
 * 2.可以使用本系统的各第三方支付
 *
 * 3.客户端使用公钥进行加密， 服务器解密， 发回的内容加密。 客户端进行解密。 公共一套公钥。 https证书不使用会被劫掉
 */
class ApiController extends Controller
{
    public $XRsa;

    public function __construct(XRsa $XRsa)
    {
        $this->XRsa = $XRsa;
    }

    /**
     * [payEntry 统一下单 处理订单接口
     * 1.数据首先解密处理,然后验证传进来的参数是否正确字段完整==
     * 2.查找商户信息,生成sign对比传进来的SIGN是否一致。
     * 3.postman 上定文档与自动化测试]
     */
    public function payEntry()
    {
        //1RAS 进行解密操作，返回的内容也需要进行加密处理
        $priveDecrypt = $this->XRsa->privateDecrypt(file_get_contents("php://input"));
        if ( ! is_string($priveDecrypt)) {
            return $this->responseRsa(403);
        }
        $priveDecrypt = json_decode($priveDecrypt, true);
        //1.1 app_id,app_secret,body,call,paymethod(wx,zfb,qq,unionpay),totalfee,third 验证规则
        // 不单独写了不好处理返回 sign 这边是平台验证 notifyurl是存放客户端的回调
        $validator = Validator::make($priveDecrypt, [
            'body'      => 'required',
            'call'      => 'required',
            'paymethod' => 'required',
            'totalfee'  => 'required',
            'third'     => 'required',
            'sign'      => 'required',
            'notifyurl' => 'required',
            'order_id'  => 'required',  //商户订单ID。
            'app_id'    => 'required'  //商户ID用来识别对应的MD5KEY
        ]);
        #传递的参数验证不通过.
        if ($validator->fails()) {
            return $this->responseRsa(12);
        }
        $shop = ShopModels::where('app_id', $priveDecrypt['app_id'])->first();
        #商户信息不存在,直接跳过。 加日志并限制访问次数20，回调可以在参数设置，也可以在后台配置
        if ( ! $shop) {
            return $this->responseRsa(11);
        }

        #2.签名验证 ，与 解密操作，回调也记得json_encode后RAS加密.
        if (verify_sign($priveDecrypt, $shop->app_secret) === false) {
            return $this->responseRsa(10);
        }

        #3.设置回调机制,首次支付成功回调平台，平台回调客户端的URL。 然后按7次调用时间，设置返回success则为成功,返回加密后的数据给客户端进行处理
        return $this->XRsa->privateEncrypt(json_encode(ThridPayController::pay($priveDecrypt)));
    }

    /**
     * [payQuery 统一下单查询  处理接口查询订单]
     *
     * @param  Request $request [description]
     */
    public function payQuery()
    {
        $priveDecrypt = $this->XRsa->privateDecrypt(file_get_contents("php://input"));

        if ( ! is_string($priveDecrypt)) {
            return $this->responseRsa(403);
        }
        $priveDecrypt = json_decode($priveDecrypt, true);
        #第三方渠道指定 与订单号 商户ID。 签名
        $validator = Validator::make($priveDecrypt, [
            'third'    => 'required',
            'sign'     => 'required',
            // 'paymethod'	=> 'required',
            'order_id' => 'required',  //商户订单ID。
            'app_id'   => 'required'  //商户ID用来识别对应的MD5KEY
        ]);

        #传递的参数验证不通过.
        if ($validator->fails()) {
            return $this->responseRsa(12);
        }

        $shop = ShopModels::where('app_id', $priveDecrypt['app_id'])->first();
        #商户信息不存在,直接跳过。 加日志并限制访问次数20，回调可以在参数设置，也可以在后台配置
        if ( ! $shop) {
            return $this->responseRsa(11);
        }

        #2.签名验证 ，与 解密操作，回调也记得json_encode后RAS加密.
        if (verify_sign($priveDecrypt, $shop->app_secret) === false) {
            return $this->responseRsa(10);
        }

        #订单应该是order_id 与本平台关联的订单才能进行第三方的查询
        $PayInfoModels = PayInfoModels::where('pay_shop_id', $shop->id)->where('order_id',
            $priveDecrypt['order_id'])->value('platform_order');

        if ( ! $PayInfoModels) {
            return $this->responseRsa(13);
        }
        $priveDecrypt['order_id'] = $PayInfoModels;

        return $this->XRsa->privateEncrypt(json_encode(ThridPayController::payStatus($priveDecrypt)));
    }

    /**
     * [payBankEntry 统一 代付下单处理， 不做成队列，直接定时处理分钟的情况， HT平台的状态与第三方的状态]
     */
    public function payBankEntry()
    {
        $priveDecrypt = $this->XRsa->privateDecrypt(file_get_contents("php://input"));
        if ( ! is_string($priveDecrypt)) {
            return $this->responseRsa(403);
        }
        $priveDecrypt = json_decode($priveDecrypt, true);
        #第三方渠道指定 与订单号 商户ID。 签名 银行卡信息查询 https://www.apistore.cn/doc/api/43
        $validator = Validator::make($priveDecrypt, [
            'to_acc_name' => 'required',
            'to_acc_no'   => 'required',
            'third'       => 'required',  //现在用的是zhong
            'sign'        => 'required',
            'trans_money' => 'required',  //交易金额单位为元
            'notifyurl'   => 'required', //每5分查询 成功则回调客户的URL 或者客户自己查询
            'order_id'    => 'required',  //商户订单ID。
            'app_id'      => 'required' //商户ID用来识别对应的MD5KEY
        ]);

        // Log::info('zhong---bank-request',['priveDecrypt'=> $priveDecrypt]);
        #传递的参数验证不通过.
        if ($validator->fails()) {
            return $this->responseRsa(12);
        }
        $shop = ShopModels::where('app_id', $priveDecrypt['app_id'])->first();
        #商户信息不存在,直接跳过。 加日志并限制访问次数20，回调可以在参数设置，也可以在后台配置
        if ( ! $shop) {
            return $this->responseRsa(11);
        }
        #检测商户HT平台当前的余额,才可以继续走下一步
        if ($priveDecrypt['trans_money'] * 100 > $shop->money) {
            return $this->responseRsa(14);
        }
        #2.签名验证 ，与 解密操作，回调也记得json_encode后RAS加密.
        if (verify_sign($priveDecrypt, $shop->app_secret) === false) {
            return $this->responseRsa(10);
        }

        return $this->XRsa->privateEncrypt(json_encode(ThridPayController::payBank($priveDecrypt)));
    }

    /**
     * [payBankQuery 银行的代付订单信息 查询]
     */
    public function payBankQuery()
    {
        $priveDecrypt = $this->XRsa->privateDecrypt(file_get_contents("php://input"));
        if ( ! is_string($priveDecrypt)) {
            return $this->responseRsa(403);
        }
        $priveDecrypt = json_decode($priveDecrypt, true);
        #第三方渠道指定 与订单号 商户ID。 签名 
        $validator = Validator::make($priveDecrypt, [
            'third'    => 'required',
            'sign'     => 'required',
            'order_id' => 'required',  //商户订单ID。
            'app_id'   => 'required' //商户ID用来识别对应的MD5KEY
        ]);
        #传递的参数验证不通过.
        if ($validator->fails()) {
            return $this->responseRsa(12);
        }
        $shop = ShopModels::where('app_id', $priveDecrypt['app_id'])->first();
        #商户信息不存在,直接跳过。 加日志并限制访问次数20，回调可以在参数设置，也可以在后台配置
        if ( ! $shop) {
            return $this->responseRsa(11);
        }
        #检测商户HT平台订单编号是否存在
        $BankInfo = BankInfo::where('platform_order', $priveDecrypt['order_id'])->value('platform_order');
        if ( ! $BankInfo) {
            return $this->responseRsa(15);
        }
        #2.签名验证 ，与 解密操作，回调也记得json_encode后RAS加密.
        if (verify_sign($priveDecrypt, $shop->app_secret) === false) {
            return $this->responseRsa(10);
        }

        return $this->XRsa->privateEncrypt(json_encode(ThridPayController::payBankStatus($priveDecrypt)));
    }

    /**
     * [直接返回本商户平台的钱数  money单位为分 返回balance appid description]
     */
    public function merchanQueryBalance()
    {
        $response = Config::get('error.200');

        $priveDecrypt = $this->XRsa->privateDecrypt(file_get_contents("php://input"));
        if ( ! is_string($priveDecrypt)) {
            return $this->responseRsa(403);
        }
        $priveDecrypt = json_decode($priveDecrypt, true);
        #第三方渠道指定 与订单号 商户ID。 签名 
        $validator = Validator::make($priveDecrypt, [
            'app_id' => 'required' //商户ID用来识别对应的MD5KEY
        ]);
        #传递的参数验证不通过.
        if ($validator->fails()) {
            return $this->responseRsa(12);
        }
        $shop = ShopModels::where('app_id', $priveDecrypt['app_id'])->first();
        #商户信息不存在,直接跳过。 加日志并限制访问次数20，回调可以在参数设置，也可以在后台配置
        if ( ! $shop) {
            return $this->responseRsa(11);
        }
        #2.签名验证 ，与 解密操作，回调也记得json_encode后RAS加密.
        if (verify_sign($priveDecrypt, $shop->app_secret) === false) {
            return $this->responseRsa(10);
        }

        $response['stateData']['balance'] = $shop->money;
        $response['stateData']['app_id']  = $priveDecrypt['app_id'];

        // Log::info('shop========>',['shop' => $shop,'priveDecrypt'=> $priveDecrypt]);
        return $this->XRsa->privateEncrypt(json_encode($response));
    }

    /**
     * [notifyUrl 请求统一下单，商家发送的接口。 按一定的规则进行调用]
     *
     * 1。商户需要对此通知做出响应，当收到商户返回“success”的应答时，酷模支付才会认为通知成功，否则认为失败，会按一定的策略（1m,1m,5m,10m,1h,6h,12h）重新发起通知。
     *
     * 2. 请求的方式为POST，传输的格式为JSON。 请留意。
     *
     * 3. 首次支付成功情况下，直接调用
     *
     * @param  Request $request [description]
     *
     */
    public function notifyUrl(Request $request)
    {

    }

    public function responseRsa($number)
    {
        return Rsa::privEncrypt(json_encode(Config::get("error.$number")));;
    }

    //增加虚拟币的支付入口处理
    public function payEntryVirtual()
    {
        $priveDecrypt = $this->XRsa->privateDecrypt(file_get_contents("php://input"));
        if ( ! is_string($priveDecrypt)) {
            return $this->responseRsa(403);
        }
        $priveDecrypt = json_decode($priveDecrypt, true);
        $validator    = Validator::make($priveDecrypt, [
            'body'      => 'required',
            'call'      => 'required',
            'paymethod' => 'required',
            'totalfee'  => 'required',
            'user_id'   => 'required',
            'sign'      => 'required',
            'notifyurl' => 'required',
            'order_id'  => 'required',  //商户订单ID。
            'app_id'    => 'required'  //商户ID用来识别对应的MD5KEY
        ]);
        #传递的参数验证不通过.
        if ($validator->fails()) {
            return $this->responseRsa(12);
        }
        $shop = ShopModels::where('app_id', $priveDecrypt['app_id'])->first();
        #商户信息不存在,直接跳过。 加日志并限制访问次数20，回调可以在参数设置，也可以在后台配置
        if ( ! $shop) {
            return $this->responseRsa(11);
        }
        #2.签名验证 ，与 解密操作，回调也记得json_encode后RAS加密.
        if (verify_sign($priveDecrypt, $shop->app_secret) === false) {
            return $this->responseRsa(10);
        }

        #3.设置回调机制,首次支付成功回调平台，平台回调客户端的URL。 然后按7次调用时间，设置返回success则为成功,返回加密后的数据给客户端进行处理
        return $this->XRsa->privateEncrypt(json_encode(ThridPayController::pay($priveDecrypt)));
    }

}
