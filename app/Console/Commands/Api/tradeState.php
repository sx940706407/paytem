<?php

namespace App\Console\Commands\Api;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

use Payment\Common\PayException;
use Payment\Client\Charge;
use Payment\Config as PayConfig;

use App\Models\Third\PayInfoModels;
use App\Models\Third\ShopModels;

use App\Services\XRsa;
use GuzzleHttp\Client;
/**
 * 查询pay_status状态为0的情况下处理，并回调第三方的方法. 如果本次调用失败对方接口，则按一定策略进行回调处理
 * 
 */
class tradeState extends Command
{
    public $XRsa;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pay:payQueryKue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kue Pay Query';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        #查找thid第三方类KUE尚未支付的订单进行处理,如果交易成功的情况下回调客户端的URL地址,二小时内的订单。 后面订单会失效.  这里自己也要做下.
        $startTime = date('Y-m-d H:i:s',time());
        $endTime = date('Y-m-d H:i:s',time() - 900);

        $pay = PayInfoModels::where('third','kue')->where('pay_status',0)
            ->whereBetween('created_at',[$endTime,$startTime])
            ->get();


        #还需要根据渠道进行调用,对应的配置文件
        foreach ($pay as $k => $v) {


            $kueConfig = []; $payData = [];

            switch ($v->channel) {
                            case 'wx':
                            case 'zfb':
            $kueConfig = Config::get('kue.kue_alipay_wechat');

            $payData = [ 
                'funname'   => 'orderquery', //prepay h5 支付
                'merid' => Config::get('kue.kue_alipay_wechat.KUE_ONE_QQ_H5_MERID'),
                'paymethod' => $v->channel ?? 'wx',
                'orderid'    => $v->platform_order,
                #加密方式 与 对应的MD5签名 就是密钥
                'md5Key'    => Config::get('kue.kue_alipay_wechat.KUE_ONE_QQ_H5_SIGN'),
                'signType'  => 'MD5',
            ];
                                break;
                            case 'unionpay':
            $kueConfig = Config::get('kue.kue_faster');

            $payData = [ 
                'funname'   => 'orderquery', //prepay h5 支付
                'merid' => Config::get('kue.kue_faster.KUE_ONE_QQ_H5_MERID'),
                'paymethod' => $v->channel ?? 'wx',
                'orderid'    => $v->platform_order,
                #加密方式 与 对应的MD5签名 就是密钥
                'md5Key'    => Config::get('kue.kue_faster.KUE_ONE_QQ_H5_SIGN'),
                'signType'  => 'MD5',
            ];

                                break;
                            case  'qq':


            $payData = [ 
                'funname'   => 'orderquery', //prepay h5 支付
                'merid' => Config::get('kue.kue.KUE_ONE_QQ_H5_MERID'),
                'paymethod' => $v->channel ?? 'wx',
                'orderid'    => $v->platform_order,
                #加密方式 与 对应的MD5签名 就是密钥
                'md5Key'    => Config::get('kue.kue.KUE_ONE_QQ_H5_SIGN'),
                'signType'  => 'MD5',
            ];

                                break;
                            default:
                                # code...
                                break;
            }            



            try {
                $ret = Charge::run(PayConfig::KE_CHANNEL_QQ_H5_STATUS, $kueConfig, $payData);
            } catch (PayException $e) {
                    Log::info('payNotifyHandleException');
                continue;
            }

            Log::info('payCrontabWatime==>',['ret'=>$ret]);

            if ($ret['flag'] == '00') {
                if ($ret['tradestate'] == 'TRADE_SUCCESS') {
                    $v->pay_status = 1;
                    $v->pay_done_time =  date('Y-m-d H:i:s');
                    $v->save();

                      // PayInfoModels::where('order_id',$v->order_id)->update(['pay_status'=>1,'pay_done_time'  => date('Y-m-d H:i:s')]);
                    #1组装返回的数据，用于通知客户端. 的回调接口 $v->notify_url
                    $data = [
                        'order_id'  => $v->order_id,
                        'platform_order'    => $v->platform_order,
                        'totalfee'  => $v->totalfee,
                        'tradestate'    => 'TRADE_SUCCESS',
                        'method'    => $v->channel,
                        'tradetime' => date('Y-m-d H:i:s'),
                    ];  

                    #应该增加一个触发的回调处理....而不是写在多个方法里面》。。
                

                    #增加签名并查找 用户商户ID
                    $shop = ShopModels::where('id',$v->pay_shop_id)->first();
                    if (!$shop) break;
                        #更新商户钱数
                    $shop->money = $shop->money + ($v->pay_money *100);
                    $shop->save();
                    
                    $data['sign'] = verify_sign_str($data,$shop->app_secret);
                    $this->XRsa =  new XRsa();

                    #加密RSA处理
                    $strRsa =  $this->XRsa->privateEncrypt( json_encode( $data ) );
                    $client = new Client([
                        'timeout' => '10.0'
                    ]);

                    $postHandle =  [
                        'body'  => $strRsa
                    ];

                    try {
                        $response = $client->request('POST', $v->notify_url, $postHandle);
                        if ($response->getStatusCode() != '200') {
                            #回调错误信息设置,商户平台URL访问失败,这里定成定时每分钟进行查询   
                            break;
                        }

                        $body = $response->getBody()->getContents();
                        if ($body == 'success') {
                           #按一定策略进行回调处理 参数要设置好.商户平台返回的内容不正确,这里定成定时
                            // PayInfoModels::where('order_id',$v->order_id)->update(['third_pay_status'=>1]);

                            $v->third_pay_status = 1;
                            $v->save();
                        }
                        Log::info('payNotifyHandleRquest',['status'=>$body,'response'=> $response->getStatusCode(),'strRsa' => $strRsa,'data'=> $data ]);
                    } catch (\Exception $e) {
                        Log::info('payNotifyHandleRquest',['strRsa' => $strRsa,'data'=> $data]);
                        
                    }

                  break;
                } else {
                    $v->pay_query_count += 1;
                    $v->save();
                    // DB::table('third_pay_info')->increment('pay_query_count',1,['order_id'=>$v->order_id ]);
                }
            } else {
                    $v->pay_query_count += 1;
                    $v->save();
                    // DB::table('third_pay_info')->increment('pay_query_count',1,['order_id'=>$v->order_id ]);
            }



        }
    }
}
