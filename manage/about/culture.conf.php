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
		'Pictures' => array(
			'Name' => '背景图',
			'Tip' => '图一为PC端，推荐尺寸为 1920*900 像素，图二为移动端，推荐尺寸为 750*900 像素',
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
            'Name' => '文化',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'name' => array(
					'Name' => '文本',
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
            'Count' => 4
		),
	),
);
return $db_config;
?>