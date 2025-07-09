<?php
// 修改产品参数
if ($price_id = (int)$_POST['wb_products_parameter_price_id']) {
	$parameter_price = db::get_one("wb_products_parameter_price","Id='{$price_id}'");
	$parameter = db::get_all('wb_products_parameter',"Id in (".$parameter_price['wb_products_parameter_id'].")", ln('Name'));
	$Param = '';
	foreach ($parameter as $k=>$v) {
		$Param .= ($k?'+':'').$v[ln('Name')];
	}
	$_POST['Param'] = addslashes($Param);
	$_POST['wb_products_parameter_id'] = addslashes($parameter_price['wb_products_parameter_id']);
	$_POST['Price'] || $_POST['Price'] = (float)$parameter_price['Price'];
}
?>