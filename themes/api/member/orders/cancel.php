<?php
$wb_orders_id = (int)$_POST['wb_orders_id'];
$wb_member_id = (int)member('Id');

$where = "Id='{$wb_orders_id}' and wb_member_id='{$wb_member_id}'";

$orders = db::get_one('wb_orders', $where);
if (!$orders) {
	str::msg('订单错误');
}
if (!in_array($orders['Status'], array(0))) {
	str::msg('无法取消订单');
}
db::update('wb_orders', $where, array(
	// 'Status' => 6,
	'CancelStatus' => 1,
	'CancelType' => $_POST['type'],
	'CancelText' => $_POST['message'],
	'CancelTime' => c('time'),
));
str::msg('提交成功，订单已取消！', 1);
?>