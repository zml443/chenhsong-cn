<?php
$db_config = array(
	'dbc' => array(
		'Language' => 1,
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(100)', ''),
		),
		'Pictures' => array(
			'Name' => '封面图',
			'Sql' => array('text'),
			// 'Tip' => '建议尺寸为 880*620 像素',
			'Type' => 'image',
		),
        'Email' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)', ''),
			'List' => 0,
		),
        'Address' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)', ''),
		),
        'Phone' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)', ''),
			'List' => 0,
		),
		'Detail' => array(
			'Type' => 'editor',
		),
		'wb_join_address_id' => array(
			'Name' => language('{/dbs.field.Address/}'),
			'Type' => 'category',
			'Table' => 'join/address',
			'Sql' => array('int(11)',''),
			'GroupRight' => language('{/dbs.field.Address/}'),
			'List' => 1,
		),
		'Seo' => 1,
	)
);
return $db_config;
?>