<?php


/*
 * 大小 1MB
 * 
**/
$size = 1024 * 1024;


/*
 * 权限
 * 
**/
$jurisdiction = !preg_match('/\.(php*?|exe|jsp)$/i', $suffix) && member('Id');



/*
 * 回调函数
 * 
**/
function callback($file = '') {
	if (!$file) return;
	$row = db::get_one('wb_member',"Id='".member('Id')."'");
	file::unlink($row['Face']);
	db::update('wb_member',"Id='".member('Id')."'",array(
		"Face"	=>	$file['Path'],
	));
	str::msg(array(
		'Path'	=>	$file['Path'],
	), 1);
}