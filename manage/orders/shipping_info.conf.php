<?php
$db_config = array(
	'dbc' => array(
	    'Name'  => array(
			'Name' => '{/orders.shipping.number/}',
			'Type' => 'text',
			'Sql' => array('varchar(200)', ''),
		),
	    'AddTime' => array(
			'Type' => 'daytime',
			'Sql' => array('int(11)', 0),
		),
	    'wb_orders_id' => array(
	    	'Type' => 'is_bind_id',
			'Sql' => array('int(11)', 0),
		),
		// // 配送方式
		// 'ShippingType' => array(
		// 	'Sql' => array('varchar(100)', ''),
		// ),
		// // 配送方式
		// 'ShippingProviders' => array(
		// 	'Sql' => array('varchar(100)', ''),
		// ),
		// 配送方式
		'Remarks' => array(
			'Name' => '备注',
			'Type' => 'textarea',
			'Sql' => array('text', ''),
		),
	)
);
return $db_config;
?>