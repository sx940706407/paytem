<?php
namespace App\Pay\Channel;

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
use App\Services\Virtualcurrency;
class Virtual extends BasePayData
{

    /**
     * 虚拟币支付 操作 function
     *  1.判断当前帐号是否创建与绑定到一个用户名上.
     *  2.如已绑定则 继续判断当天购买错误次数3次以上返回错误
     * @param [type] $request
     * @return void
     */
    public function handle($request)
    {
        $Virtualcurrency = new Virtualcurrency();
        try {
            $orderId = date('YmdHis').time().mt_rand(10000000, 99999999);
            $resutl = $Virtualcurrency->login($request['user_id'],$request['totalfee'],$orderId);
            
            if ($resutl != 'failed' && $resutl['Success'] == true) {
                Log::info('Channel\VIRTUAL\handle====>STATUS===>T');

                $url = $resutl['Data']['Url'] .'/'.$resutl['Data']['Token'];

                $shopId = ShopModels::where('app_id', $request['app_id'])->value('id');
                $data = [
                    'third'	=> 'virtual',
                    'channel'	=> $request['paymethod'],
                    'payType'	=> $request['call'],
                    'body'	=> $request['body'] ?? '虚拟币_币宝',
                    'subject'	=> $request['body'] ?? '虚拟币_币宝',
                    'order_id'	=> $request['order_id'],
                    'platform_order'	=> $orderId,
                    'notify_url'	=> $request['notifyurl'] ?? '',
                    'pay_shop_id'	=> $shopId ?? 1,
                    'pay_money'	=> $request['totalfee'] * 100  ?? 1,
                    'pay_formality'	=> 0.03,
                    'pay_channel_id'	=> 1,
                    'pay_time'	=> date('Y-m-d H:i:s'),
                    'pay_callback_content'  => json_encode($resutl),
                    'pay_data'  => json_encode($request)
                ];
                $PayInfoModels = PayInfoModels::create($data);
                $response = Config::get('error.200');
                #短链接与二维码地址,shorturl生成好的二维码地址 codeurl二维码信息
                $response['stateData']['shorturl'] =  '';
                $response['stateData']['codeurl'] =  ''; 
                $response['stateData']['outtradeno'] = $orderId;
                $response['stateData']['mweburl'] = $url;
                return $response;
            } else {
                throw new \Exception("接口调用异常", 1);
            }
        } catch (PayException $e) {
            Log::info('Channel\VIRTUAL\handle===>STATUS===>PayException');
            return  $this->ConfigRetrun(3002);
            exit;
        }
    }
}
