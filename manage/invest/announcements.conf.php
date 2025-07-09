<?php

$db_config = array(
	'dbc' => array(
		'Language' => 1,
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'List' => 'name',
		),
		'Attr' => array(
			'Tip' => '默认显示3条，没有勾选，默认按最新上传时间显示',
			'Type' => 'attr',
			'Args' => array(
				'IsHot'=> language('{/global.is_hot/}'),
				'IsSaleOut'=> '下架',
			),
			'List' => 1,
			'Search' => 1,
			'GroupRight' => 'attr',
		),
		'wb_year_id' => array(
			'Name' => '年份',
			'Type' => 'category',
			'Table'	=> 'invest/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'name',
			'Search' => 1,
			'NotNull' => 1,
		),
		'wb_type_id' => array(
			'Name' => '类型',
			'Type' => 'category',
			'Table'	=> 'invest/category2',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'name',
			'Search' => 1,
			'NotNull' => 1,
		),
        'AddTime' => array(
			'Type' => 'day',
			'Sql' => array('int(11)'),
		),
        'File' => array(
			'Name' => '文件',
			'Type' => 'image',
			'Sql' => array('text',''),
		),
	)
);
return $db_config;
?>