<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'Lang' => 1,
		),
		'Brief' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
			'Lang' => 1
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
			'Lang' => 1
		),
		'Pictures' => array(
			'Name' => '图片',
			'Tip' => '一张图片，推荐尺寸为 1600*600 像素',
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
		'Pictures2' => array(
			'Name' => '图片',
			'Tip' => '展示在相关模块，一张图片，推荐尺寸为 505*300 像素',
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
        'Data' => array(
            'Name' => '数据',
			'Tip' => '只允许最后一个技术展示此模块；一张图片，推荐尺寸为 40*40 像素',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'title' => array(
					'Name' => '标题',
					'Type' => 'text',
                    'Lang' => 1,
				),
                'name' => array(
					'Name' => '小标题1',
					'Type' => 'text',
                    'Lang' => 1,
				),
                'brief' => array(
					'Name' => '介绍1',
					'Type' => 'textarea',
                    'Lang' => 1,
				),
                'name2' => array(
					'Name' => '小标题2',
					'Type' => 'text',
                    'Lang' => 1,
				),
                'brief2' => array(
					'Name' => '介绍2',
					'Type' => 'textarea',
                    'Lang' => 1,
				),
                'name3' => array(
					'Name' => '小标题3',
					'Type' => 'text',
                    'Lang' => 1,
				),
                'brief3' => array(
					'Name' => '介绍3',
					'Type' => 'textarea',
                    'Lang' => 1,
				),
			),
			'Add' => 1,
            'Count' => 4
		),
	),
);
return $db_config;
?>