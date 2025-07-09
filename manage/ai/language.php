<?php
function_exists('c')||exit();
$language = curl::api('http://ai.test.lianyayun.com/gateway/xfyun.php', 'iw2QlKtUWmRZrJuS4kpKOt40nnPcvJag', array(
	'ApiName' => 'language',
));


echo $language;