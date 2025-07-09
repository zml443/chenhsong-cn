<?php


/*
 * 大小 3G
 * 
**/
// $size = 1024 * 1024 * 1024 * 3;

if (preg_match('/\.(png|jpe?g|gif|webp|svg)$/i', $suffix)) {
	$size = 1024 * 1024 * 5; //5MB
} else {
	$size = 1024 * 1024 * 50; //50MB
}



/*
 * 权限
 * 
**/
$jurisdiction = manage('Id') && !preg_match('/\.(php*?|exe|jsp)$/i', $suffix);



/*
 * 回调函数
 * 
**/
function callback($file = '') {
	if (!$file) return;
	global $HostStorageSize;
	global $jext_files_size;
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
	log::manage('jext_file', '文件上传');
	// str::msg(array(
	// 	'Id'	=>	$Id,
	// 	'Path'	=>	$file['Path'],
	// 	'Name'	=>	$file['Name'],
	// ), 1);
	exit(str::json(array(
		'ret' => 1,
		'msg' => array(
			'Id'	=>	$Id,
			'Path'	=>	$file['Path'],
			'Name'	=>	$file['Name'],
		),
		'HostStorageSize' => file::size($HostStorageSize),
		'jext_files_size' => file::size($jext_files_size),
		'storage_percentage' => $HostStorageSize?round($jext_files_size/$HostStorageSize,2)*100:0
	)));
}