<?php
// wb_hotel
// wb_hotel_category
$db_config = array(
	'dbc' => array(
		'Language' => 1,
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'List' => 'name',
		),
		'wb_hotel_category_id' => array(
			'Name' => language('{/dbs.field.Category/}'),
			'Type' => 'category',
			'Table'	=> 'hotel/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'attr',
			'List' => 'name',
		),
		'_where_extid_add' => array(
			'Type' => 'where_extid',
			'Cfg' => array(
				'table' => 'wb_hotel_search_where_extid',
				'ma' => 'hotel/search_where'
			),
		    'GroupRight' => 'attr',
		),
		'Pictures' => array(
			// 'Tip' => '建议尺寸为 880*620 像素',
			'Type' => 'image',
			'Sql' => array('text'),
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