<?php

$_SESSION['lang'] = $_POST['lang'];

exit(str::json(array(
	'msg' => '',
	'ret' => '1',
)));