<?php
$db_config = array(
	'dbc' =>  array(
		'Name' => array(
			'Type' => 'text',
			'Sql'  => array('varchar(200)', ''),
			'Lang' => 1
		),
		'Url' => array(
			'Type' => 'page',
			'Sql'  => array('varchar(200)', ''),
			'Field' => array(
				'page_url_type' => array('Sql'=>array('varchar(50)', '')),
			),
		),
		'UId' => array(
	        'Type' => 'uid',
	        'Field'=> array(
	            // 固定字段
	            'UId' => array('Sql'=>array('varchar(100)', '0,')),
	            'Dept' => array('Sql'=>array('tinyint(1)', 1))
	        ),
	        'Dept' => 2,
		),
		'Target' => array(
			'Type' => 'target',
			'Sql' => array('varchar(20)', '_top'),
		),
	),
);
return $db_config;
?>