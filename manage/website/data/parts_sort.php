<?php
function_exists('c') || exit;


$_GET['_inline_view_'] = 1;

$id = (int)$_POST['current_module_id'];
$one = db::get_one('wb_site_page_module_copy', "Id='{$id}'");
if (!$one) {
	str::msg('模板不存在', 0);
}
$page_row = db::get_one('wb_site_page_copy', "Id='{$one['wb_site_page_id']}'");

$parts = (array)$_POST['parts'];
foreach ($parts as $k => $v) {
	$bat = array();
	foreach ($v as $k1 => $v1) {
		$bat[$v1['id']] = array(
			'MyOrder' => $k1,
			'Id' => $v1['id']
		);
	}
	if ($bat && $k=='content') db::update_bat('wb_site_page_module_copy', 'Id', $bat);
}


$_GET['m'] = $page_row['Type']?:'customized';
if ($_GET['m']=='customized') {
	$_GET['page'] = $page_row['wb_site_page_data_id'];
}

// 按需加载模板
echo saas::html(array(
	'page_id' => $one['wb_site_page_id'],
	'module_id' => $one['Id'],
	'inline' => true,
	'pure' => true,
));