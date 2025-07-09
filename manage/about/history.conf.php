<?php

$db_config = array(
	'dbc' => array(
		'Language' => 1,
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'Search' => 1,
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
			// 'Lang' => 1
		),
		'wb_year_id' => array(
			'Name' => '年份区间',
			'Type' => 'category',
			'Table'	=> 'about/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'Name',
			'Search' => 1,
			'NotNull' => 1,
		),
		'Pictures' => array(
			'Tip' => '一张图片，推荐尺寸为 450*280 像素',
			'Type' => 'image',
			'Sql' => array('text',''),
			'Cfg' => array(
				'alt' => array(
					'Name' => 'alt',
					'Type' => 'text',
					// 'Lang' => 1,
                ),
				'title' => array(
					'Name' => 'title',
					'Type' => 'text',
					// 'Lang' => 1,
				)
            ),
		),
	),
);
return $db_config;
?>