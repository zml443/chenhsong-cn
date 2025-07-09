<?php
// https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/res_list&verify=1&id=open1419316505&token=&lang=zh_CN
// 微信开发文档
isset($c)||exit;

include dirname(__FILE__).'/config.php';

$state = rand(1000, 9999);

if (server::mobile()) {
	js::location("https://open.weixin.qq.com/connect/oauth2/authorize?appid=".WXLOGIN_APPID."&redirect_uri=".WXPAY_CALLBACK."&response_type=code&scope=snsapi_userinfo&state=".$state."#wechat_redirect");
}
else {
	js::location("https://open.weixin.qq.com/connect/qrconnect?appid=".WXLOGIN_APPID."&redirect_uri=".WXPAY_CALLBACK."&response_type=code&scope=snsapi_login&state=".$state."#wechat_redirect");
}