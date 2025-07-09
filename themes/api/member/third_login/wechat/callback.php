<?php
// https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/res_list&verify=1&id=open1419316505&token=&lang=zh_CN
// 微信开发文档
isset($c)||exit;

//扫码成功后验证
$access_token=str::json(curl::init("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".WXLOGIN_APPID."&secret=".WXLOGIN_SECRETID."&code={$_GET['code']}&grant_type=authorization_code"), 1);

$userinfo=str::json(curl::init("https://api.weixin.qq.com/sns/userinfo?access_token={$access_token['access_token']}&openid={$access_token['openid']}"), 1);

if(!isset($userinfo['openid'])||!$userinfo['openid']){
	echo '登录失败，请联系网站管理员！';
	exit;
}

// 优先 判断unionid
if ($userinfo['unionid']) {
	$where = "wechat_unionid='{$userinfo['unionid']}'";
}
else {
	$where = "wechat_openid='{$userinfo['openid']}'";
}
$member = db::get_one('wb_member', $where);
if ($member) {
	member('', $member);
	log::member('wechat_login', '微信登录');
	js::location('/member/','','.top');
}
else {
	$D = array(
		'wechat_unionid'=> $userinfo['unionid'],
		'wechat_openid'	=> $userinfo['openid'],
		'FirstName'		=> $userinfo['nickname'],
		'Face'			=> $userinfo['headimgurl'],
		'Gender'		=> $userinfo['sex']?($userinfo['sex']=='2'?'G':'B'):'',
		'AddTime'		=> c('time')
	);
	db::insert('wb_member', $D);
	$D['Id'] = db::get_insert_id();
	member('', $D);
	log::member('wechat_login', '微信登录');
	js::location('/member/guide.html','','.top');
}