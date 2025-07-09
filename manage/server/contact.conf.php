<?php
$db_config = array(
    'dbc' => array(
        'Name' => array(
            'Type' => 'text',
            'Sql' => array('varchar(500)', ''),
            'Lang' => 1,
            'NotNull' => 1,
            'Group' => '服务易',
        ),
        'Phone' => array(
            'Name' => '服务热线',
            'Type' => 'text',
            'Sql' => array('varchar(100)', ''),
            'Lang' => 1,
            'NotNull' => 1,
            'Group' => '服务易',
        ),
        'BriefDescription' => array(
            'Type' => 'textarea',
            'Sql' => array('text', ''),
            'Lang' => 1,
            'Group' => '服务易',
        ),
        'Picture' => array(
            'Name' => '图片',
			'Type' => 'image',
            'Tip' => '推荐尺寸为 378*608 像素',
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
            'Group' => '服务易',
		),

        'Name2' => array(
            'Name' => '标题',
            'Type' => 'text',
            'Sql' => array('varchar(100)', ''),
            'Lang' => 1,
            'NotNull' => 1,
            'Group' => '服务理念',
        ),
        'BriefDescription2' => array(
            'Name' => '简介',
            'Type' => 'textarea',
            'Sql' => array('text', ''),
            'Lang' => 1,
            'Group' => '服务理念',
        ),
        'Data' => array(
            'Name' => '核心价值',
			'Tip' => '一张图片，推荐尺寸控制在 66*66 像素',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'icon' => array(
					'Name' => '图标',
					'Type' => 'img',
				),
				'name' => array(
					'Name' => '文本',
					'Type' => 'text',
                    'Lang' => 1,
				),
				'brief' => array(
					'Name' => '文本2',
					'Type' => 'text',
                    'Lang' => 1,
				),
			),
			'Add' => 1,
			'Count' => 4,
            'Group' => '服务理念',
		),

        'Name3' => array(
            'Name' => '标题',
            'Type' => 'text',
            'Sql' => array('varchar(100)', ''),
            'Lang' => 1,
            'NotNull' => 1,
            'Group' => '服务时效',
        ),
        'Data2' => array(
            'Name' => '核心价值',
			'Tip' => '一张图片，推荐尺寸控制在 66*66 像素，简介的橙色字体用span标签包住',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
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
			'Count' => 3,
            'Group' => '服务时效',
		),
        'Pictures' => array(
            'Name' => '图片',
			'Type' => 'image',
            'Tip' => '推荐尺寸为 1600*640 像素',
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
            'Group' => '服务时效',
		),
    ),
);
return $db_config;
?>