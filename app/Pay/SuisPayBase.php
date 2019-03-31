<?php 
namespace App\Pay;

use GuzzleHttp\Client;
use Payment\Common\BaseData;
use Payment\Common\BaseStrategy;
use Payment\Common\PayException;
use Payment\Common\witspayConfig;
use Payment\Utils\ArrayUtil;
use Payment\Utils\DataParser;

use Config,DB,Log;

class SuisPayBase
{
    #测试地址
    protected $urlTest = 'http://test.suiszf.com/pay/gateway';
    #正式地址
    protected $url = 'http://api.suiszf.com/pay/gateway';


    protected $config;
    /**
     * 请求发送处理 function
     *
     * @param array $data
     * @return void
     */
    public function sendReq(array $data)
    {

        $data = $this->sign($data);

        dd($data);

        $client = new Client([
            'timeout' => '10.0'
        ]);
        
        $options = [
            'query' => $array,
            'http_errors' => false
        ];
        $response = $client->request('GET', $this->urlTest, $options);

        if ($response->getStatusCode() != '200') {
            throw new PayException('网络发生错误，请稍后再试curl返回码：' . $response->getReasonPhrase());
        }

    }
    /**
     * 签名 function
     *
     * @return void
     */
    public function sign(array $data)
    {
        $data = ksort($data);

        $string = $this->toUrlParams($data);

        $md5str = $string . "&key=".'xxx';
        $sign = md5($md5str);

        $data['sign'] = $sign;
        return $data;
    }


    /**
     * 获取随机数 function
     *
     * @return void
     */
    public function getRandom($param)
    {
        $str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $key = "";
        for ($i=0;$i<$param;$i++) {
            $key .= $str{mt_rand(0, 32)};    //生成php随机数
        }
        return $key;
    }

    /**
     * 获取URL设置 function
     *
     * @param [type] $params
     * @return void
     */
    public function toUrlParams($params)
    {

        $buff = "";
        foreach ($params as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }




}