<?php

$db_config = array(
	'open_copy' => 0, //开启草稿功能
	'dbc' => array(
		'Language' => 1,
		'IsUnpublished' => 0,
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'List' => 'name',
		),
		'BriefDescription' => array(
            'Name' => '核心价值',
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
		'Point' => array(
            'Name' => '技术特点',
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
		'wb_automation_category_id' => array(
			'Name' => '类别',
			'Type' => 'category',
			'Table'	=> 'factory/category',
			'Sql' => array('int(11)', ''),
			'List' => 'name',
			'Search' => 1,
			'GroupRight' => 'category',
		),
		'Picture' => array(
			'Name' => '封面图',
			'Tip' => '建议尺寸为 800*500 像素',
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
				),
			),
		),
	)
);
return $db_config;
?>