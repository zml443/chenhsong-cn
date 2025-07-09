<?php
isset($c)||exit;

// 获取后台配置参数
require_once dirname(__FILE__)."/lib/config.php";
require_once dirname(__FILE__)."/lib/WxPay.Api.php";
require_once dirname(__FILE__)."/example/WxPay.NativePay.php";
require_once dirname(__FILE__)."/example/log.php";

// 创建订单
if ($member_id = member('Id')) {
	// $member_id = member('Id');
	$order = db::get_one('wb_orders', "OrderNumber='{$_GET['OrderNumber']}' and wb_member_id='$member_id'");
	if ($order) {

		//初始化日志
		$logHandler= new CLogFileHandler(dirname(__FILE__)."/logs/".date('Y-m-d').'.log');
		$log = Log::Init($logHandler, 15);

		$notify=new NativePay();
		$input =new WxPayUnifiedOrder();
		$input->SetBody('产品购买');
		$input->SetAttach(g(ln('set.contact.company')));
		$input->SetOut_trade_no($order['OrderNumber']);
		$input->SetTotal_fee(price::orders($order)*100);	//金额 $order['Price']*100
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", c('time') + 600));
		$input->SetGoods_tag($order['Name']);
		$input->SetNotify_url(WXPAY_CALLBACK);
		$input->SetTrade_type("NATIVE");
		$input->SetProduct_id("");

		$result = $notify->GetPayUrl($input);

		$url = urlencode($result["code_url"]);
	}
}

// str::dump($input);
// str::dump($result);
?>

<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="renderer" content="webkit" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta content="telephone=no" name="format-detection" />
	<meta name="screen-orientation" content="portrait">
	<meta name="x5-orientation" content="portrait">
	<?=ly200::load_static(
		'/static/jext/css/global.css',
		'/static/jext/jext.js'
	);?>
</head>
<style>
	.no-set{visibility: hidden;}
	.wx-div{height: 240px;margin-bottom: 20px;}
	.wx-pay{font-size: 16px;color: #777;line-height: 2;}
	.wx-pay.m0{padding-top: 80px;}
	.wx-pay a{color: #43aafb;}
	.wx-pay u{font-style: inherit;text-decoration: none;color: #666;font-size: 18px;}
	.wx-pay i{font-style: inherit;text-decoration: none;color: #FF9800;font-size: 26px;}
	.wx-orrer{padding-top: 90px;color: #999;font-size: 17px;}
	.tip{font-size: 12px;color: #999;bottom: 10px;left: 10px;}
</style>
<body class='no-set'>

	<?php
	if (!member('Id')) {
		echo "
		<div class='wx-pay text-center m0'>
			您尚未登陆账号，无法继续进行操作<br>
			<a href='/login.html' target='_top'>请登录</a>
		</div>
		";
	}
	else if ($url) {
		$price=price::rate(price::orders($order));
		echo "
		<div class='wx-div m-pic'>
			<img src='/api/wxpay/example/qrcode?data={$url}' />
			<b></b>
		</div>
		<div class='wx-pay text-center'>
			{$tip}<br>
			<i>{$price}</i><br>
			<u>购买账单：{$order['OrderNumber']}</u><br>
		</div>
		";
	}
	else{
		echo "<div class='wx-orrer text-center'>参数错误</div>";
	}
	?>

</body>
</html>
<script>
<?php if ($url) { ?>
	function check_orders () {
		$.post('/api/wxpay/check',{OrderNumber:'<?=$order['OrderNumber']?>'},function(d){
			if(d.ret==1){
	            $('body').html("<div class='wx-orrer text-center'>支付成功</div>");
	            // parent.location.href=parent.location.href
	            window.parent.AjaxHtml();
			}
			else{
	            setTimeout(function(){check_orders()},1000);  
			}
		});
	};
	check_orders();
<?php }?>
$('body').removeClass('no-set');
</script>