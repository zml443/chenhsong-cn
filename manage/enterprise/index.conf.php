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
		'wb_enterprise_category_id' => array(
			'Name' => language('{/dbs.field.Category/}'),
			'Type' => 'category',
			'Table'	=> 'enterprise/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'name',
		),
		/*'AddTime' => array(
			'Type' => 'day',
			'Sql' => array('int(11)'),
			'List' => 0,
		),*/
		'Logo' => array(
			'Sql' => array('varchar(255)'),
			// 'Tip' => '建议尺寸为 880*620 像素',
			'Type' => 'img',
			'List' => 1,
		),
		'Pictures' => array(
			'Sql' => array('text'),
			// 'Tip' => '建议尺寸为 880*620 像素',
			'Type' => 'image',
			'List' => 0,
		),
		'Tel' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
		),
		'Email' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
		),
		'WXNumber' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
		),
		'Website' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
		),
		'Address' => array(
			'Type' => 'textarea',
			'Sql' => array('varchar(500)'),
		),
		'Seo' => 1,
		'Brief' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
		'Detail' => array(
			'Type' => 'editor',
		),
		'data_number_views' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_views_day' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_views_week' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_views_month' => array(
			'Sql' => array('int(11)', 0)
		),
	)
);
return $db_config;
?>