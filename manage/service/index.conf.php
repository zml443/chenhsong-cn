<?php
$db_config = array(
    'dbc' => array(
        'Language' => 1,
        'Name' => array(
            'Type' => 'text',
            'Sql' => array('varchar(100)', ''),
            'NotNull' => 1
        ),
        'Number' => array(
            'Name' => '号码/账号/链接',
            'Type' => 'text',
            'Sql' => array('varchar(255)', ''),
        ),
        'Type' => array(
            'Name' => '类型',
            'Type' => 'radio',
            'Sql' => array('varchar(50)', ''),
            'Args' => array(
                'qq' => 'QQ',
                'tel' => '手机号',
                'skype' => 'skype',
                'facebook' => 'facebook',
                'consult' => '第三方咨询链接',
                'wechat' => '微信',
                'fax' => '传真',
                'qrcode' => '二维码',
                'link' => '链接',
            ),
        ),
        'IsOpen' => array(
            'Name' => '展示',
            'Type' => 'open',
            'Sql' => array('int(1)', '1'),
        ),
        'IsPopup' => array(
            'Name' => '弹窗打开',
            'Tip' => '仅限 “第三方咨询链接” 有作用',
            'Type' => 'open',
            'Sql' => array('int(1)', '0'),
        ),
        'Picture' => array(
            'Name' => '图片',
            'Tip' => '普通二维码，微信二维码图片',
            'Type' => 'img',
            'Sql' => array('varchar(255)', ''),
            'List' => 0
        ),
    )
);
return $db_config;
?>