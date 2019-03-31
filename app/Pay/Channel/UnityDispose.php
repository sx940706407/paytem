<?php

namespace App\Pay\Channel;

/**
 * 统一处理钱数与回调。 增加lock锁 。 并发的情况下容易出现问题
 */

use App\Models\Third\ShopModels;
use App\Models\Third\PayInfoModels;
use App\Models\Third\ShopMoney;
use App\Models\Third\BankInfo;

use Config;
use DB;
use Log;

use App\Services\XRsa;
use GuzzleHttp\Client;

class UnityDispose
{
    /**
     * [unity 统一成功处理 增加商户钱数 (记录商户钱数 变化等操作),回调商户处理 ==]
     * @param  [type] $shop_id    [HT商户号的查询,用于资金更改]
     * @param  [type] $pay_money  [支付金钱 按分为单位]
     * @param  [type] $data       [支付数据]
     * @param  [type] $notify_url [回调地址]
     * @param  [type] $order_id   [订单号]
     * @param  [type] $pay_id     [支付ID模型]
     * @return [type]             [bool]
     */
    public function unity($shop_id, $pay_money, $data, $notify_url, $order_id, $pay_id)
    {
        $this->XRsa =  new XRsa();
        $shop = ShopModels::where('id', $shop_id)->first();
        if (!$shop) {
            return false;
		}
		#报错情况下,就会很麻烦了...
        $money = $pay_money  *  Config::get('channelpay.zhongnuo.zfb.commission');
		$addMoney = $shop->money + $money;
		$shopMoney = [
			'shop_id'	=>$shop->id,
			'before_money'	=> $shop->money,
			'money'	=> $money,
			'after_money'	=> $addMoney,
			'active'	=> '订单充值增加钱数:(分为单位)'.$money. '||增加钱的订单号为'.$order_id,
		];
		ShopMoney::create($shopMoney);
		#更新商户钱数 zhong 的单位为分
        $shop->money =  $addMoney;
		$shop->save();
		
        PayInfoModels::where('order_id', $order_id)->where('id', $pay_id)->lockForUpdate()->update(['pay_status'=>1,'pay_done_time'  => date('Y-m-d H:i:s')]);

		#处理返回给商户的数值,按元传进来。 也要按元传回去.防止商户处理失败.
		$data['totalfee'] = $pay_money / 100;

		#记录商户的金钱记录,方便后续的查询与兑换的情况 ,兑换也要清除商户钱数
		$data['sign'] = verify_sign_str($data, $shop->app_secret);
		
        #加密RSA处理
        $strRsa =  $this->XRsa->privateEncrypt(json_encode($data));
        $client = new Client([
            'timeout' => '10.0'
        ]);
        $postHandle =  [
            'body'  => $strRsa
        ];
        try {
            $response = $client->request('POST', $notify_url, $postHandle);
            if ($response->getStatusCode() != '200') {
				#回调错误信息设置,商户平台URL访问失败,这里定成定时每分钟进行查询
				return false;
            }
            $body = $response->getBody()->getContents();
            if ($body == 'success') {
                #按一定策略进行回调处理 参数要设置好.商户平台返回的内容不正确,这里定成定时
                PayInfoModels::where('order_id', $order_id)->where('id', $pay_id)->lockForUpdate()->update(['third_pay_status'=>1]);
            }
            Log::info('pay---request', ['status'=>$body,'response'=> $response->getStatusCode(),'strRsa' => $strRsa,'data'=> $data ]);
        } catch (\Exception $e) {
            Log::info('pay--unityDispose---error--request', ['strRsa' => $strRsa,'data'=> $data,'notify_url'=>$notify_url]);
        }
        return true;
    }
    /**
     * 银行代付的统一处理流程 处理成功返回pay_status 设置为1 third_pay_status 是回调时设置 function
     * @param  [type] $datass    [回调返回的数据]
     * @return void
     */
    public function unityBank($datass)
    {
        $bankInfo = BankInfo::where('platform_order', $datass['orderId'])->first();

        $shopId = ShopModels::where('id', $bankInfo->pay_shop_id)->lockForUpdate()->first();
        
        #成功的才进行代付的处理,商户的钱数增加与减少
        if ($datass['respCode'] == '0000') {
            $shopMoney = [
                'shop_id'   =>$shopId->id,
                'before_money'    => $shopId->money,
                'money' => ($datass['amount'] + 400)  ,
                'after_money'   => $shopId->money - ($datass['amount'] + 400)  ,
                'active'    => '代付钱数:(分为单位加上手续费Ubey)'.($datass['amount'] + 400) . '||兑换订单'.$datass['orderId'],
            ];
            ShopMoney::create($shopMoney);

            //减去商户的钱数，增加与减少都需要对应的操作记录 成功的直接扣了。 所以不需要在这里扣。 实时比较好
            // $shopId->money = $shopId->money - ($datass['amount'] + 400)  ;
            // $shopId->save();
        } else {
            $shopMoney = [
                'shop_id'   =>$shopId->id,
                'before_money'    => $shopId->money,
                'money' => ($datass['amount'] + 400)  ,
                'after_money'   => $shopId->money + ($datass['amount'] + 400)  ,
                'active'    => '回退代付钱数:(分为单位加上手续费Ubey)'.($datass['amount'] + 400) . '||兑换订单'.$datass['orderId'],
            ];
            ShopMoney::create($shopMoney);

            //回退金钱，只是不做记录。
            $shopId->money = $shopId->money + ($datass['amount'] + 400)  ;
            $shopId->save();       
        }
        //代付状态: 1  受理中  2  已入账  3  入账失败  transStatus  pay_status = 1
        $bankInfo->transStatus =  $datass['respCode'] == '0000' ?  2 : 3;
        $bankInfo->pay_status = 1;
        $bankInfo->save();

        return 'ok';
    }

	/**
	 * 回调的处理完成设置 function
	 *
	 * @return void
	 */
	public function notifUnity($result)
	{
        $payInfo = PayInfoModels::where('platform_order', $result['orderNo'])->first();
		$data = [
            'order_id'  => $payInfo->order_id,
            'platform_order'    => $payInfo->platform_order,
            'totalfee'  => $payInfo->pay_money,
            'tradestate'    => 'TRADE_SUCCESS',
            'method'    => $payInfo->channel,
            'tradetime' => date('Y-m-d H:i:s'),
		];
		$this->unity($payInfo->pay_shop_id, $payInfo->pay_money, $data, $payInfo->notify_url, $payInfo->order_id, $payInfo->id);
	}
	/**
     *虚拟币的回调.......设置  与上面差不多。 但是要单独写
	 *
	 * @return void
	 */
	public function notifUnityVirtual($result)
	{
        $payInfo = PayInfoModels::where('platform_order', $result['orderNo'])->first();
        if (empty($payInfo)) {
            return 'false';
        }
		$data = [
            'order_id'  => $payInfo->order_id,
            'platform_order'    => $payInfo->platform_order,
            'totalfee'  => $payInfo->pay_money,
            'tradestate'    => 'TRADE_SUCCESS',
            'method'    => $payInfo->channel,
            'tradetime' => date('Y-m-d H:i:s'),
		];
		$this->unity($payInfo->pay_shop_id, $payInfo->pay_money, $data, $payInfo->notify_url, $payInfo->order_id, $payInfo->id);
	}
}
