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
		/*'wb_solution_category_id' => array(
			'Name' => language('{/global.category/}'),
			'Type' => 'category',
			'Table'	=> 'solution/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'name',
		),*/
		'Pictures' => array(
			'Sql' => array('text'),
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