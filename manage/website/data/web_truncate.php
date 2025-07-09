<?php

function_exists('c') || exit;

if (manage('Level')!=1) {
	exit(str::json(array(
		'ret' => 0,
		'msg' => '权限不足',
	)));
}

db::query("TRUNCATE `wb_site_page_copy`");
db::query("TRUNCATE `wb_site_page_module_children_copy`");
db::query("TRUNCATE `wb_site_page_module_copy`");
db::query("TRUNCATE `wb_site_web`");

exit(str::json(array(
	'ret' => 1,
	'msg' => '已清空',
)));