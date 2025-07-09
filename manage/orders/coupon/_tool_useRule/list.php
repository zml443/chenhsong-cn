<?php
// 已被使用的变量
// $name, $row, $cfg



if ($row['FullType'] == 'Number') {
	echo language('panel.free.full_number').':'.$row['FullNumber'];
}
if($row['FullType'] == 'Money'){
	echo language('panel.free.full_money').':'.price::rate($row['FullMoney']);
}

?>