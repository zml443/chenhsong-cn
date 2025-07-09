<?php
// 已被使用的变量
// $name, $value, $row, $cfg


if ($row['DistributionQty']) {
	echo $row['DistributionQtyEd'].'/'.$row['DistributionQty'];
}else{
    echo language('panel.DistributionQty.number');
}

?>
