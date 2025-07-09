<?php
$db_config = array(
    'dbc' => array(
        'Name' => array(
            'Type' => 'text',
            'Sql' => array('varchar(100)', ''),
            'Lang' => 1,
            'NotNull' => 1
        ),
        'BriefDescription' => array(
            'Tip' => '橙色字体用span标签包住',
            'Type' => 'textarea',
            'Sql' => array('text', ''),
            'Lang' => 1,
        ),
        'Data' => array(
            'Name' => '生产基地布局',
            'Tip' => '一张图片，推荐尺寸控制在 1600*550 像素，简介的橙色字体用span标签包住',
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
					'Type' => 'text',
                    'Lang' => 1,
				),
			),
			'Add' => 1,
		),
    ),
);
return $db_config;
?>