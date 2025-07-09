<?php
$db_config = array(
	'dbc' =>  array(
		'wb_site_web_id' => array(
			'Sql' => array('int(11)', '0')
		),
		'wb_site_page_id' => array(
			'Sql' => array('int(11)', '0')
		),
		'Name' => array(
			'Sql' => array('varchar(100)', '')
		),
		'Number' => array(
			'Sql' => array('varchar(100)', '')
		),
		'Type' => array(
			'Sql' => array('varchar(50)', ''),
		),
		'Width' => array(
			'Sql' => array('varchar(20)', '')
		),
		'IsHide' => array(
			'Sql' => array('int(1)', '0')
		),
		'Parts' => array(
			'Sql' => array('varchar(20)', ''),
		),
		'Picture' => array(
			'Sql' => array('varchar(200)', '')
		),
		'Data' => array(
			'Type' => 'var_dump',
			'Sql' => array('longtext'),
			'Lang' => 1
		),
		'关联表' => array(
			'Table' => array('site/page_module_children'),
		),
	),
);
return $db_config;
?>