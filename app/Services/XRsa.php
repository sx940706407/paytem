<?php 
namespace App\Services;

class XRsa
{
    const CHAR_SET = "UTF-8";
    const BASE_64_FORMAT = "UrlSafeNoPadding";
    const RSA_ALGORITHM_KEY_TYPE = OPENSSL_KEYTYPE_RSA;
    const RSA_ALGORITHM_SIGN = OPENSSL_ALGO_SHA256;

    protected $public_key;
    protected $private_key;
    protected $key_len;

    public function __construct($pub_key = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA2R0vLEKdElrZ+p09C7my
dqVOnWSTx9jnBrMU0LVWTMhSChOGV8/XIcnQw2MQKVG4atKWJlzA9REYBFAq5ZPm
jebIM3XT7as8rSp8Cntm8FHDghQSzq5hpH/U+MGAJR7/WInCnFD/tin9Lh7jz3d4
Zqai4Cbnva5efOh4BrcG3T1miBkYyXgcfv0w6b8gRsErF585P1hTm3TWFkj7XeXa
cDomPG+OgC80khcGKV4CnOlJ0VV+tL8uVzmEueVQFfusajGK4/0jJYg9ZP63wDtx
XH1Bel4UbXqfoSOpJ0sI+pmU4z2RA2ESddpjLiey1Rc4+kJR0y9m63ImmvpOd2or
jQIDAQAB
-----END PUBLIC KEY-----', $pri_key = '-----BEGIN RSA PRIVATE KEY-----
MIIEpgIBAAKCAQEA2R0vLEKdElrZ+p09C7mydqVOnWSTx9jnBrMU0LVWTMhSChOG
V8/XIcnQw2MQKVG4atKWJlzA9REYBFAq5ZPmjebIM3XT7as8rSp8Cntm8FHDghQS
zq5hpH/U+MGAJR7/WInCnFD/tin9Lh7jz3d4Zqai4Cbnva5efOh4BrcG3T1miBkY
yXgcfv0w6b8gRsErF585P1hTm3TWFkj7XeXacDomPG+OgC80khcGKV4CnOlJ0VV+
tL8uVzmEueVQFfusajGK4/0jJYg9ZP63wDtxXH1Bel4UbXqfoSOpJ0sI+pmU4z2R
A2ESddpjLiey1Rc4+kJR0y9m63ImmvpOd2orjQIDAQABAoIBAQCzJGR29aPasEHp
inIDSb6aLP232nQhUrQVEBBdwTIq+qLOk5umuuR8iaQKg6OjJD2xTn77uk6wJuGV
NXyfnzB9521LIK60DTVsgICGuZmPMzfJDb0S8km4zI0yj56ngnMYX9rG1gKYEP9J
Xc2EssQSlu4PW6qdFNH76GiYyc4NHwW4pVMRR0PtnuraLB5wyZ3jGrXO9nB98Li+
tJFXuLzpUP3ouOG9VVaC3s1w0IiR654vlI3sTg81LBPanhUzo3eDhGwwpEsf7//b
vpKdumf7B83C6WE5WBBOtK5FpC5fRktvpz0QnFIh90vx8fy1+aambR+xNn+tBjfP
Ij1HBAT1AoGBAPr8Lv6s23y4GbXDCAADYn5e/0bIXVaZ7w0xPkjnBHti9mZ7P1XA
5K+m76b8ZjagkRbKOC10pZ0QEd3csRoh1+eOxMFEdfYhYy5cg2+VKsSArbz5apP4
cio/9nduVGmEJqkqZzdnGQOpp0cRmoYLgTmOJYJ+Qk21DQDv6t3W9KJfAoGBAN1z
vw9xXbJV2zyUT7gwDd0w3qk5WsgwlrJZPFRzsth81c5zap7CDP1wodHKp1Z9tZ48
nKBNWdOd4POgEmyC8ohuKSR56a0OKplB/XvkbTJHkOPq3P6zITXbjzvyYI8rltEM
y2a4WAIn9Ii2TtnuJWvKruyzbvPTBU86T6qa23GTAoGBAKW2sjS23uh3CYqoLfUM
RxDXGkea7X3Lfzm/pLcvyRbKnZPGlmfBR3zuhNdFWRuCYqmgdP0WQm70eEd7ened
ltctvZ053YTYQIsQzDt1StqZd50JNSRj6sUYnFv4vcU5WulgtOuwp6RydJ8I8XTF
zdm5j+yb/p0eCGrw/arhTX6TAoGBAJYPTcNwJXan2RS2x0JfRbXB3M+87rhCvIsE
Du6HLASoqtTnvrLveY/vV6fqc/QW4Q/lsJircZgFHp7XtERVg3VReI2gEulSdSk+
3z6prhjpB9R5nOD2jyWIrwmHF0lM1zi3O8lSV0i2vGw7ZTklt7PQNzJr8F5Gew2R
zNQldVgDAoGBAOUhkRCwhFlk+RBF2FWF7jTB17tHD7P6ONaHP9EQTSSZ+891q5ZP
t6VHuHAX9A/+zoJjbKUMMlQBvbvh6Tb172rmOevBBZupowroyqcl9llxAeTEy5UC
V9fCpJYP3Wsc6HVD3LWLXW//EIvS2PDhx/A2qYTbComGCW4Kphxn9QzE
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

        return url_safe_base64_encode($sign);
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