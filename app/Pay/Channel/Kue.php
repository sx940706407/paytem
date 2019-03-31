<?php 

namespace App\Pay\Channel;


use Payment\Common\PayException;
use Payment\Client\Charge;
use Payment\Config as PayConfig;
use Payment\Utils\ArrayUtil;

use Config,Log;

use App\Models\Third\PayInfoModels;
use App\Models\Third\PayBankInfoModels;
use App\Models\Third\ShopModels;


use App\Jobs\NotifyHandle;

/**
 * 酷E，第三方支付
 */
 class Kue
{
	/**
	 * test  http://192.168.1.251:8055/system/pay/kue/qq/sm
	 * [handle 统一下单处理 KUE]
	 * @return [type] [description]
	 */
	public function handle($request)
	{	
    	//酷E 只接入alipay,wechat,qq 银联的扫码服务 与H5 其它不接入
    	$kueConfig = Config::get('kue.kue_alipay_wechat');
		$orderNo = 'KUE'. rand(1000, 9999).date('YmdHis');

		$LocalhostNotify = 'http://paytrade.hongtonggame.com/pay/payCallbackKueQQ';

		// 订单信息
		$payData = [ 
		    'body'    => $request['body'],
		    'funname'	=> 'prepay', //prepay h5 支付
		    'merid'	=> Config::get('kue.kue_alipay_wechat.KUE_ONE_QQ_H5_MERID'),
		    'notifyurl'	=> url('pay/payCallbackKueUnionpay'),
		    'paymethod'	=> $request['paymethod'] ?? 'wx',
		    'subject'    => $request['body'],
		    'orderid'    => $orderNo,
		    'timeout_express' => time() + 600,// 表示必须 600s 内付款
		    'totalfee'    => $request['totalfee'],// 消费总金额，单位为：元
		    'tradetype' => '',  //MWEB 
		    #加密方式 与 对应的MD5签名 就是密钥
		    'md5Key'	=> Config::get('kue.kue_alipay_wechat.KUE_ONE_QQ_H5_SIGN'),
		    'signType'	=> 'MD5',
		];
		//默认为扫码支付，H5需要单独填写
		if ($request['call'] == 'h5') {
			$payData['tradetype'] = 'MWEB';
		}


		switch ($request['paymethod']) {
			case 'qq':
				$payData['merid']  = Config::get('kue.kue.KUE_ONE_QQ_H5_MERID');
				$payData['md5Key'] = Config::get('kue.kue.KUE_ONE_QQ_H5_SIGN');
				$payData['notifyurl'] = $LocalhostNotify;


				break;
			case 'unionpay':
				$payData['merid']  = Config::get('kue.kue_faster.KUE_ONE_QQ_H5_MERID');
				$payData['md5Key'] = Config::get('kue.kue_faster.KUE_ONE_QQ_H5_SIGN');
				$payData['notifyurl'] = url('pay/payCallbackKueUnionpay');

				break;
				#QQ扫码渠道使用联
			case 'unionpay_qq':
				$payData['paymethod'] = 'unionpay';
				$payData['merid']  = Config::get('kue.kue.KUE_ONE_QQ_H5_MERID');
				$payData['md5Key'] = Config::get('kue.kue.KUE_ONE_QQ_H5_SIGN');

				$payData['notifyurl'] = $LocalhostNotify;

				break;
		}

		try {
		    $ret = Charge::run(PayConfig::KE_CHANNEL_QQ_H5, $kueConfig, $payData);
		} catch (PayException $e) {
				return  Config::get('error.1003');
		    exit;
		}

		Log::info('Kue====>payHandle',['ret'=>$ret]);
		$response = Config::get('error.200');

		switch ($ret['flag']) {

			case '00':
				//短链接，自己生成二维码。而不用他的图标  替换codeurl地址 与h5地址 为服务器的地址。  然后服务器来请求结算返回
					$response['stateData']['shorturl'] = $ret['shorturl'] ?? '';
					$response['stateData']['codeurl'] = $ret['codeurl'] ?? ''; //生成本地的ID对应上
					$response['stateData']['outtradeno'] = $ret['outtradeno'] ?? '';
					$response['stateData']['mweburl'] = $ret['mweburl'] ?? ''; //生成本地的ID
					
					$shopId = ShopModels::where('app_id',$request['app_id'])->value('id');

					$data = [
						'third'	=> $request['third'],
						'channel'	=> $request['paymethod'],
						'payType'	=> $request['call'],
						'body'	=> $request['body'] ?? '酷E支付',
						'subject'	=> $request['body'] ?? '酷E支付',
						'order_id'	=> $request['order_id'] ?? $orderNo,
						'platform_order'	=> $orderNo,
						'notify_url'	=> $request['notifyurl'] ?? '',
							#支付商家的ID，用于实别内部的商家配置信息
						'pay_shop_id'	=> $shopId ?? 1,

						'pay_money'	=> $request['totalfee'] ?? 1,
							#根据支付的渠道 pay_channel_id 获取对应的比率设置
						'pay_formality'	=> 0.03,

						'pay_channel_id'	=> 1,

						'pay_time'	=> date('Y-m-d H:i:s'),

						'pay_callback_content'	=> json_encode($response) , // 
							#支付信息也要。 用于查询用户的订单状态
						'pay_data'	=> json_encode($payData),
					];

					$PayInfoModels = PayInfoModels::create($data);

					if ($response['stateData']['codeurl']) {
						$response['stateData']['codeurl'] = url('kue/'.$PayInfoModels->id);
					}
					if ($response['stateData']['mweburl']) {
						$response['stateData']['mweburl'] = url('kue/'.$PayInfoModels->id);
					}
					#测试时重写向写法，ghaa 正式发给商户自己处理
					// if (isset($ret['mweburl']) ) {
					// 	return redirect($ret['mweburl']);
					// }
					Log::info('payStatusRetrunPost',['response' => $response]);
					#触发队列任务,检查订单任务状态，每6秒进行查询(检测9次)。如果已经支付则回调用户的URL
					dispatch(new NotifyHandle($PayInfoModels));

				return  $response;
				break;


			case '99':
				return  Config::get('error.1001');
				break;


			default:
				return  Config::get('error.2001');
				break;
		}

	}
	/**
	 * test   http://192.168.1.251:8055/system/pay_status/kue/zfb/orderid
	 * [handleStatus 订单查询状态，统一下单的]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function handleStatus($request)
	{
    	$kueConfig = Config::get('kue.kue_alipay_wechat');
		$orderNo = $request['order_id'];

		$response = Config::get('error.200');
		$payInfo = PayInfoModels::where('order_id',$orderNo)->first();
		// 订单信息
		$payData = [ 
		    'funname'	=> 'orderquery', //prepay h5 支付
		    'merid'	=> Config::get('kue.kue_alipay_wechat.KUE_ONE_QQ_H5_MERID'),
		    'paymethod'	=> $request['paymethod'] ?? 'wx',
		    'orderid'    => $orderNo,
		    #加密方式 与 对应的MD5签名 就是密钥
		    'md5Key'	=> Config::get('kue.kue_alipay_wechat.KUE_ONE_QQ_H5_SIGN'),
		    'signType'	=> 'MD5',
		];
		try {
		    $ret = Charge::run(PayConfig::KE_CHANNEL_QQ_H5_STATUS, $kueConfig, $payData);
		} catch (PayException $e) {
				return  response()->json(Config::get('error.1003'));
		    exit;
		}
		Log::info('Kue===>payHandleStatus==>',['ret'=>$ret]);

		$payInfo = PayInfoModels::where('order_id',$orderNo)->first();
			#如果订单已经更新过状态，则不需要重新查询接口处理了
		if ($payInfo) {

			if ($payInfo->pay_status == 1 ) {
				$response['stateData']['tradestate'] = 'TRADE_SUCCESS';
				$response['stateData']['orderid'] = $orderNo;

				$response['stateData']['totalfee'] = $ret['totalfee'] ?? '';
				$response['stateData']['tradeno'] = $ret['tradeno'] ?? '';
				$response['stateData']['openid'] = $ret['openid'] ?? '';
				$response['stateData']['buyeremail'] = $ret['buyeremail'] ?? '';
				$response['stateData']['paydate'] = $ret['paydate'] ?? '';

				return $response;
			 } 
		}

		switch ($ret['flag']) {
			case '00':

				switch ($ret['tradestate']) {
					case 'NOTPAY':
						$response['stateData']['tradestate'] = 'NOTPAY';
						$response['stateData']['orderid'] = $orderNo;
					return $response;
						break;
					
					case 'TRADE_SUCCESS': 
						$response['stateData']['tradestate'] = 'TRADE_SUCCESS';
						$response['stateData']['orderid'] = $orderNo;

						$response['stateData']['totalfee'] = $ret['totalfee'] ?? '';
						$response['stateData']['tradeno'] = $ret['tradeno'] ?? '';
						$response['stateData']['openid'] = $ret['openid'] ?? '';
						$response['stateData']['buyeremail'] = $ret['buyeremail'] ?? '';
						$response['stateData']['paydate'] = $ret['paydate'] ?? '';
						#更新订单状态,标识订单已经支付.
						PayInfoModels::where('order_id',$orderNo)->update(['pay_status' => 1]);

						return $response;


					default:
						return  Config::get('error.1003');
						break;
				}
				return  Config::get('error.1004');

				break;
			case '2007':
				return  Config::get('error.1004');
				break;
			default:
				return  Config::get('error.1004');
				
				break;
		}



	}

	/**
	 * test http://192.168.1.251:8055/system/pay_bank/kue
	 * [handleBank 代付下单接口]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function handleBank($request)
	{
    	$kueConfig = Config::get('kue.kue');
		$response = Config::get('error.200');

		$orderNo = 'HT'.$request['third'].mt_rand(100000,999999).time();

		// 订单信息  只支持部分银行。 判断银行与当前帐号的金额是否能支付此订单。 不能则继续下一个支付

		$payData = [ 
		    'merchantid'	=> Config::get('kue.kue.KUE_ONE_QQ_H5_MERID'), //酷模系统商户号
		    'trans_money'	=> $request['trans_money'], //代付金额
		    'to_acc_name'	=> $request['to_acc_name'], //转账账户名称
		    'to_acc_no'	=> $request['to_acc_no'], //转账账户号码
		    'to_bank_name'	=> $request['to_bank_name'], //转账账户银行名称
		    'to_pro_name'	=> '广东',  //所属省份
		    'to_city_name'	=> '广州', //所属城市
		    'to_acc_dept'	=> '广州招商银行天河支行', //转账账户银行分行名称
		    'trans_card_id'	=> '362200198309144514', //转账账户身份证号
		    'trans_mobile'	=> '17688997744', //转账账户手机号码
		    'trans_summary'	=> '第三方支付备注KUE', 
		    'notify_url'	=>  'http://paytrade.hongtonggame.com/pay/payCallbackKueBank', //转账结果异步通知地址
		    'orderid'	=> $request['order_id'] ?? $orderNo,

		    #加密方式 与 对应的MD5签名 就是密钥
		    'md5Key'	=> Config::get('kue.kue.KUE_ONE_QQ_H5_SIGN'),
		    'signType'	=> 'MD5',
		];

		try {
		    $ret = Charge::run(PayConfig::KE_CHANNEL_BANK, $kueConfig, $payData);
		} catch (PayException $e) {
				return  Config::get('error.1003');
		    exit;
		}
		Log::info('Kue====>payHank===>',['ret'=>$ret]);

		switch ($ret['flag']) {
			case '2004':
				return Config::get('error.1000');
				break;
			case '00':
				$response['stateData']['result'] = $ret['result'] ?? '';

				$data = [
					'payData'	=> $payData,
					'stateData'	=> $response,
					'pay_shop_id'	=> $request['pay_shop_id'],
					'order_id'	=> $request['order_id'] ?? $orderNo,
					'platform_order'	=> $orderNo,
					'notifyurl'	=> $request['notifyurl'] ?? '',
				];
					#存放商户提交的信息
				PayBankInfoModels::create($data);
				$money = $request['trans_money'] * 100;
					#更新对应的钱数
				ShopModels::where('app_id',$request['pay_shop_id'])->decrement('money',$money);

					#还需要更新商户的金钱数,减去对应的操作. 金钱增加与减少的记录
				return $response;

			default:
				return  Config::get('error.2001');
				
				break;
		}




	}

	/**
	 * test http://192.168.1.251:8055/system/pay_bank_status/kue/201807171950403625935739738
	 * [handleBankStatus 代付下单 查询接口]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function handleBankStatus($request)
	{
    	$kueConfig = Config::get('kue.kue_alipay_wechat');
		$response = Config::get('error.200');

		$orderNo = 'HT'.$request['third'].mt_rand(100000,999999).time();

		// 订单信息  只支持部分银行。 判断银行与当前帐号的金额是否能支付此订单。 不能则继续下一个支付
		$payData = [ 
		    'merchantid'	=> Config::get('kue.kue_alipay_wechat.KUE_ONE_QQ_H5_MERID'),
		    'transno'	=> $request['order_id'],
		    #加密方式 与 对应的MD5签名 就是密钥
		    'md5Key'	=> Config::get('kue.kue_alipay_wechat.KUE_ONE_QQ_H5_SIGN'),
		    'signType'	=> 'MD5',
		];

		//更新支付状态，如果已经付款成功的话
		try {
		    $ret = Charge::run(PayConfig::KE_CHANNEL_BANK_STATUS, $kueConfig, $payData);
		} catch (PayException $e) {
				return  Config::get('error.1003');
		    exit;
		}
		Log::info('Kue====>payHankStatus===>',['ret'=>$ret]);

		switch ($ret['flag']) {
			case '00':
				$response['stateData']['result'] = $ret['result'];

				//更新付款信息
				return $response;

					#如果 订单一直处理不成功,后台还需要提供退款的操作. 处理本次支付处理，退款.

				break;
			default:
				return  Config::get('error.2001');
				
				break;
		}

	}




    /**
     * 检查Kue返回的数据是否被篡改过，商户需要对接收到的数据优先进行验签处理，确定是从酷模支付发送的通知后再进行业务方面的处理，因为没有验签而导致的后果商户自行承担
     * @param array $retData
     * @return boolean
     * @author helei
     */
    protected function verifySign(array $retData,$request)
    {

		switch ($request->channel) {
			case 'qq':
				$payData['merid']  = Config::get('kue.kue.KUE_ONE_QQ_H5_MERID');
				$payData['md5Key'] = Config::get('kue.kue.KUE_ONE_QQ_H5_SIGN');
				break;
			case 'unionpay':
				$payData['merid']  = Config::get('kue.kue_faster.KUE_ONE_QQ_H5_MERID');
				$payData['md5Key'] = Config::get('kue.kue_faster.KUE_ONE_QQ_H5_SIGN');
				break;
				#QQ扫码渠道使用联
			case 'unionpay_qq':
				$payData['paymethod'] = 'unionpay';
				$payData['merid']  = Config::get('kue.kue.KUE_ONE_QQ_H5_MERID');
				$payData['md5Key'] = Config::get('kue.kue.KUE_ONE_QQ_H5_SIGN');
				break;
		}

        $retSign = $retData['sign'];
        $values = ArrayUtil::removeKeys($retData, ['sign', 'sign_type']);

        $values = ArrayUtil::paraFilter($values);

        $values = ArrayUtil::arraySort($values);

        $signStr = ArrayUtil::createLinkstring($values);

        $signStr .= '&key=' . $payData['md5Key'];

        $sign = md5($signStr);
    	// Log::info('payCallbackKue',['retSing'=> $retSing,'sign' => $sign,'values' => $values]);
        return strtoupper($sign) === $retSign;
    }



}
