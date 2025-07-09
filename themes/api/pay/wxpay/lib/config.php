<?php

define('WXPAY_CERT_PATH', dirname(__FILE__)."/../cert/apiclient_cert.pem");
define('WXPAY_CERT_PATH', dirname(__FILE__)."/../cert/apiclient_key.pem");

// 商家号
define('WXPAY_MCHID', g('third_pay.wxpay.mchid'));
// AppKey
define('WXPAY_APPKEY', g('third_pay.wxpay.appkey'));
// 应用Id(AppId)(公众号)
define('WXPAY_APPID', g('third_pay.wxpay.appid'));
// 密钥Id(SecretId)(公众号)
define('WXPAY_SECRETID', g('third_pay.wxpay.secretid'));
// 回调链接
define('WXPAY_CALLBACK', server::domain(1).'/api/pay/wxpay/calback');
?>