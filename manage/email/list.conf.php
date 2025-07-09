<?php
$db_config = array(
    'dbc' => array(
        'Name' => array(
            'Type' => 'text',
            'Sql' => array('varchar(200)',''),
            'Lang' => 1,
            'NotNull' => 1,
        ),
        'Open' => array(
            'Type' => 'open',
            'Sql' => array('int(1)',''),
        ),
        'Type' => array(
            'Type' => 'select',
            'Sql' => array('varchar(80)',''),
            'Args' => array(
                'orders' => '订单',
                'member' => '会员',
                'website' => '商家',
            ),
            'NotNull' => 1,
            'EditHide' => 1,
        ),
        'Body' => array(
            'Type' => 'my_editor',
            'Sql'  => array('text'),
            'Lang' => 1,
            'NotNull' => 1,
        ),
    ),
    // 
    'list' => array(
        // 'type' => 'email_list',
        'layout' => array(
            'Name' => 1,
            'Open' => 1
        ),
    ),
);
return $db_config;
?>