<?php
/*
 * 下载文件
 * 下面已经指定下载类型了
 * 文件路径 path
 * 文件名称 name
 * 
 */

include '../../../php/init.php';

// 允许下载的文件类型
if ( (!isset($_GET['path']) || !preg_match("/\.(pdf|psd|png|jpe?g|gif|ico|webp|txt|zip|gz|rar|7z|docx?|xlsx?|mp[34])$/i", $_GET['path'])) && (int)$_SESSION['JextAce'] == 0 ) {
	exit();
}

if (substr_count($_GET['path'], '..')<=2 && is_file($_GET['path'])) {
	$filepath = $_GET['path'];
} else {
	$filepath = $_SERVER['DOCUMENT_ROOT'] . '/' .str_replace('../', '/', $_GET['path']);
	if (!is_file($filepath)) {
		echo '<div style="padding:40px 50px">文件不存在！</div>';
		exit;
	}
}


if ($_GET['name'] == '') {
	$_GET['name'] = basename($filepath);
} else {
	$_GET['name'] .= strrchr($filepath, '.');
}

$file_size = filesize($filepath);

if ($file_size <= 0) {
	echo '无法下载空文件！';
	exit;
}

set_time_limit(0);

$file_handle = fopen($filepath, 'r');

$name = urlencode($_GET['name']);

if ($_GET['ext']) {
	$name = preg_replace("#\.([a-zA-Z0-9]*)$#", '.' . ltrim($_GET['ext']), $name);
}

header("Content-type: application/octet-stream; name=\"{$name}\"\n");
header("Accept-Ranges: bytes\n");
header("Content-Length: $file_size\n");
header("Content-Disposition: attachment; filename=\"{$name}\"\n\n");

ob_clean();  
flush();

while (!feof($file_handle)) {
	echo fread($file_handle, 1024 * 100);
}
fclose($file_handle);

?>