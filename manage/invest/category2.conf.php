<?php
$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(100)', ''),
			'Lang' => 1,
		),
		'Tip' => array(
			'Name' => '灰色字',
			'Type' => 'text',
			'Sql' => array('varchar(250)', ''),
			'Lang' => 1,
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

		'Pictures2' => array(
			'Name' => '图标',
			'Tip' => '建议尺寸控制在 80*80 像素，图一为默认状态，图二为鼠标移入状态',
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
	)
);
return $db_config;
?>