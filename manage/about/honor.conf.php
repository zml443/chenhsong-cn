<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
			'NotNull' => 1,
			'Lang' => 1,
		),
		'wb_year_id' => array(
			'Name' => '年份区间',
			'Type' => 'category',
			'Table'	=> 'about/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'name',
			'Search' => 1,
			'NotNull' => 1,
		),
		'Pictures' => array(
			'Tip' => '一张图片，推荐尺寸控制在 417*427 像素内',
			'Type' => 'image',
			'Sql' => array('text',''),
			'Cfg' => array(
				'alt' => array(
					'Name' => 'alt',
					'Type' => 'text',
					'Lang' => 1,
                ),
				'title' => array(
					'Name' => 'title',
					'Type' => 'text',
					'Lang' => 1,
				)
            ),
		),
	),
);
return $db_config;
?>