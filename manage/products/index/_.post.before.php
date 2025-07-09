<?php
// 产品参数
$_POST['wb_products_parameter_min_price'] = 0;
$_POST['wb_products_parameter_max_price'] = 0;
$_POST['wb_products_parameter_total_stock'] = 0;
foreach ((array)$_POST['wb_products_parameter_price'] as $k => $v) {
	if (!$_POST['wb_products_parameter_min_price'] || $_POST['wb_products_parameter_min_price']>$v['price']) {
		$_POST['wb_products_parameter_min_price'] = $v['price'];
		$_POST['wb_products_parameter_min_original_price'] = $v['original_price'];
		$_POST['wb_products_parameter_min_cost_price'] = $v['cost_price'];
	}
	if ($_POST['wb_products_parameter_max_price']<$v['price']) {
		$_POST['wb_products_parameter_max_price'] = $v['price'];
		$_POST['wb_products_parameter_max_original_price'] = $v['original_price'];
		$_POST['wb_products_parameter_max_cost_price'] = $v['cost_price'];
	}
	$_POST['wb_products_parameter_total_stock'] += $v['stock'];
}