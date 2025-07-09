<?php
$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(100)', ''),
			'Search' => 1,
		),
		'UId' => array(
		    // 'Name' => '类别',
		    'Type' => 'uid',
		    'Field' => array(
		        'UId' => array('Sql'=>array('varchar(100)', '0,')),
		        'Dept' => array('Sql'=>array('tinyint(1)', 1))
		    ),
		    'Dept' => 1,
		),
	)
);
return $db_config;
?>