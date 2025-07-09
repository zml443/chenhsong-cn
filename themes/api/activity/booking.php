<?php
function_exists('c')||exit;


$DA = array(
	'Name' => $_POST['Name'],
	'AddTime' => c('time'),
	'Tel' => $_POST['Tel'],
	'Company' => $_POST['Company'],
	'Job' => $_POST['Job'],
	'Message' => $_POST['Message'],
	'wb_activity_id' => $_POST['wb_activity_id'],
);

if (!check::phone($DA['Tel'])) {
	exit(str::json(array(
		'ret' => 0,
		'msg' => '电话号码格式错误',
	)));
}

if (!$DA['Name']) {
	exit(str::json(array(
		'ret' => 0,
		'msg' => '名称不能为空',
	)));
}


db::insert('wb_activity_booking', $DA);

exit(str::json(array(
	'ret' => 1,
	'msg' => '预约成功，请按时到场参加活动，谢谢！',
)));