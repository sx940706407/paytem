<?php 

namespace App\Services;
use App\Models\Third\BankDetail;
use Config;
/**
 * 银行信息的操作获取远程的银行卡信息
 */
class Bank
{

	public function getBankInfo($cardNumber)
	{

		$bank = BankDetail::where('bank_no',$cardNumber)->where('status',1)->first();

		#cardNumber 是否为数字，如果不为直接跳出处理

		if ($bank) {
			
		} else {
			$url = "xxx";

			$http = Http::getCurl($url);



			#存放对应的银行卡信息
			if($http['code'] == 200){
				$content = json_decode($http['content'],true);
				if ($content['error_code'] == 0) {
					$result = $content['result'];
					#提取用户信息
					$data =[];

					\Log::info('http===>BANK===>',['resultList====>'=>$result]);


					foreach ($result['list'] as $k => $v) {
						$data['province']	= $v['province'];
						$data['city']	= $v['city'];
						$data['bankname']	= $v['bankname'];
						$data['branchname']	= $v['branchname'];
						$data['number']	= $v['number'];
						break;						
					}
					$data['content'] = json_encode($result['list']) ;
					$data['bank_no'] = $cardNumber;
					$data['status']	= 1;
					BankDetail::create($data);
					#status 状态为一的用户则不需要 查询接口了。 直接返回信息
				}
				return 	Config::get('error.2002');
			}			
		}

	}

	/**
	 * 银行的信息查询--使用的阿里接口 function
	 *
	 * @param [type] $cardNumber
	 * @return void
	 */
	public function bankAlias($cardNumber)
	{
		$url = "https://ccdcapi.alipay.com/validateAndCacheCardInfo.json?_input_charset=utf-8&cardNo={$cardNumber}&cardBinCheck=true";

		$http = Http::getCurl($url);

		$content = json_decode($http['content'],true);
		return $content;
	}

}