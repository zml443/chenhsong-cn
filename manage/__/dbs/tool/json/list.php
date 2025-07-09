<?php
// 已被使用的变量
// $name, $value, $row, $cfg


$val = str::json(htmlspecialchars_decode($row[$name]),'decode');
echo '<div style="min-width:200px">'.str::ary_html($val).'</div>';