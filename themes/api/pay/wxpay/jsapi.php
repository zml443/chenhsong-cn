<?php
ini_set('date.timezone','Asia/Shanghai');

require_once dirname(__FILE__)."/lib/config.php";
require_once dirname(__FILE__)."/lib/WxPay.Api.php";
require_once dirname(__FILE__)."/example/WxPay.JsApiPay.php";
require_once dirname(__FILE__)."/example/log.php";

//初始化日志
//$logHandler= new CLogFileHandler("logs/".date('Y-m-d').'.log');
//$log = Log::Init($logHandler, 15);


$tools = new JsApiPay();
if(!$_SESSION['wechat']['openId']){
	$openId = $tools->GetOpenid();
	$_SESSION['wechat']['openId'] = $openId;
}
//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody($body);
$input->SetAttach($body);
$input->SetOut_trade_no($out_trade_no);
$input->SetTotal_fee($total_fee*100);
$input->SetTime_start(date("YmdHis",$order_start_time));
$input->SetTime_expire(date("YmdHis",$order_end_time));
$input->SetGoods_tag($body);
$input->SetNotify_url(WxPayConfig::NOTIFY_URL);
$input->SetTrade_type("JSAPI");
$input->SetOpenid($_SESSION['wechat']['openId']);
$order = WxPayApi::unifiedOrder($input);

$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();
?>
<!-- <html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>微信安全支付</title> -->
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+res.err_desc+res.err_msg);
				if(res.err_msg == 'get_brand_wcpay_request:ok'){
					location.href="/rewrite/cart/success.php?OId=<?=$out_trade_no?>";
				}

			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall);
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
</head>
<body>
    <style type="text/css">
	body{padding: 0;margin:0;background-color:#eeeeee;font-family: '黑体';}
	.pay-main{background-color: #4cb131;padding-top: 20px;padding-left: 20px;padding-bottom: 20px;}
	.pay-main img{margin: 0 auto;display: block;}
	.pay-main .lines{margin: 0 auto;text-align: center;color:#cae8c2;font-size:12pt;margin-top: 10px;}
	.tips .img{margin: 20px;}
	.tips .img img{width:20px;}
	.tips span{vertical-align: top;color:#ababab;line-height:18px;padding-left: 10px;padding-top:0px;}
	.action{background:#4cb131;padding: 10px 0;color:#ffffff;text-align: center;font-size:14pt;border-radius: 10px 10px; margin: 15px;}
	.action:focus{background:#4cb131;}
	.action.disabled{background-color:#aeaeae;}
	.footer{position: absolute;bottom:0;left:0;right:0;text-align: center;padding-bottom: 20px;font-size:10pt;color:#aeaeae;}
	.footer .ct-if{margin-top:6px;font-size:8pt;}
	</style>
	<div class="conainer">
		<div class="pay-main">
			<img src="/images/wxpay/pay_logo.png">
			<div class="lines">
				<span>
					微信安全支付
				</span>
			</div>
		</div>
		<div class="tips">
			<div class="img">
				<img src="/images/wxpay/pay_ok.png">
				<span>
					已开启支付安全
				</span>
			</div>
		</div>
		<div onClick="callpay();" class="action" id="action">
			确认支付
		</div>
		<!--<div class="footer">
			<div>
				支付安全由中国人民财产保险股份有限公司承保
			</div>
			<div class="ct-if">
				7x24小时热线：0755-86010333
			</div>
		</div>-->
	</div>
<!-- </body>
</html> -->
