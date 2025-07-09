<?php
function_exists('c') || exit;

if (!p('site.page_data.edit')) {
	exit(str::json(array(
		'ret' => 0,
		'msg' => '权限不足',
	)));
}

$Id = (int)$_POST['Id'];

db::update("wb_site_web", "1", array(
	'Used' => 0,
));

db::update("wb_site_web", "Id='$Id'", array(
	'Used' => 1,
));

exit(str::json(array(
	'ret' => 1,
	'msg' => '已修改',
)));