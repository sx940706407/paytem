<?php 

namespace App\Services;
/**
 * 
openssl genrsa -out rsa_private_key.pem 1024
//生成原始 RSA私钥文件
openssl pkcs8 -topk8 -inform PEM -in rsa_private_key.pem -outform PEM -nocrypt -out private_key.pem
//将原始 RSA私钥转换为 pkcs8格式
openssl rsa -in rsa_private_key.pem -pubout -out rsa_public_key.pem
//生成RSA公钥
$priveEncrypt = Rsa::privEncrypt(json_encode($post)); 
$publicDecrypt = Rsa::publicDecrypt($priveEncrypt);

$publicEncrypt = Rsa::publicEncrypt(json_encode($post));
$priveDecrypt = Rsa::privDecrypt($publicEncrypt);

dump($post,$priveEncrypt,$publicDecrypt,$publicEncrypt,$priveDecrypt);
 */
class Rsa {    
    private static $PRIVATE_KEY = '-----BEGIN RSA PRIVATE KEY-----
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
-----END RSA PRIVATE KEY-----';    


    private static $PUBLIC_KEY = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA2R0vLEKdElrZ+p09C7my
dqVOnWSTx9jnBrMU0LVWTMhSChOGV8/XIcnQw2MQKVG4atKWJlzA9REYBFAq5ZPm
jebIM3XT7as8rSp8Cntm8FHDghQSzq5hpH/U+MGAJR7/WInCnFD/tin9Lh7jz3d4
Zqai4Cbnva5efOh4BrcG3T1miBkYyXgcfv0w6b8gRsErF585P1hTm3TWFkj7XeXa
cDomPG+OgC80khcGKV4CnOlJ0VV+tL8uVzmEueVQFfusajGK4/0jJYg9ZP63wDtx
XH1Bel4UbXqfoSOpJ0sI+pmU4z2RA2ESddpjLiey1Rc4+kJR0y9m63ImmvpOd2or
jQIDAQAB
-----END PUBLIC KEY-----
';   
 
    /**     
     * 获取私钥     
     * @return bool|resource     
     */    
    private static function getPrivateKey() 
    {        
        $privKey = self::$PRIVATE_KEY;        
        return openssl_pkey_get_private($privKey);    
    }    
 
    /**     
     * 获取公钥     
     * @return bool|resource     
     */    
    private static function getPublicKey()
    {        
        $publicKey = self::$PUBLIC_KEY;        
        return openssl_pkey_get_public($publicKey);    
    }    
 
    /**     
     * 私钥加密     
     * @param string $data     
     * @return null|string     
     */    
    public static function privEncrypt($data = '')    
    {        
        if (!is_string($data)) {            
            return null;       
        }        
        return openssl_private_encrypt($data,$encrypted,self::getPrivateKey()) ? base64_encode($encrypted) : null;    
    }    
 
    /**     
     * 公钥加密     
     * @param string $data     
     * @return null|string     
     */    
    public static function publicEncrypt($data = '')   
    {        
        if (!is_string($data)) {            
            return null;        
        }        
        return openssl_public_encrypt($data,$encrypted,self::getPublicKey()) ? base64_encode($encrypted) : null;    
    }    
 
    /**     
     * 私钥解密     
     * @param string $encrypted     
     * @return null     
     */    
    public static function privDecrypt($encrypted = '')    
    {        
        if (!is_string($encrypted)) {            
            return null;        
        }        
        return (openssl_private_decrypt(base64_decode($encrypted), $decrypted, self::getPrivateKey())) ? $decrypted : null;    
    }    
 
    /**     
     * 公钥解密     
     * @param string $encrypted     
     * @return null     
     */    
    public static function publicDecrypt($encrypted = '')    
    {        
        if (!is_string($encrypted)) {            
            return null;        
        }        
    return (openssl_public_decrypt(base64_decode($encrypted), $decrypted, self::getPublicKey())) ? $decrypted : null;    
    }
}