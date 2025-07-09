<?php

include '../../../../php/init.php';
include 'ace.class.php';


$type = '../' . ($_POST['type'] ? str_replace('../','', $_POST['type']) : 'default') . '.php';
if (is_file($type)) {
	include $type;
} else {
	echo 'THE CONFIG ERROR!';
	exit;
}


/*
 * 设置编辑权限
 * 
**/
if ((int)$_SESSION['JextAce'] == 0 || !$__READ || !$__FILE) {
	if ($__READ) {
		$_SESSION['JextAce'] = 1;
	} else {
		echo 'NEED TO LOGIN!';
		exit;
	}
}


ace::read();