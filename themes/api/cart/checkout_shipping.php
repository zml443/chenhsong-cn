<?php
function_exists('c')||exit;

$wb_member_id = member('Id');
$session_id = c('session_id');

$_SESSION['wb_member_address_id_current'] = $wb_member_address_id = (int)$_POST['wb_member_address_id'];
if ($wb_member_address_id && $wb_member_id) {
	$address = db::result("select * from wb_member_address where wb_member_id='".self::$wb_member_id."' and Id='{$wb_member_address_id}'");
	$Country = $address['Country'];
	$Province = $address['Province'];
} else {
	$Country = $_POST['Country'];
	$Province = $_POST['Province'];
}

// 计算配送方式，并且输出所有的配送方式
if($Country || $Province){
	if($wb_member_id){
		$where = "wb_member_id='{$wb_member_id}'";
	}else{
		$where = "session_id='{$session_id}'";
	}
	$BuyType = (int)$_POST['BuyType'];
	$cart = db::result("select sum(Weight*Qty) as weight, sum(Price*Qty) as price from wb_orders_cart where {$where} and BuyType='{$BuyType}' and Allow=1");
	$shipping = db::get('wb_shipping::price', array(
		'weight' => $cart['weight'],
		'price' => $cart['price'],
		'country' => $Country,
		'province' => $Province,
	));
	foreach ($shipping as $k => $v) {
		$shipping[$k]['Price'] = price::rate($v['Price'],2);
		$shipping[$k]['FreeStartPrice'] = price::rate($v['FreeStartPrice'],2);
		$shipping[$k]['FirstPrice'] = price::rate($v['FirstPrice'],2);
		$shipping[$k]['ExtWeightPrice'] = price::rate($v['ExtWeightPrice'],2);
	}
	echo str::json($shipping);
} else {
	echo '[]';
}