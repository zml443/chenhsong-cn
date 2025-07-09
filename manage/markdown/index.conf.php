<?php
$db_config = array(
	'dbc' => array(
		'Language' => 1,
		'Name' => array(
            'Type' => 'text',
            'Sql'  => array('varchar(255)', ''),
        ),
		'PermitType'  => array(
            'Type' => 'checkbox',
            'Sql'  => array('varchar(30)', 'md'),
            'Args' => array(
            	'all' => '公开访问',
            	'manage' => '管理员访问',
            	'member' => '会员访问'
            ),
        ),
		'Type'  => array(
            'Type' => 'radio',
            'Sql'  => array('varchar(25)', 'md'),
            'Args' => array(
            	'md' => 'Md 文件',
            	'html' => 'Html 文件'
            ),
        ),
		'Files'  => array(
            'Type' => 'text',
			'Type' => '/manage/markdown/index/_tool_parameter',
            'Sql'  => array('varchar(255)', ''),
        ),
		'Data'  => array(
            'Sql'  => array('text', ''),
        ),
		'UId' => array(
		    'Name' => '类别',
		    'Type' => 'uid',
		    'Field' => array(
		        'UId' => array('Sql'=>array('varchar(100)', '0,')),
		        'Dept' => array('Sql'=>array('tinyint(1)', 1))
		    ),
		    'Dept' => 0,
			'EditHide' => 1,
			'AddHide' => 1,
		),
	)
);
return $db_config;
?>