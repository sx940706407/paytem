<?php

/**
 * 通用函数处理
 */
if (!function_exists('base64Auto')) {
    /**
     * [base64Auto 判断是否base64自动解码或者直接输入]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    function base64Auto($value)
    {
        return $value === base64_encode(base64_decode($value)) ? base64_decode($value)  : $value ;
    }
}


if (!function_exists('verify_sign')) {
    /**
     * [verify_sign 检查Kue返回的数据是否被篡改过，商户需要对接收到的数据优先进行验签处理，确定是从酷模支付发送的通知后再进行业务方面的处理，因为没有验签而导致的后果商户自行承担]
     * @param  array  $retData [description]
     * @return [type]          [description]
     */
    function verify_sign(array $retData, $md5Key)
    {
        //1.移除sign 2.清除空值数组 3.对输入的数组进行字典排序 4.把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        //5.加入商户的API密钥进行计算. 判断 是否相等 6.sign 转换成大写进行对比
        $retSign = $retData['sign'];
        $values = \Payment\Utils\ArrayUtil::removeKeys($retData, ['sign', 'sign_type']);
        $values = \Payment\Utils\ArrayUtil::paraFilter($values);
        $values = \Payment\Utils\ArrayUtil::arraySort($values);
        $signStr = \Payment\Utils\ArrayUtil::createLinkstring($values);

        $signStr .= '&key=' . $md5Key;
        $sign = md5($signStr);

        
        // Log::info('payCallbackKue',['retSing'=> $retSign,'sign' => strtoupper($sign) ,'values' => json_encode($values) ]);

        return strtoupper($sign) === $retSign;
    }
}


if (!function_exists('verify_sign_str')) {
    /**
     * [verify_sign_str 检查Kue返回的数据是否被篡改过，商户需要对接收到的数据优先进行验签处理，确定是从酷模支付发送的通知后再进行业务方面的处理，因为没有验签而导致的后果商户自行承担]
     * @param  array  $retData [description]
     * @return [type]          [description]
     */
    function verify_sign_str(array $retData, $md5Key)
    {
        //1.移除sign 2.清除空值数组 3.对输入的数组进行字典排序 4.把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        //5.加入商户的API密钥进行计算. 判断 是否相等 6.sign 转换成大写进行对比
        $values = \Payment\Utils\ArrayUtil::removeKeys($retData, ['sign', 'sign_type']);
        $values = \Payment\Utils\ArrayUtil::paraFilter($values);
        $values = \Payment\Utils\ArrayUtil::arraySort($values);
        $signStr = \Payment\Utils\ArrayUtil::createLinkstring($values);

        $signStr .= '&key=' . $md5Key;
        $sign = md5($signStr);

        return strtoupper($sign);
    }
}





if (! function_exists('url_safe_base64_encode')) {
    function url_safe_base64_encode($data)
    {
        return str_replace(array('+','/', '='), array('-','_', ''), base64_encode($data));
    }
}

if (! function_exists('url_safe_base64_decode')) {
    function url_safe_base64_decode($data)
    {
        $base_64 = str_replace(array('-','_'), array('+','/'), $data);
        return base64_decode($base_64);
    }
}


function TrimArray($Input)
{
    if (!is_array($Input)) {
        return trim($Input);
    }
    return array_map('TrimArray', $Input);
}


function get_client_ip($type = 0)
{
    $type       =  $type ? 1 : 0;
    static $ip  =   null;
    if ($ip !== null) {
        return $ip[$type];
    }
    if (isset($_SERVER['HTTP_X_REAL_IP'])) {//nginx 代理模式下，获取客户端真实IP
        $ip=$_SERVER['HTTP_X_REAL_IP'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {//客户端的ip
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {//浏览当前页面的用户计算机的网关
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown', $arr);
        if (false !== $pos) {
            unset($arr[$pos]);
        }
        $ip     =   trim($arr[0]);
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];//浏览当前页面的用户计算机的ip地址
    } else {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}





/**
 * PHP发送Json对象数据
 *
 * @param $url 请求url
 * @param $jsonStr 发送的json字符串
 * @return array
 */
function http_post_json($url, $jsonStr)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
        'Content-Type: application/json; charset=utf-8',
        'Content-Length: ' . strlen($jsonStr)
    )
               );
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    

    $response = json_decode($response);
    $odata = $response->data;
    $signature = $response->signature;
    


    \Log::info('UBEYPANK===========>', ['odata'=> $odata,'signature'=> $signature]);


    $priKey= '-----BEGIN RSA PRIVATE KEY-----
MIIEogIBAAKCAQB1NSNQjrM/ZRD7YdptvKkk0iOGQ29saMeMbkNyYRmM4bCpsJDj
U7ecUN9dFfzN4P1C0XeSP9RY+kTYH5edd15zh8NEEx953fpZxb6BZq/2pu6s4z8c
B1jGiHe4euPz27GzLX206XOg74B0LSqXGNsaVOKC3EAL6SBAfpr3uy5NGNyJVVWM
l5gIv2nn1urxhEFdBALfB88Iaqbk3L46l8KqShD59Zv1BfcHd5Jyf8N3+JhiRf4x
imsClhFg22FUoKBZuUl6Vl5Eqf2MXpUl1jyIXrctx+oc/RmbcnXp6Srze80bc0cl
XNjp9psR2G96DnlHNxnuYXcNPL9DIlFUIAL/AgMBAAECggEAb/4XQVkpAzEx+dF1
Yhe70xgLo7X52K+BxLhzL+6B+HCKWooA14Zd0jogQ5TH23zY4ii+RPtCjsaMU6pU
N70gfenCdeCD2fF1zqO5NXIGPvsg4ge9fK20cPdi1d5uw8svT5LvI5dRyfwvVFL3
+Cpi6RUk3n9Pn1HhZF7U+lNbmYQVn3X1BKpAqKHEUSo8OqAKGcjL9IYiqmOAQe2y
OsEEw5WJCGavwZzYgjHnnHvkjsZtyIIZei8eMFyi8fxev/pFd93QO4fEwh+kthpx
fGpqWVuO9L3BdFVvvWKrfKhAQZgGpK3vxCcPq04Fdz6vV3Mc9oRE26z7bwaBPE3G
4UI+0QKBgQC0cqNO7P23OxJcfJbh401uAMlErND89yqVDl2mIzPVVLIrtLGxImkT
PowtiPPFG6rxQ/sXfTQBNCK1gu1/kz3W5IHQ35RgP/ncJi9W526hawTpCyiol6r1
l1TzWcQCuqnYosh0K/1aYYZIyv71NcZCldnEDOBYVP9f+CPcyioJmQKBgQCmSBKx
4xxRxzPrJyPvtLRVxmbMFxoByRQakG5S+nhfon9HWRwqAcZOQTjU3OiUlCBOM+YK
PbLps0LwNW7ztGwnrwAorlkO37naRHtS94N81L8tGrVv5UoDZeFSV786rzOmrBW4
vZGyWh88MzOZ5EBH9EkdQMDaUVv2WkJCbETAVwKBgQCoIzF8N2Npukcvmn/U10Gs
wFrJ/OV28K/i19H3HlIL87FY/DOeQ9v4rI1dWIEcJt2vlZJ/npA4luXIj8jQ2NgE
RkOX5tyQmswskAAIT/lLuzaGF3m5LimEUZA8eGYlzNy6GWQCq4KVFs5TQaMzxPmJ
zatt/DmG1RxnxgVUk6N78QKBgFPwUBeiWPpjP682O+rWYq5mECB4jPVXxyE9xaN3
suo8AlpG/nOqH6wDOqght/rA56nygu6qhLV6e5D8uDyn2G0T51Wh5W0fvRcUuNiB
/8s1LiibsfmBWqJqfJrvlqYOKVm6xuBSOck5u0jNZAAMe/KWu43b0T6kEXNDzuzu
8KnTAoGAUXNY+oMCZT84H/sShJ2MS22Eo4EcdMtEHob5ttSVOxPmu+8+QwanW+ad
M+/pFx83y7tHy8lr7jZcslmi70Jd+9ZuonUxbUIMLN2N+ddGkqfK1XtcpP3EBjGU
cFjQM8VuXgrVkyv7pARbE6k9bKthZVzm1YMcRhZUhU2UgEqZWe4=
-----END RSA PRIVATE KEY-----';

    $pubKey = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmbMRYdd3Ob2c2FRdU04P
m0FGOxpCjAuJSM53FRryIuQMD4u54eALtHsDaOJ7sqpnEUT9vggsPoEXb5LEOYhW
eaofeYvgOpYZIHYdgGA51zF6JevedcvV/YMeb3rXTuaZKpuiOS8rRfpJ3k5OmXy7
G2oyjiv20jLzB5E+HvRtStu3PHpxPKUmMwqbVkWLI5sWhLQqps8UVvgMGf+mEL5U
TLlZbJevB5x+au3lNDRdbfUCQ2Bf+1mhYkjeMtb/qTR2X+tONyvmNL0m78r27+r+
RFBQuKCWkI20fPSi4bT7BDtshYoqC83K6IFMTDZoJ5n6yoq3mja0tvYiKu+fDN7I
LwIDAQAB
-----END PUBLIC KEY-----';

    $priKey= openssl_get_privatekey($priKey);
    $pubKey= openssl_get_publickey($pubKey);
    $decrypted = '';
    $datass ='';
    $datass = str_split(base64_decode($odata), 256);

    \Log::info('UBEYPANK===========>1111', ['datass'=> $datass,'pubKey'=> $pubKey,'priKey'=> $priKey]);

    foreach ($datass as $chunk) {
        $partial = '';
        $decryptionOK = openssl_private_decrypt($chunk, $partial, $priKey);
        if ($decryptionOK === false) {
            return false;
        }
        $decrypted .= $partial;
    }
    \Log::info('UBEYPANK===========>22222', ['datass'=> $datass]);
    return array($httpCode, $datass);
}
