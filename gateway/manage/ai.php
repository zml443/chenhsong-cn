<?php
function_exists('c') || exit;


if (!manage('Id')) {
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
	} else {
		exit(str::json(array(
			'ret' => 0,
			'msg' => '账号密码错误'
		)));
	}
}

$params = array(
    'ApiName' => 'token',
    'ManageId' => manage('Id'),
    'Number' => c('Number')?:url::domain(0),
    'question' => $_POST['question'],
);

$res = curl::api('http://ai.test.lianyayun.com/gateway/ai.php', 'iw2QlKtUWmRZrJuS4kpKOt40nnPcvJag', $params);

echo $res;