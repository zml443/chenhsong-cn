<?php
$data = array(
	'Name' => $_POST['Name'],
	'Fax' => $_POST['Fax'],
	// 'Mobile' => $_POST['Mobile'],
	// 'Email' => $_POST['Email'],
	'Country' => $_POST['Country'],
	'Province' => $_POST['Province'],
	'City' => $_POST['City'],
	'Town' => $_POST['Town'],
	'UserAddress' => $_POST['UserAddress'],
	'Postcode' => $_POST['Postcode'],
);


$wb_member_id = member('Id');

// 通过验证
db::update('wb_member', "Id='{$wb_member_id}'", $data);

// 记录登录信息，第一个记录就是会员的注册ip
log::member('profile', '个人信息修改');

str::msg('update profile', 1);