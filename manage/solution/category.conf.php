<?php
return array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(100)', ''),
			'Lang' => 1,
		),
		/*'PageUrl' => array(
			'Cfg' => array(
				'Dir' => '/',
				'Ext' => '/'
			)
		),*/
		'UId' => array(
		    // 'Name' => '类别',
		    'Type' => 'uid',
		    'Field' => array(
		        'UId' => array('Sql'=>array('varchar(100)', '0,')),
		        'Dept' => array('Sql'=>array('tinyint(1)', 1))
		    ),
		    'Dept' => 1,
		),
		'Seo' => 1,
	)
);