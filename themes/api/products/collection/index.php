<?php
isset($c) || exit();
$wb_member_id = member('Id');
if (!$wb_member_id) {
	str::msg('请登录');
}
// $wb_products_id = (int)$_POST['wb_products_id'];
$res = db::log_id('collection', 'wb_products', (int)$_POST['wb_products_id']);
if ($res['is_insert']) {
	$res['msg'] = '已成功收藏';
	$res['ret'] = 101;
	exit(str::json($res));
} else {
	$res['msg'] = '已取消收藏';
	$res['ret'] = 102;
	exit(str::json($res));
}
?>