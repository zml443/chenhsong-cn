<?php
$dbc=1;
// 这个是按照json格式保存的
// GroupId ==> set 
// g('set.web.name');
$dbg = array(
    // =========================================================
    'set' => array(
        // 
        'base' => array(
            'Name' => '{/set.basic_info/}',
            'Cfg'  => array(
                'name' => array(
                    'Name' => '{/set.site_name/}',
                    'Type' => 'text',
                ),
                'domain' => array(
                    'Name' => '{/set.domain/}',
                    'Type' => 'text',
                ),
                'logo' => array(
                    'Class'=> 'w3',
                    'Name' => '{/set.logo/}',
                    'Type' => 'img',
                ),
                'flogo' => array(
                    'Class'=> 'w3',
                    'Name' => 'LOGO(底部)',
                    'Type' => 'img',
                ),
                'ico' => array(
                    'Name' => 'Ico',
                    'Type' => 'img',
                ),
                'wx' => array(
                    'Tip'  => '1张图，100*100像素',
                    'Class'=> 'w3',
                    'Name' => '微信二维码',
                    'Type' => 'img',
                ),
                'qq' => array(
                    'Tip'  => '1张图，100*100像素',
                    'Class'=> 'w3',
                    'Name' => 'qq二维码',
                    'Type' => 'img',
                ),
                'wb' => array(
                    'Name' => '微博链接',
                    'Type' => 'text',
                ),
                'copyright' => array(
                    'Name' => '{/set.copyright/}',
                    'Type' => 'text',
                    'Lang' => 1,
                ),
                'icp' => array(
                    'Name' => '{/set.icp/}',
                    'Type' => 'text',
                ),
            ),
        ),
        // 联系方式
        'web' => array(
            'Name' => '{/set.site_info/}',
            'Cfg'  => array(
                'notcopy' => array(
                    'Name' => '{/set.cannot_copy/}',
                    'Tip'  => '{/set.cannot_copy_notes/}',
                    'Type' => 'open2',
                ),
                'LockChineseIp' => array(
                    'Name' => '{/set.shield_ip/}',
                    'Tip'  => '{/set.ip_notes/}',
                    'Type' => 'open2',
                ),
                'LockChineseBrowser' => array(
                    'Name' => '{/set.shield_browser/}',
                    'Tip'  => '{/set.browser_notes/}',
                    'Type' => 'open2',
                ),
                'close'  => array(
                    'Name' => '{/set.close_web/}',
                    'Tip'  => '{/set.close_notes/}',
                    'Type' => 'open2',
                ),
                'close_detail'  => array(
                    'Name' => '{/set.close_web/}',
                    'Tip'  => '{/set.close_notes/}',
                    'Type' => 'my_editor',
                ),
            ),
        ),
        // 联系方式
        'contact' => array(
            'Name' => '{/set.content_info/}',
            'Cfg'  => array(
                'company' => array(
                    'Name' => '{/set.company/}',
                    'Type' => 'text',
                    'Lang' => 1,
                ),
                'phone' => array(
                    'Name' => '{/set.phone/}',
                    'Type' => 'text',
                    'Lang' => 1,
                ),
                'email' => array(
                    'Name' => '{/set.email/}',
                    'Type' => 'text',
                    'Lang' => 1,
                ),
                'fax' => array(
                    'Name' => '{/set.fax/}',
                    'Type' => 'text',
                    'Lang' => 1,
                ),
                'address' => array(
                    'Name' => '{/set.address/}',
                    'Type' => 'text',
                    'Lang' => 1,
                ),
            ),
        ),
    ),

    // =========================================================

    'watermark' => array(
        'config' => array(
            'Name' => '{/set.watermark/}',
            'Cfg'  => array(
                'open' => array(
                    'Name' => '{/set.is_watermark/}',
                    'Type' => 'open',
                ),
                'img' => array(
                    'Name' => '{/set.watermark_upfile/}',
                    'Type' => 'img',
                ),
                'position' => array(
                    'Name' => '{/set.water_position/}',
                    'Type' => 'position',
                ),
            ),
        ),
    ),

);

?>