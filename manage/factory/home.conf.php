<?php

$db_config = array(
	'dbc' => array(
		'Pictures' => array(
			'Name' => '智慧工程',
			'Tip' => '一张图片，推荐尺寸为 1400*522 像素',
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
		'Pictures2' => array(
			// 'Name' => 'MegaCloud平台',
			'Name' => 'iChen Cloud 震雄智云',
			'Tip' => '一张图片，推荐尺寸为 1400*522 像素',
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
		'Pictures3' => array(
			'Name' => '模具与产品',
			'Tip' => '一张图片，推荐尺寸为 1400*522 像素',
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
		'Pictures4' => array(
			'Name' => '自动化',
			'Tip' => '一张图片，推荐尺寸为 1400*522 像素',
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
	),
);
return $db_config;
?>