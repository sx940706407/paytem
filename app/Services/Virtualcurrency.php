<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use App\Services\Openssl;

use App\Models\virtual\VirtualCurrencyUser;
use App\Models\virtual\VirtualCurrencyUserBuy;

/**
 * 虚拟币的接口处理 class
 */
class Virtualcurrency
{
    protected $baseUrl;
    protected $client;

    protected $mercode;

    protected $addUser = '/coin/Adduser';
    protected $GetAddress = '/coin/GetAddress';
    protected $GetBalance = '/coin/GetBalance';
    protected $GetAcctChae = '/coin/GetAcctChae';

    #登录 购买 查询 提币=操作
    protected $login = '/coin/Login';
    protected $orderDetail = '/coin/OrderDetail';
    protected $queryStatus = '/coin/QueryStatus';

    protected $withdrawMoneyUser = '/coin/withdrawMoneyUser';
    protected $withdrawMoneyMechant = '/coin/WithdrawMoneyMechant';
    
    protected $CoinCode;

    protected $keyB;
    /**
     * 1.需要构建后台 存放当前增加用户 与获取地址的 钱包  function
     *  1.1用当前用户去购买虚拟币 或者 出售虚拟币交易
     *  1.2 3.8为Notice 通知 商户交易信息,在后加添加回调地址
     */
    public function __construct()
    {
        $this->baseUrl = Config::get('services.virtual.api');
        $this->mercode = Config::get('services.virtual.shop');

        $this->keyB = Config::get('services.virtual.keyB');


        $this->client = new Client();
    }
    /**
     * 增加用户 function  tiantian123
     * @return void
     */
    public function addUser($gameId = 300000)
    {
        $userName = str_random(12);
        $param = [
            'MerCode'   => $this->mercode,
            'TimeStamp'  => strval(time()),
            'UserName'  => $userName,
            'gameId'    => $gameId,
        ];
        $sign = md5($this->mercode . $userName . $this->keyB . date('Ymd', strval(time())));
        return  $this->guzzleClient($this->addUser, $param, $sign, true,'addUser');
    }
    /**
     * 获取地址 返回H5 让用户购买 function
     *  tiantian123 bcbdZ7P8dQPcK8spB5Nr2xPTU4UiAe7J6yV  USDX
     * @param string $gameId 游戏ID
     * @param integer $UserType  类型 1 会员，2 商户
     * @param string $CoinCode 币种代码 详见附录 4.2
     * @return void
     */
    public function GetAddress($gameId = '', $CoinCode = 'DC', $UserType = 1)
    {
        #存在gameID的情况下 查询数据获取用户名与 赋值对应币的类型
        $virtualCurrencyUser = VirtualCurrencyUser::where('game_id',$gameId)->first();
        if (!$virtualCurrencyUser) {
           return false;
        }
        $param = [
            'MerCode'   => $this->mercode,
            'TimeStamp'  => strval(time()),
            'UserType'  =>$UserType,
            'UserName'  => $virtualCurrencyUser->username,
            'CoinCode'  => $CoinCode,
            'gameId'    => $gameId,
        ];
        $sign = md5($this->mercode . $UserType. $CoinCode  . $this->keyB . date('Ymd', strval(time())));
        return  $this->guzzleClient($this->GetAddress, $param, $sign, true,'GetAddress');
    }
    /**
     * 获取余额--会员钱包余额 3.3  function
     *  1.注：所有商户已开启自动归集功能，资金会转入商户钱包地址下，用户余额通常为 0，金额以商户平台记账为准，可查询商户流水或余额核准
     * @param string $UserName
     * @param integer $UserType 1为会员 2为商户 商户的号不用填会员名称
     * @return void
     */
    public function GetBalance($UserName ='tiantian123', $UserType = 1)
    {
        $param = [
            'MerCode'   => $this->mercode,
            'TimeStamp'  => strval(time()),
            'UserType'  =>$UserType,
            'UserName'  => $UserName,
        ];
        $sign = md5($this->mercode . $UserType  . $this->keyB . date('Ymd', strval(time())));
        return  $this->guzzleClient($this->GetBalance, $param, $sign, true,'GetBalance');
    }
    /**
     * 获取钱包流水 3.4--开始与结束时间 分页PAGE  查询类型 查询某个会员的情况 function
     *
     * @param string $UserName
     * @return void
     */
    public function GetAcctChae($UserName ='tiantian123', $QueryType = 4)
    {
        $param = [
            'MerCode'   => $this->mercode,
            'TimeStamp'  => strval(time()),
            'UserName'  => $UserName,
            'QueryType' => $QueryType
        ];
        $sign = md5($this->mercode . $this->keyB . date('Ymd', strval(time())));
        return  $this->guzzleClient($this->GetAcctChae, $param, $sign, true);
    }
    /**
     * WithdrawMoneyUser 3.5 (用户提币)  还有商户提币 备注  function
     * @param string $UserName
     * @param [type] $orderId
     * @return void
     */
    public function withdrawMoneyUser($UserName ='tiantian123',$CoinCode,$CoinAddress,$Amount)
    {
        $orderId = 'WMU'.date('MDHIS').time().mt_rand(1000000,9999999);
        #获取
        $param = [
            'MerCode'   => $this->mercode,
            'TimeStamp'  => strval(time()),
            'UserName'  => $UserName,
            'OrderNo'  => $orderId,
            'CoinCode '  => $CoinCode ,
            'CoinAddress '  => $CoinAddress , //提币地址 bcbMr9nRmbQtDeJALz2xFJ8nddVwLSU3McqA
            'Amount'  => $Amount,
            'Remark '  => '提币到主帐号上',
        ];
        $sign = md5($this->mercode. $UserName. $Amount .  $this->keyB . date('Ymd', strval(time())));
        return  $this->guzzleClient($this->withdrawMoneyUser, $param, $sign, true); 
    }
    /**
     * WithdrawMoneyMechant（商户提币） 3.6  function
     * @param [type] $orderId
     * @return void
     */
    public function withdrawMoneyMechant($CoinCode,$CoinAddress,$Amount)
    {
        $orderId = 'WMU'.date('MDHIS').time().mt_rand(1000000,9999999);
        #获取
        $param = [
            'MerCode'   => $this->mercode,
            'TimeStamp'  => strval(time()),
            'OrderNo'  => $orderId,
            'CoinCode '  => $CoinCode ,
            'CoinAddress '  => $CoinAddress , //提币地址 bcbMr9nRmbQtDeJALz2xFJ8nddVwLSU3McqA
            'Amount'  => $Amount,
            'Remark '  => '提币到主帐号上',
        ];
        $sign = md5($this->mercode. $CoinCode. $Amount .  $this->keyB . date('Ymd', strval(time())));
        return  $this->guzzleClient($this->withdrawMoneyMechant, $param, $sign, true); 
    }
    /**
     * QueryStatus 3.7（查询状态）   function
     * @param string $UserName
     * @param [type] $orderId
     * @return void
     */
    public function queryStatus($UserName ='tiantian123',$orderId = '')
    {
        $param = [
            'MerCode'   => $this->mercode,
            'TimeStamp'  => strval(time()),
            'UserName'  => $UserName,
            'OrderNo'  => $orderId,
        ];
        $sign = md5($this->mercode.$orderId. $this->keyB . date('Ymd', strval(time())));
        return  $this->guzzleClient($this->queryStatus, $param, $sign, true); 
    }
    //购买处理 登录OTC OrderDetail (获取订单详情） Otc（OTC 订单变动通知）   OtcVerify（OTC 订单校验） 
    /**
     * 登录OTC function
     *  Message:6x:充值金额需大于等于100 每次点击都需要存放DB
     * @param string $UserName 会员名称
     * @param integer $type  请求类型 0-查看订单，1-买币，2-卖币
     * @param string $coin 币种 如：BCB,DC,USDX
     * @param integer $amount 卖/买币数量,如果指定，则资金托管将根据数量进行限定
     * @return void
     */
    public function login($gameId = 300002,$amount = 100,$orderId = null ,$type = 1,$coin = 'DC')
    {
        #存在gameID的情况下 查询数据获取用户名与 赋值对应币的类型
        $virtualCurrencyUser = VirtualCurrencyUser::where('game_id',$gameId)->first();
        if (!$virtualCurrencyUser) { //不存在时,则需要绑定与获取绑定地址 这两个操作
            $result = $this->addUser($gameId);
            if ($result['Success'] == true) {
                $this->GetAddress($gameId);
                $virtualCurrencyUser = VirtualCurrencyUser::where('game_id',$gameId)->first();
            } else {
                return 'failed';
            }
        }
        if (empty($orderId)) {
            $orderId = date('YmdHis').time().mt_rand(10000000,99999999);
        }
        //购买次数异常,当天时间
        $buyCount = VirtualCurrencyUserBuy::where('game_id',$gameId)
                ->where('State1',4)
                ->where('State',1)
                ->count();
        if ($buyCount >= 3) {
            return 'failed';
        }
        $param = [
            'MerCode'   => $this->mercode,
            'TimeStamp'  => strval(time()),
            'UserName'  => $virtualCurrencyUser->username,
            'Type'  => $type,
            'Coin'  => $virtualCurrencyUser->coin_code,
            'Amount'  => $amount,
            'OrderNum'  => $orderId,
            'PayMethods'  => 'bankcard,aliPay,weChatpay,payPal',
            'gameId'   =>$gameId
        ];
        $sign = md5($this->mercode .$virtualCurrencyUser->username.$type.$orderId. $this->keyB . date('Ymd', strval(time())));
        return  $this->guzzleClient($this->login, $param, $sign, true,'login');
    }
    /**
     * 获取订单详情 function
     * 1：订单未完成，2：订单成功，3：订单失败  订单类型 1：买，2：卖
     * @param string $UserName
     * @param [type] $orderId
     * @return void
     */
    public function orderDetail($UserName ='tiantian123',$orderId = '')
    {
        $param = [
            'MerCode'   => $this->mercode,
            'TimeStamp'  => strval(time()),
            'UserName'  => $UserName,
            'OrderNum'  => $orderId,
        ];
        $sign = md5($this->mercode .$UserName.$orderId. $this->keyB . date('Ymd', strval(time())));
        return  $this->guzzleClient($this->orderDetail, $param, $sign, true); 
    }
    /**
     * 统一发送请求 function
     *
     * @param [type] $requstUrl 请求的接口地址
     * @param array $param 接口参数
     * @param string $sign 每个接口的SIGN都不一致.
     * @param boolean $decode json处理返回,或者原样返回
     * @param string $type 存放DB处理的不同接口类型
     * @return void
     */
    public function guzzleClient($requstUrl, $param = [], $sign = 'md5', $decode = true,$type ='default')
    {
        $url = $this->baseUrl .$this->mercode. $requstUrl;
        $deskey = Config::get('services.virtual.DESKey');

        $openssl = new Openssl($deskey, 'DES-CBC', 'hex', $deskey, OPENSSL_RAW_DATA);
        $str = '';
        foreach ($param as $k =>  $v) {
            if ($k == 'gameId') {
                continue;
            }
            $str .= $k .'='.$v.'&';
        }
        $str = rtrim($str, '&');
        $post = [
            'param' => $openssl->encrypt($str),
            'Key'   => $this->virtualSign($sign),
        ];
        $response = $this->client->get($url, [
            'query' => $post
        ]);
        $body = $response->getBody();
        $content = $body->getContents();
        // \Log::info($requstUrl, ['getContent'=>$content,'http_status' => $response->getStatusCode()]);
        if ($response->getStatusCode() == 200) {
            if ($decode == true) {
                $content = json_decode($content, true);
            } else {
                $content;
            }   
            \Log::info($requstUrl, ['DECODE____'=>$content,'param' => $param,'type' =>$type]);
            switch ($type) {
                case 'addUser':
                    if ($content['Code'] == 1) {
                        $addUser = [
                            'mercode'   => $param['MerCode'],
                            'username'   => $param['UserName'],
                            'address'   => 0,
                            'balance'   => 0,
                            'coin_code'   => 'ETH',
                            'user_type'   => 1,
                            'address'   => 0,
                            'game_id'   => $param['gameId']
                        ];
                        VirtualCurrencyUser::create($addUser);
                    }
                    break;
                case  'GetAddress':
                    if ($content['Code'] == 1) {
                        $virtualCurrencyUser = VirtualCurrencyUser::where('game_id',$param['gameId'])->first();
                        $virtualCurrencyUser->address =$content['Data']['Address'];
                        $virtualCurrencyUser->coin_code =$content['Data']['CoinCode'];
                        $virtualCurrencyUser->save();
                    }
                    break;
                case 'login':
                    if ($content['Code'] == 1) {
                        $login = [
                            'game_id'    => $param['gameId'],
                            'mercode'    => $param['MerCode'],
                            'type'    => $param['Type'],
                            'coin'    => $param['Coin'],
                            'amount'    => $param['Amount'],
                            'order_id'    => $param['OrderNum'],
                            'pay_methods'    => $param['PayMethods'],
                        ];
                        VirtualCurrencyUserBuy::create($login);
                    }
                    break;
                case 'GetBalance':   //更新余额
                    if ($param['UserType'] == 1) {
                        $dataBalance = [
                            'balance'   => $content['Data'][0]['Balance'],
                            'frozen_amount' => $content['Data'][0]['FrozenAmount'],
                        ];

                        $virtualCurrencyUser = VirtualCurrencyUser::where('username',$param['UserName'])                               ->update($dataBalance);
                    }
                    //更新当前商户的余额操作
                    if ($param['UserType'] == 2) {
                        foreach ($content['Data'] as $k => $v) {
                            VirtualCurrencyUser::where('username','moab')
                                    ->where('coin_code',$v['CoinCode'])
                                    ->update(['balance'=>$v['Balance'],'frozen_amount'=>$v['FrozenAmount'] ]);
                        }
                    }

                    break;
            }
            return $content;
        }
        return 'failed';
    }
    /**
     * 验证签名 function
     *
     * @param [type] $userName
     * @param [type] $time
     * @return void
     */
    private function virtualSign($sign)
    {
        return strtolower(str_random(6).$sign.str_random(4));
    }
}
