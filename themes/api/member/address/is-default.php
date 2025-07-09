<?php

isset($c) || exit();

$wb_member_id = (int)member('Id');
if (!$wb_member_id) {
	str::msg('请登录', 0);
}

$id = $_POST['Id'];
$one = db::get_one('wb_member_address', "wb_member_id='{$wb_member_id}' and Id='{$id}'");

if (!$one) {
	str::msg('数据错误');
}

db::update('wb_member_address', "Type='{$one['Type']}'", array('IsDefault'=>0));
db::update('wb_member_address', "Id='{$id}'", array('IsDefault'=>1));

str::msg('已修改', 1);

?>