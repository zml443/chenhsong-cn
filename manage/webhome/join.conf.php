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
			'Type' => 'text',
			'Sql' => array('text'),
            'Lang' => 1,
		),
        'Data' => array(
			'Type' => 'json',
            'Tip'  => '一张图片，推荐尺寸 25*25 像素',
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
			),
			'Add' => 1,
            'Count' => 3
		),
	)
);
return $db_config;
?>