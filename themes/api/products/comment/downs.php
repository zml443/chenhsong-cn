<?php
isset($c) || exit();
$wb_member_id = member('Id');
if (!$wb_member_id) {
	str::msg('请登录');
}
$wb_products_comment_id = (int)$_POST['wb_products_comment_id'];
$res = db::log_id('downs', 'wb_products_comment', $wb_products_comment_id);
if ($res['is_insert']) {
	db::delete_log_id('ups', 'wb_products_comment', $wb_products_comment_id);
	$res['data_number_ups'] = (int)db::result("select sum(Number) as a from wb_products_comment_data_number_ups where `wb_products_comment_id`='$wb_products_comment_id'", 'a');
	$res['msg'] = '已给差评';
	$res['ret'] = 101;
	exit(str::json($res));
} else {
	$res['msg'] = '取消差评';
	$res['data_number_ups'] = (int)db::result("select sum(Number) as a from wb_products_comment_data_number_ups where `wb_products_comment_id`='$wb_products_comment_id'", 'a');
	$res['ret'] = 102;
	exit(str::json($res));
}
?>