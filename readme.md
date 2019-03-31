
## 聚合支付
    本项目对接其它第三方支付服务,用于项目不能对接国内支付的处理. 提供API接口与文档(PHP JAVA),方便产品线项目接入,区分对应商户号.
        参考其它项目源码与界面,核心支付流程与编码本人实现. 还支持虚拟币的支付流程与提现


- 实现类似微信支付回调的功能处理,防止商户服务回调接口未响应.提供主动查询与等待回调处理.
- 接口提供支付调用,支付宝,微信,银联H5,虚拟币.统一下单接口.参数控制
- 订单支付查询,主动查询接口与回调接口处理.参数传递.
- app/pay/channel/各个支付的类封装
- app/services/Virtualcurrency 某虚拟币的接口文档业务实现,封装.
- 使用horizon查看队列情况,与任务调度.完成定时器的一些操作.
#### 开发说明 

**名词**

商户: 对应本项目平台的客户,提供shopid与密钥。 方便商户接入

平台: 指本项目 与 第三方的平台的双重意思.  所以自身平台叫第四方平台封装

SDK : 指接入本平台的程序开发

SDK---> 提供给商户的是Pay/SDK/ 下的文件,目前只有PHP版本，后续可以考虑JAVA 与 C# 常见开发SDK


**控制器**

ApiController.php  主要用于提供本平台的接口, 业界常见的 加密与验签处理

ThridPayController.php 用于处理不同渠道的 统一下单 与统一代付处理

NotifyController.php  为处理不同渠道下的回调处理, 已经有UnityDispose统一处理 判断逻辑就行

TestApiContoller.php  为 测试本项目提供的接口能力处理.

使用了 payment 支付的扩展类,路径取自己机器的路径  复制到对应的项目vendor下面就可以使用
    因为是第三方不常见的服务所以,没有向作者push.单独使用.
***

**接口文档部分**  /app/pay/SDK/php  示例与文档说明 
``` PHP
        header("Content-Type: text/html; charset=utf-8");  
        $data = [
            'body'	=> '支付内容',
            'call'	=> 'h5',  
            'paymethod'	=> 'unionpay', 
            'totalfee'	=> 1 ,
            'third'	=> 'ubey',  
            'notifyurl'	=> 'http://192.168.1.251:8011/index.php?op=notify', 
            'order_id'	=> 'TEST'.time().date('YmdHis'), //商户个人的订单记录
            'app_id'	=> self::APPID, //平台发放给商户 的APPID
            #调用微信H5 必填三个参数
            'sceneType' => 'IOS_SDK', //IOS_WAP 或AND_WAP
            'merAppName'    => 'xxx', //应用名称 
            'merAppId'  => 'com.tencent.tmgp.sgame' //应用标识 
        ];
        $data['sign'] = self::sign($data);
        #3.调用HTTP前加密RSA处理  备注 错误参数请查看文档进行处理
        $rsaData = self::rsa($data);
        #4 HTTP 处理. 接收解密，判断业务逻辑. 商户自己处理平台返回的参数，请参考手册说明
        $http = Http::postArrayByUrl( self::url .'pay/payEntry', $rsaData);
        if ($http['code'] == 200) {
            $content = self::rsa($http['content'], 'decrypt');
            $content = json_decode($content, true);
            var_dump($content);
            echo  $content['stateData']['mweburl'];
        } else {
            throw new \Exception("支付平台接口调用异常!", 1);
        }
```


#### 项目图片,后台模板
   ![虚拟币1](http://pp29dvc6r.bkt.clouddn.com/paytem_%E8%99%9A%E6%8B%9F%E5%B8%811.png)
   ![虚拟币2](http://pp29dvc6r.bkt.clouddn.com/paytem_%E8%99%9A%E6%8B%9F%E5%B8%812.png)
   ![后台模板](http://pp29dvc6r.bkt.clouddn.com/paytem_%E5%90%8E%E5%8F%B0%E6%A8%A1%E6%9D%BF1.png)


#### Sign 签名生成方法 (a,b两个步骤)

a.支付中将对数据里面的内容进行鉴权，确定携带的信息是真实、有效、合理的。因此，这里将定义生成 sign 字符串的方法。
对所有传入参数按照字段名的 ASCII 码从小到大排序（字典序） 后，使用 URL 键值对的格式（即 key1=value1&key2=value2…）拼接成字符串 string1，值为空的字段不参与签名。

b.在 string1 最后拼接上 key=Key(商户支付密钥) 得到待签名字符串，并对待签名字符串进行 md5 运算，再将得到的签名字符串所有字符转换为大写，得到 sign 值。

测试app_id：3000031117238
测试app_secret：U84wNiT3cIoGW1d6tnyC6VnMMP7XOEh1EZAWy4l9

假设传入组装的的JSON内容为：
{\"app_id\":\"340201805050344151\",\"body\":\"body\",\"call\":\"h5\",\"notifyurl\":\"notifyurl\",\"order_id\":\"order_id\",\"paymethod\":\"qq\",\"third\":\"kue\",\"totalfee\":\"1\"}
(1)经过 a 过程 URL 键值对字典序排序后的字符串 string1 为:
	$string1 = "app_id=app_id&body=body&call=h5&notifyurl=notifyurl&order_id=order_id&paymethod=qq&third=kue&totalfee=1&key=xxxxxx"
(2)经过 b 过程后得到 sign 为：
$sign= strtoupper( md5("{$string1}&key=bb98357d44bb5b31252fd33dd7514a56") ) ;

$sign = 相当于 strtoupper( md5("app_id=app_id&body=body&call=h5&notifyurl=notifyurl&order_id=order_id&paymethod=qq&third=kue&totalfee=1&key=xxxxxx") ) ;

备注： 1.以上是签名的生成方法，发送到服务器还需要经过RAS公钥进行加密与接收信息时的解密. 提供的所有接口都要进行签名与RSA加解密操作.  
       2.所有接口都POST发送，回调也是一样。 发送与接收的数据都为JSON请留意


***

#### 统一支付异步通知

1.商户交易时传的notifyurl参数，支付完成后，HT平台支付会把支付信息发送到该url上，商户需要处理信息 (method: POST,data: JSON)
2.商户需要对此通知做出响应，当收到商户返回“success”的应答时，HT平台支付才会认为通知成功，否则认为失败，会按一定的策略（1m,1m,5m,10m,1h,6h,12h）重新发起通知。商户需要对接收到的数据优先进行验签处理，确定是从HT平台支付发送的通知后再进行业务方面的处理，因为没有验签而导致的后果商户自行承担。
**请求参数**:

商户订单号	orderid	是	String(32)	商户系统内部订单号
HT平台支付订单号	outtranno	是	String(32)	HT平台支付系统流水号

门店号	storecode	否	String(32)	商户的门店号
交易金额	orderamt	是	String(12)	订单金额
交易状态	tradestate	是	String(20)	支付成功：TRADE_SUCCESS
见附录交易状态枚举
支付方式	method	是	String(20)	订单支付方式，说明见附录支付方式说明
交易时间	tradetime	是	String(16)	支付时间，格式yyyyMMddhhmmss
签名	sign	是	String(32)	生成方法见Sign 签名生成方法

**返回参数**:
	商户处理成功后需要返回给HT平台支付“success”来说明处理成功。

下面将详细说明编码形式。 //paykey 交易密码，HT使用app_secret

假如异步通知地址是http://abc.com/notify.php，服务端将上述参数按Sign 签名生成方法处理后，按照key1=value1&key2=value2&key3=value3&...&key=商户app_secret的形式进行md5加密生成一个sign，并将该sign和上述参数一起发送出去。此时待通知的url全路径即是 (post发送，GET说明请留意)
http://abc.com/notify.php?key1=value1&key2=value2&key3=value3&...&sign=CCC89C1585AC45450D669F12068B02BE