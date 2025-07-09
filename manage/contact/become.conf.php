<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
            'Lang' => 1
		),  
        'Pictures' => array(
			'Name' => '背景图',
			'Tip' => '一张图，推荐尺寸为 1600*550 像素',
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
				)
            ),
		),
        'Data' => array(
            'Name' => '成为我们',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'txt' => array(
					'Name' => '标题',
					'Type' => 'text',
                    'Lang' => 1,
				),
				'txt2' => array(
					'Name' => '姓名',
					'Type' => 'text',
				),
				'txt3' => array(
					'Name' => '姓名(英文)',
					'Type' => 'text',
				),
				'txt4' => array(
					'Name' => '英文',
					'Type' => 'text',
				),
				'phone' => array(
					'Name' => '电话',
					'Type' => 'text',
					'Lang' => 1
				),
				'email' => array(
					'Name' => '邮箱',
					'Type' => 'text',
				),
			),
			'Add' => 1,
            'Count' => 3
		),
	)
);
return $db_config;
?>