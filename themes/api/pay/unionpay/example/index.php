<?php
header ( 'Content-type:text/html;charset=utf-8' );
include_once dirname(__FILE__).'/../sdk/acp_service.php';

$orderId = c('time');
$txnTime = date('YmdHis',c('time'));
$txnAmt = '0.01';
$params = array(
	//以下信息非特殊情况不需要改动
	'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,                 //版本号
	'encoding' => 'utf-8',				  //编码方式
	'txnType' => '01',				      //交易类型
	'txnSubType' => '01',				  //交易子类
	'bizType' => '000201',				  //业务类型
	'frontUrl' =>  com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->frontUrl,  //前台通知地址
	'backUrl' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backUrl,	  //后台通知地址
	'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,	              //签名方法
	'channelType' => '08',	              //渠道类型，07-PC，08-手机
	'accessType' => '0',		          //接入类型
	'currencyCode' => '156',	          //交易币种，境内商户固定156
	
	//TODO 以下信息需要填写
	'merId' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->merId,		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
	'orderId' => $orderId,	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
	'txnTime' => $txnTime,	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
	'txnAmt' => $txnAmt*100,	//交易金额，单位分，此处默认取demo演示页面传递的参数
	
	// 订单超时时间。
	// 超过此时间后，除网银交易外，其他交易银联系统会拒绝受理，提示超时。 跳转银行网银交易如果超时后交易成功，会自动退款，大约5个工作日金额返还到持卡人账户。
	// 此时间建议取支付时的北京时间加15分钟。
	// 超过超时时间调查询接口应答origRespCode不是A6或者00的就可以判断为失败。
	'payTimeout' => date('YmdHis', strtotime('+15 minutes')), 

	// 'riskRateInfo' =>'{commodityName=测试商品名称}',

	// 请求方保留域，
	// 透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据。
	// 出现部分特殊字符时可能影响解析，请按下面建议的方式填写：
	// 1. 如果能确定内容不会出现&={}[]"'等符号时，可以直接填写数据，建议的方法如下。
	//    'reqReserved' =>'透传信息1|透传信息2|透传信息3',
	// 2. 内容可能出现&={}[]"'符号时：
	// 1) 如果需要对账文件里能显示，可将字符替换成全角＆＝｛｝【】“‘字符（自己写代码，此处不演示）；
	// 2) 如果对账文件没有显示要求，可做一下base64（如下）。
	//    注意控制数据长度，实际传输的数据长度不能超过1024位。
	//    查询、通知等接口解析时使用base64_decode解base64后再对数据做后续解析。
	//    'reqReserved' => base64_encode('任意格式的信息都可以'),
	
	//TODO 其他特殊用法请查看 special_use_purchase.php
);
com\unionpay\acp\sdk\AcpService::sign ( $params );
$uri = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->frontTransUrl;
$html_form = com\unionpay\acp\sdk\AcpService::createAutoFormHtml( $params, $uri );
echo $html_form;
