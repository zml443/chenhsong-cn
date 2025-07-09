<?php

function_exists('c')||exit();

if (!p('app.app_store.edit')) {
	exit(str::json(array(
		'msg' => language('{/notes.no_permit/}'),
		'ret' => 5001
	)));
}

// 获取
$key = $_POST['key'];
$val = (int)$_POST['val'];

// 选择，能使用的app
$chioce = a();
$use = a('__use__');

// 判断开通
if ($use[$key]) {
	$chioce[$key] = $val;
	g('app_store', $chioce);
	if ($val) log::manage('app_store', '开启功能：'.language('{/menu.'.$use[$key]['key'].'.module_name/}'));
	else log::manage('app_store', '关闭功能：'.language('{/menu.'.$use[$key]['key'].'.module_name/}'));
	exit(str::json(array(
		'msg' => language('{/notes.ok/}'),
		'ret' => 1,
	)));
} else {
	exit(str::json(array(
		'msg' => language('{/notes.fail/}'),
		'ret' => 0,
		'u' => $use
	)));
}