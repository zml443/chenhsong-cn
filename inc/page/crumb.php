<?php
$nav = array(
	array(
		'name' => lang('{/page.index/}'),
		'href' => '/',
		'target' => '_self'
	)
);
switch ($_ARG['m']) {
	case 'search':
		$nav[] = array(
			'name' => lang('{/page.search/}'),
			'href' => url::set('', 'search'),
			'target' => '_self'
		);
		break;
	case 'team':
	case 'team-detail':
		$nav[] = array(
			'name' => lang('{/page.team/}'),
			'href' => '/team/',
			'target' => '_self'
		);
		if ($_ARG['m']=='team-detail') $nav[] = array(
			'name' => \saas::$row['Name'],
			'href' => \saas::$row['Href']
		);
		break;
	case 'products-detail':
	case 'products':
		$nav[] = array(
			'name' => lang('{/page.products/}'),
			'href' => '/products/',
			'target' => '_self'
		);
		if ($_ARG['m']=='products-detail') $nav[] = array(
			'name' => \saas::$row['Name'],
			'href' => \saas::$row['Href']
		);
		break;
	case 'blog':
	case 'blog-detail':
		$nav[] = array(
			'name' => lang('{/page.blog/}'),
			'href' => '/blog/',
			'target' => '_self'
		);
		if ($_ARG['m']=='blog-detail') $nav[] = array(
			'name' => \saas::$row['Name'],
			'href' => \saas::$row['Href']
		);
		break;
	case 'solution':
	case 'solution-detail':
		$nav[] = array(
			'name' => lang('{/page.solution/}'),
			'href' => '/solution/',
			'target' => '_self'
		);
		if ($_ARG['m']=='solution-detail') $nav[] = array(
			'name' => \saas::$row['Name'],
			'href' => \saas::$row['Href']
		);
		break;
	case 'case':
	case 'case-detail':
		$nav[] = array(
			'name' => lang('{/page.case/}'),
			'href' => '/case/',
			'target' => '_self'
		);
		if ($_ARG['m']=='case-detail') $nav[] = array(
			'name' => \saas::$row['Name'],
			'href' => \saas::$row['Href']
		);
		break;
	case 'server':
	case 'server-detail':
		$nav[] = array(
			'name' => lang('{/page.server/}'),
			'href' => '/server/',
			'target' => '_self'
		);
		if ($_ARG['m']=='server-detail') $nav[] = array(
			'name' => \saas::$row['Name'],
			'href' => \saas::$row['Href']
		);
		break;
	case 'video':
	case 'video-detail':
		$nav[] = array(
			'name' => lang('{/page.video/}'),
			'href' => '/video/',
			'target' => '_self'
		);
		if ($_ARG['m']=='video-detail') $nav[] = array(
			'name' => \saas::$row['Name'],
			'href' => \saas::$row['Href']
		);
		break;
	case 'contact-us':
		$nav[] = array(
			'name' => lang('{/page.contact_us/}'),
			'href' => url::get('', 'contact-us'),
			'target' => '_self'
		);
		break;
	case 'about':
		$nav[] = array(
			'name' => lang('{/page.about_us/}'),
			'href' => url::get('', 'about'),
			'target' => '_self'
		);
		break;
	case 'faq':
		$nav[] = array(
			'name' => lang('{/page.faq/}'),
			'href' => '/faq.html',
			'target' => '_self'
		);
		break;
	case 'member/register':
		$nav[] = array(
			'name' => lang('{/page.member_register/}'),
			'href' => '/member/register.html',
			'target' => '_self'
		);
		break;
	case 'member/login':
		$nav[] = array(
			'name' => lang('{/page.member_login/}'),
			'href' => '/member/login.html',
			'target' => '_self'
		);
		break;
	case 'cart/buynow':
		$nav[] = array(
			'name' => '立即结算',
			'href' => '/cart/checkout.html',
			'target' => '_self'
		);
		break;
	case 'cart/index':
	case 'cart/checkout':
		$nav[] = array(
			'name' => '购物车',
			'href' => '/cart/',
			'target' => '_self'
		);
		if ($_ARG['m']=='cart/checkout') {
			$nav[] = array(
				'name' => '结算',
				'href' => '/cart/checkout.html',
				'target' => '_self'
			);
		}
		if ($_ARG['m']=='cart/buynow') {
			$nav[] = array(
				'name' => '立即结算',
				'href' => '/cart/checkout.html',
				'target' => '_self'
			);
		}
		break;
	case 'member/index':
	case 'member/orders':
	case 'member/orders-detail':
	case 'member/after-sales':
	case 'member/profile':
	case 'member/orders_tracking':
	case 'member/wallet':
	case 'member/address':
	case 'member/collection':
		$nav[] = array(
			'name' => lang('{/page.member_index/}'),
			'href' => '/member/',
			'target' => '_self'
		);
		switch ($_ARG['m']) {
			case 'member/collection':
				$nav[] = array(
					'name' => '最喜歡的物品',
					'href' => '/member/address.html',
					'target' => '_self'
				);
				break;
			case 'member/address':
				$nav[] = array(
					'name' => '地址管理',
					'href' => '/member/address.html',
					'target' => '_self'
				);
				break;
			case 'member/wallet':
				$nav[] = array(
					'name' => '錢包加值',
					'href' => '/member/wallet.html',
					'target' => '_self'
				);
				break;
			case 'member/after-sales':
				$nav[] = array(
					'name' => '售後服務',
					'href' => '/member/after-sales.html',
					'target' => '_self'
				);
				break;
			case 'member/profile':
				$nav[] = array(
					'name' => '編輯個人檔案',
					'href' => '/member/profile.html',
					'target' => '_self'
				);
				break;
			case 'member/orders':
				$nav[] = array(
					'name' => '購買的物品',
					'href' => '/member/orders.html',
					'target' => '_self'
				);
				break;
			case 'member/orders-detail':
				$nav[] = array(
					'name' => '購買的物品',
					'href' => '/member/orders.html',
					'target' => '_self'
				);
				$nav[] = array(
					'name' => saas::$row['OrderNumber'],
					'href' => saas::$row['Href'],
					'target' => '_self'
				);
				break;
			case 'member/orders_tracking':
				$nav[] = array(
					'name' => '追蹤訂單',
					'href' => '/member/orders_tracking.html',
					'target' => '_self'
				);
				break;
		}
		break;
	case 'customized':
		$nav[] = array(
			'name' => saas::$page_current['Name'],
			'href' => saas::$page_current['Href'],
			'target' => '_self'
		);
		break;
}