<?php
// 订单产品表字段配置
$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Name' => '',
			'Type' => 'text',
			'Sql'  => array('varchar(200)'),
		),
		'SKU' => array(
			'Name' => '',
			'Type' => 'text',
			'Sql'  => array('varchar(50)'),
		),
		'Category' => array(
			'Name' => '',
			'Type' => 'text',
			'Sql'  => array('varchar(200)'),
		),
		'Picture'	=> array(
			'Type' => 'img',
			'Sql'  => array('varchar(200)'),
		),
		'wb_orders_id' => array(
			'Sql'  => array('int(11)', 0),
		),
		'wb_products_id' => array(
			'Sql'  => array('int(11)', 0),
		),
		'Parameter' => array(
			'Tip' => '产品参数',
			'Sql' => array('text',''),
			'Field'=> array(
				'wb_products_parameter_id' => array('Sql'=>array('varchar(120)','')),
				// 'wb_products_parameter_price_id' => array('Sql'=>array('int(11)',0)),
			),
		),
		'Price' => array(
			'Type' => 'price',
			'EditLi' => 1,
		),
		'Qty' => array(
			'Type' => 'number',
			'EditLi' => 1,
		),
		'Weight' => 1,
		'Remark' => array(
			'Type' => 'text',
			'Sql'  => array('varchar(250)'),
			'EditShow' => 1,
		),
	),
	// 列表设定
	'list' => array(
		'type' => 'orders_products',
		'layout' => array(
			'Picture' => 1,
			'Name' => array('Name'=>1, 'SKU'=>1, 'Category'=>1, 'Weight'=>1),
			'Param' => 1,
			'Price' => 1,
			'Qty' => 1,
		)
	),
);
return $db_config;
?>