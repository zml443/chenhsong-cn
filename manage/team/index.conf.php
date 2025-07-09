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
		'wb_team_category_id' => array(
			'Name' => language('{/form.department/}'),
			'Type' => 'category',
			'Table'	=> 'team/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'name',
		),
		'Seo' => 1,
		'Job' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'List' => 1,
		),
		'Pictures' => array(
			'Type' => 'image',
			'Sql' => array('text'),
			'List' => 1,
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('varchar(255)'),
		),
		'Detail' => array(
			'Type' => 'editor',
		),
	)
);
return $db_config;
?>