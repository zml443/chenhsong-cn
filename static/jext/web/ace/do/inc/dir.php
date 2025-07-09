<?php

include '../../../../php/init.php';

$type = c('jext.php') . 'api/ace/' . ($_POST['type'] ? str_replace('../','', $_POST['type']) : 'default') . '.php';
if (is_file($type)) {
    include $type;
} else {
    echo 'THE CONFIG ERROR!';
    exit;
}

if ((int)$_SESSION['JextAce'] == 0 || !$__DIR) {
	echo 'NEED TO LOGIN!';
	exit;
}

$path = c('root') . str_replace('../','',$_POST['dir']);

if (is_file($path)) str::msg(array(
	'name'	=>	$path,
	'size'	=>	filesize($path),
), 2);


if (!is_dir($path)) str::msg('', 0);

/*
 * 读取文件目录
 * 
**/
$dir = dir($path);
$ary = $ary0 = $ary1 = array();
while ($fhl = $dir->read()) {
    if ($fhl == '_notes') {
    	// file::rmdir($path.'/'.$fhl);
        continue;
    }
    if ($fhl == '.') {
        continue;
    }
    $isfile = is_file($path . $fhl);
    if ($isfile) {
    	$ary0[] = array(
			'type'	=>	1,
			'name'	=>	$fhl,
			'size'	=>	filesize($path . $fhl),
		);
    } else {
    	$ary1[] = array(
			'type'	=>	0,
			'name'	=>	$fhl,
		);
    }
}
$ary = array_merge($ary1, $ary0);
str::msg($ary, 1);
