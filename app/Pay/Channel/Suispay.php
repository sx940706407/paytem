<?php
namespace App\Pay\Channel;

// use Payment\Common\PayException;
// use Payment\Client\Charge;
// use Payment\Config as PayConfig;

use Config;
use Log;
use DB;

use App\Models\Third\PayInfoModels;
use App\Models\Third\BankInfo;
use App\Models\Third\PayBankInfoModels;
use App\Models\Third\ShopModels;

use App\Services\Bank;
use App\Models\Third\BankDetail;
use App\Pay\Channel\UnityDispose;

use App\Models\Third\ShopMoney;

use App\Pay\SuisPayBase;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;


class Suispay extends BasePayData
{
    protected $charge;

    public function __construct()
    {
        $this->charge = new SuisPayBase();
    }
    /**
     * 分为普通支付，快捷支付，与网联支付  判断三种类型 来调用对应API function
        # http://notify.dfylpro.com:10003/ 本地测试回调 frpc 测试 生成
        # http://pay.dfylpro.com/ 上线的时候记得替换成这个地址
     * @param [type] $request
     * @return void
     */
    public function handle($request)
    {
        $suispayPayConfig = Config::get('channelpay.suispay');
        $orderNo = 'ss'.date('Ymd').time().rand(1000000, 9000000);
        $payData  = [
            'mch_id'    => $suispayPayConfig['mch_id'], //商户编号
            'mch_no'    => $orderNo,
            'total_fee'    => $request['totalfee'] * 100, //默认是按元传进来  * 100
            'notify_url'    => 'http://pay.dfylpro.com/pay/suispaypay/notifyUrl',
            'success_url'   => 'http://pay.dfylpro.com/pay/suispaypay/notifyUrl/success',
            'nonce_str' => $this->getRandom(),
            'attach'    => 'JG',
            'format'    => 'HTML',
            'nonce_str'    => str_random(32),
        ];
        $payData = $this->paymentData($request, $payData);
        $string = $this->toUrlParams($payData);
        $sign = $this->sign($string);

        // dd($sign,$string,$payData);
        try {
            // $postUrl="http://api.suiszf.com/pay/gateway?".$string."&sign=".$sign; 

            $postUrl="http://api.iolk.cc/pay/trade?".$string."&sign=".$sign; 
            $packageReturnSuispay = $this->packageReturnSuispay($postUrl,$request, $orderNo);

            if (isset($packageReturnSuispay['stateData']['mweburl'])) {
                $shopId = ShopModels::where('app_id', $request['app_id'])->value('id');
                Log::info('Channel\SUISPAY\handle====>STATUS===>T',['url'=>$postUrl,'packageReturnSuispay'=> $packageReturnSuispay]);


                $data = [
                    'third'	=> 'suispay',
                    'channel'	=> $request['paymethod'],
                    'payType'	=> $request['call'],
                    'body'	=> $request['body'] ?? 'suispay支付操作',
                    'subject'	=> $request['body'] ?? 'suispay支付操作',
                    'order_id'	=> $request['order_id'],
                    'platform_order'	=> $orderNo,
                    'notify_url'	=> $request['notifyurl'] ?? '',
                    'pay_shop_id'	=> $shopId ?? 1,
                    'pay_money'	=> $request['totalfee'] * 100  ?? 1,
                    'pay_formality'	=> 0.03,
                    'pay_channel_id'	=> 1,
                    'pay_time'	=> date('Y-m-d H:i:s'),
                    'pay_callback_content'	=> '1',
                    'pay_data'	=> json_encode($packageReturnSuispay),
                ];
                $PayInfoModels = PayInfoModels::create($data);
                return $packageReturnSuispay;
            }
            Log::info('Channel\SUISPAY\handle===>STATUS===>F');
            return $this->ConfigRetrun(1003);
        } catch (\Exception $e) {
            Log::info('Channel\SUISPAY\handle===>STATUS===>PayException', ['e'  => $e]);
            return  $this->ConfigRetrun(1003);
            exit;
        }
    }
    public function getRandom($param = 32)
    {
        $str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $key = "";
        for ($i=0;$i<$param;$i++) {
            $key .= $str{mt_rand(0, 32)};    //生成php随机数
        }
        return $key;
    }
     /**
     * 获取URL设置 function
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
     * 签名 function
     *
     * @return void
     */
    public function sign($string)
    {
        $md5str = $string . "&key=".Config::get('channelpay.suispay.md5Key');
        return strtoupper( md5($md5str) );
    }


}
