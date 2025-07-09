<?php
return array(
	'NotSave' => 1,
	'dbc' => array(
		'wb_manage_id' => array(
			'Table'=> 'manage/index',
			'Type' => 'manage',
			'Sql'  => array('int(11)', 0),
		),
		// 
		'UserName' => array(
			'Type' => 'text',
			'EditShow' => 1,
			'List' => 1,
		),
		// 
		'Module' => array(
			'Type' => '/manage/manage/log/_tool_module',
			'Sql'  => array('varchar(32)', ''),
			'List' => 1,
			'Search' => 1,
		),
		// 
		'Log' => array(
			'Type' => 'text',
			'Sql' => array('varchar(180)', ''),
			'EditShow' => 1,
			'List' => 1,
			'Search' => '%',
		),
		// 
		'Ip' => array(
			'Name' => 'IP',
			'Type' => 'ip',
			'List' => 'IP',
			'Search' => '%',
		),
		// 
		'AddTime'  => array(
			'Type' => 'daytime',
			'Sql'  => array('int(11)', 0),
			'EditShow' => 1,
			'List' => 1,
		),
		// 
		'Referer' => array(
			'Type' => 'text',
			'Sql'  => array('varchar(180)'),
			'EditShow' => 1,
			// 'List' => 'IP',
		),
		// 
		'GetData'  => array(
			'Name' => 'GET',
			'Type' => 'var_dump',
			'Sql'  => array('text'),
		),
		'PostData' => array(
			'Name' => 'POST',
			'Type' => 'var_dump',
			'Sql'  => array('longtext'),
		),
	),
);