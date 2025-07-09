<?php
$db_config = array(
    'dbc' => array(
        'Name' => array(
            'Type' => 'text',
            'Sql' => array('varchar(200)', ''),
        ),
        'Phone' => array(
            'Type' => 'text',
            'Sql' => array('varchar(20)', ''),
            'EditShow' => 1,
        ),
        'Email' => array(
            'Type' => 'text',
            'Sql' => array('varchar(200)', ''),
            'EditShow' => 1,
        ),
        'Message' => array(
            'Type' => 'textarea',
            'Sql' => array('text', ''),
            'EditShow' => 1,
        ),
        'Ip' => array(
            'Name' => 'Ip',
            'Type' => 'ip',
            'Sql' => array('varchar(15)', '')
        ),
        'IsRead' => array(
            'Sql' => array('tinyint(1)', '0')
        ),
    )
);
return $db_config;
?>