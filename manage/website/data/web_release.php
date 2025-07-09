<?php
function_exists('c') || exit;

if (!p('site.page_data.edit')) {
	exit(str::json(array(
		'ret' => 0,
		'msg' => '权限不足',
	)));
}

$Id = (int)$_POST['Id'];


$allpage = db::query("select * from wb_site_page_copy where wb_site_web_id='{$Id}'");
if (!$allpage->num_rows) {
	exit(str::json(array(
		'ret' => 0,
		'msg' => '数据错误',
	)));
}

db::query("truncate table wb_site_page");
db::query("truncate table wb_site_page_module");
db::query("truncate table wb_site_page_module_children");

$page_bat = array();
while ($v=db::result($allpage)) {
	unset($v['wb_site_web_id']);
	$page_bat[] = $v;
}
db::insert_bat("wb_site_page", str::code($page_bat, 'addslashes'));


$allmodule = db::query("select * from wb_site_page_module_copy where wb_site_web_id='{$Id}'");
$module_bat = array();
while ($v=db::result($allmodule)) {
	unset($v['wb_site_web_id']);
	$module_bat[] = $v;
}
db::insert_bat("wb_site_page_module", str::code($module_bat, 'addslashes'));


$allchildren = db::query("select * from wb_site_page_module_children_copy where wb_site_web_id='{$Id}'");
$children_bat = array();
while ($v=db::result($allchildren)) {
	unset($v['wb_site_web_id']);
	$children_bat[] = $v;
}
db::insert_bat("wb_site_page_module_children", str::code($children_bat, 'addslashes'));



// 记录修改时间
g('website.update_time', c('time'));

db::update("wb_site_web", "1", array(
	'Release' => 0,
));
db::update("wb_site_web", "Id='$Id'", array(
	'Release' => 1,
	'EditTime' => c('time'),
));
exit(str::json(array(
	'ret' => 1,
	'msg' => '已发布',
)));