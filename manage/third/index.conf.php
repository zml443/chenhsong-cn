<?php
return array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql'  => array('varchar(90)')
		),
		'Type' => array(
			'Name' => language('{/panel.third_type/}'),
			'Type' => 'radio',//'select',
			'Sql'  => array('tinyint(1)', 0),
			'Args' => array(
				'0' => language('{/global.pc_mobile/}'),
				'1' => language('{/global.pc/}'),
				'2' => language('{/global.mobile/}'),
			),
			'List' => 1,
			'Search' => 1,
		),
		'IsOpen' => array(
			'Name' => language('{/global.used/}'),
			'Type' => 'open',
			'Sql'  => array('tinyint(1)', 0),
			'List' => 1,
		),
		'IsFooter' => array(
			'Name' => language('{/panel.third_is_footer/}'),
			'Type' => 'open',
			'Sql'  => array('tinyint(1)', 0),
			'List' => 1,
		),
		'Code' => array(
			'Name' => language('{/panel.third_code/}'),
			'Type' => 'textarea',
			'Sql'  => array('text'),
			'List' => 1,
		),
	),
);