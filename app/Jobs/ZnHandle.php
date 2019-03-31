<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

use Payment\Common\PayException;
use Payment\Client\Charge;
use Payment\Config as PayConfig;

use App\Models\Third\ShopModels;
use App\Models\Third\PayInfoModels;

use App\Services\XRsa;
use GuzzleHttp\Client;

use App\Pay\Channel\UnityDispose;

class ZnHandle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $XRsa;


    protected $pay;

    protected $unity;

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
        $UnityDispose = new UnityDispose();

        $zhongConfig = Config::get('zhong.zhong');
        $response = Config::get('error.200');
        sleep(4);
        #每6秒查询一次订单的情况，如果已经成功则更新对应字段并回调商户的平台接口
        for ($i=0; $i <= 6 ; $i++) {
            $payData = [
            'merchantNo'    => $zhongConfig['ID'],
            //应该用的是平台支付的订单ID，区分商户的操作.
            'orderNo'   => $this->pay->platform_order,
        ];
            $data = [
            'order_id'  => $this->pay->order_id,
            'platform_order'    => $this->pay->platform_order,
            'totalfee'  => $this->pay->totalfee,
            'tradestate'    => 'TRADE_SUCCESS',
            'method'    => $this->pay->channel,
            'tradetime' => date('Y-m-d H:i:s'),
        ];

            try {
                $ret = Charge::run(PayConfig::ZHONG_CHANNEL_STATUS, $zhongConfig, $payData);
                #支付状态status T 返回成功处理
                if ($ret['status'] == 'T') {

                #应该处理成功的情况下，就不需要继续访问unity方法了
                    $payInfoModels = PayInfoModels::where('order_id', $this->pay->order_id)->where('pay_status', 1)->first();

                    if ($payInfoModels) {
                        $i = 8;
                        break;
                    }
                    $unity = $UnityDispose->unity($this->pay->pay_shop_id, $this->pay->pay_money, $data, $this->pay->notify_url, $this->pay->order_id, $this->pay->id);
                    if ($unity) {
                        $i =8;
                    }
                    Log::info('ZNHANDLE---JOBS---T', ['response'=> $response,'ret'  => $ret]);
                }
                Log::info('ZNHANDLE---JOBS---F', ['response'=> $response,'ret'  => $ret]);
            } catch (PayException $e) {
                Log::info('ZNHANDLE---JOBSException---F', ['response'=> $response,'ret'  => $ret]);
                exit;
            }
            sleep(6);
        }
    }
}
