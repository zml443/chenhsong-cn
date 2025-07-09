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
		'AddTime' => array(
			'Type' => 'day',
			'Sql' => array('int(11)'),
		),
		'Pictures' => array(
			'Name' => '封面图',
			'Sql' => array('text'),
			// 'Tip' => '建议尺寸为 880*620 像素',
			'Type' => 'image',
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
	)
);
return $db_config;
?>