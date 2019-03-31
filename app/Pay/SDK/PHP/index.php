<?php

use common\XRsa;
use common\Http;
use common\ArrayUtil;
use common\Log;

define('APP_PATH', __DIR__);
ini_set("display_errors", "On");
error_reporting(E_ALL || E_STRICT);

final class Pay
{

    const url = 'http://192.168.1.251:8055/';  //   192.168.1.251:8055/ http://pay.dfylpro.com/


    //商户ID  每个平台都需要单独申请，用于识别对应的游戏
    const APPID = '3000010896032';
    //商户密钥
    const APPSECRET = 'NbzNuHi0ckrt0gBK7b8mn41qrMGp87y29GC7chvu';

    private $log;
    /**
     * [payEntry 商户统一下单入口]
     * @return [type] [description]
     */
    public static function payEntry()
    {
        header("Content-Type: text/html; charset=utf-8");  
        #1.组装数据  2018-11-08 新增wxH5支持 需要新增加三个参数
        $data = [
            'body'	=> '支付内容', // string 支付信息内容
            'call'	=> 'h5',  //目前只存在 sm ,与H5 两种调用方式  string
            'paymethod'	=> 'unionpay', //支付方法, 存在qq,unionpay,zfb,wx对应支付call的方式
            'totalfee'	=> 1 ,//单位为元,请留意!!
            'third'	=> 'ubey',  // ubey  与 chinaums 两个第三方平台
            'notifyurl'	=> 'http://192.168.1.251:8011/index.php?op=notify', //商户个人的回调URL
            'order_id'	=> 'TEST'.time().date('YmdHis'), //商户个人的订单记录
            'app_id'	=> self::APPID, //平台发放给商户 的APPID

            #调用微信H5 必填三个参数
            'sceneType' => 'IOS_SDK', //业务应用类型 用于苹app应用里值为IOS_SDK ；用于安卓app 应用里值为AND_SDK；用于手机网站，值为IOS_WAP 或AND_WAP
            'merAppName'    => '全民支付', //应用名称   用于苹或安卓app 应用中，传分别 对应在 AppStore和安卓分发市场中的应用名（如：全民付）；用于手机网站，传对应的网站名（如：银联商务官网）
            'merAppId'  => 'com.tencent.tmgp.sgame' //应用标识  用于苹果或安卓 app 应用中，苹果传 IOS 应用唯一标识(如com.tencent.wzryIOS ) 安卓传包名 (如： com.tencent.tmgp.sgame)如果是用于手机网站 ，传首页 URL 地址 , (如： https://m.jd.com ) ，支付宝H5支付参数无效
        ];

        #2.发送前进行签名操作.SIGN 查看手册
        $data['sign'] = self::sign($data);
        
        #3.调用HTTP前加密RSA处理  备注 错误参数请查看文档进行处理
        $rsaData = self::rsa($data);

        #4 HTTP 处理. 接收解密，判断业务逻辑. 商户自己处理平台返回的参数，请参考手册说明
        $http = Http::postArrayByUrl( self::url .'pay/payEntry', $rsaData);

        if ($http['code'] == 200) {
            $content = self::rsa($http['content'], 'decrypt');
            $content = json_decode($content, true);


            // header('Location:'.$content['stateData']['mweburl']);
            var_dump($content);
            
            echo  $content['stateData']['mweburl'];
            // echo htmlentities($content['stateData']['html_unionpay_h5'],ENT_QUOTES,"UTF-8"); 
        } else {
            throw new \Exception("支付平台接口调用异常!", 1);
        }
    }

    /**
     * [payQuery 商户 统一下单查询]
     * @return [type] [description]
     */
    // public static function payQuery()
    // {
    //     #1.组装数据
    //     $data = [
    //         'paymethod' =>'zfb',
    //         'third'	=> 'ubey', //HT平台所支付的渠道,请登录商户后台查看。 进行调用
    //         'order_id'	=> 'TEST153908381520181009191655',
    //         'app_id'	=> self::APPID
    //     ];
    //     #2.发送前进行签名操作.SIGN 查看手册
    //     $data['sign'] = self::sign($data);

    //     #3.调用HTTP前加密RSA处理  备注 错误参数请查看文档进行处理
    //     $rsaData = self::rsa($data);

    //     #4 HTTP 处理. 接收解密，判断业务逻辑. 商户自己处理平台返回的参数，请参考手册说明
    //     $http = Http::postArrayByUrl(self::url .'pay/payQuery', $rsaData);

    //     if ($http['code'] == 200) {
    //         $content = self::rsa($http['content'], 'decrypt');

    //         /**
    //           * array(3) { ["stateCode"]=> int(200) ["stateMsg"]=> string(2) "ok" ["stateData"]=> array(2) { ["tradestate"]=> string(6) "NOTPAY" ["orderid"]=> string(21) "KUE624420180723113421" } }
    //           *
    //           * 1。NOTPAY 则是未支付成功 , TRADE_SUCCESS 是支付成功 后会带上 orderid,totalfee,paydate参数
    //           */
    //         var_dump(json_decode($content, true));
    //     } else {
    //         throw new \Exception("支付平台接口调用异常!", 1);
    //     }
    // }
    /**
     * [payBankEntry 统一 代付下单接口 ]
     * @return [type] [description]
     */
    public static function payBankEntry()
    {
        $data = [
            'trans_money'	=> '1',  //转账金额 单位为元
            'third'	=> 'witspay', //HT平台所支付的渠道,请登录商户后台查看。 进行调用 支持的渠道为kue zhong
            'to_acc_name'	=> '卜天浩',
            'to_acc_no'	=> '6214837854697715',
            'notifyurl'	=> 'http://192.168.1.251:8011/index.php?op=payBankNotify', //可在后台配置,也可写在参数中
            'order_id'	=> 'TEST'.time().date('YmdHis'),
            'app_id'	=> self::APPID
        ];
        $data['sign'] = self::sign($data);

        $rsaData = self::rsa($data);
        $http = Http::postArrayByUrl( self::url .'pay/payBankEntry', $rsaData);

        if ($http['code'] == 200) {
            $content = self::rsa($http['content'], 'decrypt');

            var_dump(json_decode($content, true));
        } else {
            throw new \Exception("支付银行平台接口调用异常!", 1);
        }
    }

    /**
     * [payBankQuery 统一 代付下单查询  银联]
     * @return [type] [description]
     */
    // public static function payBankQuery()
    // {
    //     $data = [
    //         'third'	=> 'ubey', //HT平台所支付的渠道,请登录商户后台查看。 进行调用
    //         'order_id'	=> 'TEST153908373720181009191537', //商户代付下单的订单ID
    //         'app_id'	=> self::APPID
    //     ];
    //     $data['sign'] = self::sign($data);

    //     $rsaData = self::rsa($data);
    //     $http = Http::postArrayByUrl( self::url .'pay/payBankQuery', $rsaData);

    //     if ($http['code'] == 200) {
    //         $content = self::rsa($http['content'], 'decrypt');

    //         var_dump(json_decode($content, true));
    //     } else {
    //         throw new \Exception("支付银行接口调用异常!", 1);
    //     }
    // }

    /**
     * [notify 商户 回调处理]
     * @return [type] [description]
     */
    public static function notify()
    {
        #解密服务回调客户端的接口
        $content = self::rsa(file_get_contents("php://input"), 'decrypt');

        $post = json_decode($content, true);


        if (self::sign($post) != $post['sign']) {
            echo '非法调用,商户处理';
            die();
        }
        //验证成功后的商户业务处理, 需要返回success. 否则会重复调用 需要商户处理重复订单=问题
        echo 'success';
    }

    /**
     * [sign 签名操作]
     * @return [type] [description]
     */
    public static function sign(array $data)
    {
        $values =  ArrayUtil::removeKeys($data, ['sign', 'sign_type']);
        $values =  ArrayUtil::paraFilter($values);
        $values =  ArrayUtil::arraySort($values);
        $signStr = ArrayUtil::createLinkstring($values);

        $signStr .= '&key=' . self::APPSECRET;

        return  strtoupper(md5($signStr)) ;
    }
    /**
     * [rsa 进行公钥加密处理,接收解密也需要公钥处理]
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public static function rsa($data, $op='default')
    {
        $XRsa = new XRsa();

        if ($op == 'default') {
            return  $XRsa->publicEncrypt(json_encode($data))  ;
        }

        return  $XRsa->publicDecrypt($data);
    }

    public static function autoload($className)
    {
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, APP_PATH  .'\\'. $className) . '.php';
        if (is_file($fileName)) {
            require_once $fileName;
        } else {
            echo $fileName . ' is not exist';
            die;
        }
    }
}
spl_autoload_register('Pay::autoload');

//http://localhost/index.php?op=payEntry
switch ($_GET['op']) {
    case 'payEntry':
     Pay::payEntry();
        break;
    case 'payQuery':
     Pay::payQuery();
        break;
    case 'notify':
     Pay::notify();
    break;
     case 'payBankEntry':
        Pay::payBankEntry();
        break;
    case 'payBankQuery':
        Pay::payBankQuery();
        break;
    case 'payBankNotify':
        Pay::payBankNotify();
        break;
    default:
        throw new \Exception("尚未支持的API接口", 1);
        break;
}
