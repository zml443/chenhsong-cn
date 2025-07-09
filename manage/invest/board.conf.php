<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'Lang' => 1,
		),
		'SubName' => array(
			'Name' => '别名',
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'Lang' => 1,
		),
		'Brief' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
			'Lang' => 1
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
			'Lang' => 1
		),
	),
);
return $db_config;
?>