<?php

$db_config = array(
	'dbc' => array(
		// 'Language' => 1,
		'Name' => array(
			'Name' => '伙伴名称',
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'List' => 'name',
		),
		'wb_partner_category_id' => array(
			'Name' => '类别',
			'Type' => 'category',
			'Table'	=> 'partner/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'name',
		),
		'Logo' => array(
			'Name' => '伙伴商标',
			'Type' => 'img',
			'Sql' => array('varchar(255)'),
			'List' => 1,
		),
		/*'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
		),*/
	)
);
return $db_config;
?>