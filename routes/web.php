<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
队列服务器   http://192.168.1.251:8055/horizon/dashboard

文档doc  http://192.168.1.251:8055/doc/index.html

使用frpc 进行内网穿透,方便调试项目

*/



Route::get('/', function () {
    return 'paytem商户支付平台_local';
});



//不同第三方平台封装的支付宝与微信都不相同。 都需要自己封装一遍返回游戏
Route::any('/kue/{id?}','KueController@index');
Route::any('/ubey/{id?}','KueController@ubeyBank');
Route::any('/chinaums/{id?}','KueController@chinaumsBank');
Route::any('/htf/{id?}','KueController@htf');
Route::any('/Baisheng/{id?}','KueController@Baisheng');


/**
 * 提供给商户使用的后台处理.代付 。订单查询 == 
 */
Route::group(['namespace'=> 'Shop','prefix'=>'shop'],function($router){
	$router->get('index','IndexController@index');
	$router->get('user','IndexController@user');

	$router->get('order','IndexController@order');
	$router->get('orderData','IndexController@orderData')->name('order.data');

	$router->get('payChannel','IndexController@payChannel');
	$router->get('api','IndexController@api');
	$router->get('js','IndexController@js');
	$router->get('df','IndexController@df');
	$router->get('bz','IndexController@bz');
});

/**
 * 商户总管理后台 参考,使用妹子UI 制做
 */
Route::group(['namespace'=> 'system','prefix'=>'system'],function($router){
	$router->get('index','IndexController@index');

		#核心配置
	$router->get('set/core','SettingController@core');
	$router->get('set/pay','SettingController@pay');
	$router->get('set/email','SettingController@email');
	$router->get('set/sms','SettingController@sms');
	$router->get('set/blackPay','SettingController@blackPay');
		#相关记录
	$router->get('related/order','RelatedController@order');
	$router->get('related/js','RelatedController@js');
	$router->get('related/black','RelatedController@black');
		#商户功能
	$router->get('shop/add','ShopController@add');
	$router->get('shop/manager','ShopController@manager');
	$router->get('shop/js','ShopController@js');
	$router->get('shop/realName','ShopController@realName');
	$router->get('shop/api','ShopController@api');
		#管理列表
	
		#网站公告
	$router->get('other/notiy','NotiyController@notiy');
	$router->get('other/message','NotiyController@message');
	$router->get('other/quesstion','NotiyController@quesstion');

		#站内消息
		
		#问题反馈

	#统一第三方支付的渠道与方法 ==  原生的要单独写一套
	$router->get('pay/{third?}/{channel?}/{payType?}','ThridPayController@pay');
	$router->get('pay_status/{third?}/{channel?}/{order_id?}','ThridPayController@payStatus');
	$router->get('pay_bank/{third?}','ThridPayController@payBank');
	$router->get('pay_bank_status/{third?}/{order_id?}','ThridPayController@payBankStatus');

});

/**
 *1.统一下单 统一代付的处理 与涉及各平台的回调处理 12/07 加上虚拟币的处理
 *
 * postman apidoc 文档生成  项目DEMO 提供(PHP,JAVA)
 */
Route::group(['namespace'=>'Api','prefix' => 'pay'],function($router){
	//充值与订单查询 ------- 代付的操作 与 代付查询  支持回调处理
	Route::post('payEntry','ApiController@payEntry');
	Route::post('payQuery','ApiController@payQuery');

	Route::post('payBankEntry','ApiController@payBankEntry');
	Route::post('payBankQuery','ApiController@payBankQuery');

	#虚拟币的支付处理
	Route::post('payEntryVirtual','ApiController@payEntryVirtual');
	#商户余额查询 
	Route::post('merchanQueryBalance','ApiController@merchanQueryBalance');

	#测试接口 调试用xdebug
	Route::get('testApiPay','TestApiController@pay');
	Route::get('test2','TestApiController@pay2');

	Route::get('virtual','TestApiController@virtual');

	#xx的回调处理 回调本平台单一处理
	Route::any('zn/notifyUrl/{result?}','ZhongController@notify');

	#xx的回调处理 统一支付的所有都写在这里
	Route::POST('ubey/notifyUrl/{result?}','NotifyController@notifyUber');
	Route::POST('ubey/unityBank','NotifyController@notifyUberBank');

	Route::POST('witspay/notifyUrl/{result?}','NotifyController@witspay');
	Route::POST('chinaumspay/notifyUrl/{result?}','NotifyController@chinaums');
	Route::any('suispaypay/notifyUrl/{result?}','NotifyController@suispaypay');
	Route::any('htfpay/notifyUrl/{result?}','NotifyController@htfpay');
	Route::any('baishengPay/notifyUrl/{result?}','NotifyController@baishengPay');

	#后台管理上 增加回调地址 . 用于币商回调商户 处理 购买与卖入的处理
	Route::any('otcNotifyurl/{otc?}','NotifyController@otc');
});

/**
 * 虚拟币的页面展示 购买 与出售 等操作
 */
Route::group(['namespace'=>'Virtual','prefix' => 'virtual'],function($router){

	$router->get('login','LoginController@login');
	$router->post('loginDo','LoginController@loginDo');

	Route::group(['middleware'=> 'virtual'],function($router){
		$router->get('datatabslesZh','IndexController@datatabslesZh');

		$router->get('index','IndexController@index');
	
		$router->get('refreshBalance','IndexController@refreshBalance');
		$router->post('accountBank','IndexController@accountBank');
	
		$router->get('withdraw/{id?}','IndexController@withdraw');
	
		$router->get('buyList','IndexController@buyList');
		$router->post('buyList','IndexController@buyListPost');
	});

});



