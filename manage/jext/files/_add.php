<?php
function_exists('c') || exit;

// 当前文件夹
$current_row = db::result("select * from jext_files where Id='{$_POST['id']}'");

// 整理查询条件
$UId = '0,';
if ($current_row) {
	$UId = $current_row['UId'].$current_row['Id'].',';
}


if ($_FILES['file']) {
	$suffix = strrchr($_FILES['file']['name'], '.');
	while (1) {
		$save_path = c('u_file_dir').c('website.name').date('/Y-m/d/His').rand(1000,9999).$suffix;
		if (!is_file(c('root').$save_path)) {
			break;
		}
	}
	$tmp_name = str_replace('\\\\', '\\', $_FILES['file']['tmp_name']);

	file::mkdir(dirname($save_path));
	move_uploaded_file($tmp_name, c('root').$save_path);

	if (is_file(c('root').$save_path)) {
		db::insert("jext_files", array(
			'Type' => 1,
			'GroupId' => 'manage',
			'ExtId' => manage('Id'),
			'UId' => $UId,
			'AddTime' => c('time'),
			'IsTmp' => 0,
			'Path' => $save_path,
		));
		exit(str::json(array(
			'path' => $save_path,
			'ret' => 1,
		)));
	}
}
exit(str::json(array(
	'msg' => '上传失败',
	'ret' => 0,
)));
?>