<?php
require_once dirname(__FILE__)."/../lib/config.php";
require_once dirname(__FILE__)."/../lib/alipay_submit.class.php";


/**************************请求参数**************************/
//商户订单号，商户网站订单系统中唯一订单号，必填
$out_trade_no = c('time');//$_POST['WIDout_trade_no'];
//订单名称，必填
$subject = '账户充值';
//付款金额，必填
$total_fee = price::rate('0.01', 2);
//商品描述，可空
$body = '';
//超时时间，可空
$Deadline = '15m';
/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"service"       	=> 	$alipay_config['service'],
		"partner"       	=> 	$alipay_config['partner'],
		"seller_id"  		=> 	$alipay_config['seller_id'],
		"payment_type"		=> 	$alipay_config['payment_type'],
		"notify_url"		=> 	$alipay_config['notify_url'],
		"return_url"		=> 	$alipay_config['return_url'],
		"anti_phishing_key"	=>	$alipay_config['anti_phishing_key'],
		"exter_invoke_ip"	=>	$alipay_config['exter_invoke_ip'],
		"out_trade_no"		=> 	$out_trade_no,
		"subject"			=> 	$subject,
		"total_fee"			=> 	$total_fee,
		"body"				=> 	$body,
		"it_b_pay"			=> 	$Deadline,
		"_input_charset"	=> 	trim(strtolower($alipay_config['input_charset'])),
		"qr_pay_mode"		=> 	(int)$_GET['qr_pay_mode'],//支付方式
		"qrcode_width"		=>	(int)$_GET['qrcode_width'],//当支付方式为4的时候使用
		//其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
        //如"参数名"=>"参数值"
);

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
echo $html_text;
?>
<script>
	var _this_path = '/api/pay/alipay';
</script>
<script type="text/javascript" src="<?=file::self_dir(__FILE__)?>../public/ap.js"></script>
<script>
	var btn = document.querySelector(".J-btn-submit");
	btn.addEventListener("click", function (e) {
			e.preventDefault();
			e.stopPropagation();
			e.stopImmediatePropagation();
			var queryParam = "";
			Array.prototype.slice.call(document.querySelectorAll("input[type=hidden]")).forEach(function (ele,index) {
					queryParam += ele.name + "=" + encodeURIComponent(ele.value) + "&";
			});
			var gotoUrl = document.querySelector("#alipaysubmit").getAttribute("action") + "?" + queryParam;
			//alert(gotoUrl);
			_AP.pay(gotoUrl);
			return false;
	}, false);
	btn.click();
</script>