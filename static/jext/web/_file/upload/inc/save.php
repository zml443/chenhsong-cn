<?php

include '../../../../php/init.php';



$_POST['--type'] || $_POST['--type'] = 'default';
$_POST['GroupId'] || $_POST['GroupId'] = $_POST['--type'];

$name = $_POST['--name'];
$suffix = strrchr($name, '.');

if ($_POST['--isname']) {
	$filename = str_replace($suffix, '', $name);
} else {
	$filename = date('YmdHis') . rand(1000, 9999);
}

$type1 = dirname(__FILE__).'/../cfg/' . str_replace('../','',$_POST['--type']) . '.php';

if (is_file($type1)) {
	include $type1;
} else {
	str::msg('配置错误', 0);
}

if (!$jurisdiction) {
	str::msg('权限不够', 0);
}

if (preg_match('/\.(php(.*)?|exe|asp|net|ini|dll|bat|jsp|p?html|js)$/i', $suffix)) {
	str::msg('权限不够', 0);
}

if (strlen($suffix)>6 || preg_match('/(\'|")/i', $suffix)) {
	str::msg('未知后缀', 0);
}

set_time_limit(0);
ini_set('memory_limit', '6000M');

if (!$_POST['--name'] || !$_POST['--size'] || !$_POST['--move'] || !$_FILES['--file']) {
	str::msg('参数错误', 0);
}

// 检查文件大小
$HostStorageSize = c('HostStorageSize');
$jext_files_size = jext_files::size();
if ($HostStorageSize && $HostStorageSize<$jext_files_size) {
	exit(str::json(array(
		'ret' => 0,
		'msg' => '储存已达上限',
	)));
}


/*
 * 设置分段文件的
 *
**/
$size || $size = 1024 * 1024 * 5;
$save_dir || $save_dir = c('u_file_dir') . date('/Y-m/d/');
$path = c('root') . c('tmp_dir') . 'upload/'.date('Y-m-d/') . md5($_POST['--path']);
$move = $path . '/' . $_POST['--move'];
$list = $path . '/list';
$data = is_file($list) ? str::json(file_get_contents($list), 'decode') : array();
$data[$_POST['--move']] = $move;
$datasize = $path . '/size';

if ($size <= $_POST['--size'] || $_FILES['--file']['size'] > 1024 * 1024 * 5) {
	file::rmdir($path);
	str::msg('尺寸太大了', 0);
}


$jext_files_size = jext_files::size();
$HostStorageSize = c('HostStorageSize');
if ($HostStorageSize && $HostStorageSize<$jext_files_size) {
	exit(str::json(array(
		'ret' => 0,
		'msg' => '存储已达到上限',
	)));
}

/*
 * 保存数据
 *
**/
file::mkdir($path);
file::mkdir($save_dir);
file_put_contents($list, str::json($data));
$tmp_name = str_replace('\\\\', '\\', $_FILES['--file']['tmp_name']);
move_uploaded_file($tmp_name, $move);
// file::unlink($tmp_name);
if (!is_file($move)) {
	exit(str::json(array(
		'ret' => -1,
		'msg' => '上传失败',
	)));
}


// 完整上传
if ($_POST['--size'] == $_POST['--move']) {
	$i = rand(10, 99);
	$_filename = $filename . $suffix;
	while (1) {
		if (is_file(c('root') . $save_dir . $_filename)) {
			$i++;
			$_filename = $filename . " - $i" . $suffix;
		} else {
			break;
		}
	}
	$file = fopen(c('root') . $save_dir . $_filename, 'w') or exit('Unable to open file!');
	$sk = 0;
	foreach ($data as $k => $v) {
		if ($k <= $sk) {
			fclose($file);
			file::rmdir($path);
			str::msg('配置错误', 0);
		}
		$sk = $k;
		fwrite($file, file_get_contents($v));
	}
	fclose($file);
	file::rmdir($path);
	$_SESSION['JextsSaveFileStart'] = 0;
	$img = array(0, 0);
	if (preg_match('/\\.(png|jpe?g|ico|webp)$/i', $_filename)) {
		$img = getimagesize(c('root') . $save_dir . $_filename);
	}

	// 记录数据
	$array = array(
		'Path'		=>	$save_dir . $_filename,
		'Name'		=>	$name,
		'Width'		=>	$img[0],
		'Height'	=>	$img[1],
		'Size'		=>	$_POST['--size'],
	);
	if (function_exists('callback')) callback($array);
}

exit(str::json(array(
	'ret' => 1,
	'msg' => '上传成功',
	'HostStorageSize' => file::size($HostStorageSize),
	'jext_files_size' => file::size($jext_files_size),
	'storage_percentage' => $HostStorageSize?round($jext_files_size/$HostStorageSize,2)*100:0
)));