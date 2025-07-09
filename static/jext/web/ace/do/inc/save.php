<?php

include '../../../../php/init.php';
include 'ace.class.php';


$type = '../' . ($_POST['type'] ? str_replace('../','', $_POST['type']) : 'default') . '.php';
$file = $_POST['file'];
if (is_file($type)) {
	include $type;
}
else {
	echo 'THE CONFIG ERROR!';
	exit;
}

if ((int)$_SESSION['JextAce'] == 0 || !$__SAVE || !$__FILE) {
	echo 'NEED TO LOGIN!';
	exit;
}

ace::save();