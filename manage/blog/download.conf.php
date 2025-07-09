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
		'wb_products_category_id' => array(
			'Name' => '类别',
			'Type' => 'category',
			'Table'	=> 'products/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'name',
			'Search' => 1,
		),
		'Pictures' => array(
			'Name' => '封面图',
			'Tip' => '建议尺寸为 317*340 像素',
			'Type' => 'image',
			'Sql' => array('text',''),
			'Cfg' => array(
				'alt' => array(
					'Name' => 'alt',
					'Type' => 'text',
                ),
				'title' => array(
					'Name' => 'title',
					'Type' => 'text',
				)
            ),
		),
		'Files' => array(
			'Type' => 'file',
			'Sql' => array('text'),
		),
	)
);
return $db_config;
?>