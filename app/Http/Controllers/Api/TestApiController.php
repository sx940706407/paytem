<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Controllers\system\ThridPayController;
class TestApiController extends Controller
{
    /**
     * 测试内部接口支付调用 处理 function
     *
     * @return void
     */
    public function pay()
    {
        $request = [
            'third' => 'ubey',
            #分为公共参数 20 30 50 100 200 300 500
            'body' => 'ubey_body',
            'call' => 'h5', 
            'paymethod' => 'zfb',
            'notifyurl' => 'http://notify.dfylpro.com:10001',
            # 与 局部的API调用参数处理
            'totalfee'  => 50,  // 5000以下ZFB
            'order_id' => 'UBEY'.time().mt_rand(99999,111111111),
            'app_id' => '3000026125023',
        ];
        $response = ThridPayController::pay($request);
        dd($response);
        header("Location:".$response['stateData']['mweburl']);
    }
    /**
     * 虚拟币的 设置 function
     *
     * @return void
     */
    public function virtual()
    {
        $request = [
            'third' => 'virtual',
            #分为公共参数
            'body' => 'virtual',
            'notifyurl' => 'http://xxxxxx:10003',
    		'paymethod'	=> 'virtual',
    		'call'	=> 'virtual',
            # 与 局部的API调用参数处理
            'totalfee'  => 100,
            'order_id' => 'suispay'.time().mt_rand(99999,111111111),
            'app_id' => '3000010896032',
            'user_id'   => 100002,
        ];
        $response = ThridPayController::pay($request);     
        // return $response;
        header("Location:".$response['stateData']['mweburl']);
    }

}
