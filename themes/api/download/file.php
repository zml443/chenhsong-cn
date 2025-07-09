<?php

function_exists('c')||exit;



if(!((g('wb_download_config.IsMember') && member('Id')) || (g('wb_download_config.IsFeedback') && $_SESSION['lysaas-downloadFeedback']))){
	exit;
}


$row = wb_download::id(array(
	'id' => $_GET['id']
));
$filepath = c('root') . $row['File']['path'];

// 允许下载的文件类型
if (!preg_match("/\.(pdf|psd|png|jpe?g|gif|ico|webp|txt|zip|gz|rar|7z|docx?|xlsx?|mp[34])$/i", $filepath)) {
	exit();
}


if (!is_file($filepath)) {
	echo '<div style="padding:40px 50px">文件不存在！</div>';
	exit;
}



$file_size = filesize($filepath);

if ($file_size <= 0) {
	echo '无法下载空文件！';
	exit;
}

set_time_limit(0);

$file_handle = fopen($filepath, 'r');

if ($row['name']) {
	$name = $row['Name'].strrchr($filepath, '.');
} else {
	$name = basename($filepath);
}
$name = urlencode($name);


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