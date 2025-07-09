<?php

$wb_member_id = (int)member('Id');
$session_id = c('session_id');
if ($wb_member_id) {
	$where = "wb_member_id='".$wb_member_id."'"; // 购物车必要条件
} else {
	$where = "session_id='".$session_id."'"; // 购物车必要条件
}

$ids = explode(',', $_POST['Id']);
$id = '0';
foreach ($ids as $v) {
	$id .= ",".(int)$v;
}

db::delete('wb_orders_cart', $where." and Id in({$id})");

str::msg('操作成功', 1);

?>