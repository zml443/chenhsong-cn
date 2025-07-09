<?php
$db_config = array(
	'dbc' => array(
		'Language' => array(
			'Type' => 'language',
			'Sql' => array('varchar(10)'),
			'Group' => 0
		),
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)', ''),
			'Group' => 0
		),
        'Data' => array(
			'Type' => '/manage/hotel/search_where/_tool_parameter',
			// 'Sql' => array('TEXT', ''),
			'Group' => language('{/dbs.group.Filter/}'),
		),
        '关联其他表' => array(
            'Table' => array('hotel/search_where_extid'),
			'IsExtId' => 1,
        ),
	),
);
return $db_config;
?>