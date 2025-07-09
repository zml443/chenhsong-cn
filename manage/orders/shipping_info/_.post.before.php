<?php

if ($_POST['wb_orders_id']) {
	$orders_row = db::result("select * from wb_orders where Id='{$_POST['wb_orders_id']}'");
	if (!$orders_row) {
		str::msg('订单不存在');
	}
	if ($orders_row['Status']!=1 && $orders_row['Status']!=2) {
		str::msg('订单未付款，无法修改发货信息');
	}
} else {
	str::msg('订单不存在');
}
