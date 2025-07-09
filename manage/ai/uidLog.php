<?php
function_exists('c')||exit();
$group = curl::api('http://ai.test.lianyayun.com/gateway/xfyun.php', 'iw2QlKtUWmRZrJuS4kpKOt40nnPcvJag', array(
	'ApiName' => 'uidLog',
));

echo $group;