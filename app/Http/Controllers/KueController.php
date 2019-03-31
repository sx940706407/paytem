<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Third\PayInfoModels;
use App\Services\Http;
use Log;

class KueController extends Controller
{
	protected $gateway = 'https://go.bjhta.cn/pay/pay';
	#请求酷E的地址,返回内容
    public function index(Request $request)
    {
    	$id = $request->id ?? false;
    	if ($id) {
    		$pay = PayInfoModels::where('id',$id)->value('pay_callback_content');
    		$pay = json_decode($pay,true);


    		if (!empty($pay['stateData']['codeurl']) ) {
    			$http = Http::getCurl($pay['stateData']['codeurl']);
    			 Log::info('codeurl_http_test');

    			echo $http['content'];
    			 // header("Location: {$pay['stateData']['codeurl']}");  
    			 // exit;
    		}
    		if (!empty($pay['stateData']['mweburl']) ) {

    			 Log::info('mweburl_http_test');

				$homepage = file_get_contents($pay['stateData']['mweburl']);
				echo $homepage;
    		}
    	}
	}

	#Ubey的处理 银行返回内容
	public function ubeyBank(Request $request)
	{
		$id = $request->id ?? false;
    	if ($id) {
    		$pay = PayInfoModels::where('id',$id)->value('pay_callback_content');
    		$pay = json_decode($pay,true);

    		if (!empty($pay['content']) ) {
    			// $http = Http::getCurl($pay['stateData']['html_unionpay_h5']);
    			 Log::info('codeurl_http_test',['content' => $pay['content']]);

    			echo $pay['content'];
    			 // header("Location: {$pay['stateData']['codeurl']}");  
    			 // exit;
    		}


    	}		
	}
	#chinaumsBank的处理 银行返回内容
	public function chinaumsBank(Request $request)
	{
		$id = $request->id ?? false;
    	if ($id) {
    		$pay = PayInfoModels::where('id',$id)->value('pay_callback_content');
    			echo $pay;
    	}		
	}

	/**
	 * 拼接成HTML 表单方式提交 wap 方式提交与 H5 扫码的方式不一样. function
	 *
	 */
	public function Baisheng(Request $request)
	{
		$id = $request->id ?? false;
    	if ($id) {
			$pay = PayInfoModels::where('id',$id)->value('pay_callback_content');

			echo json_decode($pay);
    	}	
	}


	/**
	 * 拼接成HTML 表单方式提交 wap 方式提交与 H5 扫码的方式不一样. function
	 */
	public function htf(Request $request)
	{
		$id = $request->id ?? false;
    	if ($id) {
			$pay = PayInfoModels::where('id',$id)->value('pay_callback_content');
			$pay = \json_decode($pay,true);
			return $this->buildRequestForm($pay,'POST','WAP');
    	}	
	}


    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @param $method 提交方式。两个值可选：post、get
     * @param $button_name 确认按钮显示文字
     * @return 提交表单HTML文本
     */
	public function buildRequestForm($para_temp, $method, $button_name) {
		$sHtml = "<form id='submit' name='submit' action='".$this->gateway."' method='".$method."'>";
		foreach($para_temp as $key => $val){
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
		}
        $sHtml = $sHtml."<input type='submit' value='".$button_name."'></form>";
		$sHtml = $sHtml."<script>document.forms['submit'].submit();</script>";
		return $sHtml;
	}


}
