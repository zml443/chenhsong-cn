<?php
$db_config = array(
    'dbc' => array(
        'Subject' => array(
            'Type' => 'text',
        ),
        'Email' => array(
            'Name' => '{/email.to_email/}',
            'Type' => 'get_email',
            'WH'   => array(900,0),
            // 'Url'  => array('m=member&a=index&d=get_email', 'm=email&a=newsletter&d=get_email')
            'Cfg'  => array(
                array(
                    'Name' => '会员邮箱',
                    'Url' => 'm=member&a=index&t=email'
                ),
                array(
                    'Name' => '订阅邮箱',
                    'Url' => 'm=email&a=newsletter&t=email'
                ),
            )
        ),
        'Body' => array(
            'Type' => 'my_editor',
        ),
        '其他表' => array(
            'Table'=> array('email/log', 'email/newsletter')
        ),
    )
);
return $db_config;
?>