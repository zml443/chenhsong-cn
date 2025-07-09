<?php

// 当前用户的权限
if(!p("orders.index.edit")){
    str::msg(language('{/manage.manage.no_permit/}'), 0);
}
$update_bat = array();
$insert_bat = array();
$oid = (int)$_POST['id'];
$ids = '0';
foreach((array)$_POST['data'] as $k => $v){
	$ids .= ','.(int)$k;
}
$pro = db::all("select * from wb_products where Id in($ids)", 'Id');
foreach ((array)$_POST['data'] as $k => $v) {
	$k = (int)$k;
	$param = str::sql_in($v['param']);
	$pro[$k]['__wb_products_parameter_id'] = $param;
	$dat = array(
		'wb_orders_id' => $oid,
		'Name'    => $pro[$k][ln('Name')],
		'Price'   => price::real($pro[$k]),
		'Weight'  => $pro[$k]['Weight'],
		'Qty'     => $v['qty'],
		'Remark'  => $v['remark'],
		'Param'   => db::category_name($param, 'wb_products_parameter'),
		'wb_products_id' => $pro[$k]['Id'],
		'wb_products_parameter_id' => $param,
	);
	if ($row=db::result("select * from wb_orders_products where wb_products_id='{$k}' and wb_orders_id='{$oid}' and Param='{$dat['Param']}'")) {
		$dat['Qty'] += $row['Qty'];
		$dat['Category'] = db::category_name($pro[$k]['CateId'], 'wb_products_category');
		$update_bat[$row['Id']] = $dat;
	}
	else {
		// d($pro[$k]['Picture']);
		$pic = img::get($pro[$k]['Picture']);
		$dat['Picture'] = img::cut($pic, 100, 100, 0, 0, c('orders_file').date('Ymd/',c('time')).basename($pic));
		$insert_bat[] = $dat;
	}
}
db::update_bat('wb_orders_products', 'Id', $update_bat);
db::insert_bat('wb_orders_products', $insert_bat);
// 计算价格
if ($_POST['iscalc']) {
	$order = db::result("select * from wb_orders where Id in($oid)");
	$address = db::result("select Province from wb_orders_shipping_address where wb_orders_id in($oid)", 'Province');
	$shipping_price = price::shipping($order['ShippingType'], $address, $price, $weight);
	$weight = db::result("select sum(Weight*Qty) as a from wb_orders_products where wb_orders_id='$oid'", 'a');
	$price = db::result("select sum(Price*Qty) as a from wb_orders_products where wb_orders_id='$oid'", 'a');
	$qty = db::result("select sum(Qty) as a from wb_orders_products where wb_orders_id='$oid'", 'a');
	db::update('wb_orders', "Id='{$oid}'", array(
		'Price' => $price,
		'ShippingPrice' => $shipping_price,
		'Qty' => $qty,
		'Weight' => $weight,
	));
}
log::manage($_GET['ma'], "追加产品");
str::msg(language('{/notes.ok/}'), 1);
?>