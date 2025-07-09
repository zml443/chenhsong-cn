<?php
isset($c)||exit;

include dirname(__FILE__).'/config.php';
include dirname(__FILE__).'/saetv2.ex.class.php';


/*
https://open.weibo.com/wiki/Connect/login

	$AccessToken 可能返回的值
	{
	    "access_token": "SlAV32hkKG",
	    "remind_in": 3600,
	    "expires_in": 3600 
	}
*/

$o = new SaeTOAuthV2($CLIENT_ID, $CLIENT_SECRET);
$token = $o->getAccessToken('code', array(
	'code'			=>	$_REQUEST['code'],
	'redirect_uri'	=>	$REGISTERED_REDIRECT_URI,
));


$s = new SaeTClientV2($CLIENT_ID ,$CLIENT_SECRET, $token);
$ms  = $s->home_timeline(); // done
$uid_get = $s->get_uid();
$uid = $uid_get['uid'];
$user = $s->show_user_by_id( $uid);//根据ID获取用户等基本信息


// d($user);
$member = db::get_one('wb_member', "sina_uid='{$uid}'");
if ($member) {
	member('', $member);
	log::member('wechat_login', '微信登录');
	js::location('/member/','','.top');
}
else {
	$D = array(
		'sina_uid'		=> $uid,
		'FirstName'		=> $user['screen_name'],
		'Face'			=> $user['profile_image_url'],
		'Gender'		=> $user['gender']?($user['gender']=='f'?'G':'B'):'',
		'AddTime'		=> c('time')
	);
	db::insert('wb_member', $D);
	$D['Id'] = db::get_insert_id();
	member('', $D);
	log::member('wechat_login', '微信登录');
	js::location('/member/guide.html','','.top');
}