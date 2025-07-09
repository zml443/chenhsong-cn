<?php
$wb_orders_id = (int)$_POST['wb_orders_id'];
$wb_member_id = (int)member('Id');

$BuyType = str::rand();


$orders = wb_orders::one_current(array(
	'Id' => $wb_orders_id
));
if (!$orders) {
	str::msg('订单错误');
}

$wb_products_id = '0';
foreach ($orders['wb_orders_products'] as $k => $v) {
	$wb_products_id .= ','.($v['wb_products_id']);
}

$products = wb_products::ids(array(
	'id' => $wb_products_id
));

// 检查商品是否可以正常购买
$insert_bat = array();
$pro_data = array();
foreach ($products as $v) {
	$pro_data[$v['Id']] = $v;
}
foreach($orders['wb_orders_products'] as $k => $v) {
	$pro = $pro_data[$v['wb_products_id']];
	$pro = wb_products::deal_with_price(array(
		'row' => $pro,
		'qty' => $v['Qty'],
		'wb_products_parameter_id' => $v['wb_products_parameter_id']
	));
	if ($pro) {
		if ($pro['wb_products_parameter_id_buy']!=$v['wb_products_parameter_id']) {
			str::msg('相同配置的商品已售罄，請重新選擇');
		} else if ($pro['IsSaleOut']) {
			str::msg("商品已下架！");
		} else if ($pro['Stock']<$v['Qty']) {
			str::msg("商品庫存不足");
		}
	} else {
		str::msg("商品已下架！");
	}
	$insert_bat[] = array(
		'Name' => addslashes($v['Name']),
		'Category' => addslashes($v['Category']),
		'Picture' => addslashes($v['Picture']),
		'wb_member_id' => $wb_member_id,
		'Parameter' => str::code(str::json($pro['wb_products_parameter_buy']),'addslashes'),
		'SKU' => addslashes($v['SKU']),
		'wb_products_id' => $v['Id'],
		'wb_products_parameter_id' => $pro['wb_products_parameter_id_buy'],
		'Price' => (float)$v['Price'],
		'Qty' => (int)$v['Qty'],
		'Allow' => 1,
		'BuyType' => $BuyType,
		'AddTime' => c('time'),
		'Weight' => (float)$v['Weight'],
		// 'UnPrice' => $v['UnPrice'],
	);
}

// 加入购物车
db::insert_bat('wb_orders_cart', $insert_bat);

// d($insert_bat);

exit(str::json(array(
	'msg' => '已添加到購物車',
	'url' => '/cart/buynow.html?BuyType='.$BuyType,
	'ret' => 1
)));
