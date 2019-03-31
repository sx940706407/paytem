<?php

namespace App\Pay\Channel;

use Payment\Common\PayException;
use Payment\Client\Charge;
use Payment\Config as PayConfig;
use Payment\Utils\ArrayUtil;
/**
 * 中诺的 支付接入 微信 支付宝 银联  操作 class
 */
use Config,Log,DB;

use App\Models\Third\PayInfoModels;
use App\Models\Third\BankInfo;
use App\Models\Third\PayBankInfoModels;
use App\Models\Third\ShopModels;

use App\Jobs\ZnHandle;
use App\Services\Bank;
use App\Models\Third\BankDetail;
use App\Pay\Channel\UnityDispose;


use App\Models\Third\ShopMoney;

class Zhong
{
    /**
     * 分为普通支付，快捷支付，与网联支付  判断三种类型 来调用对应API function
     *
     * @param [type] $request
     * @return void
     */
    public function handle($request)
    {
        $zhongConfig = Config::get('zhong.zhong');
        $orderNo ='ZHONG'.date('Ymd').time().rand(100, 900);
        #sign 签名单独生成
        $payData  = [
            'merchantNo'    => $zhongConfig['ID'], //商户编号
            'orderAmount'    => $request['totalfee'] * 100, //商户订单金额，单位分
            'orderNo'    => $orderNo,
            #notifyurl 平台的回调  notify_url 才是商户调用的回调设置 h5的设置
            'notifyUrl'    => 'http://pay.dfylpro.com/pay/zn/notifyUrl',
            'callbackUrl'    => 'http://pay.dfylpro.com/pay/zn/notifyUrl?result=success',
            'productName'    => $request['body'],
            'productDesc'    => $request['body'],
            'md5Key'	=>  $zhongConfig['SIGN'],
            'signType'	=> 'MD5',
        ];
        switch ($request['paymethod']) {
            case 'zfb':  //最少10元， 按分为单位
                if ($request['call'] == 'h5') {
                    $payData['payType'] = 13;
                    $payData['mchAppName'] = $request['mchAppName'] ?? 'sfgame';
                    $payData['mchAppId'] = $request['mchAppId'] ??  'com.test.sfgame';
                    $payData['deviceType'] = '01';
                } else {
                    $payData['payType'] = 4;
                }
                break;
            case 'wx':
                if ($request['call'] == 'h5') {
                    $payData['payType'] = 3;

                    $payData['mchAppName'] = $request['mchAppName'] ?? 'sfgame';
                    $payData['mchAppId'] = $request['mchAppId'] ??  'com.test.sfgame';
                    $payData['deviceType'] = '01';
                } else {
                    $payData['payType'] = 2;
                }
                break;
            case 'unionpay':
                if ($request['call'] == 'h5') {
                    return  Config::get('error.1003');
                } else {
                    $payData['payType'] = 9;
                }
                break;
            case 'qq':
                if ($request['call'] == 'h5') {
                    $payData['payType'] = 7;
                    $payData['mchAppName'] = $request['mchAppName'] ?? 'sfgame';
                    $payData['mchAppId'] = $request['mchAppId'] ??  'com.test.sfgame';
                    $payData['deviceType'] = '01';
                } else {
                    $payData['payType'] = 8;
                }
                break;
            case 'faster':
                      $payData['payType'] = 5;
                      $payData['mchAppName'] = $request['mchAppName'] ?? 'sfgame';
                      $payData['mchAppId'] = $request['mchAppId'] ??  'com.test.sfgame';
                      $payData['deviceType'] = '01';
                break;
            default:
                return  Config::get('error.1003');
                break;
        }

        try {
            $ret = Charge::run(PayConfig::ZHONG_CHANNEL, $zhongConfig, $payData);
            $response = Config::get('error.200');
            #支付状态status T 返回成功处理
            if ($ret['status'] == 'T') {
                $response['stateData']['shorturl'] = $ret['shorturl'] ?? '';
                $response['stateData']['codeurl'] = $ret['codeurl'] ?? ''; //生成本地的ID对应上
                $response['stateData']['outtradeno'] = $ret['orderNo'] ?? '';
                $response['stateData']['mweburl'] = $ret['payUrl'] ?? ''; //生成本地的ID

                $shopId = ShopModels::where('app_id', $request['app_id'])->value('id');

                Log::info('Channel\Zhong\handle========>STATUS==================>T', ['response'=> $response,'ret'  => $ret]);
                $data = [
                    'third'	=> 'zn',
                    'channel'	=> $request['paymethod'],
                    'payType'	=> $request['call'],

                    'body'	=> $request['body'] ?? '中诺支付操作',
                    'subject'	=> $request['body'] ?? '中诺支付操作',
                    'order_id'	=> $request['order_id'],
                    'platform_order'	=> $orderNo,
                    'notify_url'	=> $request['notifyurl'] ?? '',

                    'pay_shop_id'	=> $shopId ?? 1,
                    'pay_money'	=> $request['totalfee'] * 100  ?? 1,
                    'pay_formality'	=> 0.03,
                    'pay_channel_id'	=> 1,
                    'pay_time'	=> date('Y-m-d H:i:s'),
                    'pay_callback_content'	=> json_encode($ret),
                    'pay_data'	=> json_encode($payData),
                ];
                $PayInfoModels = PayInfoModels::create($data);
                #队列检测 操作 每6秒查询订单支付情况 与kue一样的操作

                dispatch(new ZnHandle($PayInfoModels));

                return $response;
            }
            Log::info('Channel\Zhong\handle========>STATUS==================>F', ['response'=> $response,'ret'  => $ret]);

            return Config::get('error.1003');
        } catch (PayException $e) {
            return  Config::get('error.1003');
            exit;
        }
    }

    /**
     * [订单查询   统一下单  /payapi/query]
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function handleStatus($request)
    {
        $zhongConfig = Config::get('zhong.zhong');
        $response = Config::get('error.200');
        $orderNo = $request['order_id'];
        $payData = [
            'merchantNo'	=> $zhongConfig['ID'],
            'orderNo'	=> $request['order_id']
        ];
        #查询系统订单情况pay_status 为1  需要限定pay_shop_id自己对应的订单查询
        $payInfo = PayInfoModels::where('order_id', $orderNo)->first();
        #如果订单已经更新过状态，则不需要重新查询接口处理了
        if ($payInfo) {
            if ($payInfo->pay_status == 1) {
                $response['stateData']['tradestate'] = 'TRADE_SUCCESS';
                $response['stateData']['orderid'] = $orderNo;

                $response['stateData']['totalfee'] = $payInfo->pay_money ?? '';
                $response['stateData']['buyeremail'] = $payInfo->pay_shop_id ?? '';
                $response['stateData']['paydate'] = $payInfo->pay_time ?? '';

                return $response;
            }
        }
        try {
            $ret = Charge::run(PayConfig::ZHONG_CHANNEL_STATUS, $zhongConfig, $payData);
            #支付状态status T 返回成功处理
            if ($ret['status'] == 'T') {
                Log::info('Channel\Zhong\handleStatus========>status==========>T', ['response'=> $response,'ret'  => $ret]);

                $response['stateData']['tradestate'] = 'TRADE_SUCCESS';
                $response['stateData']['orderid'] = $orderNo;

                #队列检测 操作 每6秒查询订单支付情况
                return $response;
            }
            Log::info('Channel\Zhong\handleStatus========>status==========>F', ['response'=> $response,'ret'  => $ret]);

            return Config::get('error.1004');
        } catch (PayException $e) {
            return  Config::get('error.1004');
            exit;
        }
    }
    /**
     * [handleBank 银行的代付功能处理 记录 代付的条数 与减去 商户的钱数]
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function handleBank($request)
    {
        $zhongConfig = Config::get('zhong.zhong');
        $orderNo ='ZHONG'.date('YmdH').time();
        $response = Config::get('error.200');
        if ($request['to_acc_no']) {
            $bank = new Bank();
            $bank->getBankInfo($request['to_acc_no']);
        }
        $bankDetail  = BankDetail::where('bank_no', $request['to_acc_no'])->first();
        if (!$bankDetail) {
            return Config::get('error.2002');
        }
        
        DB::beginTransaction();

        $payData = [
          'merchantNo'  => $zhongConfig['ID'],
          'orderNo' => $orderNo,
          'orderAmount' => $request['trans_money'] * 100, //按分为单位为计算
          'cardNumber' => $bankDetail->bank_no,
          'accountName' => $request['to_acc_name'],
          'openBank' => $bankDetail->bankname,
          'openBranchName' => $bankDetail->branchname, //支行名称
          'openProvince' => $bankDetail->province,
          'openCity' => $bankDetail->city,
          'bankLinked' => $bankDetail->number, //银行支行联行号
          'paymentType' => 'D0', //代付类型 D0 / T1
          'accountType' => '1', //账户类型  1  个人  2 企业
        ];


        $shopId = ShopModels::where('app_id', $request['app_id'])->lockForUpdate()->first();
        $data = [
            'third' => 'zn',
            'channel' => 'bank',
            'payType' => 'payment',
            'body'  =>  '中诺代付操作',
            'subject' =>  '中诺代付操作',
            'order_id'  => $request['order_id'],
            'platform_order'  => $orderNo,
            'notify_url'  => $request['notifyurl'] ?? '',
            'pay_shop_id' => $shopId->id ?? 1,
            'pay_money' => ($request['trans_money'] - 3) * 100 ,
            'pay_formality' => 3,  //代付的比率不同 银行的这里是元处理
            'pay_channel_id'  => 1,
            'pay_time'  => date('Y-m-d H:i:s'),
            'pay_data'  => json_encode($payData),
          ];
        $BankInfo = BankInfo::create($data);

        #增加商户的兑换银行钱数操作.
        $shopMoney = [
            'shop_id'   =>$shopId->id,
            'before_money'    => $shopId->money,
            'money' => ($request['trans_money'] - 3) * 100 ,
            'after_money'   => $shopId->money - ($request['trans_money'] - 3) * 100 ,
            'active'    => '兑换钱数:(分为单位)'.($request['trans_money'] - 3) * 100  . '||兑换订单'.$request['order_id'],
        ];
        ShopMoney::create($shopMoney);
        //减去商户的钱数，增加与减少都需要对应的操作记录
        $shopId->money = $shopId->money - $request['trans_money'] * 100 ;
        $shopId->save();


        //1.读取远程的API银行接口，如果失败则返回 2.发现代付的信息
        // Log::info('zhong========bank-=====>data', ['payData'=>$payData]);
        try {
            $ret = Charge::run(PayConfig::ZHONG_CHANNEL_BANK, $zhongConfig, $payData);
            #支付状态status T 返回成功处理
            if ($ret['status'] == 'T') {
                //记录到代付表中或者放在
                Log::info('Channel\Zhong\handleBank=========>status=========>T', ['response'=> $response,'ret'  => $ret,'request'=> $request]);

                DB::commit();
                //存放银行卡号的信息防止多次查询,存放查询的结果.防止获取时失败,status标识

                #队列检测 操作 每6秒查询订单支付情况 与kue一样的操作
                return $response;
            }
            DB::rollBack();
            Log::info('Channel\Zhong\handleBank=========>status=========>F', ['response'=> $response,'ret'  => $ret,'request'  => $request]);
            return  Config::get('error.1004');
        } catch (PayException $e) {
            DB::rollBack();
            return  Config::get('error.1004');
            exit;
        }
    }
    /**
     * [handleBankStatus 银行代付的状态查询 记录]
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function handleBankStatus($request)
    {
        $zhongConfig = Config::get('zhong.zhong');
        $response = Config::get('error.200');
        $orderNo = $request['order_id'];
        $payData = [
          'merchantNo'  => $zhongConfig['ID'],
          'orderNo' => $request['order_id']
        ];
        #查询系统订单情况pay_status 为1  需要限定pay_shop_id自己对应的订单查询
        $payInfo = BankInfo::where('platform_order', $orderNo)->first();
        #如果订单已经更新过状态，则不需要重新查询接口处理了
        if ($payInfo) {
            if ($payInfo->pay_status == 1) {
                $response['stateData']['tradestate'] = 'TRADE_SUCCESS';
                $response['stateData']['orderid'] = $orderNo;

                $response['stateData']['totalfee'] = $payInfo->pay_money ?? '';
                $response['stateData']['buyeremail'] = $payInfo->pay_shop_id ?? '';
                $response['stateData']['paydate'] = $payInfo->pay_time ?? '';
                $response['stateData']['transStatus'] = $payInfo->transStatus ?? '';

                return $response;
            }
        }
        try {
            $ret = Charge::run(PayConfig::ZHONG_CHANNEL_BANK_STATUS, $zhongConfig, $payData);
            #支付状态status T 返回成功处理 
            if ($ret['status'] == 'T') {
                Log::info('Channel\Zhong\handleBankStatus=========>status=========>T', ['response'=> $response,'ret'  => $ret]);
                $response['stateData']['tradestate'] = 'TRADE_SUCCESS';
                $response['stateData']['orderid'] = $orderNo;
                // $dispose = json_decode($ret,true);
                $response['stateData']['transStatus']   = $ret['transStatus'];  //原先返回zn 以及对应的各种平台
                $response['stateData']['succeedAmount']   = $ret['succeedAmount'];  //原先返回zn 以及对应的各种平台
//{"errMsg":"受理中","merchantNo":"32413110017685","orderNo":"ZHONG20180908191536406713","serialNo":"200000004521875","sign":"bef38ce42164f87edbbde23a4252f9c9","status":"T","succeedAmount":"0","transStatus":"1"}
                return $response;
            }
            Log::info('Channel\Zhong\handleBankStatus=========>status=========>F', ['response'=> $response,'ret'  => $ret]);
            return Config::get('error.1004');
        } catch (PayException $e) {
            return  Config::get('error.1004');
            exit;
        }
    }
}
