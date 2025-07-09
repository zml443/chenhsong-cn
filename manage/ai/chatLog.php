<?php

function_exists('c')||exit();

// d('dddd',$_POST);
$chatLog = curl::api('http://ai.test.lianyayun.com/gateway/xfyun.php', 'iw2QlKtUWmRZrJuS4kpKOt40nnPcvJag', array(
	'ApiName' => 'chatLog',
	'uid' => $_POST['uid'],
	// $_POST['uid'],
));

echo $chatLog;