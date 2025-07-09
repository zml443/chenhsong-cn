<?php
$db_config = array(
    'add_to_edit' => 1,
    'edit_head' => array('IsLoginLock'=>1, 'Password'=>1, 'Delete'=>1),
    'dbc' => array(
        'UserName' => array(
            'Type' => 'text',
            'AddSave' => 1,
            'Search' => '%',
        ),
        'FirstName' => array(
            'Type' => 'first_name',
            'Field' => array(
                'FirstName' => array('Sql'=>array('varchar(50)','')),
                'LastName' => array('Sql'=>array('varchar(50)','')),
            ),
            'List' => 1
        ),
        'Status' => array(
            'Type' => 'Radio',
            'Args' => array(
                'examine' => language('{/global.examine/}'),
                'success' => language('{/global.success/}'),
                'fail' => language('{/global.fail/}')
            ),
            'Sql' => array('varchar(20)', 'examine'),
        ),
        'IsManually' => array(
            'Sql' => array('int(1)','0'),
            'AddSave' => 1
        ),
        'Password' => array(
            'Type'   => 'Password',
            'Sql'    => array('varchar(32)', ''),
        ),
        'IsLoginLock' => array(
            'Sql' => array('varchar(2)', '0'),
        ),
        'qq_openid' => array(
            'Sql'  => array('varchar(100)',''),
        ),
        'wechat_unionid' => array(
            'Sql'  => array('varchar(100)',''),
        ),
        'wechat_openid' => array(
            'Sql' => array('varchar(100)',''),
        ),
        'wb_member_id' => array(
            'Type' => 'bind-id',
            'ListType' => '/manage/member/index/_list_children', //指定列表用自定义组件
            'Sql' => array('int(11)','0'),
            'List' => 1,
        ),
        'UId' => array(
            'AddHide' => 1,
            'EditHide' => 1,
        ),
        'Email' => array(
            'Type' => 'text',
            'Sql' => array('varchar(150)'),
            'List' => 1,
        ),
        'Mobile' => array(
            'Type' => 'text',
            'Sql' => array('varchar(15)'),
            'List' => 1,
        ),
        'Level' => array(
            'Type' => 'select',
            'Args' => m('wb_member.level'),
            'Sql' => array('int(1)', 0),
        ),
        'Face' => array(
            'Type' => 'img',
            'Sql' => array('varchar(255)', ''),
        ),
        'Gender' => array(
            'Type' => 'Radio',
            'Args' => array(
                'A' => language('{/member.Ss/}'),
                'B' => language('{/member.Sir/}'), //boy
                'G' => language('{/member.Ms/}') //girl
            ),
            'Sql' => array('varchar(1)', 'A'),
        ),
        'Fax' => array(
            'Type' => 'text',
            'Sql'  => array('varchar(80)', ''),
        ),
        'Postcode' => array(
            'Type' => 'text',
            'Sql'  => array('varchar(80)', ''),
        ),
        'Integral' => array(
            'Type' => 'number',
            'Sql'  => array('numeric(10,2)', '0'),
        ),
        'WalletPrice' => array(
            // 'Name' => '{/member.wallet_price/}',
            'Type' => 'price',
            'Sql'  => array('numeric(10,2)', '0'),
            'EditHide' => 1,
            'AddHide' => 1,
            'NotSave' => 1,
            'List' => 1,
        ),
        'Brief'  => array(
            'Type' => 'textarea',
            'Sql'  => array('varchar(500)', ''),
        ),
        // 邮箱验证是否通过验证
        'VerificationEmail' => array(
            // 'Type' => 'open',
            'Sql' => array('int(1)', '0'),
            // 'GroupRight' => '属性',
        ),
        // 注册码，邮箱可用
        'RegisterCode' => array(
            'Sql' => array('varchar(32)'),
        ),
        'AddTime' => array(
            'Name' => language('{/member.register_time/}'),
            'Type' => 'DayTime',
            'EditHide' => 1,
            'AddHide' => 1,
            'List' => 1,
        ),
        'LastLoginIp' => array(
            'Sql'  => array('varchar(15)', ''),
        ),
        'LastLoginTime' => array(
            'Sql'  => array('int(11)', 0),
        ),
        // 登录次数
        'data_number_login' => array(
            'Sql'  => array('int(11)', 0),
        ),
        '关联表' => array(
            'Table' => array(
                'member/address',
                'member/message',
                'member/log',
            ),
        ),
    ),
);
if ($_GET['wb_member_id']) {
    $db_config['edit_url'] = '?ma=member/index&d=edit';
}
return $db_config;
?>