<?php 
namespace App\Services;

class XRsa2
{
    const CHAR_SET = "UTF-8";
    const BASE_64_FORMAT = "UrlSafeNoPadding";
    const RSA_ALGORITHM_KEY_TYPE = OPENSSL_KEYTYPE_RSA;
    const RSA_ALGORITHM_SIGN = OPENSSL_ALGO_MD5;

    protected $public_key;
    protected $private_key;
    protected $key_len;

    public function __construct($pub_key = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmbMRYdd3Ob2c2FRdU04Pm0FGOxpCjAuJSM53FRryIuQMD4u54eALtHsDaOJ7sqpnEUT9vggsPoEXb5LEOYhWeaofeYvgOpYZIHYdgGA51zF6JevedcvV/YMeb3rXTuaZKpuiOS8rRfpJ3k5OmXy7G2oyjiv20jLzB5E+HvRtStu3PHpxPKUmMwqbVkWLI5sWhLQqps8UVvgMGf+mEL5UTLlZbJevB5x+au3lNDRdbfUCQ2Bf+1mhYkjeMtb/qTR2X+tONyvmNL0m78r27+r+RFBQuKCWkI20fPSi4bT7BDtshYoqC83K6IFMTDZoJ5n6yoq3mja0tvYiKu+fDN7ILwIDAQAB
-----END PUBLIC KEY-----', $pri_key = '-----BEGIN RSA PRIVATE KEY-----
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
-----END RSA PRIVATE KEY-----')
    {
        $this->public_key = $pub_key;
        $this->private_key = $pri_key;

        $pub_id = openssl_get_publickey($this->public_key);
        
        $this->key_len = openssl_pkey_get_details($pub_id)['bits'];
    }

    /*
     * 创建密钥对
     */
    public static function createKeys($key_size = 2048)
    {
        $config = array(
            "private_key_bits" => $key_size,
            "private_key_type" => self::RSA_ALGORITHM_KEY_TYPE,
        );
        $res = openssl_pkey_new($config);
        openssl_pkey_export($res, $private_key);
        $public_key_detail = openssl_pkey_get_details($res);
        $public_key = $public_key_detail["key"];

        return [
            "public_key" => $public_key,
            "private_key" => $private_key,
        ];
    }

    /*
     * 公钥加密
     */
    public function publicEncrypt($data)
    {
        $encrypted = '';
        $part_len = $this->key_len / 8 - 11;
        $parts = str_split($data, $part_len);

        foreach ($parts as $part) {
            $encrypted_temp = '';
            openssl_public_encrypt($part, $encrypted_temp, $this->public_key);
            $encrypted .= $encrypted_temp;
        }

        return url_safe_base64_encode($encrypted);
    }

    /*
     * 私钥解密
     */
    public function privateDecrypt($encrypted)
    {
        $decrypted = "";
        $part_len = $this->key_len / 8;
        $base64_decoded = url_safe_base64_decode($encrypted);
        $parts = str_split($base64_decoded, $part_len);

        foreach ($parts as $part) {
            $decrypted_temp = '';
            openssl_private_decrypt($part, $decrypted_temp,$this->private_key);
            $decrypted .= $decrypted_temp;
        }
        return $decrypted;
    }

    /*
     * 私钥加密
     */
    public function privateEncrypt($data)
    {
        $encrypted = '';
        $part_len = $this->key_len / 8 - 11;
        $parts = str_split($data, $part_len);

        foreach ($parts as $part) {
            $encrypted_temp = '';
            openssl_private_encrypt($part, $encrypted_temp, $this->private_key);
            $encrypted .= $encrypted_temp;
        }

        return url_safe_base64_encode($encrypted);
    }

    /*
     * 公钥解密
     */
    public function publicDecrypt($encrypted)
    {
        $decrypted = "";
        $part_len = $this->key_len / 8;
        $base64_decoded = url_safe_base64_decode($encrypted);
        $parts = str_split($base64_decoded, $part_len);

        foreach ($parts as $part) {
            $decrypted_temp = '';
            openssl_public_decrypt($part, $decrypted_temp,$this->public_key);
            $decrypted .= $decrypted_temp;
        }
        return $decrypted;
    }

    /*
     * 数据加签
     */
    public function sign($data)
    {
        openssl_sign($data, $sign, $this->private_key, self::RSA_ALGORITHM_SIGN);

        return $sign;
    }


    public function signPrivatekeyStr($data)
    {
        $prikey = $this->signPrivatekey();
        openssl_sign($data, $sign, $prikey, self::RSA_ALGORITHM_SIGN);

        return $sign;
    }


    /*
     * 数据加签
     */
    public function signPrivatekey()
    {
        return openssl_get_privatekey($this->private_key);
    }



    /*
     * 数据签名验证
     */
    public function verify($data, $sign)
    {
        $pub_id = openssl_get_publickey($this->public_key);
        $res = openssl_verify($data, url_safe_base64_decode($sign), $pub_id, self::RSA_ALGORITHM_SIGN);

        return $res;
    }
}