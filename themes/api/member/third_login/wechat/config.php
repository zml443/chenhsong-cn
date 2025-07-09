<?php
// 微信浏览器打开
if (strstr($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
	// 应用Id(AppId)(公众号)
	define('WXLOGIN_APPID', g('third_login.wechat.publick_appid'));
	// 密钥Id(SecretId)(公众号)
	define('WXLOGIN_SECRETID', g('third_login.wechat.publick_secretid'));
}
// 普通浏览器打开
else {
	define('WXLOGIN_APPID', g('third_login.wechat.appid'));
	define('WXLOGIN_SECRETID', g('third_login.wechat.secretid'));
}
define('WXPAY_CALLBACK', server::domain(1).'/api/pay/wechat/calback');
?>