<?php
// 防止恶意进入
function_exists('c')||exit;
// 
if ($_POST['Id']) {
	$orders_row = db::result("select * from wb_orders where Id='{$_POST['Id']}'");
	if (!$orders_row) {
		str::msg('订单不存在');
	}
	if ($orders_row['Status']!=0) {
		str::msg('当前状态无法修改');
	}
} else {
	str::msg('订单不存在');
}

db::update("wb_orders","Id='{$orders_row['Id']}'", array(
	'Status' => 2,
));

str::msg('已修改', 1);