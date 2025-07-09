<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
            'Lang' => 1,
            'List' => '名称',
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
            'Lang' => 1,
		),
		'Data' => array(
            'Name' => '优势',
            'Tip' => '一张图片，推荐尺寸控制在 150*150 像素',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'title' => array(
					'Name' => '标题',
					'Type' => 'textarea',
					'Lang' => 1,
				),
				'pic' => array(
					'Name' => '图片',
					'Type' => 'img',
				),
			),
			'Add' => 1,
            'Count' => 5
		),
	)
);
return $db_config;
?>