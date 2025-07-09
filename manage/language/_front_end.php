<?php
function_exists('c')||exit;

$_SESSION['lang'] = $_POST['lang'];

exit(str::json(array(
	'msg' => $_SESSION['lang'],
	'ret' => '1',
)));