<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'List' => 'name',
			'Language' => 1,
		),
		'Logo' => array(
			'Type' => 'img',
			'Sql' => array('varchar(255)'),
			'List' => 1,
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('varchar(255)'),
		),
		'UId' => array(
			'Dept' => 1,
		),
	)
);
return $db_config;
?>