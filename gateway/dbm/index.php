<?php

function_exists('c') || exit;

$classname = $_POST['ClassName'];
$classnameAry = explode('::', $classname);

$row = array();

if (method_exists($classnameAry[0], $classnameAry[1])) {
	$row = call_user_func($classnameAry, str::code($_POST['ARG'], 'stripslashes'));
}

echo str::json($row);