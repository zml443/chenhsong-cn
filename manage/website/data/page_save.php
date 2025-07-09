<?php
function_exists('c') || exit;

if (!p('site.page_data.edit')) {
	str::msg('权限不足');
}

$id = (int)$_POST['id'];
$one = db::get_one('wb_site_page_copy', "Id='{$id}'");
if (!$one) {
	str::msg('模板不存在', 0);
}

$data = $_POST['data'];
if (!is_array($data)) {
	str::msg('数据错误');
}

$insert_data = array();
$data['header_opacity'] && $insert_data['HeaderOpacity'] = $data['header_opacity'];
isset($data['is_hidden']) && $insert_data['IsHidden'] = (int)$data['is_hidden'];

if (!$insert_data) {
	str::msg('数据错误');
}

db::update("wb_site_page_copy", "Id='{$one['Id']}'", $insert_data);

db::update("wb_site_web", "Id='{$one['wb_site_web_id']}'", array(
	'EditTime' => c('time'),
));

$_SESSION['website_preview_model'] = 1;

// 按需加载模板
exit(str::json(array(
	'msg' => '已修改',
	'ret' => 1,
)));
?>