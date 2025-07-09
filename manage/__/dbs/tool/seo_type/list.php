<?php
// 已被使用的变量
// $name, $value, $row, $cfg

// d($name, $value, $row, $cfg, $this->table);

$seo = db::seo($this->table, $row['Id']);
echo $seo['Type'];


?>