<?php
// 已被使用的变量
// $name, $row, $cfg



if ($row['FreeType'] == 'Discount') {
	echo language('panel.free.free_discount').':'.$row['FreeDiscount'];
}
if($row['FreeType'] == 'Money'){
	echo language('panel.free.free_money').':'.price::rate($row['FreeMoney']);
}

?>