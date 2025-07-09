<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
            'Lang' => 1,
		),
		'Pictures' => array(
			'Name' => 'logo',
            'Tip' => '一张图片，推荐尺寸为 250*160 像素，链接在编辑里修改',
			'Type' => 'image',
			'Sql' => array('text',''),
			'Cfg' => array(
				'url' => array(
					'Name' => '链接',
					'Type' => 'text',
				),
				'alt' => array(
					'Name' => 'alt',
					'Type' => 'text',
					'Lang' => 1
				),
				'title' => array(
					'Name' => 'title',
					'Type' => 'text',
					'Lang' => 1
				)
			),
			'Group' => '图片',
		),
	)
);
return $db_config;
?>