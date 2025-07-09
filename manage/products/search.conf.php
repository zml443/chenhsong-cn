<?php
$db_config = array(
	'dbc' => array(
		'Language' => array(
			'Type' => 'language',
			'Sql' => array('varchar(10)'),
			'Group' => 0
		),
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)', ''),
			'Group' => 0
		),
		'wb_products_category_id' => array(
            'Name' => language('{/dbs.field.DisplayOnPage/}'),
            'Type' => 'category',
            'Table' => 'products/category',
            'Sql' => array('varchar(200)', '0'),
            'Add' => 1,
			'List' => 1,
		),
		'Used' => array(
			'Type' => 'open',
			'Sql' => array('int(1)', 1),
			'Group' => 0,
			'List' => 1,
		),
		'Data' => array(
			'Type' => '/manage/products/search/_tool_parameter',
			'Sql' => array('text', ''),
			'Group' => language('{/dbs.group.Filter/}'),
		),
        '关联其他表' => array(
            'Table' => array('products/search_where','products/search_where_extid')
        ),
	),
);
return $db_config;
?>