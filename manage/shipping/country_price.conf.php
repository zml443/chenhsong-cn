<?php
// 数据结构
return array(
	'dbc' => array(
	    'Name' => array(
	    	'Type' => 'text',
	    	'Sql'  => array('varchar(250)',''),
		    'Lang' => 1
		),
	    'FirstPrice' => array(
			'Name' => language('{/orders.shipping_first_price/}'),
			'Type' => 'price',
			'Sql'  => array('numeric(10,2)', 0),
			'EditLi' => 1,
			'List' => 1,
		),
	    'FirstWeight' => array(
			'Name' => language('{/orders.shipping_first_weight/}'),
			'Type' => 'weight',
			'Sql'  => array('numeric(10,3)','0.000'),
			'EditLi' => 1,
			'List' => 1,
		),
	    'ExtWeight' => array(
			'Name' => language('{/orders.shipping_ext_weight/}'),
			'Type' => '/manage/shipping/country_price/_tool_weight_ext',
			'Field' => array(
	            // 字段名可以改，但是顺序不能乱
				'ExtWeight' => array('Sql'=>array('numeric(10,3)','0.000')),
				'ExtWeightPrice' => array('Sql'=>array('numeric(10,2)','0.00')),
			),
			'EditLi' => 1,
			'List' => 1,
		),
		'wb_address_country_id' => array(
			'Sql' => array('int(11)','0'),
		),
		'wb_shipping_id' => array(
			'Type' => 'is_bind_id',
			'Sql' => array('int(11)','0'),
		)
	)
);