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
		'wb_activity_category_id' => array(
			'Name' => language('{/dbs.field.Category/}'),
			'Type' => 'category',
			'Table'	=> 'activity/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'attr',
			'List' => 'name',
		),
		'_bind_id_add' => array(
			'Name' => language('{/dbs.field.wb_activity_booking_id/}'),
			'Type' => 'bind-A',
			'Table' => array('activity/booking'),
			'Cfg' => array(
				'ma' => 'activity/booking',
				'name' => 'Name',
				// 'picture' => 'Pictures',
			),
			'GroupRight' => 'attr',
		),
		/*'Url' => array(
			'Name' => '案例网址 URL',
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
		),*/
		// 'AddTime' => array(
		// 	'Type' => 'day',
		// 	'Sql' => array('int(11)'),
		// ),
		'BTime' => array(
			'Type' => 'deadline',
			'Field' => array(
				'BTimeStart' => array('Sql'=>array('int(11)','0')),
				'BTimeEnd' => array('Sql'=>array('int(11)','0')),
			),
		),
		'Address' => array(
			'Type' => 'text',
			'Sql' => array('varchar(255)',''),
		),
		'Sponsor' => array(
			'Type' => 'text',
			'Sql' => array('varchar(255)',''),
		),
		'Topic' => array(
			'Type' => 'text',
			'Sql' => array('varchar(255)',''),
		),
		'Guest' => array(
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'name' => array(
					'Name' => language('{/dbs.field.Name/}'),
					'Type' => 'text',
				),
				'brief' => array(
					'Name' => language('{/dbs.field.Brief/}'),
					'Type' => 'text',
				),
			),
			'Add' => 1
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