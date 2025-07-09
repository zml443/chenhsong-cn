<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'List' => 'name',
            'Lang' => 1
		),
		'wb_products_id' => array(
			'Name' => '推荐产品',
			'Tip' => '没有勾选默认显示最新的4个',
			'Type' => 'bind',
			'Sql' => array('text',''),
			'Table' => array('products/index'),
			'Cfg' => array(
				'ma' => "products/index",
				'name' => 'Name',
			),
            'Group' => "关联",
		),

	)
);
return $db_config;
?>