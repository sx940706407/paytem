<?php

namespace App\Http\Controllers\system;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Log;
use Exception;
use Config;

/**
 * 第三方支付类，根据参数注入对应类型。 调起对应的支付类
 */
class ThridPayController extends Controller
{

    /**
     * 1.部调用默认为kue，用于统一切换所有线的支付渠道 订单查询都改成回调处理
     * @param  Request $request [SDK参数提交处理]
     * @return [type]           [封装的参数处理]
     */
    public static function pay($request)
    {
//        $request = self::channelAuto($request); 配置文件,自动切换第三方平台.
        try {
            $thridService = $request['third'] ?
                            'channelpay.'.$request['third'].'.service' :
                            'channelpay.kue.service';
            $service = Config::get($thridService);
            if (empty($service)) {
                throw new Exception("platform channel not support", 1);
            }
            return (new $service)->handle($request);
        } catch (Exception $e) {
            Log::info('ThridPayContoller====>ayException', ['e'  => $e]);

            return  response()->json(Config::get('error.1002'));
        }
    }
    /**
     * [payBank 银行的代付处理 代付查询也统一换成回调处理]
     * @param  Request $request [SDK参数提交处理]
     * @return [type] [data]
     */
    public static function payBank($request)
    {
        try {
            $thridService = $request['third'] ?
                            'channelpay.'.$request['third'].'.service' :
                            'channelpay.kue.service';
            $service = Config::get($thridService);

            if (empty($service)) {
                throw new Exception("platform channel not support", 1);
            }
            return (new $service)->handleBank($request);
        } catch (Exception $e) {
            return  response()->json(Config::get('error.1002'));
        }
    }
}
