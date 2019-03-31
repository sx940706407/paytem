<?php

namespace App\Services;

class Http 
{
    
    public static function postArrayByUrl($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $content_length = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

        $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    

        $response = array(
            'code' => $response_code,
            'length' => $content_length,
            'type' => $content_type,
            'content' => $output
            );
        
        curl_close($ch);
        return $response;
        
    }

    public static function getCurl($url)
    {
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        //返回请求头
        //curl_setopt($ch, CURLOPT_HEADER, true);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);

        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $content_length = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

        $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);


        $response = array(
            'code' => $response_code,
            'length' => $content_length,
            'type' => $content_type,
            'content' => $output,
            'error' => curl_error($ch)
            );
        
        //释放curl句柄
        curl_close($ch);

        return $response;
    }
    

}
