<?php
function_exists('c') || exit;

$_GET['_inline_view_'] = 1;

if (!p('site.page_data.edit')) {
	str::msg('权限不足');
}

$id = (int)$_POST['id'];
$page_id = (int)$_POST['page_id'];
$one = db::get_one('wb_site_page_module_copy', "Id='{$id}'");
if (!$one) {
	str::msg('模板不存在', 0);
}
// $page = ['wb_site_page_id']
$page_row = db::get_one('wb_site_page_copy', "Id='{$one['wb_site_page_id']}'");

$data = $_POST['data'];
if (!is_array($data)) {
	str::msg('数据错误');
}

saas_db::fill_page_module_feild();

foreach ($data as $k => $v) {
	if ($k!='variable') {
		unset($data[$k]);
	}
}
$data = str::code($data, 'stripslashes');
$data_ln = ln('Data');
db::update("wb_site_page_module_copy", "Id='{$one['Id']}'", array(
	$data_ln => addslashes(str::json($data))
));

db::update("wb_site_web", "Id='{$one['wb_site_web_id']}'", array(
	'EditTime' => c('time'),
));

$_SESSION['website_preview_model'] = 1;

$_GET['m'] = $page_row['Type']?:'customized';
if ($_GET['m']=='customized') {
	$_GET['page'] = $page_row['wb_site_page_data_id'];
}

// 按需加载模板
exit(saas::html(array(
	// 'id' => $page['Id'],
	'page_id' => $page_id,
	'module_id' => $one['Id'],
	'inline' => true,
	'pure' => true,
)));
?>