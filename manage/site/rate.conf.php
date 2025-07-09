<?php
// 汇率表字段配置
$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(20)'),
			'Lang' => 1,
			// 'EditLi' => 1,
			'List' => 1,
		),
		'En' => array(
			'Name' => 'En',
			'Type' => 'text',
			'Sql'  => array('varchar(20)'),
			// 'EditLi' => 1,
			'List' => 1,
		),
		'Ico' => array(
			'Name' => 'Ico',
			'Type' => 'text',
			'Sql'  => array('varchar(200)'),
			// 'EditLi' => 1,
			'List' => 1,
		),
		'Rate' => array(
			'Type'  => 'number',
			'Sql'   => array('float(8)'),
			'EditLi' => 1,
			'List' => 1,
		),
		'Default' => array(
			'Type' => 'only',
			'Sql'  => array('int(1)', 0),
			'List' => 1,
		),
		'Open' => array(
			'Type' => 'open',
			'Sql'  => array('int(1)', 0),
			'List' => 1,
		),
	),
);
return $db_config;
?>
