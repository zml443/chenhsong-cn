<?php

class saas_data{
    // 默认标题数组
    static public $title = array(
        '测试标题',
        '这是一段测试标题',
        '这是一段测试标题加长版，详细信息请前往后台添加',
    );
    // 二级导航默认数据
    public static function page_category ($limit=1, $data_file='') {
        // 1为常规模式   0为预览模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            array(
                'Id' => 0,
                'Name' => '全部',
                'Href' => '',
                'Icon' => '/static/images/websvg/linear/apartment.svg',
                '_cur_' => 1,
            )
        );
        for ($i=0;$i<$limit;$i++) {
            $row[] = array(
                'Id' => 0,
                'Name' => '分类'.(1+$i).'',
                'Href' => '',
                'Icon' => '/static/images/websvg/linear/apartment.svg',
                '_cur_' => 0,
            );
        }
        return $limit>1?$row:$row[0];
    }

    // 自定义页面编辑器
    public static function page_editor ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            'Name' => '自定义页面名称',
            'Editor' => '<p>工业设计分为产品设计、环境设计、传播设计、设计管理4类；包括造型设计、机械设计、电路设计、服装设计、环境规划、室内设计、建筑设计、UI设计、平面设计、包装设计、广告设计、动画设计、展示设计、网站设计等。工业设计又称工业产品设计学，工业设计涉及到心理学，社会学，美学，人机工程学，机械构造，摄影，色彩学等。工业发展和劳动分工所带来的工业设计，与其它艺术、生产活动、工艺制作等都有明显不同，它是各种学科、技术和审美观念的交叉产物</p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p><span style="font-size: 20px;">设计理念</span></p><p><span style="font-size: 20px;"><br/></span></p><p>设计协会IC­SID(In­ter­na­tional Coun­cil of So­ci­eties of In­dus­trial De­sign)：工业设计是一种创造性的活动，其目的是为物品、过程、服务以及它们在整个生命周期中构成的系统建立起多方面的品质。<br/></p><p>美国工业设计协会IDSA(In­dus­trial De­sign­ers So­ci­ety of Amer­ica)：工业设计是一项专门的服务性工作，为使用者和生产者双方的利益而对产品和产品系列的外形、功能和使用价值进行优选。</p><p>国际工业设计协会理事会（IC­SID）给工业设计作了如下定义：就批量生产的工业产品而言，凭借训练、技术知识、经验、视觉及心理感受，而赋予产品材料、结构、构造、形态、色彩、表面加工、装饰以新的品质和规格。</p><p><br/></p><hr/><p><br/></p><p><span style="color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 20px;">设计理念</span></p><p><br/></p><p><span style="color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 20px;"><span style="color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px;">(工业)设计旨在引导创新、促发商业成功及提供更好质量的生活，是一种将策略性解决问题的过程应用于产品、系统、服务及体验的设计活动。它是一种跨学科的专业，将创新、技术、商业、研究及消费者紧密联系在一起，共同进行创造性活动、并将需解决的问题、提出的解决方案进行可视化，重新解构问题，并将其作为建立更好的产品、系统、服务、体验或商业网络的机会，提供新的价值以及竞争优势。(工业)设计是通过其输出物对社会、经济、环境及伦理方面问题的回应，旨在创造一个更好的世界。</span></span></p>'
        );
        return $row;
    }

    // 产品分类（侧边栏+产品详情）
    public static function all_products ($limit=1, $data_file='') {
        // 1为常规模式   0为预览模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            array(
                'Id' => 0,
                'Name' => '全部',
                'Href' => '',
                'Icon' => '/static/images/websvg/linear/apartment.svg',
                '_cur_' => 1,
                'children' => array(),
                'products_children' => array(
                    array(
                        'Name' => '全部',
                        'products_children' => array(
                            array(
                                'Name' => '全部产品',
                                '_cur_' => 1,
                            ),
                        ),
                    ),
                ),
            )
        );
        for ($i=0;$i<$limit;$i++) {
            $row[] = array(
                'Id' => 0,
                'Name' => '分类'.(1+$i).'',
                'Href' => '',
                'Icon' => '/static/images/websvg/linear/apartment.svg',
                '_cur_' => 0,
                'children' => array(
                    array(
                        'Name' => '二级分类'.(1+$i).'',
                        'products_children' => array(
                            array(
                                'Name' => '产品2-'.(1+$i).'',
                            ),
                        ),
                    ),
                ),
            );
        }
        return $limit>1?$row:$row[0];
    }

    // 地图默认数据
    public static function map_position ($limit=1, $data_file='') {
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        $url = 'static/images/map.png';
        return '<div class="maxw maxh"><img class="maxw maxh" style="background:url('.$url.') no-repeat center;"></div>';
    }

    // faq 数据
    public static function faq ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        for ($i=0;$i<$limit;$i++) {
            $row[] = array(
                'Id' => 0,
                'Name' => (self::$title[($i+1)%3]),
                'Picture' => array(
                    'path' => '/static/images/0'.($i%9+1).'.png',
                    'alt' => '',
                ),
                'AddTime' => 1681459022,
                'Brief' => '无线自组网定位系统',
                'BriefDescription' => '实现即时应用，即时转移。集成指挥调度、地图显示和数据监控，实现信息立体化，更直观掌握作战信息。多种链路接入选择，可与现场指挥大屏连接，实现现场作战化指挥，也可与后方指挥中心互联，实现联动指挥。',
            );
        }
        return $limit>1?$row:$row[0];
    }

    // 首页 合作伙伴数据
    public static function partner ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        for ($i=0;$i<$limit;$i++) {
            $row[] = array(
                'Name' => '伙伴'.(1+$i).'',
                'Logo' => '/static/images/logo.png',
            );
        }
        return $limit>1?$row:$row[0];
    }

    // download 数据
    public static function download ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        for ($i=0;$i<$limit;$i++) {
            $row[] = array(
                'Id' => 0,
                'Name' => (self::$title[($i+1)%3]),
                'File' => array(
                    'path' => '',
                    'size' => ''.(1+$i).'GB'
                ),
                'DownloadHref' => '',
                'Category' => '媒体资源',
                'AddTime' => 1681459022,
            );
        }
        return $limit>1?$row:$row[0];
    }

    // history 数据
    public static function history ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        $title = array(
            "迈瑞在深圳市南山区蛇口太子路金融中心创立。\r\n中国第一台自主研发的多参数监护仪。",
            "給像絲綢一樣輕盈有光澤的頭發。\r\n輕柔洗凈來自植物的成分配合，順滑地引導至如手指般的好光滑的頭發",
            "100+套模板任选一套模板风格\r\nCDN全球加速(3秒打开)\r\n固定专属顾问1对1全阶段服务\r\n资深设计师一对一网站主视觉图设计");
        for ($i=0;$i<$limit;$i++) {
            $row[] = array(
                'Id' => 0,
                'Name' => (self::$title[($i+1)%3]),
                'Picture' => array(
                    'path' => '/static/images/0.jpg',
                    'alt' => '',
                ),
                'BriefDescription' => $title[($i+1)%3],
                'AddTime' => 1681459022 + $i*(86400*365),
            );
        }
        return $limit>1?$row:$row[0];
    }

    // 人才招聘
    public static function wb_join ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        $title = array('仓库管理员','专利助理','法务代表','销售总监','UI设计师','前端工程师');
        $category = array('总经办','技术部','销售部','设计部','测试部');
        // 系统数据，limit为需要的条数
        $row = array();
        for ($i=0;$i<$limit;$i++) {
            $row[] = array(
                'Id' => 0,
                'Name' => ($title[($i+1)%6]),
                'AddTime' => 1681459022,
                'Qty' => '20',
                'Salary' => ($i+1).'000',
                'Category' => ($category[($i+1)%5]),
                'Province' => '广东',
                'Address' => '深圳市南山区前海',
                'Education' => '大专及以上',
                'Gender' => 'A',
                'Responsibility' => "1. 大学专科及以上学历，市场营销，互联网，软件服务行业经验，销售经验，计算机关专业；\r\n2.具备方案编写能力，单独向客户讲解软件产品及方案能力，自备笔记本电脑；\r\n3.较强的整合资源、公关谈判能力，沟通协调能力强；\r\n4. 良好的客户服务意识，善于团队协作，主动思考，自我驱动力强。\r\n5、优秀的市场开拓能力与宣讲能力、较强的交往能力、亲和力和说服能力；\r\n6、敬业尽职，抗压能力强，团队意识强；\r\n7，有带过团队、或者同行经验，互联网经验，软件服务行业经验的优先考虑；\r\n8、优秀应届毕业生也可考虑，公司将提供完善的培训。",
                'Demand' => "1、中专以上学历，有儿童陪伴机、早教机及平板电脑类设备整机采购经验优先;\r\n2、三年及以上整机结构件物料的采购工作经验;\r\n3、熟悉采购规范、流程及物流管理规范;具有采购议价、谈判经验;",
            );
        }
        return $limit>1?$row:$row[0];
    }

    // 友情链接
    public static function wb_links ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        for ($i=0;$i<$limit;$i++) {
            $row[] = array(
                'Id' => 0,
                'Name' => '友情链接'.($i+1),
                'Url' => '',
                'IsNofollow' => 0,
            );
        }
        return $limit>1?$row:$row[0];
    }

    // 视频数据
    public static function wb_video ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        $category = array('科幻','国漫','喜剧','仙侠','欧美电影');
        $pictures = array();
        for ($i=0;$i<4;$i++){
            $pictures[] = array(
                'path' => '/static/images/video.mp4',
                'alt' => '',
            );
        }
        for ($i=0;$i<$limit;$i++) {
            $v = array(
                'Id' => 0,
                'Name' => (self::$title[($i+1)%3]),
                'Picture' => array(
                    'path' => '/static/images/video.mp4',
                    'alt' => '',
                ),
                'Pictures' => $pictures,
                'Category' => $category[($i+1)%5],
                'BriefDescription' => '服务长简介、基于强大的全球物流运输网络和优秀的IT能力，覆盖全球300多个港口，全国68个服务网点。ANKER可为跨境卖家、外贸企业提供便捷、可靠的数字化国际物流服务。',
            );
            $v['Href'] = url::set($v,'wb_video.detail');
            $row[] = $v;
        }
        return $limit>1?$row:$row[0];
    }
    // 视频编辑器
    public static function wb_video_editor ($limit=0, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            array(
                'Name' => '产品介绍',
                'Editor' => '<p><br/></p><p><br/></p><p>智能魔盒MIFI=4G随身wifi+充电宝+蓝牙耳机，三位一体，一步到位。</p><p>WIFi：相当于“个人热点”功能，可同时支持10个终端设备连接wifi，150mbps高速上网。</p><p>充电宝：1000mah大容量，让移动终端充电时刻保持满电状态。</p><p>耳机：蓝牙5.0，连接稳定。满足用户用蓝牙耳机听音频的需求。</p><p><br/></p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p><br/></p><p>功能：</p><p>1、4G随身wifi+充电宝+蓝牙耳机，三者功能合而为一，既能将4G网络转换为wifi</p><p>&nbsp;&nbsp;&nbsp;又能给移动终端充电，同时可以满足用户用蓝牙耳机听音频的需求。</p><p>2、相当于“个人热点”功能，可同时支持10个终端设备连接wifi，同时创建自有无线网络。</p><p><br/></p><p><br/></p>'
            ),
        );
        return $row;
    }

    // 服务数据
    public static function server ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        $pictures = array();
        for ($i=0;$i<4;$i++){
            $pictures[] = array(
                'path' => '/static/images/0.jpg',
                'alt' => '',
            );
        }
        for ($i=0;$i<$limit;$i++) {
            $v = array(
                'Id' => 0,
                'Name' => (self::$title[($i+1)%3]),
                'Picture' => array(
                    'path' => '/static/images/0.jpg',
                    'alt' => '',
                ),
                'Icon' => '/static/images/websvg/linear/apartment.svg',
                'Pictures' => $pictures,
                'BriefDescription' => '服务长简介、基于强大的全球物流运输网络和优秀的IT能力，覆盖全球300多个港口，全国68个服务网点。ANKER可为跨境卖家、外贸企业提供便捷、可靠的数字化国际物流服务。',
            );
            $v['Href'] = url::set($v,'wb_server.detail');
            $row[] = $v;
        }
        return $limit>1?$row:$row[0];
    }
    // 服务编辑器
    public static function server_editor ($limit=0, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            array(
                'Name' => '产品介绍',
                'Editor' => '<p><br/></p><p><br/></p><p>智能魔盒MIFI=4G随身wifi+充电宝+蓝牙耳机，三位一体，一步到位。</p><p>WIFi：相当于“个人热点”功能，可同时支持10个终端设备连接wifi，150mbps高速上网。</p><p>充电宝：1000mah大容量，让移动终端充电时刻保持满电状态。</p><p>耳机：蓝牙5.0，连接稳定。满足用户用蓝牙耳机听音频的需求。</p><p><br/></p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p><br/></p><p>功能：</p><p>1、4G随身wifi+充电宝+蓝牙耳机，三者功能合而为一，既能将4G网络转换为wifi</p><p>&nbsp;&nbsp;&nbsp;又能给移动终端充电，同时可以满足用户用蓝牙耳机听音频的需求。</p><p>2、相当于“个人热点”功能，可同时支持10个终端设备连接wifi，同时创建自有无线网络。</p><p><br/></p><p><br/></p>'
            ),
        );
        return $row;
    }

    // 门店数据
    public static function join_branches ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        $pictures = array();
        for ($i=0;$i<4;$i++){
            $pictures[] = array(
                'path' => '/static/images/0.jpg',
                'alt' => '',
            );
        }
        for ($i=0;$i<$limit;$i++) {
            $v = array(
                'Id' => 0,
                'Name' => (self::$title[($i+1)%3]),
                'Picture' => array(
                    'path' => '/static/images/0.jpg',
                    'alt' => '',
                ),
                'Pictures' => $pictures,
                'Email' => 'service@szlianya.net',
                'Address' => '深圳市南山区前海路70号泛海城市广场2栋1201',
                'Phone' => '0755-82940957',
                'Province' => '广东深圳',
            );
            $v['Href'] = url::set($v,'wb_branches.detail');
            $row[] = $v;
        }
        return $limit>1?$row:$row[0];
    }
    // 门店编辑器
    public static function join_branches_editor ($limit=0, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            array(
                'Name' => '产品介绍',
                'Editor' => '<p><br/></p><p><br/></p><p>智能魔盒MIFI=4G随身wifi+充电宝+蓝牙耳机，三位一体，一步到位。</p><p>WIFi：相当于“个人热点”功能，可同时支持10个终端设备连接wifi，150mbps高速上网。</p><p>充电宝：1000mah大容量，让移动终端充电时刻保持满电状态。</p><p>耳机：蓝牙5.0，连接稳定。满足用户用蓝牙耳机听音频的需求。</p><p><br/></p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p><br/></p><p>功能：</p><p>1、4G随身wifi+充电宝+蓝牙耳机，三者功能合而为一，既能将4G网络转换为wifi</p><p>&nbsp;&nbsp;&nbsp;又能给移动终端充电，同时可以满足用户用蓝牙耳机听音频的需求。</p><p>2、相当于“个人热点”功能，可同时支持10个终端设备连接wifi，同时创建自有无线网络。</p><p><br/></p><p><br/></p>'
            ),
        );
        return $row;
    }

    // 企业列表
    public static function enterprise ($limit=1, $data_file=array()) {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 系统数据，limit为需要的条数
        $row = array();
        $pictures = array();
        $title = array(
            '京州丽莎贝尔时装设计有限公司',
            '塌鞴砂室内设计有限公司',
            '离叶原视觉设计有限公司',
        );
        for ($i=0;$i<$limit;$i++) {
            $pictures[] = array(
                'path' => '/static/images/logo.png',
                'alt' => '',
            );
        }
        for ($i=0;$i<$limit;$i++) {
            $v = array(
                'Id' => 0,
                'Name' => $title[($i+1)%3],
                'Logo' => '/static/images/logo.png',
                'Picture' => array(
                    'path' => '/static/images/logo.png',
                    'alt' => '',
                ),
                'Pictures' => $pictures,
                'AddTime' => 1681459022,
                'Tel' => '0700-8888 8888',
                'Email' => '1681@163.com',
                'WXNumber' => '590220',
                'Website' => 'https://www.lianyayun.com/',
                'Address' => '京州市海福区长安街道立新湖创意园2栋207室',
                'Brief' => '丽莎贝尔时装设计是一家享有盛誉的时尚设计公司。',
                'BriefDescription' => '丽莎贝尔时装设计是一家享有盛誉的时尚设计公司，致力于为现代女性创造独特、优雅和时尚的时装。自成立以来，我们公司一直以卓越的设计、高品质的面料和精湛的手工工艺而著称，为全球的时尚爱好者提供卓越的时尚体验',
                'Category' => '分类',
            );
            $v['Href'] = url::set($v,'wb_enterprise.detail');
            $row[] = $v;
        }
        return $limit>1?$row:$row[0];
    }
    // 企业编辑器
    public static function enterprise_editor ($limit=0, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            array(
                'Name' => '产品规格',
                'Editor' => '<p>工业设计分为产品设计、环境设计、传播设计、设计管理4类；包括造型设计、机械设计、电路设计、服装设计、环境规划、室内设计、建筑设计、UI设计、平面设计、包装设计、广告设计、动画设计、展示设计、网站设计等。工业设计又称工业产品设计学，工业设计涉及到心理学，社会学，美学，人机工程学，机械构造，摄影，色彩学等。工业发展和劳动分工所带来的工业设计，与其它艺术、生产活动、工艺制作等都有明显不同，它是各种学科、技术和审美观念的交叉产物</p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p><span style="font-size: 20px;">设计理念</span></p><p><span style="font-size: 20px;"><br/></span></p><p>设计协会IC­SID(In­ter­na­tional Coun­cil of So­ci­eties of In­dus­trial De­sign)：工业设计是一种创造性的活动，其目的是为物品、过程、服务以及它们在整个生命周期中构成的系统建立起多方面的品质。<br/></p><p>美国工业设计协会IDSA(In­dus­trial De­sign­ers So­ci­ety of Amer­ica)：工业设计是一项专门的服务性工作，为使用者和生产者双方的利益而对产品和产品系列的外形、功能和使用价值进行优选。</p><p>国际工业设计协会理事会（IC­SID）给工业设计作了如下定义：就批量生产的工业产品而言，凭借训练、技术知识、经验、视觉及心理感受，而赋予产品材料、结构、构造、形态、色彩、表面加工、装饰以新的品质和规格。</p><p><br/></p><hr/><p><br/></p><p><span style="color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 20px;">设计理念</span></p><p><br/></p><p><span style="color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 20px;"><span style="color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px;">(工业)设计旨在引导创新、促发商业成功及提供更好质量的生活，是一种将策略性解决问题的过程应用于产品、系统、服务及体验的设计活动。它是一种跨学科的专业，将创新、技术、商业、研究及消费者紧密联系在一起，共同进行创造性活动、并将需解决的问题、提出的解决方案进行可视化，重新解构问题，并将其作为建立更好的产品、系统、服务、体验或商业网络的机会，提供新的价值以及竞争优势。(工业)设计是通过其输出物对社会、经济、环境及伦理方面问题的回应，旨在创造一个更好的世界。</span></span></p>'
            ),
        );
        return $row;
    }
    // 企业人物
    public static function enterprise_personage ($limit=1, $data_file='') {
        // 团队图片
        $people = array(
            '/static/images/people1.png',
            '/static/images/people2.png',
            '/static/images/people3.png',
            '/static/images/people4.png',
        );
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        $title = array(
            'Anna',
            '陈曦',
            '贺阳',
            '周文'
        );
        $job = array(
            '董事长',
            'CEO',
            '总监',
            '院长'
        );
        for ($i=0;$i<$limit;$i++) {
            $v = array(
                'Id' => 0,
                'Name' => $title[$i%4],
                'Picture' => array(
                    'path' => $people[$i%4],
                    'alt' => '',
                ),
                'AssociationJob' => '协会会长',
                'Company' => '京州艾尔时装贸易有限公司',
                'CompanyJob' =>  $job[$i%4],
                'AddTime' => 1681459022,
            );
            // $v['Href'] = url::set($v,'wb_personage.detail');
            $row[] = $v;
        }
        return $limit>1?$row:$row[0];
    }

    // 时装数据
    public static function fashion ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        $title = array(
            '2023京州时装周：多元失焦，不止未来',
            '2023京州时装周自愿者招募',
            '2023京州时装周：创意绽放，风格引领'
        );
        for ($i=0;$i<$limit;$i++) {
            $v = array(
                'Id' => 0,
                'Name' => $title[$i%3],
                'Picture' => array(
                    'path' => '/static/images/0.jpg',
                    'alt' => '',
                ),
                'AddTime' => 1681459022,
                'BriefDescription' => '随着社会的发展，在一些特定场景中，现有的传统有线通信网络已经明显无法保障现场的数据通信。且在面临如恐怖袭击、重大社会活动等的突发事件，及自然灾害面前，公网往往是无法满足数据通信需求的。',
                'IsHot' => $i?0:1,
            );
            $v['Href'] = url::set($v,'wb_fashion.detail');
            $row[] = $v;
        }
        return $limit>1?$row:$row[0];
    }
    // 时装编辑器
    public static function fashion_editor ($limit=0, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            array(
                'Name' => '详情',
                'Editor' => '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;随着5G网络技术的商用，物联网似乎像破茧的彩蝶，迎来了春意盎然下的自由起舞，这是一个新的生命周期，也是一个更广阔的畅翔空间，有相关机构预计，物联网市场将是一个万亿级的市场，物联网的连接数将在百亿级的规模，物超人的时代对运营商而言会很快带来，在2020年的前5个月时间，三大运营商蜂窝物联网终端用户就达10.97亿户，比去年净增6886万，最值得注意的是，在这些用户中，用于智能制造、智能交通、智能公共事业的终端用户增长均达30%左右。可想而知，随着物联网商用的行业渗透和落地，随着国家对新型基础设施建设的大力推动，三大运营商正做足准备拥抱物联网，为千行百业的智能化改造做足准备。看运营商如何在物联网领域“乘风破浪”？</p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;新基建孕育了新物联，物联网已经由碎片化应用、闭环式发展，进入到跨界融合、集成创新、规模化发展的新阶段。在此背景下，中国电信的天翼物联将基于新的智能连接和更加开放的新平台，构建全新物联网生态，以此来打破信息“孤岛”，实现全要素互联、一体化整合、推动物联网产业进一步规模化发展。目前物联网主要有LTE Cat.4/6、LTE Cat.1、NB-IoT三种连接形式，LTE Cat.4/6即5G，主要被应用于远程医疗、自动驾驶、高清视频和工业物联网；LTE Cat.1于2016年开始商用，主要应用于可穿戴设备、POSS机、电梯监控和物流领域；中国电信的NB-IoT连接数已突破5000万，主要应用于路灯、抄表、智能停车和环境管理等场景，有昆仑燃气、天津智慧水务、海尔共享空调、小天鹅洗衣机等成功案例。中国电信正在构建终端生态、应用生态、集成商生态、行业权威生态、实验室生态、服务商生态、开发者生态和安全生态这八大生态，希望能通过生态构建吸引更多的开发者和厂商，与天翼物联一起，为未来更加智能的世界贡献力量。同样，中国联通LTE全网已打开了具备Cat 1能力，实现业务开通无缝对接，并沉淀产业互联网实践，并且中国联通物联网正式对外发布自主设计、全国产化“雁飞Cat 1”模组，该模组能够实现三大差异化优势，从当前蜂窝物联网发展的趋势来看，LTE Cat.1作为介于高速LTE类别及低速物联网之间的一种IoT指定类别，将成为连接物联网的“主力军”。同样作为运营商的老大中国移动，可以说是5G行业的顶梁柱，中国移动主要布局于智能连接、开放平台、芯片模组、智能硬件与行业应用这五大领域，同时积极锻造5G切片、边缘计算、5G模组、操作系统等5G的通用能力，赋能产业数字化转型。截至5月，中国移动已建成近14万个5G基站，并力争2020年底提前完成建设5G基站30万座，并在所有地级以上城市提供5G商用服务的目标。</p><p><br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5G将在未来成为社会信息流动的主动脉，产业转型升级的加速器和数字社会建设的新基石，既是数字经济的基础，也是建设数字中国网络强国的核心动力之一，于此，三大运营商的5G建设速度已进一步加快，预计今年三季度5G网络将具备县级以上城市的服务能力。未来在5G应用中，将有更多的物联网业界合作伙一同构建新业态，探索更多更新的物联网应用，打造全新的5G+IOT生态圈，共同推动的物联网产业快速健康发展。</p><p><br/></p>'
            )
        );
        return $row;
    }

    // 活动数据
    public static function activity ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        $title = array(
            '2023京州时装产业交易会举办',
            '2023京州服装产业方向与发展',
            '2023京州时装周交易会'
        );
        for ($i=0;$i<$limit;$i++) {
            $v = array(
                'Id' => 0,
                'Name' => $title[$i%3],
                'Picture' => array(
                    'path' => '/static/images/0.jpg',
                    'alt' => '',
                ),
                'AddTime' => 1601459022,
                'BTimeStart' => 1601459022,
                'BTimeEnd' => 1689459022,
                'Address' => '京州天启商贸城',
                'Sponsor' => '京州天启商贸集体',
                'Topic' => '商贸交会',
                'Guest' => array(
                    array(
                        'name' => '嘉宾1号',
                        'brief' => '京州时装会会长',
                    ),
                    array(
                        'name' => '嘉宾2号',
                        'brief' => '时装会顶级设计师',
                    ),
                ),
                'BriefDescription' => '随着社会的发展，在一些特定场景中，现有的传统有线通信网络已经明显无法保障现场的数据通信。且在面临如恐怖袭击、重大社会活动等的突发事件，及自然灾害面前，公网往往是无法满足数据通信需求的。',
            );
            $v['Href'] = url::set($v,'wb_activity.detail');
            $row[] = $v;
        }
        return $limit>1?$row:$row[0];
    }
    // 活动编辑器
    public static function activity_editor ($limit=0, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            array(
                'Name' => '详情',
                'Editor' => '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;随着5G网络技术的商用，物联网似乎像破茧的彩蝶，迎来了春意盎然下的自由起舞，这是一个新的生命周期，也是一个更广阔的畅翔空间，有相关机构预计，物联网市场将是一个万亿级的市场，物联网的连接数将在百亿级的规模，物超人的时代对运营商而言会很快带来，在2020年的前5个月时间，三大运营商蜂窝物联网终端用户就达10.97亿户，比去年净增6886万，最值得注意的是，在这些用户中，用于智能制造、智能交通、智能公共事业的终端用户增长均达30%左右。可想而知，随着物联网商用的行业渗透和落地，随着国家对新型基础设施建设的大力推动，三大运营商正做足准备拥抱物联网，为千行百业的智能化改造做足准备。看运营商如何在物联网领域“乘风破浪”？</p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;新基建孕育了新物联，物联网已经由碎片化应用、闭环式发展，进入到跨界融合、集成创新、规模化发展的新阶段。在此背景下，中国电信的天翼物联将基于新的智能连接和更加开放的新平台，构建全新物联网生态，以此来打破信息“孤岛”，实现全要素互联、一体化整合、推动物联网产业进一步规模化发展。目前物联网主要有LTE Cat.4/6、LTE Cat.1、NB-IoT三种连接形式，LTE Cat.4/6即5G，主要被应用于远程医疗、自动驾驶、高清视频和工业物联网；LTE Cat.1于2016年开始商用，主要应用于可穿戴设备、POSS机、电梯监控和物流领域；中国电信的NB-IoT连接数已突破5000万，主要应用于路灯、抄表、智能停车和环境管理等场景，有昆仑燃气、天津智慧水务、海尔共享空调、小天鹅洗衣机等成功案例。中国电信正在构建终端生态、应用生态、集成商生态、行业权威生态、实验室生态、服务商生态、开发者生态和安全生态这八大生态，希望能通过生态构建吸引更多的开发者和厂商，与天翼物联一起，为未来更加智能的世界贡献力量。同样，中国联通LTE全网已打开了具备Cat 1能力，实现业务开通无缝对接，并沉淀产业互联网实践，并且中国联通物联网正式对外发布自主设计、全国产化“雁飞Cat 1”模组，该模组能够实现三大差异化优势，从当前蜂窝物联网发展的趋势来看，LTE Cat.1作为介于高速LTE类别及低速物联网之间的一种IoT指定类别，将成为连接物联网的“主力军”。同样作为运营商的老大中国移动，可以说是5G行业的顶梁柱，中国移动主要布局于智能连接、开放平台、芯片模组、智能硬件与行业应用这五大领域，同时积极锻造5G切片、边缘计算、5G模组、操作系统等5G的通用能力，赋能产业数字化转型。截至5月，中国移动已建成近14万个5G基站，并力争2020年底提前完成建设5G基站30万座，并在所有地级以上城市提供5G商用服务的目标。</p><p><br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5G将在未来成为社会信息流动的主动脉，产业转型升级的加速器和数字社会建设的新基石，既是数字经济的基础，也是建设数字中国网络强国的核心动力之一，于此，三大运营商的5G建设速度已进一步加快，预计今年三季度5G网络将具备县级以上城市的服务能力。未来在5G应用中，将有更多的物联网业界合作伙一同构建新业态，探索更多更新的物联网应用，打造全新的5G+IOT生态圈，共同推动的物联网产业快速健康发展。</p><p><br/></p>'
            )
        );
        return $row;
    }

    // 酒店数据
    public static function wb_hotel ($limit=1, $data_file=''){
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        $pictures = array();
        for ($i=0;$i<$limit;$i++) {
            $pictures[] = array(
                'path' => '/static/images/0.jpg',
                'alt' => '',
            );
        }
        $title = array('香格里拉大酒店','深礼堂·艺术中心','深圳东海朗廷酒店');
        // 系统数据，limit为需要的条数
        $row = array();
        for ($i=0;$i<$limit;$i++) {
            $v = array(
                'Id' => 0,
                'Name' => $title[$i%3],
                'Picture' => $pictures[0],
                'Pictures' => $pictures,
                'AddTime' => 1681459022,
                'Brief' => '卓尔不凡的婚礼之选',
                'BriefDescription' => '卓尔不凡的婚礼之选，法式天台花园，空中天台花园，闹市中的私享之境用超高的性价比，迎接一场专属求婚和私人派对。',
                'Category' => '经典',
            );
            $v['Href'] = url::set($v,'wb_hotel.detail');
            $row[] = $v;
        }
        return $limit>1?$row:$row[0];
    }
    // 酒店编辑器
    public static function wb_hotel_editor ($limit=1, $data_file=''){
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            array(
                'Name' => '详情',
                'Editor' => '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;随着5G网络技术的商用，物联网似乎像破茧的彩蝶，迎来了春意盎然下的自由起舞，这是一个新的生命周期，也是一个更广阔的畅翔空间，有相关机构预计，物联网市场将是一个万亿级的市场，物联网的连接数将在百亿级的规模，物超人的时代对运营商而言会很快带来，在2020年的前5个月时间，三大运营商蜂窝物联网终端用户就达10.97亿户，比去年净增6886万，最值得注意的是，在这些用户中，用于智能制造、智能交通、智能公共事业的终端用户增长均达30%左右。可想而知，随着物联网商用的行业渗透和落地，随着国家对新型基础设施建设的大力推动，三大运营商正做足准备拥抱物联网，为千行百业的智能化改造做足准备。看运营商如何在物联网领域“乘风破浪”？</p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;新基建孕育了新物联，物联网已经由碎片化应用、闭环式发展，进入到跨界融合、集成创新、规模化发展的新阶段。在此背景下，中国电信的天翼物联将基于新的智能连接和更加开放的新平台，构建全新物联网生态，以此来打破信息“孤岛”，实现全要素互联、一体化整合、推动物联网产业进一步规模化发展。目前物联网主要有LTE Cat.4/6、LTE Cat.1、NB-IoT三种连接形式，LTE Cat.4/6即5G，主要被应用于远程医疗、自动驾驶、高清视频和工业物联网；LTE Cat.1于2016年开始商用，主要应用于可穿戴设备、POSS机、电梯监控和物流领域；中国电信的NB-IoT连接数已突破5000万，主要应用于路灯、抄表、智能停车和环境管理等场景，有昆仑燃气、天津智慧水务、海尔共享空调、小天鹅洗衣机等成功案例。中国电信正在构建终端生态、应用生态、集成商生态、行业权威生态、实验室生态、服务商生态、开发者生态和安全生态这八大生态，希望能通过生态构建吸引更多的开发者和厂商，与天翼物联一起，为未来更加智能的世界贡献力量。同样，中国联通LTE全网已打开了具备Cat 1能力，实现业务开通无缝对接，并沉淀产业互联网实践，并且中国联通物联网正式对外发布自主设计、全国产化“雁飞Cat 1”模组，该模组能够实现三大差异化优势，从当前蜂窝物联网发展的趋势来看，LTE Cat.1作为介于高速LTE类别及低速物联网之间的一种IoT指定类别，将成为连接物联网的“主力军”。同样作为运营商的老大中国移动，可以说是5G行业的顶梁柱，中国移动主要布局于智能连接、开放平台、芯片模组、智能硬件与行业应用这五大领域，同时积极锻造5G切片、边缘计算、5G模组、操作系统等5G的通用能力，赋能产业数字化转型。截至5月，中国移动已建成近14万个5G基站，并力争2020年底提前完成建设5G基站30万座，并在所有地级以上城市提供5G商用服务的目标。</p><p><br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5G将在未来成为社会信息流动的主动脉，产业转型升级的加速器和数字社会建设的新基石，既是数字经济的基础，也是建设数字中国网络强国的核心动力之一，于此，三大运营商的5G建设速度已进一步加快，预计今年三季度5G网络将具备县级以上城市的服务能力。未来在5G应用中，将有更多的物联网业界合作伙一同构建新业态，探索更多更新的物联网应用，打造全新的5G+IOT生态圈，共同推动的物联网产业快速健康发展。</p><p><br/></p>'
            )
        );
        return $row;
    }

    // 产品数据
    public static function products ($limit=1, $data_file=array()) {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 系统数据，limit为需要的条数
        $row = array();
        $pictures = array();
        switch ($data_file['pic_type']) {
            case 'cloth':
                for ($i=0;$i<9;$i++){
                    $pictures[] = array(
                        'path' => '/static/images/cloth-0'.($i%3+1).'.jpg',
                        'alt' => '',
                    );
                }
                break;
            default:
                for ($i=0;$i<9;$i++){
                    $pictures[] = array(
                        'path' => '/static/images/0'.($i%9+1).'.png',
                        'alt' => '',
                    );
                }
                break;
        }
        for ($i=0;$i<$limit;$i++) {
            switch ($data_file['pic_type']) {
                case 'cloth':
                    $picture = '/static/images/cloth-0'.rand(1,3).'.jpg';
                    break;
                default:
                    $picture = '/static/images/0'.($i%9+1).'.png';
                    break;
            }
            $v = array(
                'Id' => 0,
                'Name' => (self::$title[($i+1)%3]),
                'Picture' => array(
                    'path' => $picture,
                    'alt' => '',
                ),
                'Pictures' => $pictures,
                'AddTime' => 1681459022,
                'Icon' => '/static/images/websvg/linear/apartment.svg',
                'Price' => 220.01,
                'wb_products_parameter' => array(
                    array(
                        'name' => '系列',
                        'children' => array(
                            array(
                                'name' => 'Aviator',
                            ),
                        )
                    ),
                    array(
                        'name' => '适合年龄',
                        'children' => array(
                            array(
                                'name' => '18-24周岁',
                            ),
                        )
                    ),
                    array(
                        'name' => '图案',
                        'children' => array(
                            array(
                                'name' => '无',
                            ),
                        )
                    ),
                    array(
                        'name' => '风格',
                        'children' => array(
                            array(
                                'name' => '百搭',
                            ),
                        )
                    ),
                    array(
                        'name' => '颜色',
                        'children' => array(
                            array(
                                'name' => '乳白色',
                            ),
                        )
                    ),
                    array(
                        'name' => '尺码',
                        'children' => array(
                            array(
                                'name' => '155/60A/XSR',
                                'size' => '160/64A/SR',
                            ),
                        )
                    ),
                    array(
                        'name' => '年份季节',
                        'children' => array(
                            array(
                                'name' => '2023夏季',
                            ),
                        )
                    ),
                    array(
                        'name' => '衣长',
                        'children' => array(
                            array(
                                'name' => '短衣',
                            ),
                        )
                    ),
                    array(
                        'name' => '廓形',
                        'children' => array(
                            array(
                                'name' => 'A型',
                            ),
                        )
                    ),
                    array(
                        'name' => '材料成分',
                        'children' => array(
                            array(
                                'name' => '棉71%',
                                'name' => '聚酯纤维28%',
                            ),
                        )
                    ),
                ),
                'Brief' => '給像絲綢一樣輕盈有光澤的頭發。',
                'BriefDescription' => '給像絲綢一樣輕盈有光澤的頭發。 輕柔洗凈來自植物的成分配合，順滑地引導至如手指般的好光滑的頭發',
                'IsHot' => $i?0:1,
                'Category' => '当季新款',
            );
            $v['Href'] = url::set($v,'wb_products.detail');
            $row[] = $v;
        }
        return $limit>1?$row:$row[0];
    }
    // 产品编辑器
    public static function products_editor ($limit=0, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            array(
                'Name' => '产品规格',
                'Editor' => '<table style="width:100%"><tbody><tr class="firstRow"><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">123</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">12321</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">123</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">123</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">123</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">123</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">123</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">123</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">123</td></tr><tr><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">ssasd</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221);"></td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221);"></td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221);"></td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221);"></td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">adqwe</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">qwe</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221);"></td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">qwe</td></tr><tr><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">xczx</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221);"></td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">asd</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221);"></td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">asd</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221);"></td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">qwew</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">qweqwe</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">qwe</td></tr><tr><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">zxczxca</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">asd</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221);"></td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221);"></td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221);"></td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221);"></td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">qwe</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">qwe</td><td valign="top"style="border-width: 1px; border-style: solid; border-color: rgb(221, 221, 221); word-break: break-all;">qweqwe</td></tr></tbody></table><p><br/></p>'
            ),
            // array(
            //     'Name' => '产品介绍',
            //     'Editor' => '<p><br/></p><p><br/></p><p>智能魔盒MIFI=4G随身wifi+充电宝+蓝牙耳机，三位一体，一步到位。</p><p>WIFi：相当于“个人热点”功能，可同时支持10个终端设备连接wifi，150mbps高速上网。</p><p>充电宝：1000mah大容量，让移动终端充电时刻保持满电状态。</p><p>耳机：蓝牙5.0，连接稳定。满足用户用蓝牙耳机听音频的需求。</p><p><br/></p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p><br/></p><p>功能：</p><p>1、4G随身wifi+充电宝+蓝牙耳机，三者功能合而为一，既能将4G网络转换为wifi</p><p>&nbsp;&nbsp;&nbsp;又能给移动终端充电，同时可以满足用户用蓝牙耳机听音频的需求。</p><p>2、相当于“个人热点”功能，可同时支持10个终端设备连接wifi，同时创建自有无线网络。</p><p><br/></p><p><br/></p>'
            // )
        );
        return $row;
    }
    // 产品关联参数
    public static function products_extpara ($limit=1, $data_file=array()) {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 系统数据，limit为需要的条数
        $row = array();
        // 关联参数数组
        $para = array(
            array(
                'Name' => '系列',
                'children' => array(
                    array(
                        'Name' => 'Aviator',
                    ),
                )
            ),
            array(
                'Name' => '适合年龄',
                'children' => array(
                    array(
                        'Name' => '18-24周岁',
                    ),
                )
            ),
            array(
                'Name' => '图案',
                'children' => array(
                    array(
                        'Name' => '无',
                    ),
                )
            ),
            array(
                'Name' => '风格',
                'children' => array(
                    array(
                        'Name' => '百搭',
                    ),
                    array(
                        'Name' => 'Ins',
                    ),
                )
            ),
            array(
                'Name' => '颜色',
                'children' => array(
                    array(
                        'Name' => '乳白色',
                    ),
                )
            ),
            array(
                'Name' => '尺码',
                'children' => array(
                    array(
                        'Name' => '155/60A/XSR',
                    ),
                    array(
                        'Name' => '160/64A/SR',
                    ),
                )
            ),
            array(
                'Name' => '年份季节',
                'children' => array(
                    array(
                        'Name' => '2023夏季',
                    ),
                )
            ),
            array(
                'Name' => '衣长',
                'children' => array(
                    array(
                        'Name' => '短衣',
                    ),
                )
            ),
            array(
                'Name' => '廓形',
                'children' => array(
                    array(
                        'Name' => 'A型',
                    ),
                )
            ),
            array(
                'Name' => '材料成分',
                'children' => array(
                    array(
                        'Name' => '棉71%',
                        'Name' => '聚酯纤维28%',
                    ),
                )
            ),
        );
        return $para;
    }

    // 方案数据
    public static function solution ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        for ($i=0;$i<$limit;$i++) {
            $v = array(
                'Id' => 0,
                'Name' => (self::$title[($i+1)%3]),
                'Picture' => array(
                    'path' => '/static/images/0.jpg',
                    'alt' => '',
                ),
                'AddTime' => 1681459022,
                'BriefDescription' => '随着社会的发展，在一些特定场景中，现有的传统有线通信网络已经明显无法保障现场的数据通信。且在面临如恐怖袭击、重大社会活动等的突发事件，及自然灾害面前，公网往往是无法满足数据通信需求的。',
                'IsHot' => $i?0:1,
            );
            $v['Href'] = url::set($v,'wb_solution.detail');
            $row[] = $v;
        }
        return $limit>1?$row:$row[0];
    }
    // 方案编辑器
    public static function solution_editor ($limit=0, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            array(
                'Name' => '详情',
                'Editor' => '<p>无线自组网定位系统，由定位终端、传输中继基站和系统操控主机组成，具有可快速搭建，无需架设有线网及容灾抗毁性强等特点。</p><p>系统采用无线自组网设备，无线自组网设备之间由空中无线链路完成数据传输，无需任何有线链路，不仅有效降低系统造价；而且突破了因有线通信资源造成的地域限制，用最简单可靠的方式在海上等无公网地区迅速建立通信理盖。通过系统操控主机可对终端精准进行自动定位，直观化堂握前端物资的分布情况，对物资的位置进行实时跟踪掌握动态情况，同时支持轨迹回放，为指挥层提供调度决策信息。系统可适用于海上打靶训练及固定物资管控等场景。</p><p><br/></p><p>自组网定位系统，由定位终端、传输中继基站和系统操控主机组成；系统可快速搭建，无需架设有线网，具有良好的容灾抗毁性。</p><p>整体网络架构中，系统操控主机作为定位系统的指挥平台，同时兼任通信融合平台。在指挥中心位置搭建自组网基站接收各个网络节点的信息，可使用卫星链路、公网链路等方式，向后方传递定位信息。</p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p>已成功应用于南部战区某作战部队</p><p>在海上无公网环境下部署一套现场自组网定位通信系统。在海上打靶训练时，配备的定位系统可快速搭建使用，搭建一个可覆盖十公里甚至更长的无线通信链路，满足现场战斗机/指挥船对靶标定位数据的需求，同时第一时间将靶标定位信息传递至前方指挥船，前方指挥船位置可根据实际需要，将数据信息传递至后方指挥中心。</p>'
            )
        );
        return $row;
    }

    // 新闻数据
    public static function blog ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        $title = array(
            '这是一条测试新闻信息',
            '这是一条测试新闻信息，请再后台添加您的新闻',
            '联雅云专注做好中心企业的品牌形象网站'
        );
        for ($i=0;$i<$limit;$i++) {
            $v = array(
                'Id' => 0,
                'Name' => $title[$i%3],
                'Picture' => array(
                    'path' => '/static/images/0.jpg',
                    'alt' => '',
                ),
                'AddTime' => 1681459022,
                'BriefDescription' => '随着社会的发展，在一些特定场景中，现有的传统有线通信网络已经明显无法保障现场的数据通信。且在面临如恐怖袭击、重大社会活动等的突发事件，及自然灾害面前，公网往往是无法满足数据通信需求的。',
                'IsHot' => $i?0:1,
            );
            $v['Href'] = url::set($v,'wb_blog.detail');
            $row[] = $v;
        }
        return $limit>1?$row:$row[0];
    }
    // 新闻编辑器
    public static function blog_editor ($limit=0, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            array(
                'Name' => '详情',
                'Editor' => '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;随着5G网络技术的商用，物联网似乎像破茧的彩蝶，迎来了春意盎然下的自由起舞，这是一个新的生命周期，也是一个更广阔的畅翔空间，有相关机构预计，物联网市场将是一个万亿级的市场，物联网的连接数将在百亿级的规模，物超人的时代对运营商而言会很快带来，在2020年的前5个月时间，三大运营商蜂窝物联网终端用户就达10.97亿户，比去年净增6886万，最值得注意的是，在这些用户中，用于智能制造、智能交通、智能公共事业的终端用户增长均达30%左右。可想而知，随着物联网商用的行业渗透和落地，随着国家对新型基础设施建设的大力推动，三大运营商正做足准备拥抱物联网，为千行百业的智能化改造做足准备。看运营商如何在物联网领域“乘风破浪”？</p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;新基建孕育了新物联，物联网已经由碎片化应用、闭环式发展，进入到跨界融合、集成创新、规模化发展的新阶段。在此背景下，中国电信的天翼物联将基于新的智能连接和更加开放的新平台，构建全新物联网生态，以此来打破信息“孤岛”，实现全要素互联、一体化整合、推动物联网产业进一步规模化发展。目前物联网主要有LTE Cat.4/6、LTE Cat.1、NB-IoT三种连接形式，LTE Cat.4/6即5G，主要被应用于远程医疗、自动驾驶、高清视频和工业物联网；LTE Cat.1于2016年开始商用，主要应用于可穿戴设备、POSS机、电梯监控和物流领域；中国电信的NB-IoT连接数已突破5000万，主要应用于路灯、抄表、智能停车和环境管理等场景，有昆仑燃气、天津智慧水务、海尔共享空调、小天鹅洗衣机等成功案例。中国电信正在构建终端生态、应用生态、集成商生态、行业权威生态、实验室生态、服务商生态、开发者生态和安全生态这八大生态，希望能通过生态构建吸引更多的开发者和厂商，与天翼物联一起，为未来更加智能的世界贡献力量。同样，中国联通LTE全网已打开了具备Cat 1能力，实现业务开通无缝对接，并沉淀产业互联网实践，并且中国联通物联网正式对外发布自主设计、全国产化“雁飞Cat 1”模组，该模组能够实现三大差异化优势，从当前蜂窝物联网发展的趋势来看，LTE Cat.1作为介于高速LTE类别及低速物联网之间的一种IoT指定类别，将成为连接物联网的“主力军”。同样作为运营商的老大中国移动，可以说是5G行业的顶梁柱，中国移动主要布局于智能连接、开放平台、芯片模组、智能硬件与行业应用这五大领域，同时积极锻造5G切片、边缘计算、5G模组、操作系统等5G的通用能力，赋能产业数字化转型。截至5月，中国移动已建成近14万个5G基站，并力争2020年底提前完成建设5G基站30万座，并在所有地级以上城市提供5G商用服务的目标。</p><p><br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5G将在未来成为社会信息流动的主动脉，产业转型升级的加速器和数字社会建设的新基石，既是数字经济的基础，也是建设数字中国网络强国的核心动力之一，于此，三大运营商的5G建设速度已进一步加快，预计今年三季度5G网络将具备县级以上城市的服务能力。未来在5G应用中，将有更多的物联网业界合作伙一同构建新业态，探索更多更新的物联网应用，打造全新的5G+IOT生态圈，共同推动的物联网产业快速健康发展。</p><p><br/></p>'
            )
        );
        return $row;
    }

    // 案例列表
    public static function wb_case ($limit=1, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        $title = array(
            '雪花概念广告设计',
            'woody国风服饰拍摄',
            '艺术展馆概念设计',
            '向往、人生、徘徊——diana品牌宣传'
        );
        $pictures = array();
        for ($i=0;$i<6;$i++){
            $pictures[] = array(
                'path' => '/static/images/0.jpg',
                'alt' => '',
            );
        }
        // 关联参数数组
        $para = array(
            array(
                'Name' => '设备型号',
                'children' => array(
                    array(
                        'Name' => 'JYH3-22',
                    ),
                    array(
                        'Name' => '2套',
                    ),
                    array(
                        'Name' => 'JYP2-5-6',
                    ),
                )
            ),
            array(
                'Name' => '过滤精度',
                'children' => array(
                    array(
                        'Name' => '100um',
                    ),
                )
            ),
            array(
                'Name' => '系统出水量',
                'children' => array(
                    array(
                        'Name' => '1000m³/h',
                    ),
                )
            ),
        );
        for ($i=0;$i<$limit;$i++) {
            $v = array(
                'Id' => 0,
                'Name' => $title[$i%4],
                'Picture' => array(
                    'path' => '/static/images/0.jpg',
                    'alt' => '',
                ),
                'Pictures' => $pictures,
                'AddTime' => 1681459022,
                'BriefDescription' => '随着社会的发展，在一些特定场景中，现有的传统有线通信网络已经明显无法保障现场的数据通信。且在面临如恐怖袭击、重大社会活动等的突发事件，及自然灾害面前，公网往往是无法满足数据通信需求的。',
                'Category' => '广告设计',
                'SearchWhere' => $para,
            );
            $v['Href'] = url::set($v,'wb_case.detail');
            $row[] = $v;
        }
        return $limit>1?$row:$row[0];
    }
    // 案例编辑器
    public static function case_editor ($limit=0, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            array(
                'Name' => '详情',
                'Editor' => '<p>工业设计分为产品设计、环境设计、传播设计、设计管理4类；包括造型设计、机械设计、电路设计、服装设计、环境规划、室内设计、建筑设计、UI设计、平面设计、包装设计、广告设计、动画设计、展示设计、网站设计等。工业设计又称工业产品设计学，工业设计涉及到心理学，社会学，美学，人机工程学，机械构造，摄影，色彩学等。工业发展和劳动分工所带来的工业设计，与其它艺术、生产活动、工艺制作等都有明显不同，它是各种学科、技术和审美观念的交叉产物</p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p><img src="/static/images/1400.jpg"/></p><p><br/></p><p><span style="font-size: 20px;">设计理念</span></p><p><span style="font-size: 20px;"><br/></span></p><p>设计协会IC­SID(In­ter­na­tional Coun­cil of So­ci­eties of In­dus­trial De­sign)：工业设计是一种创造性的活动，其目的是为物品、过程、服务以及它们在整个生命周期中构成的系统建立起多方面的品质。<br/></p><p>美国工业设计协会IDSA(In­dus­trial De­sign­ers So­ci­ety of Amer­ica)：工业设计是一项专门的服务性工作，为使用者和生产者双方的利益而对产品和产品系列的外形、功能和使用价值进行优选。</p><p>国际工业设计协会理事会（IC­SID）给工业设计作了如下定义：就批量生产的工业产品而言，凭借训练、技术知识、经验、视觉及心理感受，而赋予产品材料、结构、构造、形态、色彩、表面加工、装饰以新的品质和规格。</p><p><br/></p><hr/><p><br/></p><p><span style="color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 20px;">设计理念</span></p><p><br/></p><p><span style="color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 20px;"><span style="color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px;">(工业)设计旨在引导创新、促发商业成功及提供更好质量的生活，是一种将策略性解决问题的过程应用于产品、系统、服务及体验的设计活动。它是一种跨学科的专业，将创新、技术、商业、研究及消费者紧密联系在一起，共同进行创造性活动、并将需解决的问题、提出的解决方案进行可视化，重新解构问题，并将其作为建立更好的产品、系统、服务、体验或商业网络的机会，提供新的价值以及竞争优势。(工业)设计是通过其输出物对社会、经济、环境及伦理方面问题的回应，旨在创造一个更好的世界。</span></span></p>'
            )
        );
        return $row;
    }

    // 团队列表
    public static function team ($limit=1, $data_file='') {
        // 团队图片
        $people = array(
            '/static/images/people1.png',
            '/static/images/people2.png',
            '/static/images/people3.png',
            '/static/images/people4.png',
        );
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array();
        $title = array(
            'Margaux',
            'Jayde',
            'Loxley',
            'Alexus'
        );
        for ($i=0;$i<$limit;$i++) {
            $v = array(
                'Id' => 0,
                'Name' => $title[$i%4],
                'Picture' => array(
                    'path' => $people[$i%4],
                    'alt' => '',
                ),
                'AddTime' => 1681459022,
                'BriefDescription' => '我们懂得站在客户的角度思考，善于沟通,懂得取舍。
                我们的设计，是谦逊的、灵活的、亲和的、懂得倾听的。
                我们的设计，是独具美感的、凸显功能的、往创造价值的方向去努力的。',
                'Category' => '视觉总监',
            );
            $v['Href'] = url::set($v,'wb_team.detail');
            $row[] = $v;
        }
        return $limit>1?$row:$row[0];
    }
    // 团队编辑器
    public static function team_editor ($limit=0, $data_file='') {
        // 1为预览模式   0为常规模式
        if (!$_SESSION['website_preview_model']) {
            return array();
        }
        // 若导入了默认文件，则调用导入的文件
        if (is_file($data_file)) {
            return include $data_file;
        }
        // 系统数据，limit为需要的条数
        $row = array(
            array(
                'Name' => '详情',
                'Editor' => '<p>我们懂得站在客户的角度思考，善于沟通,懂得取舍。</p><p>我们的设计，是谦逊的、灵活的、亲和的、懂得倾听的。</p><p>我们的设计，是独具美感的、凸显功能的、往创造价值的方向去努力的。</p><p><br/></p><p>1941年9月13日出生，出生于日本大阪。</p><p>1957年左右，开始练习职业拳击。</p><p>1959～1961年，考察日本传统建筑。</p><p>1962～1969年，游学于美国、欧洲和非洲。</p><p>1969年，创办“安藤忠雄建筑研究所”（Tadao Ando Ar­chi­tec­ture&amp;As­so­ci­ates）。</p><p>1969年在大阪成立安藤忠雄建筑研究所，设计了许多个人住宅。其中位在大阪的“住吉的长屋”获得很高的评价。</p><p><br/></p><p><span style="font-size: 20px;">&nbsp;受邀</span></p><p><br/></p><p><br/></p><p>-&nbsp;2010年受邀请到“中国移动飞信&quot;做设计分享</p><p>-&nbsp;2012年受邀请到“创新工场”做设计分享</p><p><br/></p><p><span style="font-size: 20px;">荣誉</span><br/></p><p><br/></p><p>1980年代在关西周边（特别是神户?北野町、大阪心斋桥一带）设计了许多商业设施、寺庙、教会等。</p><p>1987年-担任耶鲁大学的客座教授。</p><p>1988年-担任哥伦比亚大学的客座教授。</p><p>1990年代之后公共建筑、美术馆，及海外的建筑设计案开始增加。</p><p>1989年-担任哈佛大学的客座教授。</p><p>1995年-获得普利兹克建筑奖。</p><p>1997年-执教于日本东京大学建筑系，并担任东京大学工学部教授。</p><p>1997年-2003年-从东京大学退休，转任名誉教授。</p><p>2005年-获得东京大学的终身特别荣誉教授。</p><p>2011年-担任东南大学的客座教授。</p>'
            )
        );
        return $row;
    }

}