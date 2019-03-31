<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Log;
use App\Models\Third\PayInfoModels;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

use Payment\Common\PayException;
use Payment\Client\Charge;
use Payment\Config as PayConfig;

use App\Models\Third\ShopModels;

use App\Services\XRsa;
use GuzzleHttp\Client;

/**
 * 订单首次生成的时候处理,1.直接查询远程的订单状态. 脚本休眠7秒10次的查询
 * 2.如果订单一直没有响应,不使用第三方的回调情况下。 使用定时脚本进行查询(每分钟) 。 1小时的内的调用.订单处理情况
 *
 */
class NotifyHandle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $XRsa;


    protected $pay;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PayInfoModels $pay)
    {
        $this->pay = $pay;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->XRsa =  new XRsa();
        // Log::info('payNotifyHandle',['pay' => $this->pay]);
        sleep(6);
        $i = 1;
        #回调这里订单查询需要使用延时处理.
        while ($i < 8) {
            #延缓执行订单查询接口,查询超过7次则跳出, 一分内没有支付成功.  支付成功的状态为1则 直接跳出
            sleep(6);

            $kueConfig = Config::get('kue.kue_alipay_wechat');

            $payData = [
                'funname'   => 'orderquery', //prepay h5 支付
                'merid' => Config::get('kue.kue_alipay_wechat.KUE_ONE_QQ_H5_MERID'),
                'paymethod' => $this->pay->channel ?? 'wx',
                'orderid'    => $this->pay->platform_order,
                #加密方式 与 对应的MD5签名 就是密钥
                'md5Key'    => Config::get('kue.kue_alipay_wechat.KUE_ONE_QQ_H5_SIGN'),
                'signType'  => 'MD5',
            ];

            switch ($this->pay->channel) {
                            case 'wx':
                            case 'zfb':
            $kueConfig = Config::get('kue.kue_alipay_wechat');

            $payData = [
                'funname'   => 'orderquery', //prepay h5 支付
                'merid' => Config::get('kue.kue_alipay_wechat.KUE_ONE_QQ_H5_MERID'),
                'paymethod' => $this->pay->channel ?? 'wx',
                'orderid'    => $this->pay->platform_order,
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
                'paymethod' => $this->pay->channel ?? 'wx',
                'orderid'    => $this->pay->platform_order,
                #加密方式 与 对应的MD5签名 就是密钥
                'md5Key'    => Config::get('kue.kue_faster.KUE_ONE_QQ_H5_SIGN'),
                'signType'  => 'MD5',
            ];

                                break;
                            case  'qq':


            $payData = [
                'funname'   => 'orderquery', //prepay h5 支付
                'merid' => Config::get('kue.kue.KUE_ONE_QQ_H5_MERID'),
                'paymethod' => $this->pay->channel ?? 'wx',
                'orderid'    => $this->pay->platform_order,
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
            } catch (\PayException $e) {
                Log::info('payNotifyHandleException');
                continue;
            }

            Log::info('payNotifyHandleException2', ['ret'=>$ret]);

            if ($ret['flag'] == '00') {
                if ($ret['tradestate'] == 'TRADE_SUCCESS') {
                    $payInfo = PayInfoModels::where('order_id', $this->pay->order_id)->where('id', $this->pay->id)->first();

                    if ($payInfo) {
                        if ($payInfo->pay_status == 1) {
                            return false;
                        }
                    }

                    PayInfoModels::where('order_id', $this->pay->order_id)->where('id', $this->pay->id)->update(['pay_status'=>1,'pay_done_time'  => date('Y-m-d H:i:s')]);

                    #需要更新本HT平台商户所获取钱数. 需要在订单查询与队列进行调用

                    #还需要回调客户端发送的URL。 方便线上的调试本地要做好内网传递
                    $i = 11;

                    #1组装返回的数据，用于通知客户端. 的回调接口 $this->pay->notify_url
                    $data = [
                        'order_id'  => $this->pay->order_id,
                        'platform_order'    => $this->pay->platform_order,
                        'totalfee'  => $this->pay->totalfee,
                        'tradestate'    => 'TRADE_SUCCESS',
                        'method'    => $this->pay->channel,
                        'tradetime' => date('Y-m-d H:i:s'),
                    ];
                    #增加签名并查找 用户商户ID
                    $shop = ShopModels::where('id', $this->pay->pay_shop_id)->first();
                    if (!$shop) {
                        break;
                    }
                    #更新商户钱数
                    $shop->money = $shop->money + ($this->pay->pay_money *100);
                    $shop->save();

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
                        $response = $client->request('POST', $v->notify_url, $postHandle);
                        if ($response->getStatusCode() != '200') {
                            #回调错误信息设置,商户平台URL访问失败,这里定成定时每分钟进行查询
                            break;
                        }

                        $body = $response->getBody()->getContents();
                        if ($body == 'success') {
                            #按一定策略进行回调处理 参数要设置好.商户平台返回的内容不正确,这里定成定时
                            PayInfoModels::where('order_id', $v->order_id)->where('id', $this->pay->id)->update(['third_pay_status'=>1]);
                        }
                        Log::info('payNotifyHandleRquest==>JOBS==>', ['status'=>$body,'response'=> $response->getStatusCode(),'strRsa' => $strRsa,'data'=> $data ]);
                    } catch (\Exception $e) {
                        Log::info('payNotifyHandleRquest==>JOBS==>', ['strRsa' => $strRsa,'data'=> $data]);
                    }
                    break;
                } else {
                    PayInfoModels::where('order_id', $this->pay->order_id)->where('id', $this->pay->id)->increment('pay_query_count', 1);
                }
            } else {
                PayInfoModels::where('order_id', $this->pay->order_id)->where('id', $this->pay->id)->increment('pay_query_count', 1);
            }

            $i++;
        }
    }
}
