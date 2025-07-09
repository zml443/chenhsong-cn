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
		'PageUrl' => array(
			'Type' => 'pageurl',
			'Tip' => language('{/notes.custom_url/}'),
			'Sql' => array('varchar(200)', ''),
		),
		'wb_exhibition_id' => array(
			'Type' => 'bind-id',
			'Sql' => array('int(11)', ''),
		),
		'Pictures' => array(
			'Name' => '封面图',
			// 'Tip' => '建议尺寸为 880*620 像素',
			'Type' => 'image',
		),
		'wb_exhibition_products_category_id' => array(
			'Name' => '类别',
			'Type' => '/manage/exhibition/products/_tool_category',
			'Table'	=> 'exhibition/products_category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'name',
			'Search' => 1,
		),
		'Seo' => 1,
		/*'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
		),*/
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