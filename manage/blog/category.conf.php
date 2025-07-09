<?php
$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(100)', ''),
			'Lang' => 1,
		),
		// 'PageUrl' => array(
		// 	'Type' => 'pageurl',
		// 	'Tip' => language('{/notes.custom_url/}'),
		// 	'Sql' => array('varchar(200)', ''),
		// ),
		'pc' => array(
            'Name' => 'Pc',
            'Type' => 'image',
            'Tip'  => '一张图片, 1920 * 720 像素,文字在编辑里修改',
			'Sql' => array('text', ''),
            'Cfg'  => array(
                'alt' => array(
                    'Name' => 'alt',
                    'Type' => 'text',
					'Lang' => 1,
                ),
                'title' => array(
                    'Name' => 'title',
                    'Type' => 'text',
					'Lang' => 1,
                ),
            ),
			'Group' => '广告图',
        ),
        // 手机版
        'mobile' => array(
            'Name' => '手机',
            'Type' => 'image',
            'Tip'  => '一张图片, 750 * 720 像素,文字在编辑里修改',
			'Sql' => array('text', ''),
            'Cfg'  => array(
                'alt' => array(
                    'Name' => 'alt',
                    'Type' => 'text',
					'Lang' => 1,
                ),
                'title' => array(
                    'Name' => 'title',
                    'Type' => 'text',
					'Lang' => 1,
                ),
            ),
			'Group' => '广告图',
        ),
		'UId' => array(
		    // 'Name' => '类别',
		    'Type' => 'uid',
		    'Field' => array(
		        'UId' => array('Sql'=>array('varchar(100)', '0,')),
		        'Dept' => array('Sql'=>array('tinyint(1)', 1))
		    ),
		    'Dept' => 1,
		),
		'Seo' => 1,
	)
);
return $db_config;
?>