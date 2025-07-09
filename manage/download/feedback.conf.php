<?php
return array(
    'dbc' => array(
        'Name' => array(
            'Type' => 'text',
            'Sql' => array('varchar(200)', ''),
            'EditShow' => 1,
            'NotNull' => 1,
        ),
        'Phone' => array(
            'Type' => 'text',
            'Sql' => array('varchar(200)', ''),
            'EditShow' => 1,
        ),
        'Country' => array(
            'Name' => '国家/地区',
            'Type' => 'text',
            'Sql' => array('varchar(200)', ''),
            'EditShow' => 1,
        ),
        'Email' => array(
            'Type' => 'text',
            'Sql' => array('varchar(200)', ''),
            'EditShow' => 1,
        ),
        'Address' => array(
            'Name' => '所在城市',
            'Type' => 'text',
            'Sql' => array('varchar(200)', ''),
            'EditShow' => 1,
        ),
        'Areas' => array(
            'Name' => '关注领域',
            'Type' => 'text',
            'Sql' => array('varchar(200)', ''),
            'EditShow' => 1,
        ),
        'Message' => array(
            'Type' => 'textarea',
            'Sql' => array('text', ''),
            'EditShow' => 1,
        ),
        'AddTime' => array(
            'Type' => 'day',
            'Sql' => array('int(11)', '0'),
            'EditShow' => 1,
        ),
        
		'wb_download_id' => array(
			'Name' => '咨询文件',
			'Type' => 'bind',
			'Sql' => array('text',''),
			'Table' => array('blog/download'),
			'Cfg' => array(
				'ma' => "blog/download",
				'name' => 'Name',
			),
            'Group' => '关联',
		),

        'Ip' => array(
            'Name' => 'Ip',
            'Type' => 'ip',
            'Sql' => array('varchar(15)', ''),
            'EditShow' => 1,
        ),
        'IsRead' => 1,
    )
);