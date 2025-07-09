<?php
isset($c) || exit();
$wb_member_id = member('Id');
if (!$wb_member_id) {
	str::msg('请登录');
}

$wb_products_id = explode(',', $_POST['wb_products_id']);
foreach ($wb_products_id as $v) {
	$id = (int)$v;
	if ($id) {
		$res = db::delete_log_id('collection', 'wb_products', $id);
	}
}

exit(str::json(array(
	'msg' => '已取消收藏',
	'ret' => 102
)));
?>