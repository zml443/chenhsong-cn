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
			'Tip' => language('{/panel.search_url_tip/}'),
	        'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'List' => 1,
		),
		'IsUsed' => array(
			'Tip' => language('{/panel.search_used_tip/}'),
	        'Type' => 'open',
			'Sql' => array('tinyint(1)', '0'),
			'List' => 1,
		),
		'IsHot' => array(
	        'Type' => 'open',
			'Sql' => array('tinyint(1)', '0'),
			'List' => 1,
		),
	)
);
return $db_config;
?>