<?php


/*
 * 大小 1MB
 * 
**/
$size = 1024 * 1024 * 5;


/*
 * 权限
 * 
**/
$jurisdiction = !preg_match('/\.(php*?|exe|jsp|p?html|txt)$/i', $suffix);



/*
 * 回调函数
 * 
**/
function callback($file = '') {
	if (!$file) return;
	$Id = db::insert('jext_files', array(
		'Type'		=>	1,
		'GroupId'	=>	'default',
		'Ly'		=>	$_POST['Ly'],
		'CutLy'		=>	$_POST['CutLy'],
		'IsCut'		=>	(int)$_POST['IsCut'],
		'ExtId'		=>	0,
		'ExtId2'	=>	0,
		'UId'		=>	$_POST['UId'] ? $_POST['UId'] : '0,',
		'Name'		=>	$file['Name'],
		'Path'		=>	$file['Path'],
		'Width'		=>	$file['Width'],
		'Height'	=>	$file['Height'],
		'Size'		=>	$file['Size'],
		'AddTime'	=>	c('time'),
		'SessionId'	=>	c('session_id'),
		'IsTmp'		=>	1
	));
	str::msg(array(
		'Id'	=>	$Id,
		'Path'	=>	$file['Path'],
		'Name'	=>	$file['Name'],
	), 1);
}