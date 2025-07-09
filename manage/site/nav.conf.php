<?php
$db_config = array(
	'dbc' =>  array(
		'Name' => array(
			'Type' => 'text_language',
			'Sql' => array('varchar(200)', ''),
			'Lang' => 1,
			'NotNull' => 1
		),
		'Url' => array(
			'Type' => 'page',
			'Sql'  => array('varchar(200)', ''),
			'Field' => array(
				'page_url_type' => array('Sql'=>array('varchar(50)', '')),
			),
		),
		// 下拉风格
		'SubnavType' => array(
			'Sql'  => array('varchar(50)', ''),
		),
		// 图片
		'Pictures' => array(
			'Sql'  => array('text', ''),
			'List' => 0
		),
		'UId' => array(
	        'Type' => '/manage/site/nav/_tool_uid',
	        'Field'=> array(
	            // 固定字段
	            'UId' => array('Sql'=>array('varchar(100)', '0,')),
	            'Dept' => array('Sql'=>array('tinyint(1)', 1))
	        ),
	        'Dept' => 0,
		),
		'Target' => array(
	        // 'Type' => '/manage/site/nav/_tool_target',
	        'Type' => 'radio',
	        'Args' => array(
	        	'_top' => '当前窗口打开页面',
	        	'_blank' => '新窗口打开页面',
	        ),
			'Sql' => array('varchar(20)', '_top'),
		),
	),
);
return $db_config;
?>