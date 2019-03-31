<?php

namespace App\Console\Commands\Api;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


use App\Models\Third\PayInfoModels;
use App\Models\Third\ShopModels;

use App\Services\XRsa;
use GuzzleHttp\Client;
class tradeStateNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pay:payQueryKueThrid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'thrid callback http';

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
        sleep(5);
        //pay_status 为1的情况下进行调用,pay_notify_time pay_notify_count (回调时间,并回调的次数大于7次则标记为，商户自己没有处理. 则通过查询订单来完成)
        //30分内的订单查询
        $body = '';
        $pay =  PayInfoModels::where('pay_status',1)->where('third_pay_status','!=',1)->lockForUpdate()->get();
        // Log::info('tradeStateNotifyStatus_crontab',['time'=> date('Y-m-d') ]);

        //调用策略（1m,1m,5m,10m,1h,6h,12h）默认第一次是调用过的
        foreach ($pay as $k => $v) {
            #1组装返回的数据，用于通知客户端. 的回调接口 $v->notify_url
            $data = [
                'order_id'  => $v->order_id,
                'platform_order'    => $v->platform_order,
                'totalfee'  => $v->pay_money / 100,  //统一按元为单位返回
                'tradestate'    => 'TRADE_SUCCESS',
                'method'    => $v->channel,
                'tradetime' => date('Y-m-d H:i:s'),
            ];  
            #增加签名并查找 用户商户ID
            $shop = ShopModels::where('id',$v->pay_shop_id)->first();
            if (!$shop) continue;

            $data['sign'] = verify_sign_str($data,$shop->app_secret);
            $this->XRsa =  new XRsa();
            $strRsa =  $this->XRsa->privateEncrypt( json_encode( $data ) );
            $client = new Client([
                'timeout' => '10.0'
            ]);
            $postHandle =  [
                'body'  => $strRsa
            ];
            $time = time();
            #防止订单的已经在队列中发送处理了.或者使用锁机制来处理
            $payInfoModels = PayInfoModels::where('order_id', $v->order_id)->where('third_pay_status', 1)->first();
            if ($payInfoModels) {
                continue;
            }
            switch ($v->pay_notify_count) {
                 case '':
                 case 0:
                 case 1:

                    # local.ERROR: Server error: `POST http://qpgame.s16.hongtonggame.com:5555/bosscmd/htpayCallBack.php`  需要try catch
                   
                    try {
                        $response = $client->request('POST', $v->notify_url, $postHandle);
                        if ($response->getStatusCode() != '200') {

                            $v->pay_notify_time = $time + 60;
                            $v->pay_notify_count = 2;
                            $v->save();
                            break;
                        }
                        $body = $response->getBody()->getContents();
                        if ($body == 'success') {
                           #按一定策略进行回调处理 参数要设置好.商户平台返回的内容不正确,这里定成定时
                           $v->third_pay_status = 1;
                           $v->save();
                        } else {

                            $v->pay_notify_time = $time + 60;
                            $v->pay_notify_count = 2;
                            $v->save();
                        }                        
                    } catch (\Exception $e) {
                            $v->pay_notify_time = $time + 60;
                            $v->pay_notify_count = 2;
                            $v->save();                        
                    }


                    Log::info('tradeStateNotifyStatus===>1',['status'=>$body,'data'=> $data,'strRsa'=> $strRsa ]);

                     break;
                 case 2:
                    if (time() <= $v->pay_notify_time ) continue ; 

                    try {
                        $response = $client->request('POST', $v->notify_url, $postHandle);
                        if ($response->getStatusCode() != '200') {
                            $v->pay_notify_time = $time + 60;
                            $v->pay_notify_count = 3;
                            $v->save();
                            break;
                        }

                        $body = $response->getBody()->getContents();
                        if ($body == 'success') {
                           #按一定策略进行回调处理 参数要设置好.商户平台返回的内容不正确,这里定成定时
                           $v->third_pay_status = 1;
                           $v->save();
                        } else {
                            $v->pay_notify_time = $time + 60;
                            $v->pay_notify_count = 3;
                            $v->save();                            
                        }                        
                    } catch (\Exception $e) {
                            $v->pay_notify_time = $time + 60;
                            $v->pay_notify_count = 3;
                            $v->save();     
                    }
                    Log::info('tradeStateNotifyStatus===>2',['status'=>$body,'data'=> $data ,'strRsa'=> $strRsa ]);
                     break;
                case 3:
                    if (time() <= $v->pay_notify_time ) continue ; 

                        try {
                            $response = $client->request('POST', $v->notify_url, $postHandle);
                            if ($response->getStatusCode() != '200') {
                                $v->pay_notify_time = $time + 300;
                                $v->pay_notify_count = 4;
                                $v->save(); 
                                break;
                            }

                            $body = $response->getBody()->getContents();
                            if ($body == 'success') {
                               #按一定策略进行回调处理 参数要设置好.商户平台返回的内容不正确,这里定成定时
                               $v->third_pay_status = 1;
                               $v->save();

                            } else {

                                $v->pay_notify_time = $time + 300;
                                $v->pay_notify_count = 4;
                                $v->save();
                            }                            
                        } catch (\Exception $e) {
                                $v->pay_notify_time = $time + 300;
                                $v->pay_notify_count = 4;
                                $v->save();                            
                        }

                        Log::info('tradeStateNotifyStatus===>3',['status'=>$body,'data'=> $data ,'strRsa'=> $strRsa]);
   
                    break;
                case 4:
                    if (time() <= $v->pay_notify_time ) continue ; 

                        try {
                            $response = $client->request('POST', $v->notify_url, $postHandle);
                            if ($response->getStatusCode() != '200') {

                                $v->pay_notify_time = $time + 600;
                                $v->pay_notify_count = 5;
                                $v->save();  
                                break;
                            }

                            $body = $response->getBody()->getContents();
                            if ($body == 'success') {
                               #按一定策略进行回调处理 参数要设置好.商户平台返回的内容不正确,这里定成定时
                               $v->third_pay_status = 1;
                               $v->save();
                            } else {
                                $v->pay_notify_time = $time + 600;
                                $v->pay_notify_count = 5;
                                $v->save();
                            }                            
                        } catch (\Exception $e) {
                                $v->pay_notify_time = $time + 600;
                                $v->pay_notify_count = 5;
                                $v->save();                            
                        }

                        Log::info('tradeStateNotifyStatus===>4',['status'=>$body,'data'=> $data ]);

                    break;
                case 5:
                    if (time() <= $v->pay_notify_time ) continue ; 

                        try {
                            $response = $client->request('POST', $v->notify_url, $postHandle);
                            if ($response->getStatusCode() != '200') {

                                $v->pay_notify_time = $time + 3600;
                                $v->pay_notify_count = 6;
                                $v->save();
             
                                break;
                            }

                            $body = $response->getBody()->getContents();
                            if ($body == 'success') {
                               #按一定策略进行回调处理 参数要设置好.商户平台返回的内容不正确,这里定成定时
                               $v->third_pay_status = 1;
                               $v->save();
                            } else {
                                $v->pay_notify_time = $time + 3600;
                                $v->pay_notify_count = 6;
                                $v->save();

                            }                            
                        } catch (\Exception $e) {
                                $v->pay_notify_time = $time + 3600;
                                $v->pay_notify_count = 6;
                                $v->save();
                        }


                        Log::info('tradeStateNotifyStatus===>5',['status'=>$body,'data'=> $data ]);

                    break;
                case 6:
                    if (time() <= $v->pay_notify_time ) continue ; 
                        try {
                            $response = $client->request('POST', $v->notify_url, $postHandle);
                            if ($response->getStatusCode() != '200') {
                                $v->pay_notify_time = $time + 21600;
                                $v->pay_notify_count = 7;
                                $v->save(); 
                                break;
                            }

                            $body = $response->getBody()->getContents();
                            if ($body == 'success') {
                               #按一定策略进行回调处理 参数要设置好.商户平台返回的内容不正确,这里定成定时
                               $v->third_pay_status = 1;
                               $v->save();
                            } else {
                                $v->pay_notify_time = $time + 21600;
                                $v->pay_notify_count = 7;
                                $v->save(); 
                            }                            
                        } catch (\Exception $e) {
                                $v->pay_notify_time = $time + 21600;
                                $v->pay_notify_count = 7;
                                $v->save();                             
                        }


                        Log::info('tradeStateNotifyStatus===>6',['status'=>$body,'data'=> $data ]);
                    break;
                case 7:
                    if (time() <= $v->pay_notify_time ) continue ; 

                        try {
                            $response = $client->request('POST', $v->notify_url, $postHandle);
                            if ($response->getStatusCode() != '200') {
                                $v->pay_notify_count = 10;
                                $v->third_pay_status = 1;
                                $v->save();  
                                break;
                            }

                            $body = $response->getBody()->getContents();
                            if ($body == 'success') {
                               #按一定策略进行回调处理 参数要设置好.商户平台返回的内容不正确,这里定成定时
                               $v->third_pay_status = 1;
                               $v->save();

                            } else {
                                $v->pay_notify_count = 10;
                                $v->third_pay_status = 1;
                                $v->save();                            
                            }                            
                        } catch (\Exception $e) {
                                $v->pay_notify_count = 10;
                                $v->third_pay_status = 1;
                                $v->save();         
                        }

                        Log::info('tradeStateNotifyStatus===>7',['status'=>$body,'data'=> $data ]);

                    break;
                 default:
                    $v->pay_notify_count = 10;
                    $v->third_pay_status = 1;
                    $v->save();
                    //直接设置为成功，不处理。 商户自己承担

                     break;
             } 


        }


    }
}
