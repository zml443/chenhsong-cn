<?php
isset($c) || exit();
$wb_orders_id = (int)$_POST['wb_orders_id'];
$wb_member_id = (int)member('Id');

$where = "Id='{$wb_orders_id}' and wb_member_id='{$wb_member_id}'";

$orders = db::get_one('wb_orders', $where);
if (!$orders) {
	str::msg('订单错误');
}
if ($orders['Status']==3) {
	str::msg('订单已发货，暂时无法进行退款申请');
}
if ($orders['Status']!=1) {
	str::msg('无法进行退款申请');
}

$data = array(
	'RefundType' => $_POST['type'],
	'RefundStatus' => 1,
	'RefundText' => $_POST['message'],
	'RefundTime' => c('time')
);
if (!$data['RefundType']) {
	str::msg('請填寫退款原因');
}

db::update('wb_orders', $where, $data);
str::msg('退款申请成功', 1);
?>