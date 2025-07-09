<?php
// 已被使用的变量
// $name, $value, $row, $cfg


// d($row[$name]);
$val = ip::info($row[$name]);

echo $val['ip'] . '【'.$val['country'].'.'.$val['area'].'】';