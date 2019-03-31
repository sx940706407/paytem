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
use App\Models\Third\BankInfo;
use App\Models\Third\PayBankInfoModels;
use App\Models\Third\ShopModels;

use App\Services\Bank;
use App\Models\Third\BankDetail;
use App\Pay\Channel\UnityDispose;

use App\Models\Third\ShopMoney;

class Htf extends BasePayData
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
        
        if ($request['app_id'] == 3000020325615) {
            $htfpay = Config::get('channelpay.htf_hero');
        } elseif ($request['app_id'] == 3000026125023){
            $htfpay = Config::get('channelpay.htf_jg');
        } else{
            #默认是 天天 巅峰的支付宝 WX也要测试下
            $htfpay = Config::get('channelpay.htf');
        }

        $orderNo ='HTFPAY'.date('Ymd').time().rand(10000000, 90000000);
        $payData  = [
            'partner'    => $htfpay['partner'], //商户编号
            'out_trade_no'=> $orderNo,
            'total_fee' => $request['totalfee'] * 100,
            'notify_url'    => 'http://pay.dfylpro.com/pay/htfpay/notifyUrl',
            'timestamp' => date('Y-m-d H:i:s'),
            'signType'	=> 'HTFPAY',
            'md5Key'	=> $htfpay['partner_md5key'],
        ];
        $payData = $this->paymentData($request, $payData);
        try {
            $ret = Charge::run(PayConfig::HTF_CHANNEL, $htfpay, $payData);
            $packageRetrunHtf = $this->packageRetrunHtf($ret, $request, $orderNo);

            if (isset($packageRetrunHtf['htmlwap'])) {
                $shopId = ShopModels::where('app_id', $request['app_id'])->value('id');
                Log::info('Channel\HTFPAY\handle====>STATUS===>T', ['ret'=>$ret,'packageRetrunHtf'=> $packageRetrunHtf]);
                $data = [
                    'third'	=> 'HTFPAY',
                    'channel'	=> $request['paymethod'],
                    'payType'	=> $request['call'],
                    'body'	=> $request['body'] ?? 'HTFPAY支付操作',
                    'subject'	=> $request['body'] ?? 'HTFPAY支付操作',
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
                    $packageRetrunHtf['stateData']['mweburl'] = url('htf/'.$PayInfoModels->id);
                }
                return $packageRetrunHtf;
            }
            Log::info('Channel\HTFPAY\handle===>STATUS===>F', ['ret'  => $ret]);
            return $this->ConfigRetrun(1003);
        } catch (PayException $e) {
            Log::info('Channel\HTFPAY\handle===>STATUS===>PayException', ['e'  => $e]);
            return  $this->ConfigRetrun(1003);
            exit;
        }
    }

    /**
     * [handleBank witsPay 代付服务,需要查询对应的银行卡号信息. 还号有API接口服务]
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function handleBank($request)
    {
        $witsPayConfig = Config::get('channelpay.witspay');
        $orderNo ='WITSPAYBANK'.date('YmdH').time();
        $response = Config::get('error.200');
        #外部查询银行卡号的详细信息,分行==信息
        if ($request['to_acc_no']) {
            $bank = new Bank();
            $bank->getBankInfo($request['to_acc_no']);
            /**
                        {
                        "cardType": "DC",
                        "bank": "CMB",
                        "key": "6214837854697715",
                        "messages": [],
                        "validated": true,
                        "stat": "ok"
                    }
             */
            $bankDetailAlias = $bank->bankAlias($request['to_acc_no']);
        }
        #银行编码的查询使用支付宝的接口处理
        $bankDetail  = BankDetail::where('bank_no', $request['to_acc_no'])->first();
        if (!$bankDetail && !$bankDetailAlias) {
            return Config::get('error.2002');
        }
        #仅支持对应的银行支付,还需要检测
        $supportBank = [
            'ICBC'  => '工商银行',
            'ABC'  => '农业银行',
            'BOC'  => '中国银行',
            'CCB'  => '建设银行',
            'COMM'  => '交通银行',
            'CMB'  => '招商银行',
            'CITIC'  => '中信银行',
            'CEB'  => '光大银行',
            'CIB'  => '兴业银行',
            'CMBC'  => '民生银行',
            'HXB'  => '华夏银行',
            'SPDB'  => '浦发银行',
            'PSBC'  => '邮政储蓄银行',
            'PINGANBK'  => '平安银行',
            'BKSH'  => '上海银行',
            'CGB'  => '广发银行',
        ];
        if (!isset($supportBank[$bankDetailAlias['bank']])) {
            return Config::get('error.2003');
        }
        
        $payData = [
            #公共报文
            'partnerId'    => $witsPayConfig['SHOP_ID_1'], //商户编号
            'amount'    => $request['trans_money'],
            'notifyUrl'    => 'http://notify.dfylpro.com:10003/pay/witspayBank/notifyUrl',
            'jumpUrl'   => 'http://notify.dfylpro.com:10003/pay/witspayBank/notifyUrl/success',
            'requestNo'    => $orderNo,
            'signType'  => 'MD5',
            'service'  => 'batchPrepare',
            #对应接口的报文，回调需要单独处理
            'totalAmount'   => '', //按单位为元，最大小数为2位
            'totalCount'   => 1,
            'details'   => [
                #明细流水号  merchOrderNo 作为批次号，merchDetailNo 作为明细对应的流水号
                'merchDetailNo' => $orderNo,
                #支付金额
                'amount' => $request['trans_money'],
#编码请查看《附录-银行编码》 目前支持 ICBC:工商银行,ABC:农业银行,BOC:中国银行,CCB:建设银行,COMM:交通银行,CMB:招商银行,CITIC:中信银行,CEB:光大银行,CIB:兴业银行,CMBC:民生银行,HXB:华夏银行,SPDB:浦发银行,PSBC:邮政储蓄银行,PINGANBK:平安银行,BKSH:上海银行,CGB:广发银行
                'bankId' => $bankDetailAlias['bank'],
                #银行账户类型
                'accountType' => 'PERSON',
                #银行账户名  张三
                'accountName' => $request['to_acc_name'],
                #银行账户号 63002211111111111111
                'accountNumber' => $bankDetail->bank_no,
                #分支行 重庆沙坪坝xxx支行
                'branchName' => $bankDetail->branchname,
                #分支行省市 重庆
                'province' => $bankDetail->province,
                #分支行城市 长寿
                'city' => $bankDetail->city,
            ],
            'remark'   => '购买手机',
        ];
        try {
            $ret = Charge::run(PayConfig::WITSPAY_CHANNEL_BANK, $witsPayConfig, $payData);
            if ($ret['data']['state'] == '38') {
                $shopId = ShopModels::where('app_id', $request['app_id'])->lockForUpdate()->first();
                $data = [
                    'third' => 'ubey',
                    'channel' => 'bank',
                    'payType' => 'payment',
                    'body'  =>  'UBEY代付操作',
                    'subject' =>  'UBEY代付操作',
                    'order_id'  => $request['order_id'],
                    'platform_order'  => $orderNo,
                    'notify_url'  => $request['notifyurl'] ?? '',
                    'pay_shop_id' => $shopId->id ?? 1,
                    'pay_money' => ($request['trans_money'] + 4) * 100 ,
                    'pay_formality' => 3,  //代付的比率不同 银行的这里是元处理
                    'pay_channel_id'  => 1, //代付的渠道 有支付宝 ==操作
                    'pay_time'  => date('Y-m-d H:i:s'),
                    'pay_data'  => json_encode($payData),
                  ];
                $BankInfo = BankInfo::create($data);
                //减去商户的钱数，增加与减少都需要对应的操作记录
                $shopId->money = $shopId->money - ($request['trans_money'] + 400)  ;
                $shopId->save();

                Log::info(
                    'Channel\Zhong\handleBank=========>status=========>T',
                        ['response'=> $response,'ret'  => $ret,'request'=> $request]
                );
                return $response;
            }
            Log::info(
                'Channel\Zhong\handleBank=========>status=========>F',
                         ['response'=> $response,'ret'  => $ret,'request'  => $request]
            );
            return Config::get('error.1004');
        } catch (PayException $e) {
            return  Config::get('error.1004');
            exit;
        }
    }
}
