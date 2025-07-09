<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'List' => 'name',
		),
		'wb_activity_id' => array(
			'Type' => 'bind-B',
			'Sql' => array('int(11)', 0),
			'Table' => array('activity/index'),
			'Cfg' => array(
				'ma' => 'activity/index',
				'name' => 'Name',
				'picture' => 'Pictures',
			),
		),
		'AddTime' => array(
			'Type' => 'day',
			'Sql' => array('int(11)'),
			'EditShow' => 1,
			'NotSave' => 1,
		),
		'Tel' => array(
			'Type' => 'text',
			'Sql' => array('varchar(255)',''),
		),
		'Company' => array(
			'Type' => 'text',
			'Sql' => array('varchar(255)',''),
		),
		'Job' => array(
			'Type' => 'text',
			'Sql' => array('varchar(255)',''),
		),
		'Message' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
	)
);
return $db_config;
?>