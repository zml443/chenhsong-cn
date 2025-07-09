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
			'Tip' => '一张图片，推荐尺寸为 960*635 像素',
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
        
        'Name2' => array(
            'Name' => '标题',
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
            'Lang' => 1,
		),
		'SubName' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
		),
        'Data' => array(
            'Name' => '生产架构',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
                'name' => array(
					'Name' => '标题',
					'Type' => 'text',
                    'Lang' => 1,
				),
                'brief' => array(
					'Name' => '介绍',
					'Type' => 'textarea',
                    'Lang' => 1,
				),
			),
			'Add' => 1,
            'Count' => 2
		),
		'Picture' => array(
			'Name' => '生产架构图片',
			'Tip' => '一张图片，推荐尺寸为 822*552 像素',
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