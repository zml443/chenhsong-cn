<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'Lang' => 1,
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
			'Lang' => 1
		),
		'Name2' => array(
			'Name' => '发展历程标题', 
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'Lang' => 1,
		),
		'BriefDescription2' => array(
			'Name' => '发展历程简介', 
			'Type' => 'textarea',
			'Sql' => array('text'),
			'Lang' => 1
		),
		'Name3' => array(
			'Name' => '荣誉资质标题', 
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'Lang' => 1,
		),

		'Pictures' => array(
			'Name' => '视频',
			'Tip' => '图片推荐尺寸为 1600*720 像素，图片在编辑里改',
			'Type' => 'image',
			'Sql' => array('text',''),
			'Lang' => 1,
			'Cfg' => array(
				'pic' => array(
					'Name' => '背景图',
					'Type' => 'img',
                ),
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
        'Data' => array(
            'Name' => '数据',
			'Tip' => '一张图片，推荐尺寸为 40*40 像素',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'icon' => array(
					'Name' => '图标',
					'Type' => 'img',
				),
				'unit' => array(
					'Name' => '数值',
					'Type' => 'unit',
                    'Lang' => 1,
				),
				'name' => array(
					'Name' => '文本',
					'Type' => 'text',
                    'Lang' => 1,
				),
			),
			'Add' => 1,
            'Count' => 5
		),
	),
);
return $db_config;
?>