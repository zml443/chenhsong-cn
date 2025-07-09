<?php
return array(
	'dbc' => array(
	    'Name' => array(
	        'Type' => 'text',
	        'Sql' => array('varchar(200)'),
	        'Lang' => 1
	    ),
	    'UId' => array(
	        'Type' => 'uid',
	        'Sql' => array('varchar(100)', '0,'),
	        'Field' => array(
	            'Dept' => array('Sql' => array('tinyint(1)', 1))
	        ),
	        'Dept' => 1,
	    ),
		'Seo' => 1
	)
);