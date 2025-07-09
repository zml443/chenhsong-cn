<?php

function_exists('c')||exit();

$wb_site_page_id = (int)$_POST['wb_site_page_id'];
$current_module_id = (int)$_POST['current_module_id'];
$current_parts_name = $_POST['current_parts_name'];

$page_row = db::result("select * from wb_site_page_copy where Id='$wb_site_page_id'");
if (!$page_row) {
	exit(str::json(array(
		'msg' => '页面不存在',
		'ret' => 0,
	)));
}

$module_id = (int)$_POST['module_id'];
$module_row = lydb::result("select * from ss_module where Id='$module_id'");
if (!$module_row) {
	exit(str::json(array(
		'msg' => '模板不存在',
		'ret' => 0,
	)));
}

// 修改
if ($current_module_id) {
	// 
	$current_module_row = db::result("select * from wb_site_page_module_copy where Id='{$current_module_id}'");
	if ($module_row['Parts']!=$current_module_row['Parts']) {
		exit(str::json(array(
			'msg' => '类型不对',
			'ret' => 0,
		)));
	}
	db::update('wb_site_page_module_copy', "Id='{$current_module_id}'", array(
		'Name' => $module_row['Name'],
		'Number' => $module_row['Number'],
	));
	exit(str::json(array(
		'msg' => '模板以更换',
		'ret' => 1,
	)));
	// 
} else {
	// 
	if ($module_row['Parts']=='header' || $module_row['Parts']=='footer') {
		exit(str::json(array(
			'msg' => '此模板不可添加',
			'ret' => 0,
		)));
	}
	$module_row = str::code($module_row, 'addslashes');
	db::insert('wb_site_page_module_copy', array(
		'Name' => $module_row['Name'],
		'Number' => $module_row['Number'],
		'Parts' => 'content',
		'wb_site_web_id' => $page_row['wb_site_web_id'],
		'wb_site_page_id' => $wb_site_page_id,
	));
	exit(str::json(array(
		'msg' => '已添加',
		'ret' => 1,
	)));
	// 
}
