<?php
isset($c) || exit();

if (!member('Id')) {
	str::msg('请登录');
}

$wb_member_id = (int)member('Id');

$data = array(
	// 'Name' => $_POST[$k.'Name'],
	'wb_member_id' => $wb_member_id,
	'FirstName' => $_POST['FirstName'],
	'LastName' => $_POST['LastName'],
	'Address' => $_POST['Address'],
	'Country' => $_POST['Country'],
	'Province' => $_POST['Province'],
	'City' => $_POST['City'],
	'Town' => $_POST['Town'],
	'Postcode' => $_POST['Postcode'],
	'Phone' => $_POST['Phone'],
	'Email' => $_POST['Email'],
	'Type' => $_POST['Type'],
);

$billing_count = db::get_row_count("wb_member_address", "wb_member_id='{$wb_member_id}' and Type='billing'");

if ($data['Type']=='billing' && (int)$_POST['Id']==0 && $billing_count) {
	str::msg('账单运送地址只能编写一个');
}

if (!check::mobile($data['Phone'])) {
	str::msg('电话号码不正确!');
}

if (!$data['Address'] || !$data['Country'] || !$data['FirstName'] || !$data['LastName'] || !$data['Type']) {
	str::msg('请填写完整!');
}

$shipping_count = db::get_row_count("wb_member_address", "wb_member_id='{$wb_member_id}' and Type='shipping'");
if ($shipping_count==0) {
	$data['IsDefault'] = 1;
}

if ($_POST['Id']) {
	$id = (int)$_POST['Id'];
	db::update('wb_member_address', "Id='$id' and wb_member_id='$wb_member_id'", $data);
} else {
	db::insert('wb_member_address', $data);
}

if ($billing_count==0) {
	$data['Type'] = 'billing';
	db::insert('wb_member_address', $data);
}

str::msg('地址已保存!', 1);
?>