<?php
$id_array = explode(',', $_POST['Id']);
$id_where = array();
$uid_where = '';
foreach ($id_array as $v) {
	$v = (int)$v;
	if ($v) {
		$id_where[] = $v;
		$uid_where .= " or find_in_set('$v', UId)";
	}
}
if ($uid_where) {
	$uid_where = trim($uid_where, ' or ');
	$has_categoryd = db::get_all('wb_products_category', $uid_where, "Id");
	foreach ($has_categoryd as $v) {
		$id_where[] = $v['Id'];
	}
}
$id_where = implode(',', array_filter($id_where));
if ($id_where) {
	$count = db::get_row_count('wb_products', "wb_products_category_id in($id_where)");
} else {
	$count = 0;
}
if ($count) {
	str::msg('有 '.$count.' 个产品选择了此分类', 1);
} else {
	str::msg('');
}
?>