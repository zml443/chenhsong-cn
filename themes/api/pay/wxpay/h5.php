<?php

require_once dirname(__FILE__).'/lib/config.php';

function xmlToArray($xml)
{
	//禁止引用外部xml实体
	libxml_disable_entity_loader(true);
	$values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
	return $values;
}

function postXmlCurl($xml, $url, $useCert = false, $second = 30){
	$ch = curl_init();
	//设置超时
	curl_setopt($ch, CURLOPT_TIMEOUT, $second);

	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//严格校验
	//设置header
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	//要求结果为字符串且输出到屏幕上
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	//post提交方式
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	//运行curl
	$data = curl_exec($ch);
	//返回结果
	if($data){
		curl_close($ch);
		return $data;
	} else {
		$error = curl_errno($ch);
		curl_close($ch);
		echo "curl出错，错误码:".$error;
	}
}

function arr2xml($arr,$node=null) {
    $xml = "<xml>";
	foreach ($arr as $key=>$val)
	{
		if (is_numeric($val)){
			$xml.="<".$key.">".$val."</".$key.">";
		}else{
			$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
		}
	}
	$xml.="</xml>";
	return $xml;
}
$order=db::get_one('orders', "OrderNumber = '{$_GET['OrderNumber']}'");
$body = g(ln('set.contact.company'));
$out_trade_no = $order['OrderNumber'];
$total_fee = price::orders($order);
$order_start_time = $c['time'];
$order_end_time = $order_start_time + 1600;

// $out_trade_no = $c['time'];
$total_fee = 0.01;

$jsons = array(
	"appid"				=>	WXPAY_APPID,
	"body"				=>	$body,
	"mch_id"			=>	WXPAY_MCHID,
	"nonce_str"			=>	md5($out_trade_no.WXPAY_APPKEY),
	"notify_url"		=>	WXPAY_CALLBACK,
	"out_trade_no"		=>	$out_trade_no,
	"spbill_create_ip"	=>	ip::get(),
	"total_fee"			=>	$total_fee*100,
	"trade_type"		=>	"MWEB",
	"time_start"		=>	date("YmdHis",$order_start_time),
	"time_expire"		=>	date("YmdHis",$order_end_time),
	"scene_info"		=>	'{"h5_info": {"type":"Wap","wap_url":"'.server::domain().'","wap_name":"'.g(ln('set.contact.company')).'"}}',
	/* "scene_info"		=>	array(
								"h5_info"	=>	array(
									"type"		=>	"Wap",
									"wap_url"	=>	server::domain(),
									"wap_name"	=>	"鼎阳商城",
								),
	), */


);

ksort($jsons);
$str = '';
foreach($jsons as $k=>$v){
	if ($k != "sign" && $v != "" && !is_array($v)) {
		$str.="$k=$v&";
	}
}
$jsons['sign']=strtoupper(md5($str.'key='.WXPAY_APPKEY));
// echo $str;
// str::dump(arr2xml($jsons));
$data = (postXmlCurl(arr2xml($jsons), "https://api.mch.weixin.qq.com/pay/unifiedorder"));

// str::dump($data);

$xml_r = xmlToArray($data);

// str::dump($xml_r);
// str::dump(WXPAY_APPKEY);

?>
<script type="text/javascript" src="/static/jext/jq.js"></script>
<script>
function wxPay(){
	$.ajax({
		url : '/api/wxpay/check.php',
		data:{OrderNumber:"<?=$out_trade_no?>"},
		type : "POST",
		dataType : 'json',
		success : function (d){
			if(d.ret==1){
				$('body').html('<div style="text-align:center;font-size:16pt;margin:240px 0 30px;color:#777;">支付成功！</div>');
				//window.location="/rewrite/cart/success.php?OrderNumber=<?=$out_trade_no?>";
                setTimeout(function () {
                    location.href='/member/orders.html';
                }, 3000);
			} else {
				setTimeout(function () {
					wxPay()
				}, 1000);
			}
		}
	})
}
wxPay();
</script>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>微信安全支付</title>
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
	.action{background:#4cb131;padding: 10px 0;color:#ffffff;text-align: center;font-size:14pt;border-radius: 10px 10px; margin: 15px; display:block;}
	.action:focus{background:#4cb131;}
	.action.disabled{background-color:#aeaeae;}
	a{text-decoration:none;}
	a:link{color:#fff;}
	a:visiteds{color:#fff;}
	a:hover{color:#fff;}
	a:active{color:#fff;}
	.footer{position: absolute;bottom:0;left:0;right:0;text-align: center;padding-bottom: 20px;font-size:10pt;color:#aeaeae;}
	.footer .ct-if{margin-top:6px;font-size:8pt;}
	</style>
	<div class="conainer">
		<div class="pay-main">
			<img src="/static/themes/api/wxpay/public/pay_logo.png">
			<div class="lines">
				<span>
					微信安全支付
				</span>
			</div>
		</div>
		<div class="tips">
			<div class="img">
				<img src="/static/themes/api/wxpay/public/pay_ok.png">
				<span>
					已开启支付安全
				</span>
			</div>
		</div>
		<a href="<?=$xml_r['mweb_url']?>" class="action" id="action">
			确认支付
		</a>
		<!--<div class="footer">
			<div>
				支付安全由中国人民财产保险股份有限公司承保
			</div>
			<div class="ct-if">
				7x24小时热线：0755-86010333
			</div>
		</div>-->
	</div>
</body>
</html>
