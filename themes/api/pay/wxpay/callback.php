<?php
/**
*
* example目录下为简单的支付样例，仅能用于搭建快速体验微信支付使用
* 样例的作用仅限于指导如何使用sdk，在安全上面仅做了简单处理， 复制使用样例代码时请慎重
* 请勿直接直接使用样例对外提供服务
* 
**/

// 获取后台配置参数
require_once 'lib/config.php';
require_once "lib/WxPay.Api.php";
require_once "lib/WxPay.Notify.php";
require_once "example/WxPay.Config.php";
require_once "example/log.php";

//初始化日志
$logHandler= new CLogFileHandler(dirname(__FILE__)."/logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);



$config = new WxPayConfig();
Log::DEBUG("begin notify");

$xml_r = file_get_contents('php://input');//$GLOBALS['HTTP_RAW_POST_DATA'];
// Log::DEBUG("callback，".$xml_r);
function xmlToArray($xml)
{    
	//禁止引用外部xml实体
	libxml_disable_entity_loader(true);
	$values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);        
	return $values;
}
$xml_r = xmlToArray($xml_r);
Log::DEBUG("callback1，".print_r($xml_r,1));

$input = new WxPayOrderQuery();
$input->SetOut_trade_no($xml_r["out_trade_no"]);
$res = WxPayApi::orderQuery($config, $input);
Log::DEBUG("callback2，".print_r($res,1));
($res['trade_state']=='SUCCESS' || $res['return_code'] =='SUCCESS' || $res['result_code'] =='SUCCESS') && $order = db::get_one("orders","OrderNumber='{$res['out_trade_no']}' and Status in (0,1)");

$order && Log::DEBUG("callback3，".print_r($order,1));
if($order && (price::orders($order)*100) == $res['total_fee']){
	//开始你的表演。。。
	db::update("wb_orders","Id='{$order['Id']}'",array(
		'Status'	=>	2,
		'PaymentMethod'	=>	'微信支付'
	));
	Log::DEBUG('OK:'.json_encode($res));
}else{
	Log::DEBUG('回调数据异常'.json_encode($res));
}
?>