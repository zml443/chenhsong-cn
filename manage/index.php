<?php

include '../inc/global.php';

// 将管理员数据记录到session，包含了token登录
\system\manage::get();

if ($_GET['manage_token']) {
	js::location('/manage/');
}

// 调用一次权限
p_all();

// 判断有没有选择模板
if (manage('Id')>0 && c('HostType')=='saas') {
	$has_web_copy_row = db::result("select count(*) as a from wb_site_web", 'a');
	if (!$has_web_copy_row && !$_GET['ma'] && !$_GET['m']) {
		js::location('?ma=website/module');
	}
}

// 预处理
if ($_GET['mg']) {
	$_GET['ma'] = $_GET['mg'];
}
if ($_GET['ma']) {
	$a = explode('/', $_GET['ma']);
	$_GET['m'] = $a[0];
	$_GET['a'] = trim($a[1].'/'.$a[2], '/');
	$_GET['mg'] || $_GET['_ifr_'] = 1;
}
$_GET['ma'] = trim(str_replace('..', '', $_GET['m'].'/'.$_GET['a']), '/');

if (!$_GET['u'] && $_GET['ma']) {
	$_GET['u'] = c('manage.permit.U.'.$_GET['ma']);
}
$_GET['u'] && $_GET['U'] = explode(',',$_GET['u']);

if (!$_GET['_ifr_']) $_GET['_ifr_'] = $_GET['_popup_'];
if (!$_GET['_ifr_']) $_GET['_ifr_'] = $_GET['_popup_top_'];
if (!$_GET['_ifr_']) $_GET['_ifr_'] = $_GET['_popup_left_'];
if (!$_GET['_ifr_']) $_GET['_ifr_'] = $_GET['_popup_right_'];
if (!$_GET['_ifr_']) $_GET['_ifr_'] = $_GET['_popup_bottom_'];
if (!$_GET['_ifr_']) $_GET['_ifr_'] = $_GET['_alert_side_'];
if (!$_GET['_ifr_']) $_GET['_ifr_'] = $_GET['_alert_'];
if ($_GET['_popup_'] || $_GET['_popup_top_'] || $_GET['_popup_left_'] || $_GET['_popup_right_'] || $_GET['_popup_bottom_'] || $_GET['_alert_side_'] || $_GET['_alert_']) $_GET['_is_popup_'] = 1;


// 更新管理员的 session 数据
if (manage('Id')>0) {
	manage('', db::get_one('wb_manage', "Id='".manage('Id')."'"));
}

// 网站状态
use system\web as ww;
ww::jump302();


// 入口
//////////////////////////////////////////////////////////////////////////////////////
if (!is_file("{$_GET['ma']}.conf.php") && !is_file("{$_GET['ma']}.php")) {
	$_GET['m'] = 'account';
	$_GET['a'] = 'index';
	$_GET['ma'] = "account/index";
}
if ($_GET['ma']=='account/index' && in_array(c('HostTag'), array('web','weben'))) {
	$_GET['m'] = 'account';
	$_GET['a'] = 'index2';
	$_GET['ma'] = "account/index2";
}

ob_start();
if (!\system\manage::islogin()) {	//未登录
	include 'login.php';
} else if($_GET['_ifr_']) {
	if (is_file($_GET['ma'].".conf.php")) {
		include c('root').'manage/__/dbs/get.class.php';
	} else if (is_file($_GET['ma'].".php")) {
		include $_GET['ma'].".php";
	}
} else {
	include 'main.php';
}
$html = ob_get_contents();
ob_end_clean();

if ($_POST['ly_manage_sign'] && (!$_GET['d'] || in_array($_GET['d'], array('list', 'edit', 'add')))) {
	exit(str::json(array(
		'ret' => 1,
		'html' => $html,
	)));
} else {
	echo $html;	
}

db::close();