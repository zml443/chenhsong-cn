<?php 
$head = g('wb_site_config');
$nav = array(
	// array(
	// 	'name'  	=> l('首页','Home'),
	// 	'href'  	=> '/',
	// 	'target' 	=> '_self',
	// 	'is_footer'	=> 0,
	// 	'cur' 		=> $navId=='index'?'cur':'',
	// ),
	'products' => array(
		'name' 		=> l('产品中心','Products'),
		'href' 		=> 'javascript:;',
		'target' 	=> '_self',
		'cur' 		=> $navId=='products'?'cur':'',
		'is_footer'	=> 1,
		'is_pro' 	=> 1,
		'children'  => array(),
	),
	'industry' => array(
		'name' 		=> l('行业方案','Industry'),
		'href' 		=> '/industry',
		'target'	=> '_self',
		'is_Sol'	=> 1,
		'cur' 		=> $navId=='industry'?'cur':'',
		'is_footer'	=> 1,
		'children'	=> array(),
	),
	'factory' => array(
		'name' 		=> l('智能产业','Smart Factory'),
		'href' 		=> '/smart-factory',
		'target'	=> '_self',
		'cur' 		=> $navId=='factory'?'cur':'',
		'is_footer'	=> 1,
		'children'	=> array(
			array(
				'name' 		=> l('iChen Smart Factory 震雄智能工厂','iChen Smart Factory'),
				'subname'	=> 'engineering', 
				'href' 		=> '/smart-factory',
				'target' 	=> '_self',
				'cur' 		=> $navTwoId=='factory'?'cur':'',
			),
			array(
				'name' 		=> l('iChen Cloud 震雄智云','iChen Cloud'),
				'subname'	=> 'megacloud',
				'href' 		=> '/smart-factory-megacloud',
				'target' 	=> '_self',
				'cur' 		=> $navTwoId=='megacloud'?'cur':'',
			),
			// array(
			// 	'name' 		=> l('模具与产品','Mold and Product'),
			// 	'subname'	=> 'mold',
			// 	'href' 		=> '/smart-factory-mold',
			// 	'target' 	=> '_self',
			// 	'cur' 		=> $navTwoId=='mold'?'cur':'',
			// ),
			array(
				'name' 		=> l('iChen AI Molder 震雄AI调模大师','iChen AI Molder'),
				'subname'	=> 'automation',
				'href' 		=> '/smart-factory-automation',
				'target' 	=> '_self',
				'cur' 		=> $navTwoId=='automation'?'cur':'',
			),
		),
	),
	'service' => array(
		'name' 		=> l('服务&支持','Service'),
		'href' 		=> '/service-network',
		'target' 	=> '_self',
		'cur' 		=> $navId=='service'?'cur':'',
		'is_footer'	=> 1,
		'children'	=> array(
			array(
				'name' 		=> l('全球服务网络','Global Service Network'),
				'href' 		=> '/service-network#service_network',
				'target' 	=> '_self',
				'cur' 		=> $navTwoId=='network'?'cur':'',
			),
			array(
				'name' 		=> l('全球配件仓','Global accessory warehouse'),
				'href' 		=> '/service-network#service_accessory',
				'target' 	=> '_self',
				'cur' 		=> '',
			),
			array(
				'name' 		=> l('服务易','Service Easy'),
				'href' 		=> '/service',
				'target' 	=> '_self',
				'cur' 		=>  $navTwoId=='service'?'cur':'',
			),
		),
	),
	'media' => array(
		'name' 		=> l('媒体中心 ','Media Center'),
		'href' 		=> '/blog',
		'target'	=> '_self',
		'cur' 		=> $navId=='media'?'cur':'',
		'is_footer'	=> 1,
		'children'	=> array(),
	),
	'about' => array(
		'name' 		=> l('关于我们','About'),
		'href' 		=> '/about',
		'target'	=> '_self',
		'cur' 		=> $navId=='about'?'cur':'',
		'is_footer'	=> 1,
		'children'	=> array(
			array(
				'name' 		=> l('震雄故事','About Us'),
				'href' 		=> '/about#about_one',
				'target' 	=> '_self',
				'cur' 		=> $navTwoId=='about'?'cur':'',
			),
			array(
				'name' 		=> l('蒋震工业慈善基金','Charity'),
				'href' 		=> '/about#about_charity',
				'target' 	=> '_self',
				'cur' 		=> '',
			),
			array(
				'name' 		=> l('发展历程','History'),
				'href' 		=> '/about#about_history',
				'target' 	=> '_self',
				'cur' 		=> '',
			),
			array(
				'name' 		=> l('荣誉资质','Honor'),
				'href' 		=> '/about#about_honor',
				'target' 	=> '_self',
				'cur' 		=> '',
			),
			array(
				'name' 		=> l('企业文化','Culture'),
				'href' 		=> '/about#about_culture',
				'target' 	=> '_self',
				'cur' 		=> '',
			),
			array(
				'name' 		=> l('先进技术','Technology'),
				'href' 		=> '/technology',
				'target' 	=> '_self',
				'cur' 		=> $navTwoId=='technology'?'cur':'',
			),
			array(
				'name' 		=> l('品质生产','Production'),
				'href' 		=> '/production',
				'target' 	=> '_self',
				'cur' 		=> $navTwoId=='production'?'cur':'',
			),
			array(
				'name' 		=> l('社会责任','Responsibility'),
				'href' 		=> '/responsibility',
				'target' 	=> '_self',
				'cur' 		=> $navTwoId=='responsibility'?'cur':'',
			),
			array(
				'name' 		=> l('投资者专区','Invest'),
				// 'href' 		=> '/invest',
				'href' 		=> c('lang') =='en' ?'https://chenhsong.com.hk/investor-relations/':'https://chenhsong.com.hk/investor-relations-cn/',
				'target' 	=> '_blank',
				'cur' 		=> $navTwoId=='invest'?'cur':'',
				'children'	=> array(
					array(
						'name' 		=> l('创办人之言','From the Founder'),
						'href' 		=> '/founder',
						'target' 	=> '_self',
						'cur' 		=> $navThreeId=='founder'?'cur':'',
						'pic' 		=> '/images/about/invest/1.jpg',
					),
					array(
						'name' 		=> l('董事局成员','Board Members'),
						'href' 		=> '/board-member',
						'target' 	=> '_self',
						'cur' 		=> $navThreeId=='board'?'cur':'',
						'pic' 		=> '/images/about/invest/2.jpg',
					),
					array(
						'name' 		=> l('公司资料','Company Information'),
						'href' 		=> '/company-information',
						'target' 	=> '_self',
						'cur' 		=> $navThreeId=='information'?'cur':'',
						'pic' 		=> '/images/about/invest/3.jpg',
					),
				),
			),
		),
	),
	'contact' => array(
		'name' 		=> l('联系我们','Contact'),
		'href' 		=> '/contact',
		'target'	=> '_self',
		'cur' 		=> $navId=='contact'?'cur':'',
		'is_footer'	=> 1,
		'children'	=> array()
	),
);

// 产品
$products_cate = db::get_all('wb_products_category', 'Dept = 1', "*", 'MyOrder asc, Id asc');
foreach((array)$products_cate as $item){
	$nav['products']['children'][] = array('Id'=> $item['Id'], 'name' => $item[ln('Name')], 'href' => 'javascript:;');
}

// 行业
$industry = db::get_limit('wb_industry', "Language = '{$c['lang']}' and IsSaleOut != 1", "*", 'MyOrder asc, Id asc',0,12);
foreach((array)$industry as $item){
	$nav['industry']['children'][] = array('Id'=> $item['Id'], 'name' => $item['Name'], 'href' => url::set($item, 'wb_industry.detail'));
}

// 新闻
$blog_cate = db::get_all('wb_blog_category', 'Dept = 1', "*", 'MyOrder asc, Id asc');
foreach((array)$blog_cate as $item){
	$nav['media']['children'][] = array('Id'=> $item['Id'], 'name' => $item[ln('Name')], 'href' => url::set($item, 'wb_blog.list'), 'cur' => $CateId==$item['Id']?'cur':'');
}
$nav['media']['children']['down'] = array(
		'name' 		=> l('下载专区','Download'),
		'href' 		=> '/download',
		'target' 	=> '_self',
		'cur' 		=> $navTwoId=='download'?'cur':'',
);

// 投资者关系报告
$invest_cate = db::get_all('wb_invest_category2', 'Dept = 1', "*", 'MyOrder asc, Id asc');
foreach((array)$invest_cate as $item){
	$nav['about']['children'][8]['children'][] = array('Id'=> $item['Id'], 'name' => $item[ln('Name')], 'tip' => $item[ln('Tip')], 'href' => url::set($item, 'wb_invest_category2.category'), 'cur' => $CateId==$item['Id']?'cur':'', 'icon' => $item['Pictures2']);
}

// 联系我们
$contact_all = db::get_limit('wb_contact', '1', "*", 'MyOrder asc, Id asc',0,2);
foreach((array)$contact_all as $item){
	$nav['contact']['children'][] = array('Id'=> $item['Id'], 'name' => $item[ln('Name')], 'href' => '/contact#contact'.$item['Id'], 'cur' => $item['Id']==1?'cur':'');
}

$nav['contact']['children']['base'] = array(
	'name' 		=> l('全球制造基地','Global Manufacturing Base'),
	'href' 		=> '/contact#base',
	'target' 	=> '_self',
	'cur' 		=> '',
);
$nav['contact']['children']['subsidiaries'] = array(
	'name' 		=> l('全球分公司','Global Subsidiaries'),
	'href' 		=> '/contact#contact_two',
	'target' 	=> '_self',
	'cur' 		=> '',
);
$nav['contact']['children']['beus'] = array(
	'name' 		=> l('成为我们','Be Us'),
	'href' 		=> '/contact#contact_three',
	'target' 	=> '_self',
	'cur' 		=> '',
);

?>