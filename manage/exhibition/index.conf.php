<?php

$db_config = array(
	'add_to_edit' => 1,
    /*'edit_head' => array(
    	'xxx' => array(
    		'name' => '产品类别',
    		'ico' => '',
    		'url' => href('app.exhibition.products_category', ''),
    	)
    ),*/
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'List' => 'name',
		),
		'PageUrl' => array(
			'Type' => 'pageurl',
			'Tip' => language('{/notes.custom_url/}'),
			'Sql' => array('varchar(200)', ''),
		),
		'编辑关联数据' => array(
			'Name' => language('{/dbs.field.wb_products_id/}'),
			'Type' => '/manage/exhibition/index/_tool_products',
			'Sql' => array('int(11)'),
			'AddHide' => 1
		),
		'AddTime' => array(
			'Type' => 'day',
			'Sql' => array('int(11)'),
		),
		'Address' => array(
			'Type' => 'text',
			'Sql' => array('varchar(250)'),
		),
		'data_number_views' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_views_day' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_views_week' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_views_month' => array(
			'Sql' => array('int(11)', 0)
		),
	)
);
return $db_config;
?>