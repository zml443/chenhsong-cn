<?php
include_once dirname(__FILE__).'/sdk/acp_service.php';
/**
 * 交易说明：	前台类交易成功才会发送后台通知。后台类交易（有后台通知的接口）交易结束之后成功失败都会发通知。
 *              为保证安全，涉及资金类的交易，收到通知后请再发起查询接口确认交易成功。不涉及资金的交易可以以通知接口respCode=00判断成功。
 *              未收到通知时，查询接口调用时间点请参照此FAQ：https://open.unionpay.com/ajweb/help/faq/list?id=77&level=0&from=0
 */
$logger = com\unionpay\acp\sdk\LogUtil::getLogger();
$logger->LogInfo("receive back notify: " . com\unionpay\acp\sdk\createLinkString ( $_POST, false, true ));

if (isset ( $_POST ['signature'] )) {
	// echo com\unionpay\acp\sdk\AcpService::validate ( $_POST ) ? '验签成功' : '验签失败';
	if(com\unionpay\acp\sdk\AcpService::validate ($_POST)){
		$orderId = $_POST['orderId']; //其他字段也可用类似方式获取
		$respCode = $_POST['respCode'];
		
		if($respCode == '00' || $respCode == 'A6'){
			$params = array(
					//以下信息非特殊情况不需要改动
					'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,		  //版本号
					'encoding' => 'utf-8',		  //编码方式
					'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,		  //签名方法
					'txnType' => '00',		      //交易类型
					'txnSubType' => '00',		  //交易子类
					'bizType' => '000000',		  //业务类型
					'accessType' => '0',		  //接入类型
					'channelType' => '07',		  //渠道类型
			
					//TODO 以下信息需要填写
					'orderId' => $_POST["orderId"],
					'merId' => $_POST["merId"],
					'txnTime' => $_POST["txnTime"],
			);
			com\unionpay\acp\sdk\AcpService::sign ( $params ); // 签名
			$url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->singleQueryUrl;
			
			$result_arr = com\unionpay\acp\sdk\AcpService::post ( $params, $url);
			
			if (com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
				if ($result_arr["respCode"] == "00"){
					if ($result_arr["origRespCode"] == "00"){
						//交易成功，继续处理业务逻辑
						//业务代码。。。
					} else if ($result_arr["origRespCode"] == "03"
							|| $result_arr["origRespCode"] == "04"
							|| $result_arr["origRespCode"] == "05"){
						//后续需发起交易状态查询交易确定交易状态
						//TODO
						echo "交易处理中，请稍微查询。<br>\n";
					} else {
						//其他应答码做以失败处理
						//TODO
						echo "交易失败：" . $result_arr["origRespMsg"] . "。<br>\n";
					}
				} else if ($result_arr["respCode"] == "03"
						|| $result_arr["respCode"] == "04"
						|| $result_arr["respCode"] == "05" ){
					//后续需发起交易状态查询交易确定交易状态
					//TODO
					echo "处理超时，请稍微查询。<br>\n";
				} else {
					//其他应答码做以失败处理
					//TODO
					echo "失败：" . $result_arr["respMsg"] . "。<br>\n";
				}
			}
		}
		
		
	}
	//判断respCode=00、A6后，对涉及资金类的交易，请再发起查询接口查询，确定交易成功后更新数据库。

} else {
	echo '签名为空';
}
exit;

?>