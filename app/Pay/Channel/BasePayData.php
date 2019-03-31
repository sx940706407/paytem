<?php
namespace App\Pay\Channel;

use Config;
use DB;
use Log;
use QL\QueryList;
use App\Jobs\NotifyHandle;
use Payment\Utils\ArrayUtil;

class BasePayData
{
    /**
     * 不同的渠道支持的参数都不一样，与对应的H5与SM这两个 function
     *
     * @param [type] $third
     * @return void
     */
    public function paymentData(array $third, array $payData)
    {
        switch ($third['third']) {
            case 'chinaums':
                #平台识别对应的商户号 对应的游戏处理. 比如天天 == 本平台的商户号
                if ($third['call'] == 'h5') {
                    $call = [
                        'zfb'   => 'trade.h5Pay',
                        'wx'   => 'WXPay.h5Pay',
                        'unionpay'   => 'uac.order',
                    ];
                    $payData['msgType'] = $call[$third['paymethod']];
                    if ($third['paymethod'] == 'wx') {
                        #微信H5支付必填。参数 官方的也一样
                        $payData['sceneType'] = $third['sceneType'] ? 
                                                    $third['sceneType'] : 
                                                    '';
                        $payData['merAppName'] = $third['merAppName'] ? 
                                                    $third['merAppName']: 
                                                     '';
                        $payData['merAppId'] = $third['merAppId'] ? 
                                                    $third['merAppId'] :
                                                    '';
                    }
                } elseif ($third['call'] == 'sm') {
                    return  Config::get('error.1003');
                }
                return $payData;
                break;
                #随身付
            case 'suispay': 
                if ($third['call'] == 'h5') {
                    $call = [
                        'zfb'   => 'pay.alipay.wap',
                        'qq'   => 'pay.qq.wap',
                        'wx'   => 'pay.weixin.wap',
                        'unionpay'   => 'unified.trade.micropay'
                    ];
                    $payData['service'] = $call[$third['paymethod']];
                } elseif ($third['call'] == 'sm') {
                    $call = [
                        'qq'   => 'pay.qq.native',
                        'wx'    => 'pay.weixin.native',
                        'zfb'   => 'pay.alipay.native'
                    ];


                    return  Config::get('error.1003');
                }
                return $payData;
                break;
                #和付通
            case 'htf':
                if ($third['call'] == 'h5') {
                    $call = [
                        'zfb'   => 'ALIPAY_WAP_PAY',
                        'qq'   => 'QQ_WAP_PAY',
                        'wx'   => 'WECHAT_WAP_PAY',
                        'unionpay'   => 'UNIONPAY_WAP_PAY',
                        'jd'   => 'JD_WAP_PAY',
                        'baidu'   => 'BD_WAP_PAY',
                        'sn'   => 'SN_WAP_PAY',
                        'mt'   => 'MT_WAP_PAY',
                        // 'faster_unionpay'   => 'ONLINE_BANK_QUICK_PAY',
                    ];
                    $payData['payment_type'] = $call[$third['paymethod']];
                } else {
                    return  Config::get('error.1003');
                }
                $payData['sign'] = $this->htfSign($payData);
                return $payData;
                break;
            case 'Baisheng': 

               if ($third['call'] == 'h5') {
                    $call = [
                        'zfb'   => 'ALIPAY_WAP_PAY', //ALIPAY_WAP_PAY_1
                        'wx'   => 'WECHAT_WAP_PAY',  //WECHAT_WAP_PAY_1
                    ];
                    $payData['PaymentTypeCode'] = $call[$third['paymethod']];
                } else {
                    $call = [
                        'jd'   => 'JD_QRCODE_PAY', //ALIPAY_WAP_PAY_1
                        'zfb'   => 'ALIPAY_QRCODE_PAY',
                        'unionpay'   => 'UNIONPAY_QRCODE_PAY',
                    ];
                    $payData['PaymentTypeCode'] = $call[$third['paymethod']];
                }
                return $payData;
                break;
            default:
                return  Config::get('error.1003');
                break;
        }
    }

    /**
     * 封装返回的数据 主要是SM与H5的这两个处理 单独封装处理 chinaums function
     *
     * @param Array $response
     * @return void
     */
    public function packageReturnChinaums( $responseHttp,Array $third,String $orderNo)
    {
        $response = Config::get('error.200');
        #短链接与二维码地址,shorturl生成好的二维码地址 codeurl二维码信息
        $response['stateData']['shorturl'] =  '';
        $response['stateData']['codeurl'] =  ''; 
        $response['stateData']['outtradeno'] = $orderNo;
        #ZFB 返回的HTML，需要单独获取链接就行
        switch ($third['paymethod']) {
            case 'zfb':
                $payUrlHref = QueryList::html($responseHttp)->find('#payUrlA')->attrs('href');
                $response['stateData']['mweburl'] = $payUrlHref[0]  ?? ''; //生成本地的ID
                
                return ['response' =>$response,'resultUrl' => $payUrlHref[0] ?? '' ];
                break;
            case 'wx': 
                return ['response' =>$response,'resultUrl' => 'wx'];
                #银联基本是返回HTML，需要封装一层在返回给客户端处理
            case 'unionpay':
                return ['response' =>$response,'resultUrl' => 'unionpay'];
                break;
            default:
                return ['response' =>$response];
                break;
        }
    }


    public function packageRetrunHtf($responseHttp,Array $third,String $orderNo)
    {
        $response = Config::get('error.200');
        #短链接与二维码地址,shorturl生成好的二维码地址 codeurl二维码信息
        $response['stateData']['shorturl'] =  '';
        $response['stateData']['codeurl'] =  ''; 
        $response['stateData']['outtradeno'] = $orderNo;
        $response['stateData']['htmlwap'] = $responseHttp;
        #ZFB 返回的HTML，需要单独获取链接就行
        switch ($third['paymethod']) {
            case 'zfb':
                // $payUrlHref = QueryList::html($responseHttp)->find('h2 > a')->attrs('href');
                // $response['stateData']['mweburl'] = $payUrlHref[0]  ?? ''; //生成本地的ID
                return ['htmlwap' =>$response ];
                break;
            case 'wx': 
                return ['htmlwap' =>$response];
                #银联基本是返回HTML，需要封装一层在返回给客户端处理
            case 'unionpay':
                return ['htmlwap' =>$response];
                break;
            default:
                return ['htmlwap' =>$response];
                break;
        }
    }



    public function packageRetrunBaisheng($responseHttp,Array $third,String $orderNo)
    {
        $response = Config::get('error.200');
        #短链接与二维码地址,shorturl生成好的二维码地址 codeurl二维码信息
        $response['stateData']['shorturl'] =  '';
        $response['stateData']['codeurl'] =  ''; 
        $response['stateData']['outtradeno'] = $orderNo;
        $response['stateData']['htmlwap'] = $responseHttp;
        #ZFB 返回的HTML，需要单独获取链接就行
        switch ($third['paymethod']) {
            case 'zfb':
            case 'wx': 
            case 'unionpay':
                return ['htmlwap' =>$response ];
        }
    }


    /**
     * 支付参数的签名生成 function
     *
     * @param [type] $payData
     * @return void
     */
    public function htfSign($paydata)
    {
        $paydata = ArrayUtil::paraFilter($paydata);
        $paydata = ArrayUtil::arraySort($paydata);

        $paydata = $this->createLinkstringUrlencode($paydata);

        $sign = md5($paydata.'b03346caea57bcb84517adb44bef9100');
        return $sign;
    }

    /**
     * 随身支付的配置 function
     *
     * @param [type] $responseHttp
     * @param Array $third
     * @param String $orderNo
     * @return void
     */
    public function packageReturnSuispay($responseHttp,Array $third,String $orderNo)
    {
        $response = Config::get('error.200');
        #短链接与二维码地址,shorturl生成好的二维码地址 codeurl二维码信息
        $response['stateData']['shorturl'] =  '';
        $response['stateData']['codeurl'] =  ''; 
        $response['stateData']['outtradeno'] = $orderNo;
        $response['stateData']['mweburl'] = $responseHttp; //生成本地的ID

        return $response;
    }

    /**
     * 是否开户队列，分为主动与被动两种方式进行查询 function
     *
     * @return void
     */
    public function queueStart()
    {
        #触发队列任务,检查订单任务状态，每6秒进行查询(检测9次)。如果已经支付则回调用户的URL
        dispatch(new NotifyHandle($PayInfoModels));
    }

    /**
     * 封装返回的配置文件  function
     *
     * @return void
     */
    public function ConfigRetrun($number)
    {
        return Config::get('error'.$number);
    }

    public  function createLinkstringUrlencode($para) {
        $arg  = "";
        foreach ($para as $key => $val) {
            $arg.=$key."=".urlencode($val)."&";
        }
        //去掉最后一个&字符
        $arg = rtrim($arg,'&');
        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
        
        return $arg;
    }

}
