<?php

include '../../../php/init.php';

$path = $_REQUEST['path'];

if ($_REQUEST['webid']) {
	$jmdl = new jmdl\config(array(
	    'webid' => $_REQUEST['webid']
	));
	if ($jmdl->_dbname) db::query("use ".$jmdl->_dbname);
	else {
		echo $path;
		exit;
	}
}

$row = db::result("select * from jext_files where Path = '{$path}'");

if ($row['CutLy']) {
	echo $row['CutLy'];
}
else {
	echo $path;
}