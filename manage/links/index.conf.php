<?php

$db_config = array(
	'dbc' => array(
		'Language' => 1,
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'List' => 'name',
		),
		'Url' => array(
			'Type' => 'text',
			'Sql' => array('varchar(255)'),
			'List' => 1,
		),
		'IsNofollow' => array(
			'Type' => 'open',
			'Sql' => array('int(1)',0),
			'List' => 1,
		),
	)
);
return $db_config;
?>