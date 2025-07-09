<?php

return array(
	'dbc' => array(
		'Language' => 1,
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'List' => 'name',
		),
		'GroupId' => array(
			'Type' => 'radio',
			'Sql' => array('varchar(30)'),
			'Args' => array(
				'wb_products' => language('{/dbs.relative.wb_products/}'),
				'wb_info' => language('{/dbs.relative.wb_info/}'),
				'wb_case' => language('{/dbs.relative.wb_case/}'),
				'wb_hotel' => language('{/dbs.relative.wb_hotel/}'),
			),
			'List' => 1,
			'Search' => 1,
		),
		'Seo' => 1,
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