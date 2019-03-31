<?php 

return [
	'10'	=>['stateCode'	=> 10,'stateMsg'=> '签名验证失败!','stateData' => []],
	'11'	=>['stateCode'	=> 11,'stateMsg'=> '商户信息不存在!请留意app_id是否填写有误','stateData' => []],
	'12'	=>['stateCode'	=> 12,'stateMsg'=> '传入的参数有误,请按手册参数说明传入','stateData' => []],
	'13'	=>['stateCode'	=> 13,'stateMsg'=> '订单不存在!','stateData' => []],
	'14'	=>['stateCode'	=> 14,'stateMsg'=> '商户余额不足,请在HT平台上充值.','stateData' => []],
	'15'	=>['stateCode'	=> 15,'stateMsg'=> '订单ID不存在,查询失败.请留意自己商户订单是否填写有误','stateData' => []],

	'101'	=>['stateCode'	=> 101,'stateMsg'=> '非法操作!_!','stateData' => []],

	'200'	=>['stateCode'	=> 200,'stateMsg'=> 'ok','stateData' => []],
	'403'	=>['stateCode'	=> 403,'stateMsg'=> '验证失败,非法操作!','stateData' => []],

	'1000'	=>['stateCode'	=> 1000,'stateMsg'=> '平台帐号余额不足,请更换渠道进行代付.','stateData' => []],
	'1001'	=>['stateCode'	=> 1001,'stateMsg'=> '渠道提供商未响应,请更换渠道参数进行调用','stateData' => []],
	'1002'	=>['stateCode'	=> 1002,'stateMsg'=> '渠道尚未支持,如有问题请联系客服!,请留意渠道大小写等问题.参考手册上支持的第三方渠道','stateData' => []],
	'1003'	=>['stateCode'	=> 1003,'stateMsg'=> '渠道目前不可用,请稍后在试!!','stateData' => []],
	'1004'	=> ['stateCode'	=> 1004,'stateMsg'=> '渠道订单尚未交易成功,请稍后查询!','stateData' => []],

	'1010'	=> ['stateCode'	=> 1010,'stateMsg'=> '代付订单查询错误,请检查订单参数是否存在错误。','stateData' => []],


	'2001'	=>['stateCode'	=> 2001,'stateMsg'=> '系统内部错误!请联系管理员','stateData' => []],
	'2002'	=>['stateCode'	=> 2002,'stateMsg'=> '系统API读取错误,请稍后重试!','stateData' => []],


	'2003'	=>['stateCode'	=> 2003,'stateMsg'=> '当前渠道不支付此银行的代付操作','stateData' => []],

	//虚拟币的配置-----
	'3001'	=>['stateCode'	=> 3001,'stateMsg'=> '当天未支付订单已超过三笔!','stateData' => []],
	'3002'	=>['stateCode'	=> 3002,'stateMsg'=> '虚拟币平台异常,请稍后重试!','stateData' => []],

	'3003'	=>['stateCode'	=> 3003,'stateMsg'=> '虚拟币平台绑定异常,请联系管理员查看','stateData' => []],

];