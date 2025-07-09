<?php
return array(
    'dbc' => array(
        'From' => array(
            'Name' => '来源页面',
            'Type' => 'text',
            'Sql' => array('varchar(200)', ''),
            'EditShow' => 1,
            'NotNull' => 1,
            'List' => "来源页面",
        ),
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
        // 'Company' => array(
        //     'Type' => 'text',
        //     'Sql' => array('varchar(200)', ''),
        //     'EditShow' => 1,
        // ),
        // 'Job' => array(
        //     'Type' => 'text',
        //     'Sql' => array('varchar(200)', ''),
        //     'EditShow' => 1,
        // ),
        // // 自定义表单的json数据
        // 'Other' => array(
        //     // 'Type' => 'var_dump',
        //     'Sql' => array('text', ''),
        //     'EditShow' => 1,
        // ),
        // 'Files' => array(
        //     'Type' => 'file',
        //     'Sql' => array('text',''),
        //     'EditShow' => 1,
        // ),
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
        'Ip' => array(
            'Name' => 'Ip',
            'Type' => 'ip',
            'Sql' => array('varchar(15)', ''),
            'EditShow' => 1,
        ),
        'IsRead' => 1,
    )
);