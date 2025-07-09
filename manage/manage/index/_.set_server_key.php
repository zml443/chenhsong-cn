<?php
function_exists('c') || exit;

if (!p('manage/index.edit') && c('manage.type')!='normal') {
	exit(str::json(array(
		'ret' => 0,
		'msg' => '权限不够',
	)));
}


$Id = (int)$_POST['Id'];
$row = db::result("select * from wb_manage where Id='$Id' limit 1");
// 生成密钥
if (!$row['ServerKey']) {
	while (1) {
		$row['ServerKey'] = str::rand(32);
		$x = db::query("select `ServerKey` from wb_manage where `ServerKey`='{$row['ServerKey']}' limit 1");
		if ($x->num_rows==0) {
			break;
		}
	}
}

// 录入
db::update('wb_manage', "Id='$Id'", array(
	'ServerKey' => $row['ServerKey'],
	'ServerKeyOpen' => (int)$_POST['ServerKeyOpen'],
));

exit(str::json(array(
	'ret' => 1,
	'msg' => '已生成密钥',
	'server_key' => $row['ServerKey']
)));