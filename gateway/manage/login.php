<?php
function_exists('c') || exit;


extract($_POST, EXTR_PREFIX_ALL, 'p');
// 验证码
/*if (strtolower($p_Excode)!=strtolower($_SESSION['VCode']['manage']) || !$_SESSION['VCode']['manage']) {
	str::msg('验证码错误', 0);
}
unset($_SESSION['VCode']['manage']);*/
$userinfo = db::get_one('wb_manage', "UserName='{$p_UserName}'");
// 账号被锁定
if ($userinfo['IsLoginLock']) {
	exit(str::json(array(
		'ret' => 3002,
		'msg' => '账号被锁定'
	)));
} else if ($userinfo['Password'] == str::password($p_Password)) {
	$userinfo['LastLoginTime'] = c('time');
	$userinfo['LastLoginIp'] = ip::get();
	manage('', $userinfo);
	db::update('wb_manage', "UserName='{$p_UserName}'", array(
			'LastLoginTime'	=>	$userinfo['LastLoginTime'],
			'LastLoginIp'	=>	$userinfo['LastLoginIp'],
			'data_number_login' => $userinfo['data_number_login']+1
		)
	);
	log::manage('wb_manage', "管理员登录【{$p_UserName}】");
	$token = jwt::getToken(array(
		'iss'=>'jwt_admin', //该JWT的签发者
		'iat'=>c('time'), //签发时间
		'exp'=>c('time')+72000, //过期时间
		'sub'=>manage('Id'), //面向的用户
		'jti'=>md5(uniqid('JWT').c('time')) //该Token唯一标识
	), c('manage.apikey')?:c('LYYApiKey'));
	exit(str::json(array(
		'ret' => 1,
		'authorization' => $token
	)));
} else {
	exit(str::json(array(
		'ret' => 0,
		'msg' => '账号密码错误'
	)));
}