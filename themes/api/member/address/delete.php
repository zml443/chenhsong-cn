<?php

isset($c) || exit();

$wb_member_id = (int)member('Id');
if (!$wb_member_id) {
	str::msg('请登录', 0);
}

$ids = explode(',', $_POST['Id']);
$id = '0';
foreach ($ids as $v) {
	$id .= ",".(int)$v;
}


$Type = $_POST['Type'];

if ($_POST['Type']=='billing') {
	$billing_count = db::get_row_count("wb_member_address", "wb_member_id='{$wb_member_id}' and Type='billing'");
	if ($billing_count>1) {
		db::delete('wb_member_address', "wb_member_id='{$wb_member_id}' and Id in({$id}) and Type='billing'");
	} else {
		str::msg('至少保留一个地址');
	}
} else {
	$shipping_count = db::get_row_count("wb_member_address", "wb_member_id='{$wb_member_id}' and Type='shipping'");
	if ($shipping_count>1) {
		db::delete('wb_member_address', "wb_member_id='{$wb_member_id}' and Id in({$id}) and Type='shipping'");
	} else {
		str::msg('至少保留一个地址');
	}
}

str::msg('已删除', 1);

?>