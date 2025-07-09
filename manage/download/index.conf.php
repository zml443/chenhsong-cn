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
        'PageUrl' => array(
            'Type' => 'pageurl',
            'Tip' => language('{/notes.custom_url/}'),
            'Sql' => array('varchar(200)', ''),
        ),
		'wb_download_category_id' => array(
			'Name' => language('{/global.category/}'),
			'Type' => 'category',
			'Table'	=> 'download/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'name',
		),
		'AddTime' => array(
			'Type' => 'day',
			'Sql' => array('int(11)'),
		),
		'Files' => array(
			'Type' => 'file',
			'Sql' => array('text'),
		),
		// 'Seo' => 1,
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
		/*'Detail' => array(
			'Type' => 'editor',
		),*/
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
		'data_number_download' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_download_day' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_download_week' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_download_month' => array(
			'Sql' => array('int(11)', 0)
		),
	)
);