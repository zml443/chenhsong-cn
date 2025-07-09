<?php
$db_config = array(
    'dbc' => array(
        /*'Name' => array(
            'Type' => 'text',
            'Sql' => array('varchar(200)', ''),
            'EditShow' => 1,
        ),*/
        'wb_member_id' => array(
            'Name' => '会员',
            'Type' => 'member',
            'Sql' => array('int(11)', '0'),
            'EditShow' => 1,
        ),
        'session_id' => array(
            'Sql' => array('varchar(32)', ''),
        ),
        'wb_manage_id' => 1,
        'wb_feedback_work_id' => array(
            'Sql' => array('int(11)', '0'),
            'IsSearchId' => 1
        ),
        'UId' => array(
            'Dept' => 0,
            'EditHide' => 1,
            'AddHide' => 1,
        ),
        'Star' => array(
            'Type' => 'star',
            'Sql' => array('numeric(3,1)', '10.0'),
            'EditShow' => 1
        ),
        'Message' => array(
            'Type' => 'textarea',
            'Sql' => array('text', ''),
            'EditShow' => 1,
        ),
        'IsHasPictures' => array(
            'Sql' => array('tinyint(1)', 0),
        ),
        'Pictures' => array(
            'Name' => '图片集',
            'Type' => 'image',
            'Sql' => array('text',''),
        ),
        'AddTime' => array(
            // 'Name' => 'Ip',
            'Type' => 'daytime',
            'Sql' => array('int(11)', 0),
            'EditShow' => 1,
        ),
        'Ip' => array(
            'Name' => 'Ip',
            'Type' => 'ip',
            'Sql' => array('varchar(15)', ''),
            'Field' => array(
                'IpInfo' => array('Sql'=>array('text',''))
            ),
        ),
        'IsShow' => array(
            'Sql' => array('tinyint(1)', 1)
        ),
        'IsRead' => array(
            'Sql' => array('tinyint(1)', '0')
        ),
        /*'Reply'  => array(
            'Type' => 'reply',
            'Field'=> array(
                'Reply' => array('Sql' => array('text','')),
                'ReplyOpen' => array('Sql' => array('int(1)', 0)),
            ),
        ),*/
        'data_number_ups' => array(
            'Sql' => array('int(11)', 0)
        ),
        'data_number_downs' => array(
            'Sql' => array('int(11)', 0)
        ),
    )
);
return $db_config;
?>