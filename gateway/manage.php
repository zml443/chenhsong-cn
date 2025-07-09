<?php
include '../inc/global.php';

extract($_GET['ApiName']!=''?$_GET:$_POST, EXTR_PREFIX_ALL, 'p');
$p_ApiName = str_replace('..', '', $p_ApiName);
($p_ApiName=='') && str::msg('非法的请求！');



if ($p_ApiName=='login' || $p_ApiName=='ai') {
	// 
} else {
	$OAuth2 = c('authorization');
	if (manage('Id')){
		// 
	} else if ($OAuth2) {
		$token = jwt::verifyToken($OAuth2, c('manage.apikey')?:c('LYYApiKey'));
		if ($token) {
			$userinfo = db::get_one('wb_manage', "UserName='{$token['sub']}'");
			manage('', $userinfo);
		}
	}
	manage('Id') || exit(str::json(array(
		'ret' => 0,
		'msg' => '登录失败！'
	)));
}


if (is_file(c('root').'gateway/manage/'.$p_ApiName.'.php')) {
	include c('root').'gateway/manage/'.$p_ApiName.'.php';
	exit;
}

str::msg('what are you want to do?');