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
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
		'Brief' => array(
            'Tip' => '首页展示',
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
		'Url' => array(
            'Name' => '外链',
			'Tip' => "外链优先",
			'Type' => 'text',
			'Sql' => array('varchar(250)', ''),
		),
		'Pictures' => array(
			'Name' => '列表-封面图',
			'Tip' => '图一为PC端，建议尺寸为 1920*960 像素；图二为移动端，建议尺寸为 750*960 像素',
			'Type' => 'image',
			'Sql' => array('text',''),
			'Cfg' => array(
				'alt' => array(
					'Name' => 'alt',
					'Type' => 'text',
                ),
				'title' => array(
					'Name' => 'title',
					'Type' => 'text',
				)
            ),
		),
		'Seo' => 1,
		
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