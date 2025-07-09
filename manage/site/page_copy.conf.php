<?php
$db_config = array(
	'dbc' =>  array(
		// 数据锁定
		'IsLock' => 1,
		'NotSeo' => 1,
		'wb_site_web_id' => array(
			'Sql' => array('int(11)', '0')
		),
	    'wb_site_page_data_id' => array(
	        'Sql' => array('int(11)', '0'),
	    ),
		// 
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)', ''),
			'Lang' => 1
		),
		'HeaderOpacity' => array(
			'Sql' => array('varchar(30)', ''),
		),
		'Number' => array(
			// 'Type' => 'text',
			'Sql' => array('varchar(50)', ''),
		),
		'Type' => array(
			// 'Type' => 'text',
			'Sql' => array('varchar(50)', ''),
		),
		'Style' => array(
			// 'Type' => 'text',
			'Sql' => array('varchar(50)', '', '页面风格，如：简约，经典'),
		),
		'Width' => array(
			// 'Type' => 'text',
			'Sql' => array('varchar(20)', ''),
		),
		'HaveHeader' => array(
			'Sql' => array('int(1)', '1'),
		),
		'HaveFooter' => array(
			'Sql' => array('int(1)', '1'),
		),
		'HaveLefter' => array(
			// 'Type' => 'text',
			'Sql' => array('int(1)', '1'),
		),
		'HaveRighter' => array(
			'Sql' => array('int(1)', '1'),
		),
		'Tag' => array(
			// 'Type' => 'text',
			'Sql' => array('varchar(20)', ''),
		),
		'Picture' => array(
			'Sql' => array('varchar(200)', ''),
		),
		'PictureMobile' => array(
			'Sql' => array('varchar(200)', ''),
		),
		'Seo' => 1,
		'Editor' => array(
			'Name' => '页面内容',
			'Type' => 'editor',
			'Lang' => 1
		),
	    'UId' => array(
	        // 'Type' => 'uid',
	        'Sql' => array('varchar(100)', '0,'),
	        'Field' => array(
	            'Dept' => array('Sql' => array('tinyint(1)', 1))
	        ),
	        'Dept' => 1,
	    ),
	    '关联表' => array(
	    	'Table' => array('site/page_module_copy', 'site/page_module_children_copy'),
	    	'ExtId' => 1,
	    )
	),
);
return $db_config;
?>