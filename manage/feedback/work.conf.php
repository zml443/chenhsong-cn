<?php
$db_config = array(
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
        'Email' => array(
            'Type' => 'text',
            'Sql' => array('varchar(200)', ''),
            'EditShow' => 1,
        ),
        'Url' => array(
            'Name' => '参考链接',
            'Type' => 'text',
            'Sql' => array('varchar(200)', ''),
            'EditShow' => 1,
        ),
        'wb_member_id' => array(
            'Sql' => array('int(11)', '0'),
        ),
        'UId' => 1,
        'Status' => array(
            'Type' => 'radio',
            'Sql' => array('varchar(30)', ''),
            'Args' => array(
                'wait' => '待处理',
                'processing' => '处理中，客服接单',
                'finished' => '处理完成',
                'comment' => '服务评价',
                'end' => '已完成',
            ),
        ),
        'IsClose' => array(
            'Type' => 'open',
            'Sql' => array('int(1)', '0'),
        ),
        'Type' => array(
            'Type' => 'radio',
            'Sql' => array('varchar(30)', ''),
            'Args' => array(
                'fn' => '功能需求',
                'module' => '模块风格',
                'effect' => '交互效果',
                'experience' => '用户体验',
                'other' => '其它',
            ),
            'EditShow' => 1,
        ),
        '留言按钮' => array(
            'Name' => language('{/dbs.field.Comment/}'),
            'Type' => 'comment',
            'Cfg' => array(
                'Href' => '?ma=feedback/work_comment&wb_feedback_work_id={{id}}',
            ),
            'List' => array(
                'name' => ' ',
                'by' => 201,
                'class' => 'w_1',
            ),
            'AddHide' => 1,
        ),
        'Star' => array(
            'Type' => 'star',
            'Sql' => array('numeric(3,1)', '10.0'),
            'EditShow' => 1
        ),
        'Comment' => array(
            'Type' => 'textarea',
            'Sql' => array('text', ''),
            'EditShow' => 1,
        ),
        'Pictures' => array(
            'Name' => '图片集',
            'Type' => 'image',
            'Sql' => array('text',''),
            'EditShow' => 1,
        ),
        'Object' => array(
            'Name' => '主题',
            'Type' => 'textarea',
            'Sql' => array('varchar(500)', ''),
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
        'Ip' => array(
            'Name' => 'Ip',
            'Type' => 'ip',
            'Sql' => array('varchar(15)', ''),
            'EditShow' => 1,
        ),
        'data_number_views' => 1,
        'data_number_ups' => 1,
        'data_number_comment' => 1,
        '关联表' => array(
            'Table' => array('feedback/work_comment'),
        ),
    )
);
return $db_config;
?>