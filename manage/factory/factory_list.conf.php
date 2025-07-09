<?php

$db_config = array(
	'dbc' => array(
		'Language' => 1,
		'Name' => array(
			'Type' => 'textarea',
			'Sql' => array('varchar(200)'),
			'NotNull' => 0,
            'List' => '名称',
		),
		'SubName' => array(
			'Type' => 'textarea',
			'Sql' => array('varchar(200)'),
			'NotNull' => 0,
            'List' => '名称',
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
        
		'Data' => array(
            'Name' => '优势',
            'Tip' => '一张图片，推荐尺寸控制在 40*40 像素',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'title' => array(
					'Name' => '标题',
					'Type' => 'text',
				),
				'pic' => array(
					'Name' => '图标',
					'Type' => 'img',
				),
			),
			'Add' => 1,
            'Count' => 11
		),

		'Picture' => array(
            'Name' => '封面图',
			'Type' => 'image',
            'Tip' => '推荐尺寸为 800*auto 像素',
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
            'Group' => '图片',
		),
	)
);
return $db_config;
?>