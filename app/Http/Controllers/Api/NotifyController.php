<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pay\Channel\UnityDispose;
use App\Models\Third\PayInfoModels;
use App\Models\Third\BankInfo;

use Log;
use DB;
use Config;
use App\Models\virtual\VirtualCurrencyUser;
use App\Models\virtual\VirtualCurrencyUserBuy;
use App\Services\Virtualcurrency;

class NotifyController extends Controller
{
    public $public_key='-----BEGIN PUBLIC KEY-----
    MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmbMRYdd3Ob2c2FRdU04Pm0FGOxpCjAuJSM53FRryIuQMD4u54eALtHsDaOJ7sqpnEUT9vggsPoEXb5LEOYhWeaofeYvgOpYZIHYdgGA51zF6JevedcvV/YMeb3rXTuaZKpuiOS8rRfpJ3k5OmXy7G2oyjiv20jLzB5E+HvRtStu3PHpxPKUmMwqbVkWLI5sWhLQqps8UVvgMGf+mEL5UTLlZbJevB5x+au3lNDRdbfUCQ2Bf+1mhYkjeMtb/qTR2X+tONyvmNL0m78r27+r+RFBQuKCWkI20fPSi4bT7BDtshYoqC83K6IFMTDZoJ5n6yoq3mja0tvYiKu+fDN7ILwIDAQAB
-----END PUBLIC KEY-----';

    protected $priavte_key='-----BEGIN RSA PRIVATE KEY-----
MIIEogIBAAKCAQB1NSNQjrM/ZRD7YdptvKkk0iOGQ29saMeMbkNyYRmM4bCpsJDj
U7ecUN9dFfzN4P1C0XeSP9RY+kTYH5edd15zh8NEEx953fpZxb6BZq/2pu6s4z8c
B1jGiHe4euPz27GzLX206XOg74B0LSqXGNsaVOKC3EAL6SBAfpr3uy5NGNyJVVWM
l5gIv2nn1urxhEFdBALfB88Iaqbk3L46l8KqShD59Zv1BfcHd5Jyf8N3+JhiRf4x
imsClhFg22FUoKBZuUl6Vl5Eqf2MXpUl1jyIXrctx+oc/RmbcnXp6Srze80bc0cl
XNjp9psR2G96DnlHNxnuYXcNPL9DIlFUIAL/AgMBAAECggEAb/4XQVkpAzEx+dF1
Yhe70xgLo7X52K+BxLhzL+6B+HCKWooA14Zd0jogQ5TH23zY4ii+RPtCjsaMU6pU
N70gfenCdeCD2fF1zqO5NXIGPvsg4ge9fK20cPdi1d5uw8svT5LvI5dRyfwvVFL3
+Cpi6RUk3n9Pn1HhZF7U+lNbmYQVn3X1BKpAqKHEUSo8OqAKGcjL9IYiqmOAQe2y
OsEEw5WJCGavwZzYgjHnnHvkjsZtyIIZei8eMFyi8fxev/pFd93QO4fEwh+kthpx
fGpqWVuO9L3BdFVvvWKrfKhAQZgGpK3vxCcPq04Fdz6vV3Mc9oRE26z7bwaBPE3G
4UI+0QKBgQC0cqNO7P23OxJcfJbh401uAMlErND89yqVDl2mIzPVVLIrtLGxImkT
PowtiPPFG6rxQ/sXfTQBNCK1gu1/kz3W5IHQ35RgP/ncJi9W526hawTpCyiol6r1
l1TzWcQCuqnYosh0K/1aYYZIyv71NcZCldnEDOBYVP9f+CPcyioJmQKBgQCmSBKx
4xxRxzPrJyPvtLRVxmbMFxoByRQakG5S+nhfon9HWRwqAcZOQTjU3OiUlCBOM+YK
PbLps0LwNW7ztGwnrwAorlkO37naRHtS94N81L8tGrVv5UoDZeFSV786rzOmrBW4
vZGyWh88MzOZ5EBH9EkdQMDaUVv2WkJCbETAVwKBgQCoIzF8N2Npukcvmn/U10Gs
wFrJ/OV28K/i19H3HlIL87FY/DOeQ9v4rI1dWIEcJt2vlZJ/npA4luXIj8jQ2NgE
RkOX5tyQmswskAAIT/lLuzaGF3m5LimEUZA8eGYlzNy6GWQCq4KVFs5TQaMzxPmJ
zatt/DmG1RxnxgVUk6N78QKBgFPwUBeiWPpjP682O+rWYq5mECB4jPVXxyE9xaN3
suo8AlpG/nOqH6wDOqght/rA56nygu6qhLV6e5D8uDyn2G0T51Wh5W0fvRcUuNiB
/8s1LiibsfmBWqJqfJrvlqYOKVm6xuBSOck5u0jNZAAMe/KWu43b0T6kEXNDzuzu
8KnTAoGAUXNY+oMCZT84H/sShJ2MS22Eo4EcdMtEHob5ttSVOxPmu+8+QwanW+ad
M+/pFx83y7tHy8lr7jZcslmi70Jd+9ZuonUxbUIMLN2N+ddGkqfK1XtcpP3EBjGU
cFjQM8VuXgrVkyv7pARbE6k9bKthZVzm1YMcRhZUhU2UgEqZWe4=
-----END RSA PRIVATE KEY-----';

    /**
     * 商户的回调处理需要支付的密钥处理与验证情况 function
     *
     * @return void
     */
    public function notifyUber(Request $request)
    {
        #银联支付成功后的回调
        if ($request->result == 'success') {
            return '支付成功,感谢您的支持';
        }
        // $priKey= openssl_pkey_get_private($this->priavte_key);
        // $requestContent = $request->all();
        // Log::info('UBEY=============>NOTIFY=====>RESULT=====>111',['request-odata'=>$request->data,'request-signature' => $request->signature,'all' => $request->all() ]);

        #解密处理返回的data 与验证sign 的情况
        $decrypted = [];
        $datass = base64_decode($request->data);
        $datass = json_decode($datass, true);
        $signature=base64_decode($request->signature);

        Log::info('UBEY=============>NOTIFY=====>RESULT=====>', ['datass'=> $datass]);
        #检测重复订单问题，防止多次回调处理。 就会导致给玩家多发金钱了,与商户号钱多等问题
        if (!empty($datass['orderId'])) {
            $payInfo = PayInfoModels::where('platform_order', $datass['orderId'])
                        ->where('pay_status', 1)
                        ->first();
            if ($payInfo) {
                Log::info('重复订单处理,异步回调请留意', ['payInfo'=>$payInfo]);

                return '重复订单处理,异步回调请留意';
            }
        }
        #银行回调的处理方式  zfb的也处理了，不验证签名。 这JB平台
        if (isset($datass['respInfo'])) {
            Log::info('UBEY=============>NOTIFY=====>BANK====>RESULT', ['datass' => $datass]);
            if ($datass['respInfo'] == 'success') {
                $decrypted['orderNo'] = $datass['orderId'];
                $UnityDispose = new UnityDispose();
                $UnityDispose->notifUnity($decrypted);

                return 'ok';
            }
        }
        //签名验证成功的情况下,进行统一的操作
        if (openssl_verify(base64_decode($request->data), $signature, $this->public_key, OPENSSL_ALGO_MD5)) {
            Log::info('UBEY=============>NOTIFY=====>H5ZFB');
            $decrypted['orderNo'] = $datass['orderId'];
            $UnityDispose = new UnityDispose();
            $UnityDispose->notifUnity($decrypted);
            return 'ok';
        } else {
            return 'false';
        }
    }



    /**
     *
     *
     * 银行的回调处理功能
     *
     * @return void
     */
    public function notifyUberBank(Request $request)
    {
        #base64_decode 返回的request->all() file_get_content("php://input");
        $datass = base64_decode($request->data);
        $datass = json_decode($datass, true);

        Log::info('UBEYBANK****************NOTIFY*************>RESULT*************>', ['datass'=> $datass]);
        #检测重复订单问题，防止多次回调处理。 就会导致给玩家多发金钱了,与商户号钱多等问题
        if (!empty($datass['orderId'])) {
            $payInfo = BankInfo::where('platform_order', $datass['orderId'])
                        ->where('pay_status', 1)
                        ->first();
            if ($payInfo) {
                Log::info('重复代付处理,异步回调请留意', ['payInfo'=>$payInfo]);

                return '重复代付处理,异步回调请留意';
            }
        }
        #银行回调的处理方式  zfb的也处理了，不验证签名。 这JB平台 UnityDispose为Ubey的处理，每个平台出一个 NOTIFY也一样
        if (isset($datass['respInfo'])) {
            Log::info('UBEYBANK****************NOTIFY*************>BANK222222');
            $UnityDispose = new UnityDispose();
            $result = $UnityDispose->unityBank($datass);
            
            if ($result != 'ok') {
                throw new \Exception("request is not ok", 1);
            }
            return 'ok';
        }
    }
    /**
     * witspay支付的回调处理 function 扫码支付的回调支持,看下代付是否也一样
     *
     * @return void
     */
    public function witspay(Request $request)
    {
        #可以验证签名,防止非法调用. 一般情况下不验证也行....
        Log::info('WITSPAY=============>NOTIFY=====>', ['all' => $request->all() ]);
        $response = $request->all();
        #同步跳转时的回调设置 ,可以返回网页或者其它的设置
        if ($request->result == 'success') {
            return '支付成功,感谢您的支持';
        }
        if (!empty($response['paymentNo'])) {
            $payInfo = PayInfoModels::where('platform_order', $response['paymentNo'])
                        ->where('pay_status', 1)
                        ->first();
            if ($payInfo) {
                Log::info('重复订单处理,异步回调请留意_WITSPAY', ['payInfo'=>$payInfo]);
            }
        }
        #银行回调的处理方式  zfb的也处理了，不验证签名。 这JB平台
        if (isset($response['status'])) {
            Log::info('WITSPAY=======>NOTIFY====>RESPONSE===>', ['all' => $response]);
            if ($response['status'] == 'success') {
                $decrypted['orderNo'] = $response['requestNo'];
                $UnityDispose = new UnityDispose();
                $UnityDispose->notifUnity($decrypted);
                return 'ok';
            }
        }
    }


    /**
     * witspay支付的回调处理 function 扫码支付的回调支持,看下代付是否也一样
 {"all":{"buyerUsername":"cra***@126.com","nP":"wavM","payTime":"2018-11-06 15:14:25","connectSys":"MYBANK2","sign":"D0824B075BADD9E430570BA2D172EF3D","extraBuyerInfo":"{\"cardAttr\":\"BALANCE\"}","mid":"898310060514010","invoiceAmount":"1","settleDate":"2018-11-06","billFunds":"支付宝余额:1","buyerId":"2088002348122824","tid":"88880001","totalAmount":"1","couponAmount":"0","buyerPayAmount":"1","targetOrderId":"2018110622001422825432295531","notifyId":"b818ebd8-114e-478d-bc47-15e1f1ebb8ba","billFundsDesc":"支付宝余额支付0.01元。","subInst":"UMS-MARKET","orderDesc":"webpay测试商户","seqId":"00350201750N","merOrderId":"3194CHINAUMSPAY201811064155","status":"TRADE_SUCCESS","targetSys":"Alipay 2.0"}}
     * @return void
     */
    public function chinaums(Request $request)
    {
        $response = $request->all();
        #可以验证签名,防止非法调用. 一般情况下不验证也行....
        Log::info('CHINAUMS=============>NOTIFY=====>', ['all' => $response ]);
        #同步跳转时的回调设置 ,可以返回网页或者其它的设置
        if ($request->result == 'success') {
            return '支付成功,感谢您的支持,回调的网页设置';
        }
        if (!empty($response['merOrderId'])) {
            $payInfo = PayInfoModels::where('platform_order', $response['merOrderId'])
                        ->where('pay_status', 1)
                        ->first();
            if ($payInfo) {
                Log::info('重复订单处理,异步回调请留意_WITSPAY', ['payInfo'=>$payInfo->id]);
            }
            return 'success';
        }
        #银行回调的处理方式  zfb的也处理了，不验证签名。 这JB平台
        if (isset($response['status'])) {
            Log::info('CHINAUMS=======>NOTIFY====>RESPONSE===>UnityDispose');
            if ($response['status'] == 'TRADE_SUCCESS') {
                $decrypted['orderNo'] = $response['merOrderId'];
                $UnityDispose = new UnityDispose();
                $UnityDispose->notifUnity($decrypted);

                return 'success';
            }
        }
    }

    /**
     * 支付回调的处理suispay function
     *
     * @param Request $request
     * @return void
     */
    public function suispaypay(Request $request)
    {
        //production.ERROR: json_decode() expects parameter 1 to be string, array given
        // $params = json_decode($request->all(),true);

        $params = $request->all();
        
        #可以验证签名,防止非法调用. 一般情况下不验证也行....
        Log::info('suispaypay=============>NOTIFY=====>', ['all' => $params ]);


        if (!isset($params['mch_id']) || empty($params['sign'])) {
            Log::info('excption error mch_id___'.$request->ip());
        }
        if (!empty($params['mch_no'])) {
            $payInfo = PayInfoModels::where('platform_order', $params['mch_no'])
                        ->where('pay_status', 1)
                        ->first();
            if ($payInfo) {
                return 'ok';
                Log::info('重复订单处理,异步回调请留意_WITSPAY', ['payInfo'=>$payInfo]);
            }
        }
        #验证码    pay_state == 1
        if ($params['pay_state'] == 1) {
            $datas = [
                'mch_id'    => $params['mch_id'],
                'mch_no'    => $params['mch_no'],
                'sys_no'    => $params['sys_no'],
                'total_fee'    => $params['total_fee'],
                'pay_state'    => $params['pay_state'],
                'attach'    => $params['attach'],
                'nonce_str'    => $params['nonce_str'],
                'time_end'    => $params['time_end'],
            ];
            $string = $this->toUrlParams($datas);
            $sign = $this->sign($string);

            if ($params['sign']  == $sign) {
                $decrypted['orderNo'] = $params['mch_no'];
                $UnityDispose = new UnityDispose();
                $UnityDispose->notifUnity($decrypted);
                return 'ok';
            }
            Log::info('excption error mch_id___SIGN'.$request->ip());
            return 'sign error';
        }
        return 'on paid';
    }
    /**
    *  suispaypay获取URL设置 不同第三方回调签名处理不同 单独设置 function
    *
    * @param [type] $params
    * @return void
    */
    public function toUrlParams(array $params)
    {
        ksort($params);
        $buff = "";
        foreach ($params as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }
    /**
     *  suispaypay 签名 function
     *
     * @return void
     */
    public function sign($string)
    {
        $md5str = $string . "&key=".'05a4b54bd82b43a9928351f983641490';
        return strtoupper(md5($md5str));
    }


    /**
     * 回调接口处理 function  http request 真实状态码
     * @param Request $request
     * @return void
     */
    public function htfpay(Request $request)
    {
        $params = $request->all();
        $decrypted = [];

        Log::info('htfpay=============>NOTIFY=====>', ['all' => $params ]);
        if (!empty($params['out_trade_no'])) {
            $payInfo = PayInfoModels::where('platform_order', $params['out_trade_no'])
                        ->where('pay_status', 1)
                        ->first();
            if ($payInfo) {
                Log::info('重复订单处理,异步回调请留意_htfpay', ['payInfo'=>$payInfo->id]);
                return 'false order repeat';
            }
        }
        if ($params['code'] == 0 && $params['state'] == 'S') {
            $decrypted['orderNo'] = $params['out_trade_no'];
            $UnityDispose = new UnityDispose();
            $UnityDispose->notifUnity($decrypted);
            return 'ok';
        }
        return 'false';
    }


    /**
     *  回调接口处理 function  http request 真实状态码
     * @param Request $request
     * @return void
     */
    public function baishengPay(Request $request)
    {
        $params = $request->all();
        $decrypted = [];

        Log::info('baishengPay_____________NOTIFY', ['all' => $params ]);

        if (!empty($params['OutPaymentNo'])) {
            $payInfo = PayInfoModels::where('platform_order', $params['OutPaymentNo'])
                        ->where('pay_status', 1)
                        ->first();
            if ($payInfo) {
                Log::info('重复订单处理,异步回调请留意_htfpay', ['payInfo'=>$payInfo->id]);
                return 'false order repeat';
            }
        }
        if ($params['code'] == 200) {
            $decrypted['orderNo'] = $params['OutPaymentNo'];
            $UnityDispose = new UnityDispose();
            $UnityDispose->notifUnity($decrypted);
            return 'ok';
        }
        return 'false';
    }
    /**
     * 通知订单变动 function
     *  1.主动发送给商户，系统会自动在通知地址后面加上/otc 回调处理虚拟币的交易情况
     *
     *  /otc （OTC 订单变动通知 )  只是通知情况 1为成功 可以查看实时交易情况
     *  /OtcVerify (OTC 订单校验 ) MD5(Account+Bank+RealName+SubBranch+KeyB)，
     *  /otcQuery (用户虚拟币余额查询 ) MD5(Coin + CoinAmount +KeyB)
     *
     *  http://xxxxpay/otcNotifyurl/ 测试地址
     * sign 计算演示: 所有参数按字母顺序从小到大 a~z 排序后加上 keyB 值做 MD5 加密 . md5 转小写
     *
     * OrderId 已经改成 OrderNum,留意下，这个平台随意更改字段....
     * @return void
     */
    public function otc(Request $request)
    {
        $params = $request->all();
        $otc = $request->otc  ?? '';

        Log::info('OTCPAY___NOTIFY__REQUEST', ['all' => $params ,'otc' => $otc]);
        if (empty($otc)) {
            return 'false';
        }
        if ($params['Sign'] != $this->otcSign($params)) {
            Log::info('sign_error___1111_OTCPAY', ['all' => $params ,'otc' => $otc]);
            return 'false';
        }
        $dataJson = [
            'Success'   => true,
            'Code'  => 1,
            'Message'   => 'xx'
        ];
        Log::info('OTCPAY_____NOTIFY__SIGN', ['all' => $params ,'otc' => $otc]);
        if ($otc == 'otc') { //Otc（OTC 订单变动通知） 4.3

            $dataState =[
                'order_id'   => $params['OrderNum'],
                'State1'   => $params['State1'],
                'State2'   => $params['State2'],
                'price'   => $params['Price'],
                'Remark'    => $params['Remark'],
                'return_content'    => json_encode($params)
            ];
            if ($params['State2'] == 2 && $params['State1'] == 2) {  //购买成功的处理
                VirtualCurrencyUserBuy::where('order_id', $params['OrderNum'])
                            ->update($dataState);

                Log::info('success_pay_state2==2', ['dataJson' => $dataJson]);
                #游戏的回调设置 但是其它WEBPC 没有调用
                $decrypte = [];
                $decrypted['orderNo'] = $params['OrderNum'];
                $UnityDispose = new UnityDispose();
                $UnityDispose->notifUnityVirtual($decrypted);
                return json_encode($dataJson);
            }
            if ($params['State2'] == 1 && $params['State1'] == 4) {
                VirtualCurrencyUserBuy::where('order_id', $params['OrderNum'])
                            ->update($dataState);
                Log::info('error_pay_state2_and_state1_status', ['dataJson' => $dataJson]);
                return json_encode($dataJson);
            }
            VirtualCurrencyUserBuy::where('order_id', $params['OrderNum'])
                    ->update($dataState);
            return json_encode($dataJson);

        }
        /**
        商户代理平台提供订单校验接口，玩家在 OTC 卖币页面申请卖币金额时，币宝主动
        请求商户，商户应校验玩家余额是否充足，在充足的情况下，商户在回传校验金额结果的
        同时并告知 OTC 订单是否需要人工审核，于此同时应该冻结玩家对应资金，如果回传参数
        Status 为 0 ,默认现在不需要审核, 直接通过  如需要审核机制这里还需要重新写 加通知==

        同步6X备注:订单被投诉后，由管理员确认收款。投诉单id:72254 提现到后要点确定...
        */
        if ($otc == 'otcVerify') { // OtcVerify（OTC 订单校验） 卖币页面时请求 4.4
            $user = VirtualCurrencyUser::where(['username'=>$params['UserName'],'coin_code'=>$params['Coin']])->first();
            if (!$user) {
                $dataJson['Success']   = false;
                $dataJson['Code']   = 0;
                return json_encode($dataJson);
            }
            $sign = strtolower(md5($user->account.$user->bank.$user->real_name.$user->sub_branch .Config::get('services.virtual.keyB')));

            $dataJson['Account']   = $user->account;
            $dataJson['Bank']   = $user->bank;
            $dataJson['RealName'] =$user->real_name;
            $dataJson['SubBranch'] =$user->sub_branch;
            $dataJson['Status'] = 1;
            $dataJson['Sign'] = $sign;
            
            return json_encode($dataJson);
        }
        /**
        用户平台虚拟币余额查询 OTC页面显示使用 4.5 返回当前币的种类数量
        
        {"Success":true, "Code":1, "Message":"xx", ”Coin”:”USDX”, ”CoinAmount”:”1000.123”, ”Sign”:”b35d8
        e7f7221d82937689f5ac56a8d7b” }
        */
        if ($otc == 'otcQuery') {
            $Virtualcurrency = new Virtualcurrency();
            $Virtualcurrency->GetBalance('mocb', 2);

            $bank = VirtualCurrencyUserBuy::where('order_id', $params['OrderNum'])->first();
            if ($bank) {
                $user = VirtualCurrencyUser::where(['username'=>$bank->mercode,'coin_code'=>$bank->coin])
                            ->first();
                if (!$user) {
                    return 'failed';
                }
                $sign = strtolower(md5($user->coin_code.$user->balance .Config::get('services.virtual.keyB')));
                $dataJson['Coin'] =$user->coin_code;
                $dataJson['CoinAmount'] =$user->balance;
                $dataJson['Sign'] = $sign;
                return json_encode($dataJson);
            }
        }
        /**
 商户提供此接口 ,币宝主动请求给商户，商户提供平台用户的银行卡信息，在卖币交易完成后，资金转入该银行卡
        {"Success":true, "Code":1, "Message":"xx", ”Account”:”6222564898745698123”, ”Bank”:”农业银
行”,”RealName”:” 张三”,” SubBranch”:”金寨路支行“ ”Sign”:”b35d8e7f7221d82937689f5ac56a8d7
b” }  提供对应币的银行卡信息 ，请保证银行的信息填写正确,币商平台未提供通过与查询功能. 回退也可能有问题.
         */
        if ($otc == 'getBankCard') {  // 4.6
            $bank = VirtualCurrencyUserBuy::where('order_id', $params['OrderNum'])->first();
            if ($bank) {
                $user = VirtualCurrencyUser::where(['username'=>$bank->mercode,'coin_code'=>$bank->coin])
                            ->first();
                if (!$user) {
                    return 'failed';
                }
                $sign = strtolower(md5($user->account.$user->bank.$user->real_name.$user->sub_branch .Config::get('services.virtual.keyB')));

                $dataJson['Account']   = $user->account;
                $dataJson['Bank']   = $user->bank;
                $dataJson['RealName'] =$user->real_name;
                $dataJson['SubBranch'] =$user->sub_branch;
                $dataJson['Sign'] = $sign;
                return json_encode($dataJson);
            }
        }

        #默认的通知,上述是币商实时主动通知  Notice（通知）  3.9 返回的订单是什么鬼，都不是传给OTC的 有病
        //用户充币会产生三条通知记录：用户充币通知，用户转出通知，商户充币通知， 资金要归集到商户账上。用户提币，商户充币，商户提币均为一条通知记录。
/*
        OTCPAY___NOTIFY__REQUEST {"all":{"Amount":"100","Coin":"DC","Fee":"0.00","FromAddr":"bcbH3SFhTovQA2LtkQk5LcSGM3tjCN34Z9kb","Id":"notice201812102149366038DAWGgT","OrderNo":"1812102149343676YDr","State":"4","ToAddr":"bcbDoYXsHsxJJvS9dgjyFA2LE1enw5kqdAWN","TradeNo":"dtcp20181210214936602GxdG0j3J2","TradeTime":"2018-12-10 21:49:36","Type":"1","sign":"e61cb48f5670065628b3b76a74092454"},"otc":""} 
*/


        // if(isset($params['OrderNo'])){
        //         $virtual = VirtualCurrencyUserBuy::where('order_id',$params['OrderNo'])
        //         ->first();
        //     if ($virtual->State == 1) { //重复订单的调用处理
        //         return json_encode($dataJson);
        //     }
        //     //成功 并是用户充币才进行处理 其它的行为直接存放就行。 后续操作
        //     if ($params['State'] == 4 ) {
        //         $dataNotice = [
        //             'amount'    => $params['Amount'],
        //             'pay_time'    => $params['TradeTime'],
        //             'fee'    => $params['Fee'],
        //             'State'    => $params['State'],
        //             'notice_type'    => $params['Type'],
        //             'FromAddr'    => $params['FromAddr'],
        //             'ToAddr'    => $params['ToAddr'],
        //         ];

        //         VirtualCurrencyUserBuy::where('order_id',$params['OrderNo'])->update($dataNotice);
        //         return json_encode($dataJson);
        //     }
        //     $dataNotice = [
        //         'return_content'=> json_encode($params),
        //     ];
        //     VirtualCurrencyUserBuy::where('order_id',$params['OrderNo'])->update($dataNotice);
        //     return json_encode($dataJson);
        // }
    }
    /**
     * 生成签名的处理  认证TOKEN 与SIGN 防止 恶意调用 function  KEYB 是对应项目的
     *
     * @return void
     */
    public function otcSign($params)
    {
        $str = '';
        ksort($params);
        foreach ($params as $k => $v) {
            if ($k == 'Sign') {
                continue;
            }
            // Log::info('kkkk_vvvv',['k'=>$k,'v'=>$v]);
            $str .= $k .'='.$v.'&';
        }
        $str = rtrim($str, '&').Config::get('services.virtual.keyB');
        return strtolower(md5($str));
    }
}
