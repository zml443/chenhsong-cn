<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <title>微信支付样例-订单查询</title>
</head>
<?php
/**
*
* example目录下为简单的支付样例，仅能用于搭建快速体验微信支付使用
* 样例的作用仅限于指导如何使用sdk，在安全上面仅做了简单处理， 复制使用样例代码时请慎重
* 请勿直接直接使用样例对外提供服务
* 
**/
// 获取后台配置参数
require_once dirname(__FILE__)."/../lib/config.php";
require_once dirname(__FILE__)."/../lib/WxPay.Api.php";
require_once dirname(__FILE__)."/log.php";
require_once dirname(__FILE__)."/WxPay.Config.php";

if((isset($_REQUEST["transaction_id"]) && $_REQUEST["transaction_id"] != "" 
		&& !preg_match("/^[0-9a-zA-Z]{10,64}$/i", $_REQUEST["transaction_id"], $matches))
	|| (isset($_REQUEST["out_trade_no"]) && $_REQUEST["out_trade_no"] != "" 
		&& !preg_match("/^[0-9a-zA-Z]{10,64}$/i", $_REQUEST["out_trade_no"], $matches))){
	header('HTTP/1.1 404 Not Found');
	exit();
}

//初始化日志
$logHandler= new CLogFileHandler(dirname(__FILE__)."/../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#f00;'>$key</font> : ".htmlspecialchars($value, ENT_QUOTES)." <br/>";
    }
}


if(isset($_REQUEST["transaction_id"]) && $_REQUEST["transaction_id"] != ""){
	try {
		$transaction_id = $_REQUEST["transaction_id"];
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$config = new WxPayConfig();
		printf_info(WxPayApi::orderQuery($config, $input));
	}
	catch(Exception $e) {
		Log::ERROR(json_encode($e));
	}
	exit();
}

if(isset($_REQUEST["out_trade_no"]) && $_REQUEST["out_trade_no"] != ""){
	try{
		$out_trade_no = $_REQUEST["out_trade_no"];
		$input = new WxPayOrderQuery();
		$input->SetOut_trade_no($out_trade_no);
		$config = new WxPayConfig();
		printf_info(WxPayApi::orderQuery($config, $input));
	} catch(Exception $e) {
		Log::ERROR(json_encode($e));
	}
	exit();
}
?>
<body>  
	<form action="#" method="post">
        <div style="margin-left:2%;color:#f00">微信订单号和商户订单号选少填一个，微信订单号优先：</div><br/>
        <div style="margin-left:2%;">微信订单号：</div><br/>
        <input type="text" style="width:96%;height:35px;margin-left:2%;" name="transaction_id" /><br /><br />
        <div style="margin-left:2%;">商户订单号：</div><br/>
        <input type="text" style="width:96%;height:35px;margin-left:2%;" name="out_trade_no" /><br /><br />
		<div align="center">
			<input type="submit" value="查询" style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" />
		</div>
	</form>
</body>
</html>
