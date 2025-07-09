<?php

$wb_member_id = member('Id');

if (!$wb_member_id) {
	str::msg('请登录');
}

$member = db::get_one('wb_member', "Id='{$wb_member_id}'");

$save_dir = c('u_file_dir') . strtolower(c('website.name')) . date('/Y-m/d/');
$path = file::base64($_POST['face_base64'], $save_dir);
if (is_file(c('root').$path)) {
	file::unlink($member['Face']);
	db::update('wb_member', "Id='{$wb_member_id}'", array(
		'Face' => $path
	));
	str::msg($path, 1);
} else {
	str::msg('上传失败');
}
?>