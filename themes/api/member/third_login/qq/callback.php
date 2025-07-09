<?php

require_once(dirname(__FILE__)."/API/qqConnectAPI.php");
$qc = new QC();

$access_token=$qc->qq_callback();
$openid=$qc->get_openid();

$qc = new QC($access_token, $openid);

$arr=$qc->get_user_info();

// str::dump($arr);die;

$member=db::get_one('wb_member',"qq_openid='{$openid}'");

if ($member) {
	member('', $member);
	log::member('qq_login', 'QQ登录');
	js::location('/member/','','.top');
}
else {
	$D=array(
		'qq_openid'		=>	$openid,
		'FirstName'		=>	$arr['nickname'],
		'Face'			=>	$arr['figureurl_2'],
		'Gender'		=>	$arr['gender']=='男'?'B':'G',
		'AddTime'		=> c('time')
	);
	db::insert('wb_member', $D);
	$D['Id']=db::get_insert_id();
	member('', $D);
	log::member('qq_login', 'QQ登录');
	js::location('/member/guide.html','','.top');
}