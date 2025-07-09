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
        'Url'=> array(
            'Name' => '外链',
			'Type' => 'text',
			'Sql' => array('text'),
			'Lang' => 1
		),
		'Picture' => array(
			'Name' => 'logo',
			'Tip' => '图片推荐尺寸为 291*144 像素',
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
		'Pictures' => array(
			'Name' => '背景图',
			'Tip' => '图一为PC端，推荐尺寸为 1920*960 像素，图二为移动端，推荐尺寸为 750*auto 像素',
			'Type' => 'image',
			'Sql' => array('text',''),
		),
	),
);
return $db_config;
?>