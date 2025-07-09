<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
            'Lang' => 1,
            'Group' => '团队介绍',
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
            'Lang' => 1,
            'Group' => '团队介绍',
		),
		'Name2' => array(
            'Name' => '标题',
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
            'Lang' => 1,
            'Group' => '服务项目',
		),
		'Data' => array(
            'Name' => '服务项目',
            'Tip' => '一张图标，推荐尺寸控制在 30*30 像素',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'icon' => array(
					'Name' => '图标',
					'Type' => 'img',
				),
				'title' => array(
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
            'Count' => 6,
            'Group' => '服务项目',
		),
        'Picture' => array(
            'Name' => '服务项目移动端图片',
			'Type' => 'image',
            'Tip' => '推荐尺寸为 690*auto 像素',
			'Sql' => array('text',''),
            'Lang' => 1,
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
            'Group' => '服务项目',
		),
        
		'Data2' => array(
            'Name' => '服务案例',
            'Tip' => '一张图片，推荐尺寸控制在 1280*680 像素',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'pic' => array(
					'Name' => '图片',
					'Type' => 'img',
				),
				'title' => array(
					'Name' => '标题',
					'Type' => 'text',
                    'Lang' => 1,
				),
				'brief' => array(
					'Name' => '介绍',
					'Type' => 'textarea',
                    'Lang' => 1,
				),
				'url' => array(
					'Name' => '链接',
					'Type' => 'text',
				),
			),
			'Add' => 1,
            'Group' => '服务案例',
		),

        'Data3' => array(
            'Name' => '服务流程',
            'Tip' => '一张图标，推荐尺寸控制在 180*180 像素',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'icon' => array(
					'Name' => '图标',
					'Type' => 'img',
				),
				'title' => array(
					'Name' => '标题',
					'Type' => 'text',
                    'Lang' => 1,
				),
			),
			'Add' => 1,
            'Count' => 6,
            'Group' => '服务流程',
		),
        'Pictures' => array(
            'Name' => '服务流程移动端图片',
			'Type' => 'image',
            'Tip' => '推荐尺寸为 690*auto 像素',
			'Sql' => array('text',''),
            'Lang' => 1,
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
            'Group' => '服务流程',
		),
	)
);
return $db_config;
?>