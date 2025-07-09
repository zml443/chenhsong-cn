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
		'wb_case_category_id' => array(
			'Name' => language('{/dbs.field.Category/}'),
			'Type' => 'category',
			'Table'	=> 'case/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'attr',
			'List' => 'name',
		),
		'_where_extid_add' => array(
			'Type' => 'where_extid',
			'Cfg' => array(
				'table' => 'wb_case_search_where_extid',
				'ma' => 'case/search_where'
			),
		    'GroupRight' => 'attr',
		),
		/*'Url' => array(
			'Name' => '案例网址 URL',
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
		),*/
		'AddTime' => array(
			'Type' => 'day',
			'Sql' => array('int(11)'),
		),
		'Pictures' => array(
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
			'Type' => 'editor_open',
			'Field' => array(
				'DetailType' => array('Sql'=>array('varchar(50)', 'content')),
				'DetailUrl' => array('Sql'=>array('varchar(255)', '')),
			),
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