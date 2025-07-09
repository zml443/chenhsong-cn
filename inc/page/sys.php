<?php
if (c('HostTag')=='shop') {
    $app_store_ary = include c('root').'manage/__/app-shop.php';
} else {
    $app_store_ary = include c('root').'manage/__/app-web.php';
}
$row = array();
$row[] = array(
	'label' => lang('{/page.index/}'),
	'type' => 'index',
	'value' => '/',
);
if ($app_store_ary['_']['wb_products'] || a('wb_products')) {
	$row[] = array(
		'label' => lang('{/page.products/}'),
		'children' => array(
			array(
				'label' => lang('{/page.products/}'),
				'type' => 'products',
				'value' => '/products/',
			),
			array(
				'label' => lang('{/page.products_detail/}'),
				'type' => 'products-detail',
				'value' => '/products-detail/id-0',
			),
		),
	);
}

if (a('wb_activity')) {
	$row[] = array(
		'label' => lang('{/page.activity/}'),
		'children' => array(
			array(
				'label' => lang('{/page.activity/}'),
				'type' => 'activity',
				'value' => '/activity/',
			),
			array(
				'label' => lang('{/page.activity_detail/}'),
				'type' => 'activity-detail',
				'value' => url::set('', 'wb_activity.detail'),
			),
		),
	);
}


if (a('wb_enterprise')) {
	$row[] = array(
		'label' => lang('{/page.enterprise/}'),
		'children' => array(
			array(
				'label' => lang('{/page.enterprise_personage/}'),
				'type' => 'enterprise-personage',
				'value' => url::set('', 'wb_enterprise_personage.list'),
			),
			array(
				'label' => lang('{/page.enterprise/}'),
				'type' => 'enterprise',
				'value' => '/enterprise/',
			),
			array(
				'label' => lang('{/page.enterprise_detail/}'),
				'type' => 'enterprise-detail',
				'value' => url::set('', 'wb_enterprise.detail'),
			),
		),
	);
}

if (a('wb_fashion')) {
	$row[] = array(
		'label' => lang('{/page.fashion/}'),
		'children' => array(
			array(
				'label' => lang('{/page.fashion/}'),
				'type' => 'fashion',
				'value' => '/fashion/',
			),
			array(
				'label' => lang('{/page.fashion_detail/}'),
				'type' => 'fashion-detail',
				'value' => url::set('', 'wb_fashion.detail'),
			),
		),
	);
}

if (a('wb_branches')) {
	$row[] = array(
		'label' => lang('{/page.branches/}'),
		'children' => array(
			array(
				'label' => lang('{/page.branches/}'),
				'type' => 'branches',
				'value' => '/branches/',
			),
			array(
				'label' => lang('{/page.branches_detail/}'),
				'type' => 'branches-detail',
				'value' => url::set('', 'wb_branches.detail'),
			),
		),
	);
}

if (a('wb_hotel')) {
	$row[] = array(
		'label' => lang('{/page.hotel/}'),
		'children' => array(
			array(
				'label' => lang('{/page.hotel/}'),
				'type' => 'hotel',
				'value' => '/hotel/',
			),
			array(
				'label' => lang('{/page.hotel_detail/}'),
				'type' => 'hotel-detail',
				'value' => url::set('', 'wb_hotel.detail'),
			),
		),
	);
}

if (a('wb_blog')) {
	$row[] = array(
		'label' => lang('{/page.blog/}'),
		'children' => array(
			array(
				'label' => lang('{/page.blog/}'),
				'type' => 'blog',
				'value' => '/blog/',
			),
			array(
				'label' => lang('{/page.blog_detail/}'),
				'type' => 'blog-detail',
				'value' => url::set('', 'wb_blog.detail'),
			),
		),
	);
}
if (a('wb_team')) {
	$row[] = array(
		'label' => lang('{/page.team/}'),
		'children' => array(
			array(
				'label' => lang('{/page.team/}'),
				'type' => 'team',
				'value' => url::set('', 'wb_team.list'),
			),
			array(
				'label' => lang('{/page.team_detail/}'),
				'type' => 'team-detail',
				'value' => url::set('', 'wb_team.detail'),
			),
		),
	);
}
if (a('wb_case')) {
	$row[] = array(
		'label' => lang('{/page.case/}'),
		'children' => array(
			array(
				'label' => lang('{/page.case/}'),
				'type' => 'case',
				'value' => url::set('', 'wb_case.list'),
			),
			array(
				'label' => lang('{/page.case_detail/}'),
				'type' => 'case-detail',
				'value' => url::set('', 'wb_case.detail'),
			),
		),
	);
}
if (a('wb_solution')) {
	$row[] = array(
		'label' => lang('{/page.solution/}'),
		'children' => array(
			array(
				'label' => lang('{/page.solution/}'),
				'type' => 'solution',
				'value' => url::set('', 'wb_solution.list'),
			),
			array(
				'label' => lang('{/page.solution_detail/}'),
				'type' => 'solution-detail',
				'value' => url::set('', 'wb_solution.detail'),
			),
		),
	);
}
if (a('wb_server')) {
	$row[] = array(
		'label' => lang('{/page.server/}'),
		'children' => array(
			array(
				'label' => lang('{/page.server/}'),
				'type' => 'server',
				'value' => url::set('', 'wb_server.list'),
			),
			array(
				'label' => lang('{/page.server_detail/}'),
				'type' => 'server-detail',
				'value' => url::set('', 'wb_server.detail'),
			),
		),
	);
}
if (a('wb_join')) {
	$row[] = array(
		'label' => lang('{/page.join/}'),
		'type' => 'join',
		'value' => '/join.html',
	);
}
if (a('wb_join_branches')) {
	$row[] = array(
		'label' => lang('{/page.branches/}'),
		'children' => array(
			array(
				'label' => lang('{/page.branches/}'),
				'type' => 'branches',
				'value' => url::set('', 'wb_join_branches.list'),
			),
			array(
				'label' => lang('{/page.branches_detail/}'),
				'type' => 'branches-detail',
				'value' => url::set('', 'wb_join_branches.detail'),
			),
		),
	);
}
if (a('wb_video')) {
	$row[] = array(
		'label' => lang('{/page.video/}'),
		'children' => array(
			array(
				'label' => lang('{/page.video/}'),
				'type' => 'video',
				'value' => url::set('', 'wb_video.list'),
			),
			array(
				'label' => lang('{/page.video_detail/}'),
				'type' => 'video-detail',
				'value' => url::set('', 'wb_video.detail'),
			),
		),
	);
}
if (a('wb_faq')) {
	$row[] = array(
		'label' => lang('{/page.faq/}'),
		'type' => 'faq',
		'value' => url::set('', 'wb_faq.list'),
	);
}
if (a('wb_download')) {
	$row[] = array(
		'label' => lang('{/page.download/}'),
		'type' => 'download',
		'value' => url::set('', 'wb_download.list'),
	);
}
$row[] = array(
	'label' => lang('{/page.contact_us/}'),
	'type' => 'contact-us',
	'value' => url::set('', 'contact-us'),
);
$row[] = array(
	'label' => lang('{/page.about_us/}'),
	'type' => 'about',
	'value' => url::set('', 'about'),
);
$row[] = array(
	'label' => lang('{/page.search/}'),
	'type' => 'search',
	'value' => url::set('', 'search'),
);
if (c('HostTag')=='shop') {
	$row[] = array(
		'label' => lang('{/page.member_login/}'),
		'type' => 'member/login',
		'value' => '/member/login.html',
	);
	$row[] = array(
		'label' => lang('{/page.member_register/}'),
		'type' => 'member/register',
		'value' => '/member/register.html',
	);
}
$res = db::query("select * from wb_site_page_data where `IsLock`=0");
if ($res->num_rows) {
	$customized = array();
	while ($v = db::result($res)) {
		$customized[] = array(
			'id' => $v['Id'],
			'label' => $v[ln('Name')],
			'value' => url::set($v, 'wb_site_page_data'),
		);
	}
	$row[] = array(
		'label' => '自定义页面',
		'value' => '',
		'children' => $customized
	);
}