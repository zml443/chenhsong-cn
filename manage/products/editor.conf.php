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
		'Editor' => array(
			'Type' => 'my_editor',
			'Sql' => array('longtext'),
			'Group' => 0
		),
		'wb_products_id' => array(
			'Type' => 'is_bind_id',
			'Sql' => array('int(11)', 0),
		),
	),
);
return $db_config;
?>