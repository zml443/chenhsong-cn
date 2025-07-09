<?php
// 已被使用的变量
// $name, $row, $cfg
$field_key = array();
foreach ($cfg['Field'] as $k => $v) $field_key[] = $k;
$eftime0 = $field_key[0];
$eftime1 = $field_key[1];

$time0 = (int)$row[$eftime0];
$time1 = (int)$row[$eftime1];

?>
<div class="nowrap">
	<?=$time1<c('time')?'已过期' : date('Y-m-d H:i', $time0).' <br> '.date('Y-m-d H:i', $time1)?>
</div>