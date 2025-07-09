<?php
include_once dirname(__FILE__).'/sdk/acp_service.php';
/**
 * 交易说明：	前台类交易成功才会发送后台通知。后台类交易（有后台通知的接口）交易结束之后成功失败都会发通知。
 *              为保证安全，涉及资金类的交易，收到通知后请再发起查询接口确认交易成功。不涉及资金的交易可以以通知接口respCode=00判断成功。
 *              未收到通知时，查询接口调用时间点请参照此FAQ：https://open.unionpay.com/ajweb/help/faq/list?id=77&level=0&from=0
 */

$logger = com\unionpay\acp\sdk\LogUtil::getLogger();
$logger->LogInfo("receive front notify: " . com\unionpay\acp\sdk\createLinkString ( $_POST, false, true ));
$orderId = $_POST['orderId'];
$row = db::get_one('wb_orders',"OrderNumber='{$orderId}'");
if(!$row){
	return false;
}
/*该页面只做跳转*/
js::location('/member/orders/?OrderId='.$row['OrderId']);
exit;
?>