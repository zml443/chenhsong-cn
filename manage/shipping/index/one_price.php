<?php
function_exists('c') || exit;

// 多个运输方式
$shipping = ly200::shipping_all_price(array(
    'weight' => $_GET['weight'],
    'country' => $_GET['country'],
    'province' => $_GET['province'],
    'price' => $_GET['price'],
    'lane' => $_GET['lang'],
));


// 单个运输方式
// $shipping = ly200::shipping_one_price(array(
//     'weight' => $_GET['weight'],
//     'country' => $_GET['country'],
//     'province' => $_GET['province'],
//     'price' => $_GET['price'],
//     'wb_shipping_id' => $_GET['wb_shipping_id'],
//     'lane' => $_GET['lang'],
// ));

exit(str::json(array(
	'ret' => 1,
	'msg' => '成功',
    'data' => $shipping,
)));