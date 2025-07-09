<?php
function_exists('c')||exit;

$UId = $_POST['UId'] ? $_POST['UId'] : '0,';
$Name = $_POST['Name'];
if (!$Name) {
	exit(str::json(array(
		'ret' => 0,
		'msg' => '文件夹名字不能为空',
	)));
} else if (db::get_row_count('jext_files', "GroupId='manage' and ExtId='".manage('Id')."' and UId='$UId' and Name='$Name' and Type=0")) {
	exit(str::json(array(
		'ret' => 0,
		'msg' => '文件夹名字重复',
	)));
}
$Id = db::insert('jext_files', array(
	'UId'		=>	$UId,
	'Dept'		=>	substr_count($UId, ','),
	'ExtId'		=>	manage('Id'),
	'ExtId2'	=>	0,
	'GroupId'	=>	'manage',
	'Name'		=>	$Name,
	'Path'		=>	'',
	'AddTime'	=>	c('time'),
	'Type'		=>	0,
	'IsTmp'		=>	0
));
log::manage('jext_files', '添加文件夹');
exit(str::json(array(
	'ret' => 1,
	'msg' => language('{/notes.ok/}'),
)));