<?php
function_exists('c')||exit;

$_SESSION['manage.lang'] = $_POST['lang'];

exit(str::json(array(
	'msg' => '',
	'ret' => '1',
)));