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

use App\Jobs\UberHandle;

use App\Services\Bank;
use App\Models\Third\BankDetail;
use App\Pay\Channel\UnityDispose;


use App\Models\Third\ShopMoney;

class Ubey
{
    /**
     * 分为普通支付，快捷支付，与网联支付  判断三种类型 来调用对应API function
     *
     * @param [type] $request
     * @return voidT
     */
    public function handle($request)
    {
        if ($request['app_id'] == 3000010896032) {
            $ubeyConfig = Config::get('ubey.ubey2');
        } elseif ($request['app_id'] == 3000020325615) {
            $ubeyConfig = Config::get('ubey.hero');
        } elseif ($request['app_id'] == 3000026125023) {
            $ubeyConfig = Config::get('ubey.jg_self');
        } elseif ($request['app_id'] == 3000031117238) {
            $ubeyConfig = Config::get('ubey.jg_self');
        } else {
            $ubeyConfig = Config::get('ubey.ubey');
        }
        $orderNo ='Ubey'.date('Ymd').time().rand(100, 900);
        #sign 签名单独生成 http://notify.dfylpro.com:10003/ 本地测试回调
        $payData  = [
            'account'    => $ubeyConfig['ID'], //商户编号
            'amount'    => $request['totalfee'] * 100, //商户订单金额，单位分
            #notifyurl 平台的回调  notify_url 才是商户调用的回调设置 h5的设置
            'callback_url'    => urlencode('http://pay.dfylpro.com/pay/ubey/notifyUrl?result=success'),
            'notify_url'    => urlencode('http://pay.dfylpro.com/pay/ubey/notifyUrl') ,
            'orderId'    => $orderNo,
            'type'  => 'kkwwo',
        ];
        switch ($request['paymethod']) {
            case 'zfb':  //最少10元， 按分为单位
                if ($request['call'] == 'h5') {
                    $payData['type'] = 'koali_wap'; //
                    unset($payData['callback_url']);
                } elseif ($request['call'] == 'app') {
                    $payData['type'] = 'koali_app';
                    unset($payData['callback_url']);
                } else {
                    $payData['type'] = 'koali';
                }
                break;
            case 'wx':
                if ($request['call'] == 'h5') {
                    $payData['type'] = 'kowx_wap';
                } elseif ($request['call'] == 'app') {
                    $payData['type'] = 'kowx_app';
                } else {
                    $payData['type'] = 'kowx';
                }
                break;
            case 'unionpay':
                if ($request['call'] == 'h5') {
                    $payData['type'] = 'kkwwo';
                } else {
                    $payData['type'] = 'kkwwo';
                }
                break;
            case 'qq':
                if ($request['call'] == 'h5') {
                    $payData['type'] = 'koqq_wap';
                } else {
                    $payData['type'] = 'koqq';
                }
                break;
            default:
                return  Config::get('error.1003');
                break;
        }
        try {
            if ($request['paymethod'] != 'unionpay') {
                $ret = Charge::run(PayConfig::UBEY_SM_CHANNEL, $ubeyConfig, $payData);
            } else {
                $ret = Charge::run(PayConfig::UBEY_CHANNEL, $ubeyConfig, $payData);
            }
            $response = Config::get('error.200');
            #支付状态status T 返回成功处理
            if ($ret['getStatusCode'] == 200) {
                //二维码 与 生成数据
                $response['stateData']['shorturl'] = $ret['data']['shorturl'] ?? '';
                $response['stateData']['codeurl'] = $ret['data']['codeurl'] ?? '';
                #订单号 与 生成的URLH5地址  与 返回HTML原生的内容 给游戏处理
                $response['stateData']['outtradeno'] = $ret['data']['orderId'] ?? '';
                $response['stateData']['mweburl'] = $ret['data']['url'] ?? ''; //生成本地的ID
                $response['stateData']['html_unionpay_h5'] = $ret['content'] ?? '';
                if (isset($ret['data']['url']) && $payData['type'] == 'kowx_app') {
                    $response['stateData']['app'] =  base64_decode($ret['data']['url']) ?? '';
                }

                Log::info('Channel\Ubey\handle========>STATUS==================>T', ['ret'=> $ret]);

                $shopId = ShopModels::where('app_id', $request['app_id'])->value('id');
                $data = [
                    'third'	=> 'ubey',
                    'channel'	=> $request['paymethod'],
                    'payType'	=> $request['call'],
                    'body'	=> $request['body'] ?? 'ubey支付操作',
                    'subject'	=> $request['body'] ?? 'ubey支付操作',
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
                #银行的回调,需要单独在封装一层处理
                if (isset($ret['content'])) {
                    $response['stateData']['mweburl'] = url('ubey/'.$PayInfoModels->id);
                }
                #队列检测 操作 每6秒查询订单支付情况 与kue一样的操作
                // dispatch(new ZnHandle($PayInfoModels));
                return $response;
            }
            Log::info('Channel\Ubey\handle========>STATUS==================>F', ['response'=> $response]);

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
        if ($request['app_id'] == 3000010896032) {
            $ubeyConfig = Config::get('ubey.ubey2');
        } elseif ($request['app_id'] == 3000020325615) {
            $ubeyConfig = Config::get('ubey.hero');
        } else {
            $ubeyConfig = Config::get('ubey.ubey');
        }
        $response = Config::get('error.200');
        $orderNo = $request['order_id'];

        $payData = [
            'account'	=> $ubeyConfig['ID'],
            'orderId'	=> $orderNo,
            'type'  => 'TenQuery'
        ];
        #查询系统订单情况pay_status 为1  需要限定pay_shop_id自己对应的订单查询
        $payInfo = PayInfoModels::where('platform_order', $orderNo)->first();
        #如果订单已经更新过状态，则不需要重新查询接口处理了
        if ($payInfo) {
            if ($payInfo->pay_status == 1) {
                $response['stateData']['tradestate'] = 'TRADE_SUCCESS33';
                $response['stateData']['orderid'] = $orderNo;

                $response['stateData']['totalfee'] = $payInfo->pay_money ?? '';
                $response['stateData']['buyeremail'] = $payInfo->pay_shop_id ?? '';
                $response['stateData']['paydate'] = $payInfo->pay_time ?? '';

                return $response;
            }
        }
        try {
            $ret = Charge::run(PayConfig::UBEY_CHANNEL_STATUS, $ubeyConfig, $payData);
            #支付状态status T 返回成功处理
            if ($ret['data']['orderId_state'] == '3') {
                Log::info('Channel\Ubey\handleStatus========>status==========>T', ['response'=> $response,'ret'  => $ret]);

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
        if ($request['app_id'] == 3000010896032) {
            $ubeyConfig = Config::get('ubey.ubey2');
        } elseif ($request['app_id'] == 3000020325615) {
            $ubeyConfig = Config::get('ubey.hero');
        } else {
            $ubeyConfig = Config::get('ubey.ubey');
        }
        $orderNo ='Ubey'.date('YmdH').time();
        $response = Config::get('error.200');
        #外部查询银行卡号的详细信息,分行==信息
        if ($request['to_acc_no']) {
            $bank = new Bank();
            $bank->getBankInfo($request['to_acc_no']);
        }
        $bankDetail  = BankDetail::where('bank_no', $request['to_acc_no'])->first();
        if (!$bankDetail) {
            return Config::get('error.2002');
        }
        $bankNumber = [
            '中国邮政储蓄银行'  => '01000000',
            '中国农业银行'  => '01000001',
            '中国银行'  => '01000002',
            '交通银行'  => '01000003',
            '中信银行'  => '01000004',
            '中国光大银行'  => '01000005',
            '华夏银行'  => '01000006',
            '中国民生银行'  => '01000007',
            '广发银行'  => '01000008',
            '平安银行'  => '01000009',
            '招商银行'  => '01000010',
            '兴业银行'  => '01000011',
            '上海浦东发展银行'  => '01000012',
            '恒丰银行'  => '01000013',
            '浙商银行'  => '01000014',
            '渤海银行'  => '01000015',
            '徽商银行'  => '01000016',
            '中国工商银行'  => '01000017',
            '中国建设银行'  => '01050000',
        ];
        if (!isset($bankNumber[$bankDetail->bankname])) {
            return Config::get('error.1003');
        }
        $payData = [
            'accName' => urlencode($request['to_acc_name']) ,
            'accNo' => $bankDetail->bank_no,
            'account' => $ubeyConfig['ID'],
            'amount'  => $request['trans_money'] * 100, //分为单位 传过来的钱+费率
            'banktype'    => $bankNumber[$bankDetail->bankname],
            'notify_url'  => urlencode('http://pay.dfylpro.com/pay/ubey/unityBank') ,
            'orderId'   => $orderNo,
            'type'   => 'ToPay'
        ];
        try {
            $ret = Charge::run(PayConfig::UBEY_BANK_CHANNEL, $ubeyConfig, $payData);
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

    /**
     * [handleBankStatus 银行代付的状态查询 记录  查询可以不写，回调一定要正常。 但是也要提供]
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function handleBankStatus($request)
    {
        if ($request['app_id'] == 3000010896032) {
            $ubeyConfig = Config::get('ubey.ubey2');
        } elseif ($request['app_id'] == 3000020325615) {
            $ubeyConfig = Config::get('ubey.hero');
        } else {
            $ubeyConfig = Config::get('ubey.ubey');
        }


        $response = Config::get('error.200');
        $orderNo = $request['order_id'];
        $payData = [
          'merchantNo'  => $ubeyConfig['ID'],
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
            $ret = Charge::run(PayConfig::ZHONG_CHANNEL_BANK_STATUS, $ubeyConfig, $payData);
            #支付状态status T 返回成功处理
            if ($ret['status'] == 'T') {
                Log::info('Channel\Zhong\handleBankStatus=========>status=========>T', ['response'=> $response,'ret'  => $ret]);
                $response['stateData']['tradestate'] = 'TRADE_SUCCESS';
                $response['stateData']['orderid'] = $orderNo;

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
