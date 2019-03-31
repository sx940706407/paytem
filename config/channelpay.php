<?php 

return [

	#微信通,其它第三方平台
	'wxt'	=> [
		'service'	=> 'App\Pay\Channel\Wxt',
		'unity_commission'	=> 0.97,
	],
	#Ubey的支付配置处理
	'ubey'	=> [
		'service'	=> 'App\Pay\Channel\Ubey',
		'unity_commission'	=> 0.97,

		'ID'	=> 'x',
		'pay_password'	=> 'x',
		'google_captcha'	=> 'x',
	],
	#ubey 单一的商户号处理  天天棋牌，提现也需要判断。 quartet平台处理
	'ubey2'	=> [
		'service'	=> 'App\Pay\Channel\Ubey',
		'unity_commission'	=> 0.97,

		'ID'	=> 'x',
		'pay_password'	=> 'x',
		'google_captcha'	=> 'x',
	],
	#http://api.zhi-pay.com
	'witspay'	=> [
		'service'	=> 'App\Pay\Channel\WitsPay',
		'zfb'	=> [
			'commission'	=> 0.97 // 1 - 0.03 手续费用 防止商户平台的钱数看起来 与真实的不合
		]	,
		'SHOP_ID_1'	=>  'x',
		'SHOP_KEY_1'	=> 'x'
		],
	#chinaums 支付  银联商务H5支付处理
	'chinaums'	=> [
		'service'	=> 'App\Pay\Channel\Chinaums',
		
		'zfb'	=> [
			'commission'	=> 0.97 // 1 - 0.03 手续费用 防止商户平台的钱数看起来 与真实的不合
		],
		'test-server'	=> 'https://qr-test2.chinaums.com/netpay-portal/webpay/pay.do',
		'production-server'=> 'https://qr.chinaums.com/netpay-portal/webpay/pay.do',

		#天天的H5 支付宝处理
		'mid'	=> 'x',
		'tid'	=> 'x',
		'instMid'	=> 'x',  //YUEDANDEFAULT
		'msgSrc'	=> 'x',
		'msgSrcId'	=> 4452,
		'md5'	=> 'xx',
	],
	#随身智付 平台接入 配置
	'suispay'	=> [
		'service'	=> 'App\Pay\Channel\Suispay',
		'zfb'	=> [
			'commission'	=> 0.97 // 1 - 0.03 手续费用 防止商户平台的钱数看起来 与真实的不合
		],
		'mch_id'	=> x,
		'md5Key'	=> 'x',
	],
	#和通付的测试
	'htf'	=> [
		'service'	=> 'App\Pay\Channel\Htf',
		'zfb'	=> [
			'commission'	=> 0.97 // 1 - 0.03 手续费用 防止商户平台的钱数看起来 与真实的不合
		],
		'partner'	=> 'x',
		'partner_password'	=> 'x',
		'partner_pay'	=> 'x',
		'partner_phone'	=> 'x',
		'partner_md5key'	=> 'x',
	],

	'htf_hero'	=> [
		'service'	=> 'App\Pay\Channel\Htf',
		'zfb'	=> [
			'commission'	=> 0.97 // 1 - 0.03 手续费用 防止商户平台的钱数看起来 与真实的不合
		],
		'partner'	=> 'x',
		'partner_password'	=> 'x',
		'partner_pay'	=> 'x',
		'partner_phone'	=> 'x',
		'partner_md5key'	=> 'x',
	],

	'htf_jg'	=> [
		'service'	=> 'App\Pay\Channel\Htf',
		'zfb'	=> [
			'commission'	=> 0.97 // 1 - 0.03 手续费用 防止商户平台的钱数看起来 与真实的不合
		],
		'partner'	=> 'x',
		'partner_password'	=> 'x',
		'partner_pay'	=> 'x',
		'partner_phone'	=> 'x',
		'partner_md5key'	=> 'x',
	],

	#天天的HFT 商户号
	'htf_tiantian'	=> [
		'service'	=> 'App\Pay\Channel\Htf',
		'zfb'	=> [
			'commission'	=> 0.97 // 1 - 0.03 手续费用 防止商户平台的钱数看起来 与真实的不合
		],
		'partner'	=> 'x',
		'partner_password'	=> 'x',
		'partner_pay'	=> 'x',
		'partner_phone'	=> 'x',
		'partner_md5key'	=> 'x',
	],

	#baisheng config
	'Baisheng'	=> [
		'service'	=> 'App\Pay\Channel\Baisheng',
		'zfb'	=> [
			'commission'	=> 0.97 // 1 - 0.03 手续费用 防止商户平台的钱数看起来 与真实的不合
		],
		'partner'	=> 'x',
		'partner_md5key'	=> 'x',

	],
	#baisheng config 虚拟币的处理
	'virtual'	=> [
		'service'	=> 'App\Pay\Channel\Virtual',
		'zfb'	=> [
			'commission'	=> 0.97 // 1 - 0.03 手续费用 防止商户平台的钱数看起来 与真实的不合
		],
	],

];