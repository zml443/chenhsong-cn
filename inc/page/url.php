<?php

$row = array();
$row[] = array(
	'label' => lang('{/page.index/}'),
	'type' => 'index',
	'value' => '/',
);
if ($app_store_ary['_']['wb_products'] || a('wb_products')) {
	$row[] = array(
		'label' => lang('{/page.products/}'),
		'type' => 'products',
		'value' => '/products/'
	);
	$pro_x = wb_products_category::all_url();
	if ($pro_x) {
		$row[] = array(
			'label' => lang('{/page.products_category/}'),
			'type' => 'products',
			'value' => '',
			'children' => $pro_x
		);
	}
}
if (a('wb_activity')) {
	$row[] = array(
		'label' => lang('{/page.activity/}'),
		'type' => 'activity',
		'value' => '/activity/',
	);
	$pro_x = wb_activity_category::all_url();
	if ($pro_x) {
		$row[] = array(
			'label' => lang('{/page.activity_category/}'),
			'type' => 'activity',
			'value' => '',
			'children' => $pro_x
		);
	}
}
if (a('wb_enterprise')) {
	$row[] = array(
		'label' => lang('{/page.enterprise_personage/}'),
		'type' => 'enterprise-personage',
		'value' => '/enterprise-personage/',
	);
	$row[] = array(
		'label' => lang('{/page.enterprise/}'),
		'type' => 'enterprise',
		'value' => '/enterprise/',
	);
	$pro_x = wb_enterprise_category::all_url();
	if ($pro_x) {
		$row[] = array(
			'label' => lang('{/page.enterprise_category/}'),
			'type' => 'enterprise',
			'value' => '',
			'children' => $pro_x
		);
	}
}
if (a('wb_fashion')) {
	$row[] = array(
		'label' => lang('{/page.fashion/}'),
		'type' => 'fashion',
		'value' => '/fashion/',
	);
	$pro_x = wb_fashion_category::all_url();
	if ($pro_x) {
		$row[] = array(
			'label' => lang('{/page.fashion_category/}'),
			'type' => 'fashion',
			'value' => '',
			'children' => $pro_x
		);
	}
}
if (a('wb_branches')) {
	$row[] = array(
		'label' => lang('{/page.branches/}'),
		'type' => 'branches',
		'value' => '/branches/',
	);
	$pro_x = wb_branches_category::all_url();
	if ($pro_x) {
		$row[] = array(
			'label' => lang('{/page.branches_category/}'),
			'type' => 'branches',
			'value' => '',
			'children' => $pro_x
		);
	}
}
if (a('wb_hotel')) {
	$row[] = array(
		'label' => lang('{/page.hotel/}'),
		'type' => 'hotel',
		'value' => '/hotel/',
	);
	$pro_x = wb_hotel_category::all_url();
	if ($pro_x) {
		$row[] = array(
			'label' => lang('{/page.hotel_category/}'),
			'type' => 'hotel',
			'value' => '',
			'children' => $pro_x
		);
	}
}
if (a('wb_blog')) {
	$row[] = array(
		'label' => lang('{/page.blog/}'),
		'type' => 'blog',
		'value' => '/blog/',
	);
	$pro_x = wb_blog_category::all_url();
	if ($pro_x) {
		$row[] = array(
			'label' => lang('{/page.blog_category/}'),
			'type' => 'blog',
			'value' => '',
			'children' => $pro_x
		);
	}
}
if (a('wb_case')) {
	$row[] = array(
		'label' => lang('{/page.case/}'),
		'type' => 'case',
		'value' => '/case/',
	);
	$pro_x = wb_case_category::all_url();
	if ($pro_x) {
		$row[] = array(
			'label' => lang('{/page.case_category/}'),
			'type' => 'case',
			'value' => '',
			'children' => $pro_x
		);
	}
}
if (a('wb_team')) {
	$row[] = array(
		'label' => lang('{/page.team/}'),
		'type' => 'team',
		'value' => '/team/',
	);
	$pro_x = wb_team_category::all_url();
	if ($pro_x) {
		$row[] = array(
			'label' => lang('{/page.team_category/}'),
			'type' => 'team',
			'value' => '',
			'children' => $pro_x
		);
	}
}
if (a('wb_video')) {
	$row[] = array(
		'label' => lang('{/page.video/}'),
		'type' => 'video',
		'value' => '/video/',
	);
	$pro_x = wb_video_category::all_url();
	if ($pro_x) {
		$row[] = array(
			'label' => lang('{/page.video_category/}'),
			'type' => 'video',
			'value' => '/video/',
			'children' => $pro_x
		);
	}
}
if (a('wb_solution')) {
	$row[] = array(
		'label' => lang('{/page.solution/}'),
		'type' => 'solution',
		'value' => '/solution.html',
		'children' => $pro_x
	);
	$pro_x = wb_solution::all_url();
	if ($pro_x) {
		$row[] = array(
			'label' => lang('{/page.solution_detail/}'),
			'type' => 'solution',
			'value' => '',
			'children' => $pro_x
		);
	}
}
if (a('wb_server')) {
	$row[] = array(
		'label' => lang('{/page.server/}'),
		'type' => 'server',
		'value' => '/server.html',
	);
	$pro_x = wb_server::all_url();
	if ($pro_x) {
		$row[] = array(
			'label' => lang('{/page.server_detail/}'),
			'type' => 'server',
			'value' => '',
			'children' => $pro_x
		);
	}
}
if (a('wb_join')) {
	$row[] = array(
		'label' => lang('{/page.join/}'),
		'type' => 'join',
		'value' => '/join.html',
	);
}
if (a('wb_faq')) {
	$row[] = array(
		'label' => lang('{/page.faq/}'),
		'type' => 'faq',
		'value' => '/faq.html',
	);
}
if (a('wb_download')) {
	$row[] = array(
		'label' => lang('{/page.download/}'),
		'type' => 'download',
		'value' => '/download.html',
	);
	$pro_x = wb_download_category::all_url();
	if ($pro_x) {
		$row[] = array(
			'label' => lang('{/page.download_category/}'),
			'type' => 'download',
			'value' => '',
			'children' => $pro_x
		);
	}
}
$row[] = array(
	'label' => lang('{/page.contact_us/}'),
	'type' => 'contact-us',
	'value' => '/contact-us.html',
);
/*if (a('wb_products_brand')) {
	$row[] = array(
		'label' => '品牌页面',
		'value' => '/brand.html',
	);
}*/
$row[] = array(
	'label' => lang('{/page.about_us/}'),
	'type' => 'about',
	'value' => '/about.html',
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
			'type' => 'customized-'.$v['Id'],
			'value' => '/customized/page-'.$v['Id'],
		);
	}
	$row[] = array(
		'label' => '自定义页面',
		'type' => 'customized',
		'value' => '',
		'children' => $customized
	);
}