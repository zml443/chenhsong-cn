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
		'wb_video_category_id' => array(
			'Name' => '类别',
			'Type' => 'category',
			'Table'	=> 'video/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'name',
			'Search' => 1,
		),
		'Pictures' => array(
			'Name' => '封面图',
			'Sql' => array('text'),
			// 'Tip' => '建议尺寸为 880*620 像素',
			'Type' => 'image',
		),
		'Seo' => 1,
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