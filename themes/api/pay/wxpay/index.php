<?php
isset($c)||exit;

// 获取后台配置参数
require_once dirname(__FILE__).'/lib/config.php';
require_once dirname(__FILE__)."/lib/WxPay.Api.php";
require_once dirname(__FILE__)."/example/WxPay.NativePay.php";
require_once dirname(__FILE__)."/example/log.php";

// 创建订单

$order=db::get_one('wb_orders', "OrderNumber = '{$_GET['OrderNumber']}'");
if($order){
    $total_fee = price::orders($order);
    $body = '产品购买';
    $subject = g(ln('set.contact.company'));
    $out_trade_no = $order['OrderNumber'];
    $order_start_time = c('time');

    //初始化日志
    $logHandler= new CLogFileHandler(dirname(__FILE__)."/logs/".date('Y-m-d').'.log');
    $log = Log::Init($logHandler, 15);

    $notify=new NativePay();
    $input =new WxPayUnifiedOrder();
    $input->SetBody($body);
    $input->SetAttach($subject);
    $input->SetOut_trade_no($out_trade_no);
    $input->SetTotal_fee($total_fee*100);    //金额 $order['Price']*100
    $input->SetTime_start(date("YmdHis", $order_start_time));
    $input->SetTime_expire(date("YmdHis", time() + 600));
    $input->SetGoods_tag($order['Name']);
    $input->SetNotify_url(WXPAY_CALLBACK);
    $input->SetTrade_type("NATIVE");
    $input->SetProduct_id("");

    $result = $notify->GetPayUrl($input);

    $url2 = urlencode($result["code_url"]);
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta charset="utf-8">
<title>微信支付</title>
<style>
.dn{display:none}
.di{display:inline}
.dib{display:inline-block}
.b_dib{display:inline-block;*display:inline;*zoom:1}
.db{display:block}
.vh{visibility:hidden}
.vv{visibility:visible}
.rel{position:relative}
.abs{position:absolute}
.oh{overflow:hidden}
.z{*zoom:1}
.l{float:left}
.r{float:right}
.cl{clear:both}
.group{*zoom:1}
.group:after{content:"\200B";display:block;height:0;clear:both}
.tc{text-align:center}
.tr{text-align:right}
.tl{text-align:left}
.tj{text-align:justify;*text-justify:distribute}
.vt{vertical-align:top}
.vm{vertical-align:middle}
.vb{vertical-align:bottom}
.f0{font-size:0}
.fa{font-family:Arial}
.faN{font-family:"Arial Narrow"}
.fs{font-family:SimSun}
.fyh{font-family:"Microsoft YaHei"}
.indent{text-indent:2em}
.n{font-weight:400;font-style:normal}
.b{font-weight:700}
.i{font-style:italic}
.tdn{text-decoration:none}
.tdn:hover{text-decoration:none}
.tdu{text-decoration:underline}
.poi{cursor:pointer}
.text_hide{line-height:999em;overflow:hidden}
body{line-height:1.6;font-family:"Microsoft YaHei",Helvetica,Verdana,Arial,Tahoma;font-size:14px}
body{color:#303030}
input,textarea,select{color:#000}
input,textarea{outline:0}
body,h1,h2,h3,h4,p,ul,ol,dl,dd{margin:0}
ul,ol{padding-left:0;list-style-type:none}
a img{border:0}
a{color:#374673}
a:hover{color:#5770bb}
a:active{color:#374673}
.mail_box{position:relative;box-shadow: 0 1px 1px rgba(0,0,0,0.35);-moz-box-shadow: 0 1px 1px rgba(0,0,0,0.35);-webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.35);background:#fff url(/static/themes/api/wxpay/public/bg_mail_box_hd1518d5.png) repeat-x 0 -60px}
.mail_box_inner{position:relative;bottom:-10px;overflow:hidden;*zoom:1;padding:60px 170px 100px;background:transparent url(/static/themes/api/wxpay/public/bg_mail_box_ft1518d5.png) repeat-x bottom left}
.mail_box_corner{position:absolute;top:0;width:6px;height:30px;background:transparent url(/static/themes/api/wxpay/public/bg_mail_box_hd1518d5.png) no-repeat 0 0}
.mail_box_corner.left{background-position:0 0;left:-5px}
.mail_box_corner.right{background-position:0 -30px;right:-5px}
.pay_widget_hd,.pay_widget_bd{display:inline-block;*display:inline;*zoom:1;vertical-align:middle;*margin-right:5px}
.pay_widget_hd{padding-top:.35em}
.widget_name{color:#6c6c6c;font-size:12px;font-weight:400}
.widget_desc{margin-top:-4px;font-size:14px}
.msg_default_box{padding:12px 0;border:1px solid #2b4d69;background-color:#445f85;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;letter-spacing:6px;color:#fff}
.msg_default_box i{margin-left:-16px}
.msg_default_box p{display:inline-block;*display:inline;*zoom:1;vertical-align:middle;letter-spacing:normal;text-align:left;font-size:16px; color:#fff;}
.msg_default_box strong{display:block;color:#fff;font-size:15px;font-weight:400}
.msg_box{padding:12px 0;border:1px solid #259483;background-color:#4ca698;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;box-shadow: 0 1px 2px rgba(0,0,0,0.2);-moz-box-shadow: 0 1px 2px rgba(0,0,0,0.2);-webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.2);color:#fff;text-align:center;letter-spacing:6px}
.msg_box i{margin-left:-16px}
.msg_box p{display:inline-block;*display:inline;*zoom:1;vertical-align:middle;letter-spacing:normal;text-align:left;font-size:16px}
.msg_box strong{display:block;color:#fff;font-size:15px;font-weight:400}
.msg_error_box{padding:18px 14px;border:1px solid #b17475;background-color:#e4b8b9;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px}
.msg_error_box p{color:#000;font-size:15px;font-weight:400}
.area{text-align:center}
.area_hd h2{display:none}
.pay_bill .area_hd{border-bottom:3px solid #e0e3eb;padding-bottom:4px;height:60px}
.pay_bill .area_hd .icon_wrapper{display:inline-block;*display:inline;*zoom:1;position:relative;top:34px;padding-left:12px;padding-right:14px;background-color:#fff}
.area_bd{display:none}
.pay_bill .area_bd{display:block}
.wrapper{width:920px;margin-left:auto;margin-right:auto}
body{background:#d4d5d7 url(/static/themes/api/wxpay/public/bg_pay1518d5.png)}
.header{height:66px;background:url(/static/themes/api/wxpay/public/bg_pay_header15b813.png)}
.pay_logo{text-align:center;padding-top:18px;padding-bottom:0}
.pay_logo img{width:100%;height:100%}
.pay_logo .index_access{display:inline-block;width:120px;height:34px;vertical-align:top}
.content{padding-top:7px;padding-bottom:60px}
.aside{clear:both;margin-top:14px;padding-top:20px;border-top:3px solid #e0e3eb}
.footer{padding-top:20px;padding-bottom:60px;text-align:center;background-color:#f1f1f1;border-top:1px solid #c1c1c1;color:#8b8e98;font-size:12px}
.linklist a{text-decoration:none;margin-left:2px;margin-right:2px;color:#8b8e98}
.linklist a:active{color:#585858}
.copyright{padding-top:4px}
.pay_msg .msg_box,.pay_msg .msg_default_box{display:inline-block;*display:inline;*zoom:1;width:258px}
.pay_msg_t{line-height:2.2;color:#000;font-size:26px;font-weight:400}
.pay_msg_desc{padding-top:0;padding-bottom:4px;margin-top:-2px}
.pay_msg_desc strong{margin-left:.3em;margin-right:.3em;color:#f29a00;font-weight:400}
.pay_tip{padding-top:6px;padding-bottom:10px;color:#565656}
.qr_img_wrapper{display:block;position:relative;height:306px}
.qr_img_wrapper .qrcode{width:301px;height:301px}
.pay_money{padding-bottom:20px;padding-top:50px;color:#585858;font-size:60px;font-weight:400;border-bottom:1px solid #d0d8e4;line-height:68px}
.pay_money span{margin-right:-10px}
.pay_bill_unit{padding:18px 0 40px;background:transparent url(/static/themes/api/wxpay/public/bg_pay_bill_split1518d5.png) no-repeat center bottom}
.pay_bill_unit.no_extra{background:none}
.pay_bill_unit dl{border-bottom:1px solid #e5e7ea}
.pay_bill_unit dt{color:#4a4a4a;font-size:20px;line-height:24px}
.pay_bill_unit dd{padding-top:4px;padding-bottom:16px;color:#666}
.pay_bill_info{padding-top:10px;line-height:26px}
.pay_bill_info p{overflow:hidden;*zoom:1}
.pay_bill_info label{float:left;font-size:14px;color:#8e8e8e}
.pay_bill_info .pay_bill_value{float:right}
.pay_add_on.arrow{display:inline-block;width:0;height:0;margin-right:10px;border-width:12px 0 12px 12px;border-color:#c4c7cf;border-style:dashed dashed dashed solid}
.icon30_add_on{display:inline-block;width:30px;height:30px;vertical-align:middle;background:transparent url(/static/themes/api/wxpay/public/icon30_add_on1518d5.png) no-repeat 0 0}
.help .icon30_add_on{background-position:0 0}
.icon60_qr{display:inline-block;width:60px;height:60px;vertical-align:middle;background:transparent url(/static/themes/api/wxpay/public/icon60_qr15b813.png) no-repeat 0 0}
.qr_default .icon60_qr{background-position:0 -60px}
.qr_succ .icon60_qr{background-position:0 0}
.icon60_pay{display:inline-block;width:60px;height:60px;vertical-align:middle;background:transparent url(/static/themes/api/wxpay/public/icon60_pay15b813.png) no-repeat 0 0}
.shopping .icon60_pay{background-position:0 0}
.icon110_msg{display:inline-block;width:110px;height:110px;vertical-align:middle;background:transparent url(/static/themes/api/wxpay/public/icon110_msg15b813.png) no-repeat 0 0}
.pay_error .icon110_msg{background-position:-110px 0}
.pay_succ .icon110_msg{background-position:0 0}
.qr_default #qr_normal,.qr_succ #qr_normal{display:block}
.qr_default .msg_box{display:none}
.qr_succ .msg_default_box{display:none}
.pay_error #pay_error{display:block}
.pay_succ #pay_succ{display:block}
.guide{display:none;position:absolute;top:0;margin-left:-101px}
</style>
</head>
<body>
    <div class="header pngFix">
    	<h1 class="pay_logo">
            <a class="index_access" href="/">
            	<img title="微信支付" alt="微信支付标志" src="/static/themes/api/wxpay/public/logo_pay.png" class="pngFix">
            </a>
        </h1>
    </div>
    <div class="content">
        <div class="wrapper mail_box">
            <div class="mail_box_inner pngFix">
                <div class="area primary">
                    <div id="payMsg" class="pay_msg qr_default">
                        <div class="area_hd">
                        	<h2>支付结果</h2>
                        </div>
                        <div id="pay_succ" class="area_bd">
                        	<i class="icon110_msg pngFix"></i>
                        	<h3 class="pay_msg_t">
                            	购买成功
                            </h3>
                            <div class="vh" id="payMsgDetail">
                            	<p class="pay_msg_desc">
                                	<span id="userName">
                                    	&lt;用户&gt;
                                    </span>
                                    	，你使用
                                    <strong id="bankCard">
                                    	&lt;银行卡&gt;
                                    </strong>
                                    银行卡完成了本次交易。
                                </p>
                            	<p class="pay_tip">
                                    <span id="redirectTimer">
                                    	5
                                    </span>
                                    秒后返回商户网页，你也可以点击
                                    <a id="resultLink" target="_blank" href="javascript:;">
                                    	这里
                                    </a>
                                    立即返回。
                                </p>
                            </div>
                        </div>

                        <div id="pay_error" class="area_bd">
                        	<i class="icon110_msg pngFix"></i>
                        	<h3 class="pay_msg_t">
                            	无法支付
                            </h3>
                            <p class="pay_msg_desc">
                                商品金额大于银行卡快捷支付限额
                            </p>
                        </div>

                        <div id="qr_normal" class="area_bd">
                        	<span class="qr_img_wrapper" id="qr_box">
                            	<img id="QRcode" alt="二维码" class="qrcode" src="/api/wxpay/example/qrcode.php?data=<?php echo urlencode($url2);?>" />
                                <img id="guide" alt="" src="/static/themes/api/wxpay/public/webpay_guide.png" class="guide pngFix" style="left: 50%; opacity: 0; display: none; margin-left: -101px;">
                            </span>
                            <div class="msg_default_box">
                            	<i class="icon60_qr pngFix"></i>
                            	<p>请使用微信扫描<br>二维码以完成支付</p>
                            </div>
                            <div class="msg_box">
                                <i class="icon60_qr pngFix"></i>
                                <p><strong>扫描成功</strong>请在手机确认支付</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="area second">
                    <div class="pay_bill shopping">
                        <div class="area_hd">
                            <h2>支付清单</h2>
                            <span class="icon_wrapper"><i class="icon60_pay pngFix"></i></span>
                        </div>
                        <div class="area_bd">
                        	<h3 class="pay_money"> <?=price::rate($total_fee)?></h3>
                            <div class="pay_bill_unit no_extra">
                                <dl>
                                	<dt><?=$subject?></dt>
                                	<dd><?=$body?></dd>
                                </dl>
                                <div class="pay_bill_info">
                                    <p><label>交易单号</label><span class="pay_bill_value"><?=$out_trade_no?></span></p>
									<p><label>创建时间</label><span class="pay_bill_value"><?=date("Y-m-d", $order_start_time)?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="aside">
                    <div class="pay_widget help">
                        <div class="pay_widget_hd">
                        	<i class="icon30_add_on pngFix"></i>
                        </div>
                        <div class="pay_widget_bd">
                            <strong class="widget_name">客服</strong>
                            <p class="widget_desc">0755 - 86013860</p>
                        </div>
                    </div>
                </div> -->
            </div>
            <b class="mail_box_corner left pngFix"></b>
            <b class="mail_box_corner right pngFix"></b>
        </div>
    </div>
    <!--[if IE 6]>
    <script type="text/javascript" src="/zh_CN/htmledition/js/DD_belatedPNG1c27aa.js"></script>
    <script type="text/javascript"> window.onload = function() { DD_belatedPNG.fix(".pngFix"); } </script>
    <![endif]-->
</body>
</html>


<script src="/static/jext/jq.js"></script>
<script>
function init() {
	$(".pay_bill .pay_bill_unit:last-child").addClass("no_extra");

	var _nTimer = 0,
		_oGuide$ = $("#guide"),
		_oGuideTrigger$ = $("#QRcode");

	function _back() {
		_nTimer = setTimeout(function() {
			_oGuide$.stop().animate({marginLeft:"-101px",opacity:0}, "400", "swing",function(){
				_oGuide$.hide();
			});
		}, 100);
	}

	/*guide*/
	_oGuide$.css({"left":"50%", "opacity":0});
	_oGuideTrigger$.mouseover(function(){
		clearTimeout(_nTimer);
		_oGuide$.css("display", "block").stop().animate({marginLeft:"+147px", opacity:1}, 900, "swing", function() {
			_oGuide$.animate({marginLeft:"+134px"}, 300);
		});
	}).mouseout(_back);

	_oGuide$.mouseover(function(){
		clearTimeout(_nTimer);
	}).mouseout(_back);
}

init();
setInterval(wxPay,1000);
function wxPay(){
	$.ajax({
		url : '/api/pay/wxpay/check',
		data:{OrderNumber:"<?=$out_trade_no?>"},
		type : "POST",
		dataType : 'json',
		success : function (data){
			if(data.ret==1){
                $('#pay_succ').show();
                $('.area.second, #qr_normal').hide();
                setTimeout(function () {
                    location.href='/member/orders.html';
                }, 3000);
			}
		}
	})
}
</script>
