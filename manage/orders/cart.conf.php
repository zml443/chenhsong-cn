<?php
$db_config = array(
	'dbc' => array(
	    'Name' => array(
			'Tip' => '产品名称',
    	),
	    'Category' => array(
			'Tip' => '产品类别',
			'Sql' => array('varchar(200)', ''),
    	),
	    'SKU' => array(
			'Tip' => 'SKU',
			'Sql' => array('varchar(200)', ''),
    	),
	    'Href' => array(
			'Sql' => array('varchar(200)', ''),
    	),
	    'BuyType' => array(
			'Sql' => array('varchar(20)', '0'),
		),
	    'wb_member_id' => array(
			'Sql' => array('int(11)', '0'),
		),
	    'session_id' => array(
			'Sql' => array('varchar(32)', ''),
		),
	    'AddTime' => 1,
	    'Picture' => array(
			'Sql' => array('varchar(200)', ''),
	    ),
	    'wb_products_id' => array(
			'Sql' => array('int(11)', '0'),
		),
		// 产品参数
	    'Parameter' => array(
			'Sql' => array('text'),
		),
	    'wb_products_parameter_id' => array(
			'Sql' => array('varchar(120)'),
		),
	    'Weight' => array(
			'Type' => 'Weight',
			'Sql' => array('numeric(10,3)', '0'),
		),
	    'Price' => array(
			'Type' => 'Price',
			'Sql'  => array('numeric(10,2)', '0'),
		),
	    'UnPrice' => array(
			'Type' => 'Price',
			'Sql'  => array('numeric(10,2)', '0'),
		),
	    'Qty' => array(
			'Sql'  => array('int(11)', '1'),
		),
	    'Remark'	=> array(
			'Sql'  => array('varchar(120)', ''),
		),
		// 確認購買
	    'Allow' => array(
			'Sql' => array('int(1)', '0'),
		),
	)
);
return $db_config;
?>