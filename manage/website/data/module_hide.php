<?php
isset($c) || exit;

if (!p('site.page_data.edit')) {
	str::msg('权限不足');
}

$page_id = (int)$_POST['page_id'];
$id = (int)$_POST['id'];
db::update('wb_site_page_module_copy', "Id='{$id}' and Parts='content'", array(
	'IsHide' => (int)$_POST['IsHide']
));
str::msg('', 1);
?>