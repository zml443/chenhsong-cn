<?php
function_exists('c') || exit;

if (!p('site.page_data.edit')) {
	str::msg('权限不足');
}

$page_id = (int)$_POST['page_id'];
$id = (int)$_POST['id'];
db::delete('wb_site_page_module_copy', "Id='{$id}' and IsLock=0");
str::msg('', 1);
?>