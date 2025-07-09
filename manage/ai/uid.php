<?php
function_exists('c')||exit();

$url = 'http://ai.test.lianyayun.com/gateway/xfyun.php';
$key = 'iw2QlKtUWmRZrJuS4kpKOt40nnPcvJag';

$res = curl::api($url, $key, array(
	'ApiName' => 'uid',
	'uid' => $_POST['uid'],
	'name' => $_POST['name'],
	'mask' => $_POST['mask'],
));

echo $res;