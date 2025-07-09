<?php
// 已被使用的变量
// $name, $value, $row, $cfg
// d($name, $value, $row, $cfg);

if ($cfg['Lang']) {
	$v = $row[ln($name)];
}
else {
	$v = $row[$name];
}
$v = str::code(str::json(htmlspecialchars_decode($v), 'decode'));

?>
<div nowrap><?=$v['number']?> <span class="cr9"><?=$v['unit']?></span></div>