<?php
namespace App\Pay\Channel;

use Payment\Common\PayException;
use Payment\Client\Charge;
use Payment\Config as PayConfig;
use Payment\Utils\ArrayUtil;
/**
 * Uber H5网银接入 扫码看情况
 */
use Config;
use Log;
use DB;

use App\Models\Third\PayInfoModels;

use App\Models\Third\ShopModels;


class Baisheng extends BasePayData
{
    /**
     * 分为普通支付，快捷支付，与网联支付  判断三种类型 来调用对应API function
        # http://notify.dfylpro.com:10003/ 本地测试回调 frpc 测试 生成
        # http://pay.dfylpro.com/ 上线的时候记得替换成这个地址
     * @param [type] $request
     * @return void
     */
    public function handle($request)
    {

        $htfpay = Config::get('channelpay.Baisheng');

        $orderNo ='BAISHENG'.date('Ymd').time().rand(10000000, 90000000);
        $payData  = [
            'MerchantId'    => $htfpay['partner'], //商户编号
            'OutPaymentNo'=> $orderNo,
            'PaymentAmount' => $request['totalfee'] * 100,
            'NotifyUrl'    => 'http://pay.dfylpro.com/pay/baishengPay/notifyUrl',
            'Timestamp' => date('Y-m-d H:i:s'),
            'signType'	=> 'HTFPAY',
            'md5Key'	=> $htfpay['partner_md5key'],
            'PassbackParams'    => $request['app_id'],
        ];

        $payData = $this->paymentData($request, $payData);
        try {
            $ret = Charge::run(PayConfig::BAISHENG_CHANNEL, $htfpay, $payData);

            if (isset($ret)) {

                $returnBaseData = $this->packageRetrunBaisheng($ret, $request, $orderNo);

                $shopId = ShopModels::where('app_id', $request['app_id'])->value('id');
                Log::info('Channel\BAISHENG\handle====>STATUS===>T', ['ret'=>$ret,'returnBaseData'=> $returnBaseData]);
                $data = [
                    'third'	=> 'BAISHENG',
                    'channel'	=> $request['paymethod'],
                    'payType'	=> $request['call'],
                    'body'	=> $request['body'] ?? 'BAISHENG支付操作',
                    'subject'	=> $request['body'] ?? 'BAISHENG支付操作',
                    'order_id'	=> $request['order_id'],
                    'platform_order'	=> $orderNo,
                    'notify_url'	=> $request['notifyurl'] ?? '',
                    'pay_shop_id'	=> $shopId ?? 1,
                    'pay_money'	=> $request['totalfee'] * 100  ?? 1,
                    'pay_formality'	=> 0.03,
                    'pay_channel_id'	=> 1,
                    'pay_time'	=> date('Y-m-d H:i:s'),
                    'pay_callback_content'	=>json_encode($ret),
                    'pay_data'	=> json_encode($payData),
                ];
                $PayInfoModels = PayInfoModels::create($data);

                if ($PayInfoModels) {
                    $returnBaseData['stateData']['mweburl'] = url('Baisheng/'.$PayInfoModels->id);
                }
                return $returnBaseData;
            }
            Log::info('Channel\BAISHENG\handle===>STATUS===>F', ['ret'  => $ret]);
            return $this->ConfigRetrun(1003);
        } catch (PayException $e) {
            Log::info('Channel\BAISHENG\handle===>STATUS===>PayException', ['e'  => $e]);
            return  $this->ConfigRetrun(1003);
            exit;
        }
    }
 
}
