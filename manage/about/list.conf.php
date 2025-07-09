<?php

$db_config = array(
	'dbc' => array(
		'Year' => array(
            'Name' => '年份',
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
            'List' => '年份',
		),
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
            'Lang' => 1
		),
		'wb_director_id' => array(
			'Type' => 'bind-id',
			'Sql'   => array('int(11)','0'),
		),
        'Pictures' => array(
            'Name'=>'封面图',
			'Tip' => '一张图片，推荐尺寸控制在 376*282 像素',
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
	)
);
return $db_config;
?>