<?php
include '../inc/global.php';

extract($_GET['ApiName']!=''?$_GET:$_POST, EXTR_PREFIX_ALL, 'p');
($p_ApiName=='' || $p_timestamp=='' || $p_sign=='') && str::msg('非法的请求！');
abs($p_timestamp-$c['time'])>1800 && str::msg('请求已过时，请重新发起请求！');

$ApiKey='mVRNMuftzxs0s0Ff';//$c['ApiKey'];

curl::sign($ApiKey, str::code($_POST,'stripslashes'))!=$p_sign && str::msg('签名错误！');


$p_ApiName = str_replace('..', '', $p_ApiName);

if (is_file(c('root').'gateway/index/'.$p_ApiName.'.php')) {
	include c('root').'gateway/index/'.$p_ApiName.'.php';
	exit;
}
/*if($p_ApiName=='ueeseo'){
	method_exists('api\\seo', $p_Action) && eval("api\\seo::$p_Action();");
}else{
	// other ...
}*/

str::msg('what are you want to do?');