<?php

$db_config = array(
	'dbc' => array(
		'Language' => 1,
		'Name' => array(
			'Name' => language('{/dbs.field.Job/}'),
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1
		),
		'wb_join_category_id' => array(
			'Name' => language('{/dbs.field.JobCategory/}'),
			'Type' => 'category',
			'Table' => 'join/category',
			'Sql' => array('int(11)',''),
			'GroupRight' => language('{/dbs.field.JobCategory/}'),
		),
		'wb_join_address_id' => array(
			'Name' => language('{/dbs.field.Address/}'),
			'Type' => 'category',
			'Table' => 'join/address',
			'Sql' => array('int(11)',''),
			'GroupRight' => language('{/dbs.field.JobCategory/}'),
		),
		'AddTime' => array(
			'Type' => 'day',
			'Sql' => array('int(11)', '0'),
		),
		'Qty' => array(
			'Type' => 'text',
			'Sql' => array('varchar(100)', '0'),
		),
		'Gender' => array(
			'Type' => 'radio',
			'Sql' => array('varchar(1)', 'A'),
			'Args' => array(
				'A' => '保密/不限',
				'B' => '男', //Boy
				'G' => '女', //Gird
			),
		),
		'Address' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)', ''),
		),
		'Education' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)', ''),
		),
		'Responsibility' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
		'Demand' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
	)
);
return $db_config;
?>