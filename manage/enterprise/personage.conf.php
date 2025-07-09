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
		'wb_enterprise_category_id' => array(
			'Name' => language('{/form.department/}'),
			'Type' => 'category',
			'Table'	=> 'enterprise/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'name',
		),
		'Seo' => 1,
		'AssociationJob' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'List' => 1,
		),
		'Company' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'List' => 1,
		),
		'CompanyJob' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'List' => 1,
		),
		'Pictures' => array(
			'Type' => 'image',
			'Sql' => array('text'),
			'List' => 1,
		),
		'Detail' => array(
			'Type' => 'editor_open',
			'Field' => array(
				'DetailType' => array('Sql'=>array('varchar(50)', 'content')),
				'DetailUrl' => array('Sql'=>array('varchar(255)', '')),
			),
		),
	)
);
return $db_config;
?>