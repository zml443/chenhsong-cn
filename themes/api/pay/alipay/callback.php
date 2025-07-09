<?php

require_once dirname(__FILE__)."/lib/config.php";
require_once dirname(__FILE__)."/lib/alipay_notify.class.php";

$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();
if($verify_result) {//验证成功
	$out_trade_no = $_POST['out_trade_no'];//商户号
	$trade_no = $_POST['trade_no'];//交易号
	$trade_status = $_POST['trade_status'];//状态
	$orders = db::get_one("wb_orders","OrderNumber='{$out_trade_no}' and Status='0'");
	$price_total = $orders['Price'];//应付金额
	if($_POST['seller_id']!=$alipay_config['seller_id'] || $_POST['total_fee']!=$price_total){
		/*将错误的记录写入文件中*/
		$fileContent = file_get_contents("php://input");
		$fp = fopen(dirname(__FILE__).'/logs/error_log.txt', 'a+');
		$str="/--------------------------------------------------------\r\n";
		$str.="【".$out_trade_no."验证成功,付款失败】\r\n";
		$str.="POST: ".$fileContent."\r\n";
		$str.=($_POST['seller_id']!=$alipay_config['seller_id']?"条件一有误".$_POST['seller_id']."!=".$alipay_config['seller_id']:"")."\r\n";
		$str.=($_POST['total_fee']!=$price_total?"条件二有误".$_POST['total_fee']."!=".$price_total:"")."\r\n";
		$str.="--------------------------------------------------------/\r\n\r\n";
		fwrite($fp, $str);
		fclose($fp);
		exit;
	}

	if($_POST['trade_status'] == 'TRADE_FINISHED'){//一旦触发这个条件，前台用户不允许申请退款，如需退款只能通过线下退款，支付宝退款渠道已关闭
		
	}
	else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
		//业务代码。。。
	}
	echo "success";//请不要修改或删除
}
else {
		/*将错误的记录写入文件中*/
		$fileContent = file_get_contents("php://input");
		$fp = fopen(dirname(__FILE__).'/logs/error_log.txt', 'a+');
		$str="/--------------------------------------------------------\r\n";
		$str.="【".$out_trade_no."验证失败,付款结果】\r\n";
		$str.="POST: ".$fileContent."\r\n";
		$str.=json_encode($res)."\r\n";
		$str.="--------------------------------------------------------/\r\n\r\n";
		fwrite($fp, $str);
		fclose($fp);
    //验证失败
    echo "fail";
}
?>
