<?php

return array(
    'dbg' => array(
        // 基础信息
        'webname' => array(
            'Name' => language('{/panel.site_name/}'),
            // 'Name' => language('{/panel.logo_alt/}'),
            'Type' => 'text',
            'Group' => language('{/panel.basic_info/}'),
        ),
        'logo' => array(
            'Class'=> 'w2',
            'Name' => language('{/panel.logo/}'),
            'Type' => 'img',
            'Group' => language('{/panel.basic_info/}'),
        ),
        // 'logo-white' => array(
        //     'Class'=> 'w2',
        //     'Name' => language('{/panel.logo_white/}'),
        //     'Type' => 'img',
        //     'Group' => language('{/panel.basic_info/}'),
        // ),
        'ico' => array(
            'Name' => 'Ico',
            'Type' => 'img',
            'Group' => language('{/panel.basic_info/}'),
        ),
        'copyright' => array(
            'Name' => language('{/panel.copyright/}'),
            'Type' => 'text',
            'Lang' => 1,
            'Group' => language('{/panel.basic_info/}'),
        ),
        'icp' => array(
            'Name' => language('{/panel.icp/}'),
            'Type' => 'text',
            'Group' => language('{/panel.basic_info/}'),
        ),
        'beian' => array(
            'Name' => language('{/panel.beian/}'),
            'Type' => 'text',
            'Group' => language('{/panel.basic_info/}'),
        ),
        'beian_url' => array(
            'Name' => language('{/panel.beian_url/}'),
            'Type' => 'text',
            'Group' => language('{/panel.basic_info/}'),
        ),
        
        // 留言提醒邮箱
        // 'feedback_reminder_email' => array(
        //     // 'Name' => language('{/dbs.feedback_reminder_email/}'),
        //     'Type' => 'text',
        //     'Group' => language('{/panel.reminder_setting/}'),
        // ),

        // 网站设置
        'notcopy' => array(
            'Class'=> 'border_bottom flex-middle2 flex-between',
            'Name' => language('{/panel.cannot_copy/}'),
            'Tip'  => language('{/panel.cannot_copy_notes/}'),
            'Type' => 'open',
            'Group' => language('{/panel.site_info/}'),
        ),
        'LockChineseIp' => array(
            'Class'=> 'border_bottom flex-middle2 flex-between',
            'Name' => language('{/panel.shield_ip/}'),
            'Tip'  => language('{/panel.ip_notes/}'),
            'Type' => 'open',
            'Group' => language('{/panel.site_info/}'),
        ),
        'LockChineseBrowser' => array(
            'Class'=> 'border_bottom flex-middle2 flex-between',
            'Name' => language('{/panel.shield_browser/}'),
            'Tip'  => language('{/panel.browser_notes/}'),
            'Type' => 'open',
            'Group' => language('{/panel.site_info/}'),
        ),
        'close'  => array(
            'Class'=> 'flex-middle2 flex-between',
            'Name' => language('{/panel.close_web/}'),
            'Tip'  => language('{/panel.close_notes/}'),
            'Type' => 'open',
            'Group' => language('{/panel.site_info/}'),
        ),
        'close_detail'  => array(
            // 'Name' => '{/panel.close_web/}',
            'Tip'  => language('{/panel.close_notes/}'),
            'Type' => 'my_editor',
            'Group' => language('{/panel.site_info/}'),
        ),

        // 新增
        'hotline' => array(
            'Name' => '服务热线',
            'Type' => 'text',
            'Lang' => 1,
            'Group' => language('{/panel.content_info/}'),
        ),
        'customer' => array(
            'Name' => '客服链接',
            'Type' => 'textarea',
            'Lang' => 1,
            'Group' => language('{/panel.content_info/}'),
        ),
        'code_wx' => array(
            'Name' => '关注-微信',
            'Tip' => '一张图，推荐尺寸为 100*100 像素',
            'Type' => 'img',
            'Group' => '二维码信息',
            'Class'=> 'w2',
        ),
        'code_dy' => array(
            'Name' => '关注-抖音',
            'Type' => 'img',
            'Group' => '二维码信息',
            'Class'=> 'w2',
        ),
        'code_gzh' => array(
            'Name' => '公众号',
            'Type' => 'img',
            'Group' => '二维码信息',
            'Class'=> 'w2',
        ),
        'code_sph' => array(
            'Name' => '视频号',
            'Type' => 'img',
            'Group' => '二维码信息',
            'Class'=> 'w2',
        ),

        
        'link_facebook' => array(
            'Name' => 'Facebook',
            'Type' => 'text',
            'Group' => '英文版-关注链接',
        ),
        'link_tiktok' => array(
            'Name' => 'TikTok',
            'Type' => 'text',
            'Group' => '英文版-关注链接',
        ),
        'link_linkedin' => array(
            'Name' => 'Linkedin',
            'Type' => 'text',
            'Group' => '英文版-关注链接',
        ),

        // 商城版数据
        'company' => array(
            'Name' => language('{/form.company/}'),
            'Type' => 'text',
            'Lang' => 1,
            'Group' => language('{/panel.content_info/}'),
            'UnSet' => c('HostTag')!='shop',
        ),
        'phone' => array(
            'Name' => language('{/form.phone/}'),
            'Type' => 'text',
            'Lang' => 1,
            'Group' => language('{/panel.content_info/}'),
            'UnSet' => c('HostTag')!='shop',
        ),
        'email' => array(
            'Name' => language('{/form.email/}'),
            'Type' => 'text',
            'Lang' => 1,
            'Group' => language('{/panel.content_info/}'),
            'UnSet' => c('HostTag')!='shop',
        ),
        'fax' => array(
            'Name' => language('{/form.fax/}'),
            'Type' => 'text',
            'Lang' => 1,
            'Group' => language('{/panel.content_info/}'),
            'UnSet' => c('HostTag')!='shop',
        ),
        'address' => array(
            'Name' => language('{/form.address/}'),
            'Type' => 'text',
            'Lang' => 1,
            'Group' => language('{/panel.content_info/}'),
            'UnSet' => c('HostTag')!='shop',
        ),
    ),
);