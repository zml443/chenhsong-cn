<?php
include '../inc/global.php';

extract($_GET['ApiName']!=''?$_GET:$_POST, EXTR_PREFIX_ALL, 'p');
$p_ApiName = str_replace('..', '', $p_ApiName);
($p_ApiName=='') && str::msg('非法的请求！');


abs($_POST['timestamp']-c('time'))>1800 && exit(str::json(array(
	'ret' => 0,
	'msg' => '请求已过时，请重新发起请求！'
)));
$userinfo = db::get_one('wb_manage', "UserName='{$_POST['UserName']}'");
($userinfo['ServerKey'] && $userinfo['ServerKeyOpen']) || exit(str::json(array(
	'ret' => 0,
	'msg' => '密钥错误，请联系管理员',
)));
curl::sign($userinfo['ServerKey'], str::code($_POST,'stripslashes'))!=$_POST['sign'] && exit(str::json(array(
	'ret' => 0,
	'msg' => '签名错误！',
)));


if (is_file(c('root').'gateway/dbm/'.$p_ApiName.'.php')) {
	include c('root').'gateway/dbm/'.$p_ApiName.'.php';
	exit;
}

str::msg('what are you want to do?');