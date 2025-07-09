<?php
// 已被使用的变量
// $name, $value, $row, $cfg



if ($row['UseQty']) {
	echo $row['UseQty'];
}else{
    echo language('panel.UseQty.number');
}

?>
