<?php
// 已被使用的变量
// $name, $value, $row, $cfg


// 优惠券类型&使用条件
if($row['FullType'] == 'Money'){
	$full_sale = str_replace(
		array('{{full}}','{{sale}}'),
		array(price::rate($row['FullMoney']),$row['FreeDiscount']),
		language('panel.free.money_number')
	);

	if($row['FreeType'] == 'Money'){
		$full_sale = str_replace(
			array('{{full}}','{{sale}}'),
			array(price::rate($row['FullMoney']),price::rate($row['FreeMoney'])),
			language('panel.free.money')
		);
	}
}else{
	$full_sale = str_replace(
		array('{{full}}','{{sale}}'),
		array($row['FullNumber'],$row['FreeDiscount']),
		language('panel.free.discount_money')
	);

	if($row['FreeType'] == 'Money'){
		$full_sale = str_replace(
			array('{{full}}','{{sale}}'),
			array($row['FullNumber'],price::rate($row['FreeMoney'])),
			language('panel.free.money_number')
		);
	}
}

echo $full_sale;


?>
