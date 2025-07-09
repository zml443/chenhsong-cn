<?php

$perimtConf = array(
    // 全局
    // ==================================================================
    'global' => array(
        'file_upload' => array(
            'list' => 'm=jext&a=file_upload',
            'del'  => 1,
            'hide' => 1
        ),
        'tag' => array(
            'list' => 'm=tag&a=index',
            'del'  => 1,
            'add'  => 1,
            'edit' => 1,
            'hide' => 1
        ),
    ),
    // ==================================================================

    // 后台主页
    // ==================================================================
    'home' => array(
        'index' => array(
            'list' => 'm=account&a=index',
        ),
    ),
    // ==================================================================

    // 广告图 
    // ==================================================================
    'ad' => array(
        '0' => array(
            'edit' => 'm=ad&a=0',
        ),
        'index' => array(
            'edit'   => 'm=ad&a=index&g=ad',
            'hide'   => 1,
        ),
        'industry' => array(
            'edit'   => 'm=ad&a=industry&g=ad',
            'hide'   => 1,
        ),
        'factory' => array(
            'edit'   => 'm=ad&a=factory&g=ad',
            'hide'   => 1,
        ),
        'megacloud' => array(
            'edit'   => 'm=ad&a=megacloud&g=ad',
            'hide'   => 1,
        ),
        'mold' => array(
            'edit'   => 'm=ad&a=mold&g=ad',
            'hide'   => 1,
        ),
        'automation' => array(
            'edit'   => 'm=ad&a=automation&g=ad',
            'hide'   => 1,
        ),
        'service' => array(
            'edit'   => 'm=ad&a=service&g=ad',
            'hide'   => 1,
        ),
        // 'media' => array(
        //     'edit'   => 'm=ad&a=media&g=ad',
        //     'hide'   => 1,
        // ),
        'about' => array(
            'edit'   => 'm=ad&a=about&g=ad',
            'hide'   => 1,
        ),
        'contact' => array(
            'edit'   => 'm=ad&a=contact&g=ad',
            'hide'   => 1,
        ),
        
        'download' => array(
            'edit'   => 'm=ad&a=download&g=ad',
            'hide'   => 1,
        ),
        // 'products' => array(
        //     'edit'   => 'm=ad&a=products&g=ad',
        //     'hide'   => 1,
        // ),
        // 'innovate' => array(
        //     'edit'   => 'm=ad&a=innovate&g=ad',
        //     'hide'   => 1,
        // ),
        // 'blog' => array(
        //     'edit'   => 'm=ad&a=blog&g=ad',
        //     'hide'   => 1,
        // ),
    ),
    // ==================================================================

    // 首页
    'webhome' => array(
        '0' => array(
            'edit' => 'm=webhome&a=0',
        ),
        'about' => array(
            'edit'   => 'm=webhome&a=about',
        ),
        'address'=> array(
            'edit'   => 'm=webhome&a=address',
        ),
        'custom'=> array(
            'edit'   => 'm=webhome&a=custom',
        ),
        'join'=> array(
            'edit'   => 'm=webhome&a=join',
        ),
        'lang'=> array(
            'list'   => 'm=webhome&a=lang',
            'myorder'=> 1,
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
        ),
    ),
    // ==================================================================

    // 产品
    // ==================================================================
    'products' => array(
        
        '0' => array(
            'edit' => 'm=products&a=0',
        ),
        'products' => array(
            'list'   => 'm=products&a=index',
            'myorder'=> 1,
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'copy'   => 1,
            'seo'    => 1,
            // 'export' => 1,
            // 'restore' => 1,
            // 'recycle' => 1,
        ),
        'category' => array(
            'list'   => 'm=products&a=category',
            'add'    => 1,
            // '_add'   => 1,
            'edit'   => 1,
            'del'    => 1,
            'seo'    => 1,
            'myorder'=> 1,
        ),
        'cases' => array(
            'list'   => 'm=products&a=cases',
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'myorder'=> 1,
            'copy'   => 1,
            'hide'=> 1,
            'hide_nav' => 1,
        ),
        /*
        'excel_upload' => array(
            'add'    => 'm=products&a=excel_upload',
        ),
        'wholesale' => array(
            'list' => 'm=products&a=wholesale',
            'add'  => 1,
            'edit' => 1,
            'del'  => 1,
            'hide' => 1,
        ),
        'comment' => array(
            'list' => 'm=products&a=comment',
            'edit' => 1,
        ),
        'brand' => array(
            'list' => 'm=products&a=brand',
            'add' => 1,
            'edit' => 1,
            'del' => 1,
            'copy' => 1,
            'hide' => 1,
        ),
        'search' => array(
            'list' => 'm=products&a=search',
            'add' => 1,
            'edit' => 1,
            'del' => 1,
            'copy' => 1,
            'hide' => 1,
        ),
        'where' => array(
            'list' => 'm=products&a=search_where',
            'add' => 1,
            'edit' => 1,
            'del' => 1,
            'copy' => 1,
            'hide' => 1,
        ),*/
    ),
    // ==================================================================

    // 行业方案
    'industry' => array(
        'index' => array(
            'list'   => 'm=industry&a=index',
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'myorder'=> 1,
            'copy'   => 1,
            'seo'    => 1,
        ),
        
        'application' => array(
            'list'   => 'm=industry&a=application',
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'myorder'=> 1,
            'copy'   => 1,
            'hide'=> 1,
            'hide_nav'=> 1,
        ),
    ),
    // ==================================================================

    // 智慧工厂
    // ==================================================================
    'factory' => array(
        '0' => array(
            'edit' => 'm=factory&a=0',
        ),
        'home' => array(
            'edit' => 'm=factory&a=home',
        ),
        // 'index' => array(
        //     'list'   => 'm=factory&a=index',
        //     'myorder'=> 1,
        //     'add'    => 1,
        //     'edit'   => 1,
        //     'del'    => 1,
        //     'copy'   => 1,
        // ),
        'factory' => array(
            'edit' => 'm=factory&a=factory',
        ),
        'factory_list'=> array(
            'list' => 'm=factory&a=factory_list',
            'myorder'=> 1,
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'copy'   => 1,
        ),
        'megacloud' => array(
            'edit' => 'm=factory&a=megacloud',
        ),
        'list' => array(
            'list'   => 'm=factory&a=list',
            'myorder'=> 1,
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'copy'   => 1,
        ),
        'auto' => array(
            'edit' => 'm=factory&a=auto',
        ),
        'auto_list'=> array(
            'list' => 'm=factory&a=auto_list',
            'myorder'=> 1,
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'copy'   => 1,
        ),

        'mold'=> array(
            'edit' => 'm=factory&a=mold',
        ),
        // 'automation' => array(
        //     'list'   => 'm=factory&a=automation',
        //     'myorder'=> 1,
        //     'add'    => 1,
        //     'edit'   => 1,
        //     'del'    => 1,
        //     'copy'   => 1,
        // ),
        // 'category' => array(
        //     'list'   => 'm=factory&a=category&l=category',
        //     'add'    => 1,
        //     'edit'   => 1,
        //     'del'    => 1,
        //     'seo'    => 1,
        //     'myorder'=> 1,
        // ),
    ),
    // ==================================================================

    // 智慧工厂
    // ==================================================================
    'server' => array(
        '0' => array(
            'edit' => 'm=server&a=0',
        ),
        'index' => array(
            'edit' => 'm=server&a=index',
        ),
        'network' => array(
            'edit' => 'm=server&a=network',
        ),
        'address' => array(
            'list' => 'm=server&a=address',
            // 'myorder'=> 1,
            // 'add'    => 1,
            'edit'   => 1,
            // 'del'    => 1,
        ),
        'accessory' => array(
            'edit' => 'm=server&a=accessory',
        ),
        'contact' => array(
            'edit' => 'm=server&a=contact',
        ),
    ),
    // ==================================================================

    // 媒体中心
    // ==================================================================
    'blog' => array(
        '0' => array(
            'edit' => 'm=blog&a=0',
        ),
        'index' => array(
            'list'   => 'm=blog&a=index',
            'myorder'=> 1,
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'copy'    => 1,
            'seo'    => 1,
        ),
        'category' => array(
            'list'   => 'm=blog&a=category&l=category',
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'seo'    => 1,
            'myorder'=> 1,
        ),
        // 'down'=> array(
        //     'edit' => 'm=blog&a=down',
        // ),
        'download' => array(
            'list'   => 'm=blog&a=download',
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'copy'    => 1,
            'myorder'=> 1,
        ),
    ),
    // ==================================================================

    // 关于我们
    // ==================================================================
    'about' => array(
        '0' => array(
            'edit' => 'm=about&a=0',
        ),
        'index'=> array(
            'edit' => 'm=about&a=index',
        ),
        'director' => array(
            'list'   => 'm=about&a=director',
            // 'add'    => 1,
            'edit'   => 1,
            // 'del'    => 1,
            'myorder'=> 1,
        ),
        'glory' => array(
            'list'   => 'm=about&a=glory',
            'myorder'=> 1,
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'copy'    => 1,
            'hide'    => 1,
            'hide_nav' => 1,
        ),
        'service' => array(
            'list'   => 'm=about&a=service',
            'myorder'=> 1,
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'copy'    => 1,
            'hide'    => 1,
            'hide_nav' => 1,
        ),
        'charitable' => array(
            'edit' => 'm=about&a=charitable',
        ),
        'history' => array(
            'list'   => 'm=about&a=history',
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'myorder'=> 1,
        ),
        'honor' => array(
            'list'   => 'm=about&a=honor',
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'myorder'=> 1,
        ),
        'category' => array(
            'list'   => 'm=about&a=category',
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'myorder'=> 1,
        ),
        'culture' => array(
            'edit' => 'm=about&a=culture',
        ),
        'list' => array(
            'list'   => 'm=about&a=list',
            'myorder'=> 1,
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'copy'    => 1,
            'hide'    => 1,
            'hide_nav' => 1,
        ),
        'technology' => array(
            'list'   => 'm=about&a=technology',
            'myorder'=> 1,
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
        ),
        'production'=> array(
            'edit' => 'm=about&a=production',
        ),
        'info'=> array(
            'edit' => 'm=about&a=info',
        ),
        'responsibility' => array(
            'list'   => 'm=about&a=responsibility',
            'myorder'=> 1,
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
        ),
    ),
    // ==================================================================

    // 投资者关系
    // ==================================================================
    'invest' => array(
        '0' => array(
            'edit' => 'm=invest&a=0',
        ),
        'founder'=> array(
            'edit' => 'm=invest&a=founder',
        ),
        'board' => array(
            'list'   => 'm=invest&a=board',
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'myorder'=> 1,
        ),
        'contact'=> array(
            'edit' => 'm=invest&a=contact',
        ),
        'information' => array(
            'list'   => 'm=invest&a=information',
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'myorder'=> 1,
        ),
        'announcements'=> array(
            'list'   => 'm=invest&a=announcements',
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'copy'    => 1,
            'myorder'=> 1,
        ),
        'category' => array(
            'list'   => 'm=invest&a=category',
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'myorder'=> 1,
        ),
        'category2'=> array(
            'list'   => 'm=invest&a=category2',
            // 'add'    => 1,
            'edit'   => 1,
            // 'del'    => 1,
            // 'copy'    => 1,
            // 'myorder'=> 1,
        ),
    ),
    // ==================================================================
    
    // 联系我们
    // ==================================================================
    'contact' => array(
        '0' => array(
            'edit' => 'm=contact&a=0',
        ),
        'index' => array(
            'list'   => 'm=contact&a=index',
            'myorder'=> 1,
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
        ),
        'affiliate'=> array(
            'list'   => 'm=contact&a=affiliate',
            'myorder'=> 1,
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
        ),
        'category' => array(
            'list'   => 'm=contact&a=category',
            'add'    => 1,
            'edit'   => 1,
            'del'    => 1,
            'myorder'=> 1,
        ),
        'become'=> array(
            'edit' => 'm=contact&a=become',
        ),
    ),
    // ==================================================================

    // 留言
    // ==================================================================
    'feedback' => array(
        'feedback' => array(
            'list' => 'm=feedback&a=index',
            'edit' => 1,
            '_view_edit' => 1,
            'del' => 1,
            'export' => 0,
        ),
        'download' => array(
            'list' => 'm=download&a=feedback',
            'edit' => 1,
            '_view_edit' => 1,
            'del' => 1,
            'export' => 0,
        ),
        'area' => array(
            'list' => 'm=feedback&a=area',
            'add' => 1,
            'edit' => 1,
            'del' => 1,
        ),
    ),
    // ==================================================================

    // seo
    // ==================================================================
    'seo' => array(
        'seo' => array(
            'edit' => 'm=seo&a=config&E=edit',
        ),
    ),
    // 单页seo
    'pageseo' => array(
        'seo' => array(
            'list'   => 'm=site&a=page_data&l=seo',
            'edit'   => 1,
            'seo'    => 1,
            'hide'   => 0,
        ),
    ),
    // ==================================================================

    // 统计
    // ==================================================================
    'statistics' => array(
        'analytics' => array(
            'list' => 'm=statistics&a=analytics',
        ),
    ),
    // ==================================================================

    // 设置
    // ==================================================================
    'set' => array(
        '0' => array(
            'edit' => 'm=site&a=0',
        ),
        // 网站设置
        'set' => array(
            'edit' => 'm=site&a=config&E=self',
            'hide' => 1
        ),
        // 水印
        // 'page_url' => array(
        //     'edit' => 'm=site&a=page_url',
        //     'hide' => 1
        // ),
        // 水印
        // 'watermark' => array(
        //     'edit' => 'm=site&a=watermark',
        //     'hide' => 1
        // ),
        // 关键词
        // 'keywords' => array(
        //     'list' => 'm=keywords&a=index',
        //     'add'  => 1,
        //     'edit' => 1,
        //     'del'  => 1,
        //     'hide' => 1
        // ),
        // 第三方代码管理
        'code' => array(
            'list' => 'm=third&a=index',
            'add'  => 1,
            'edit' => 1,
            'del'  => 1,
            'hide' => 1
        ),
        // 语言切换
        // 'language' => array(
        //     'edit' => 'm=language&a=index&E=edit',
        //     'hide' => 1
        // ),
        // 汇率
        // 'rate' => array(
        //     'list' => 'm=site&a=rate',
        //     // 'add'  => 1,
        //     // 'del'  => 1,
        //     'myorder' => 1,
        //     'edit' => 1,
        //     '_hide_edit' => 1,
        //     'hide' => 1
        // ),
        // 管理员
        'manage' => array(
            'list' => 'm=manage&a=index',
            'add'  => 1,
            'edit' => 1,
            'del'  => 1,
            'hide' => 1
        ),
        // 管理员，日志
        'manage_log' => array(
            'list' => 'm=manage&a=log',
            'edit' => 1,
            '_view_edit' => 1,
            'hide' => 1
        ),
        // 邮箱
        'email' => array(
           /* '0' => array(
                'edit' => 'm=email&a=0',
                'hide' => 1,
            ), */
            // 邮箱设置
            'set' => array(
                'edit' => 'm=email&a=config',
                'hide' => 1,
            ),
            'list' => array(
                'list' => 'm=email&a=list',
                'add' => 1,
                'edit' => 1,
                'hide' => 1,
            ),
            // 邮箱
            'send' => array(
                'edit' => 'm=email&a=send',
                'hide' => 1,
            ),
            // 日志
            'log' => array(
                'list' => 'm=email&a=log',
                // 'edit' => 1,
                'hide' => 1,
            ),
        ),
        // // 邮箱订阅
        // 'newsletter' => array(
        //     'list' => 'm=email&a=newsletter',
        //     'del'  => 1,
        //     'hide' => 1,
        // ),
        // 地区
        // 'address' => array(
        //     'list' => 'm=address&a=index',
        //     'add'  => 1,
        //     'edit' => 1,
        //     'del'  => 1,
        //     'hide' => 1,
        //     'orderby' => 'asc',
        // ),
        // country
        // 'country' => array(
        //     'list' => 'm=address&a=country',
        //     'add'  => 1,
        //     'edit' => 1,
        //     'del'  => 1,
        //     'hide' => 1,
        //     'orderby' => 'asc',
        // ),
        // 发货方式，运费
        // 'shipping' => array(
        //     'shipping' => array(
        //         'list' => 'm=shipping&a=index',
        //         'add'  => 1,
        //         'edit' => 1,
        //         'del'  => 1,
        //         'hide' => 1
        //     ),
        //     'shipping_price' => array(
        //         'list' => 'm=shipping&a=price',
        //         'edit' => 1,
        //         'hide' => 1
        //     ),
        //     'shipping_country_price' => array(
        //         'list' => 'm=shipping&a=country_price',
        //         'edit' => 1,
        //         'hide' => 1
        //     ),
        // ),
        // 支付
        // 'pay' => array(
        //     'edit' => 'm=site&a=pay',
        //     'hide' => 1
        // ),
    ),
    // ==================================================================

    // 订单
    // ==================================================================
    /*'orders' => array(
        'orders_all' => array(
            'list' => 'm=orders&a=index&L=list',
            'add' => 1,
            'edit' => 'm=orders&a=index&E=edit',
            // 'del' => 1,
        ),
        'orders_shipping' => array(
            'list' => 'm=orders&a=index',
        ),
        'orders_cancel' => array(
            'list' => 'm=orders&a=index&Status=cancel',
        ),
        'shipping_info' => array(
            'edit' => 'm=orders&a=shipping_info',
            'hide' => 1
        ),
        'address' => array(
            'edit' => 'm=orders&a=address',
            'hide' => 1
        ),
        'invoice' => array(
            'edit' => 'm=orders&a=invoice',
            'hide' => 1
        ),
        'products' => array(
            'list' => 'm=orders&a=products',
            'del' => 1,
            'edit' => 1,
            '_hide_edit' => 1,
            'hide' => 1,
        ),
        'config' => array(
            'edit' => 'm=site&a=orders',
        ),
    ),*/
    // ==================================================================

    
    // 会员
    // ==================================================================
    /*'member' => array(
        'member' => array(
            'list' => 'm=member&a=index',
            'edit' => 'm=member&a=index&E=edit',
            'add'  => 1,
            'del'  => 1,
        ),
        'address' => array(
            'list' => 'm=member&a=address',
            'add'  => 1,
            'edit' => 1,
            'del'  => 1,
            'hide' => 1
        ),
        'login_config' => array(
            'list' => 'm=member&a=login',
            'edit' => 1,
        ),
        'set' => array(
            'edit' => 'm=member&a=set',
        ),
        'message_log' => array(
            'list' => 'm=member&a=message_log',
            'add'  => 1,
            'edit' => 1,
            'del'  => 1,
        ),
        'message' => array(
            'list' => 'm=member&a=message',
            'add'  => 1,
            'edit' => 1,
            'del'  => 1,
        ),
    ),*/
    // ==================================================================

    
    // 营销
    // ==================================================================
    /*'marketing' => array(
        //优惠券
        'coupon' => array(
            'list' => 'm=orders&a=coupon',
            'add'  => 1,
            'edit' => 1,
            'del'  => 1,
        ),
        //弹窗公告
        'notice' => array(
            'list' => 'm=notice&a=index',
            'add'  => 1,
            'edit' => 1,
            'del'  => 1,
        ),
    ),*/
    // ==================================================================


    // 应用商店
    // ==================================================================
    'app' => array(
        '0' => array(
            'edit' => 'm=app&a=0',
        ),
        'app_store' => array(
            'edit' => 'm=app&a=app_store',
        ),
        // 展会
        'exhibition' => array(
            'index' => array(
                'list'   => 'm=exhibition&a=index&l=app',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'copy'   => 1,
                'seo'    => 1,
                'hide'   => 1,
            ),
            'products_category' => array(
                'list'   => 'm=exhibition&a=products_category&l=category&_inline_=1',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'hide'   => 1,
                'hide_nav' => 1,
            ),
            'products' => array(
                'list'   => 'm=exhibition&a=products&_inline_=1',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'hide'   => 1,
                'hide_nav' => 1,
            ),
        ),
        // 活动
        'activity' => array(
            'index' => array(
                'list'   => 'm=activity&a=index&l=app',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'copy'   => 1,
                'seo'    => 1,
                'hide'   => 1,
            ),
            'category' => array(
                'list'   => 'm=activity&a=category&l=app_category',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'hide'   => 1,
            ),
            'booking' => array(
                'list'   => 'm=activity&a=booking&l=app',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'hide'   => 1,
            ),
        ),
        // 团队
        'team' => array(
            'index' => array(
                'list'   => 'm=team&a=index&l=app',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'copy'   => 1,
                'seo'    => 1,
                'hide'   => 1,
            ),
            'category' => array(
                'list'   => 'm=team&a=category&l=app_category',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'hide'   => 1,
            ),
        ),
        // 视频
        'video' => array(
            'index' => array(
                'list'   => 'm=video&a=index&l=app',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'copy'   => 1,
                'hide'   => 1,
            ),
            'category' => array(
                'list'   => 'm=video&a=category&l=app_category',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'hide'   => 1,
            ),
        ),
        // 企业
        'enterprise' => array(
            'index' => array(
                'list'   => 'm=enterprise&a=index&l=app',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'copy'   => 1,
                'hide'   => 1,
            ),
            'category' => array(
                'list'   => 'm=enterprise&a=category&l=app_category',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'hide'   => 1,
            ),
            'personage' => array(
                'list'   => 'm=enterprise&a=personage&l=app',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'hide'   => 1,
            ),
        ),
        // 企业
        'fashion' => array(
            'index' => array(
                'list'   => 'm=fashion&a=index&l=app',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'copy'   => 1,
                'hide'   => 1,
            ),
            'category' => array(
                'list'   => 'm=fashion&a=category&l=app_category',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'hide'   => 1,
            ),
        ),
        // 人才招聘
        'join' => array(
            'index' => array(
                'list'   => 'm=join&a=index&l=app',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'copy'   => 1,
                'hide'   => 1,
            ),
            'category' => array(
                'list'   => 'm=join&a=category&l=app_category',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'hide'   => 1,
            ),
            'address' => array(
                'list'   => 'm=join&a=address&l=app_category',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'hide'   => 1,
            ),
        ),
        // 分公司&分店
        'branches' => array(
            'index' => array(
                'list'   => 'm=join&a=branches&l=app',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'copy'   => 1,
                'hide'   => 1,
            ),
            'address' => array(
                'list'   => 'm=join&a=address&l=app_category',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'hide'   => 1,
            ),
        ),
        // 问答
        'faq' => array(
            'index' => array(
                'list'   => 'm=faq&a=index&l=app',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'copy'   => 1,
                'hide'   => 1,
            ),
            'category' => array(
                'list'   => 'm=faq&a=category&l=app_category',
                'myorder'=> 1,
                'add'    => 1,
                'edit'   => 1,
                'del'    => 1,
                'hide'   => 1,
            ),
        ),
        // 移动端客服
        'service_mobile' => array(
            'index' => array(
                'list' => 'm=service&a=mobile&L=edit&_popup_=1',
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                'orderby' => 'asc',
                'hide' => 1,
            )
        ),
        // 客服
        'service' => array(
            'index' => array(
                'list' => 'm=service&a=index&L=edit',
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                'orderby' => 'asc',
                'hide' => 1,
            )
        ),
        // 服务
        'server' => array(
            'index' => array(
                'list' => 'm=server&a=index&l=app',
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                'seo' => 1,
                'orderby' => 'asc',
                'hide' => 1,
            )
        ),
        // 新闻
        'blog' => array(
            'index' => array(
                'list' => 'm=blog&a=index&l=app',
                'myorder' => 1,
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                'seo' => 1,
                'hide' => 1,
            ),
            'category' => array(
                'list' => 'm=blog&a=category&l=app_category',
                'myorder' => 1,
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'seo' => 1,
                'hide' => 1,
            ),
        ),
        // 发展历程
        'history' => array(
            'index' => array(
                'list' => 'm=history&a=index&l=app',
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                'orderby' => 'asc',
                'hide' => 1,
            )
        ),
        // 合作伙伴
        'partner' => array(
            'index' => array(
                'list' => 'm=partner&a=index&l=app',
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                // 'orderby' => 'asc',
                'myorder' => 1,
                'hide' => 1,
            )
        ),
        // 友情链接
        'links' => array(
            'index' => array(
                'list' => 'm=links&a=index&l=app',
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                // 'orderby' => 'asc',
                'myorder' => 1,
                'hide' => 1,
            ),
            'set' => array(
                'edit' => 'ma=links/config&e=popup&_popup_=1',
                'hide' => 1,
            )
        ),
        // 帮助中心
        'help' => array(
            'index' => array(
                'list' => 'm=help&a=index&l=app_category',
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                'seo' => 1,
                'hide' => 1,
            )
        ),
        // 帮助中心
        'markdown' => array(
            'index' => array(
                'list' => 'm=markdown&a=index&l=app_category',
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                'seo' => 1,
                'hide' => 1,
            )
        ),
        // 案例
        'case' => array(
            'index' => array(
                'list' => 'm=case&a=index&l=app',
                'myorder' => 1,
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                'seo' => 1,
                'hide' => 1,
            ),
            'category' => array(
                'list' => 'm=case&a=category&l=app_category',
                'myorder' => 1,
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'seo' => 1,
                'hide' => 1,
            ),
            'search' => array(
                'list' => 'm=case&a=search&l=app',
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                'hide' => 1,
            ),
            'where' => array(
                'list' => 'm=case&a=search_where&l=app',
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                'hide' => 1,
            ),
        ),
        // 解决方案
        'solution' => array(
            'index' => array(
                'list' => 'm=solution&a=index&l=app',
                'myorder' => 1,
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                'seo' => 1,
                'hide' => 1,
            ),
            /*'category' => array(
                'list' => 'm=solution&a=category&l=app_category',
                'myorder' => 1,
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'seo' => 1,
                'hide' => 1,
            ),*/
        ),
        // 下载
        'download' => array(
            'index' => array(
                'list' => 'm=download&a=index&l=app',
                'myorder' => 1,
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                // 'seo' => 1,
                'hide' => 1,
            ),
            'category' => array(
                'list' => 'm=download&a=category&l=app_category',
                'myorder' => 1,
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'seo' => 1,
                'hide' => 1,
            ),
            'feedback' => array(
                'list' => 'm=download&a=feedback&l=app',
                'edit' => 1,
                'del' => 1,
                'hide' => 1,
            ),
        ),
        // 酒店
        'hotel' => array(
            'index' => array(
                'list' => 'm=hotel&a=index&l=app',
                'myorder' => 1,
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                // 'seo' => 1,
                'hide' => 1,
            ),
            'category' => array(
                'list' => 'm=hotel&a=category&l=app_category',
                'myorder' => 1,
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'seo' => 1,
                'hide' => 1,
            ),
            'search' => array(
                'list' => 'm=hotel&a=search&l=app',
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                'hide' => 1,
            ),
            'where' => array(
                'list' => 'm=hotel&a=search_where&l=app',
                'add' => 1,
                'edit' => 1,
                'del' => 1,
                'copy' => 1,
                'hide' => 1,
            ),
        ),
        // 
    ),
	'app'=>array(),
    // ==================================================================


    // 页面
    // ==================================================================
    'web' => array(
        'page_type' => array(
            'list' => 'm=site&a=page_data&L=type',
            'edit' => 1,
        ),
        'page' => array(
            'list' => 'm=site&a=page_data&L=list',
            'edit' => 1,
            'add'  => 1,
            'del'  => 1,
            'seo'  => 1,
            // 'myorder'=> 1,
            'orderby' => 'asc',
        ),
        'nav' => array(
            'list' => 'm=site&a=nav&L=list',
            'edit' => 1,
            'add' => 1,
            'del' => 1,
            'myorder' => 1,
            'orderby' => 'asc',
        ),
        'footer_nav' => array(
            'list' => 'm=site&a=footer_nav&l=category',
            'edit' => 1,
            'add'  => 1,
            'del'  => 1,
            'myorder'=> 1,
            'orderby'=> 'asc',
        ),
    ),
	'web'=>array(),
    // ==================================================================
);


// 开始执行
c('manage.permit.config', $perimtConf);
if (manage('Level')!=1) {
    $permit_array_cur = str::json(db::result("select Permit from wb_manage where Id='".manage('Id')."'", 'Permit'), 'decode');
    c('manage.permit.array_cur', $permit_array_cur);
    if ($permit_array_cur['app']) $perimtConf['app']['0']['xxxx'] = 1;
}
permit::check('0', c('manage.permit.config'));