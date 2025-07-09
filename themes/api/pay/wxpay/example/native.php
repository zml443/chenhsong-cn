<?php
/**
*
* example目录下为简单的支付样例，仅能用于搭建快速体验微信支付使用
* 样例的作用仅限于指导如何使用sdk，在安全上面仅做了简单处理， 复制使用样例代码时请慎重
* 请勿直接直接使用样例对外提供服务
*
**/

// 获取后台配置参数
require_once dirname(__FILE__)."/../lib/WxPay.Api.php";
require_once dirname(__FILE__)."/WxPay.NativePay.php";
require_once dirname(__FILE__)."/log.php";

//初始化日志
$logHandler= new CLogFileHandler(dirname(__FILE__)."/../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//模式二
/**
 * 流程：
 * 1、调用统一下单，取得code_url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、支付完成之后，微信服务器会通知支付成功
 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */

$notify=new NativePay();
$input =new WxPayUnifiedOrder();
$input->SetBody("SS");
$input->SetAttach("SS");
$input->SetOut_trade_no(date('YmdHis')."44");
$input->SetTotal_fee(1);	//金额
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url(WXPAY_CALLBACK);
$input->SetTrade_type("NATIVE");
$input->SetProduct_id("");

$result = $notify->GetPayUrl($input);

$url2 = $result["code_url"];

// str::dump($input);
// str::dump($result);
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>微信支付样例-扫码</title>
</head>
<body>
	<!-- <div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;">扫描支付模式一（已被）</div><br/> -->
	<br/><br/><br/>
	<div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;">扫描支付模式</div><br/>
	<img alt="模式二扫码支付" src="qrcode.php?data=<?php echo urlencode($url2);?>" style="width:150px;height:150px;"/>
	<div style="color:#ff0000"><b>微信支付样例程序，仅做参考</b></div>

</body>
</html>
