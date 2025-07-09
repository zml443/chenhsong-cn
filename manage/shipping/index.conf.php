<?php
$db_config = array(
	'dbc' => array(
	    'Name' => array(
	    	'Type' => 'text',
	    	'Sql' => array('varchar(200)', ''),
	        'Lang' => 1
		),
	    'Free' => array(
			'Name' => language('{/orders.shipping_free/}'),
			// 'Type' => 'wb_shipping_free',
			'Type' => '/manage/shipping/index/_tool_free',
			'Field' => array(
	            // 字段名可以改，但是顺序不能乱
				'FreeOpen' => array('Sql'=>array('int(1)','0')),
				'FreeStartPrice' => array('Sql'=>array('numeric(10,2)','0.00')),
			),
	        'List' => 1
		),
	    'Weight' => array(
			'Name' => language('{/orders.shipping_price/}'),
			'Type' => '/manage/shipping/index/_tool_weight',
			'Table' => array('shipping/price', 'shipping/country_price'),
			'Field' => array(
	            // 字段名可以改，但是顺序不能乱
				'FirstPrice' => array('Sql'=>array('numeric(10,2)','0.00')),
				'FirstWeight' => array('Sql'=>array('numeric(10,3)','0.000')),
				'ExtWeight' => array('Sql'=>array('numeric(10,3)','0.000')),
				'ExtWeightPrice' => array('Sql'=>array('numeric(10,2)','0.00')),
			),
			'EditHide' => 1,
	        'List' => 1
		),
	    'Picture' => array(
	        'Type' => 'img',
	        'Sql' => array('varchar(200)'),
	    ),
	    'IsOpen' => array(
	        'Name' => language('{/global.used/}'),
	        'Type' => 'open',
	        'Sql' => array('int(1)', 1),
	        'List' => 1
	    )
	),
);
return $db_config;
?>