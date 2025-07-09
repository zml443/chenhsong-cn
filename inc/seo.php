<?php

function_exists('c')||exit();


saas::$page_url = $_SERVER['REQUEST_URI'];

switch ($_GET['m']) {
	// 首页
	case '/':
		saas::$page_url = '/';
		break;
	// 产品
	case 'products':
		saas::$seo = db::seo('wb_products_category', $_GET['cid']);
		saas::$seo || saas::$seo = db::seo('products');
		break;
	case 'products-detail':
		saas::$row = wb_products::detail(array(
			'id' => $_GET['id']
		));
		saas::$row['Language']!=c('lang') && js::location(url::set('', 'wb_products.list'));
		saas::$page_url = url::set(saas::$row, 'wb_products');
		saas::$row || saas::$is404 = 1;
		saas::$seo = db::seo('wb_products', $_GET['id']);
		saas::$row && db::number('views', 'wb_products', saas::$row['Id']);
		break;
	// 团队
	case 'team':
		saas::$seo = db::seo('wb_team_category', $_GET['cid']);
		saas::$seo || saas::$seo = db::seo('team');
		$_SESSION['saas_prev_next_wb_team_cid'] = (int)$_GET['cid'];
		break;
	case 'team-detail':
		saas::$row = wb_team::detail(array(
			'id' => $_GET['id']
		));
		saas::$row['Language']!=c('lang') && js::location(url::set('', 'wb_team.list'));
		saas::$page_url = url::set(saas::$row, 'wb_team');
		saas::$row || saas::$is404 = 1;
		saas::$row || saas::$row = saas_data::team(1);
		saas::$seo = db::seo('wb_team', $_GET['id']);
		break;
	// 新闻博客
	case 'blog':
		saas::$seo = db::seo('wb_blog_category', $_GET['cid']);
		saas::$seo || saas::$seo = db::seo('blog');
		$_SESSION['saas_prev_next_wb_blog_cid'] = (int)$_GET['cid'];
		break;
	case 'blog-detail':
		saas::$row = wb_blog::detail(array(
			'id' => $_GET['id']
		));
		saas::$row['Language']!=c('lang') && js::location(url::set('', 'wb_blog.list'));
		saas::$page_url = url::set(saas::$row, 'wb_blog');
		saas::$row || saas::$is404 = 1;
		saas::$seo = db::seo('wb_blog', $_GET['id']);
		saas::$row && db::number('views', 'wb_blog', saas::$row['Id']);
		break;
	// 解决方案
	case 'solution':
		saas::$seo = db::seo('wb_solution_category', $_GET['cid']);
		saas::$seo || saas::$seo = db::seo('solution');
		$_SESSION['saas_prev_next_wb_solution_cid'] = (int)$_GET['cid'];
		break;
	case 'solution-detail':
		saas::$row = wb_solution::detail(array(
			'id' => $_GET['id']
		));
		saas::$row['Language']!=c('lang') && js::location(url::set('', 'wb_solution.list'));
		saas::$page_url = url::set(saas::$row, 'wb_solution');
		saas::$row || saas::$is404 = 1;
		saas::$seo = db::seo('wb_solution', $_GET['id']);
		break;
	// 行业服务
	case 'server':
		saas::$seo = db::seo('wb_server_category', $_GET['cid']);
		saas::$seo || saas::$seo = db::seo('server');
		$_SESSION['saas_prev_next_wb_server_cid'] = (int)$_GET['cid'];
		break;
	case 'server-detail':
		saas::$row = wb_server::detail(array(
			'id' => $_GET['id']
		));
		saas::$row['Language']!=c('lang') && js::location(url::set('', 'wb_server.list'));
		saas::$page_url = url::set(saas::$row, 'wb_server');
		saas::$row || saas::$is404 = 1;
		saas::$seo = db::seo('wb_server', $_GET['id']);
		break;
	// 协会
	case 'enterprise':
		saas::$seo = db::seo('wb_enterprise_category', $_GET['cid']);
		saas::$seo || saas::$seo = db::seo('enterprise');
		$_SESSION['saas_prev_next_wb_enterprise_cid'] = (int)$_GET['cid'];
		break;
	case 'enterprise-detail':
		saas::$row = wb_enterprise::detail(array(
			'id' => $_GET['id']
		));
		saas::$row['Language']!=c('lang') && js::location(url::set('', 'wb_enterprise.list'));
		saas::$page_url = url::set(saas::$row, 'wb_enterprise');
		saas::$row || saas::$is404 = 1;
		saas::$seo = db::seo('wb_enterprise', $_GET['id']);
		break;
	// 时装周
	case 'fashion':
		saas::$seo = db::seo('wb_fashion_category', $_GET['cid']);
		saas::$seo || saas::$seo = db::seo('fashion');
		$_SESSION['saas_prev_next_wb_fashion_cid'] = (int)$_GET['cid'];
		break;
	case 'fashion-detail':
		saas::$row = wb_fashion::detail(array(
			'id' => $_GET['id']
		));
		saas::$row['Language']!=c('lang') && js::location(url::set('', 'wb_fashion.list'));
		saas::$page_url = url::set(saas::$row, 'wb_fashion');
		saas::$row || saas::$is404 = 1;
		saas::$seo = db::seo('wb_fashion', $_GET['id']);
		break;
	// 分店
	case 'branches':
		saas::$seo = db::seo('wb_join_branches_category', $_GET['cid']);
		saas::$seo || saas::$seo = db::seo('join_branches');
		$_SESSION['saas_prev_next_wb_join_branches_cid'] = (int)$_GET['cid'];
		break;
	case 'branches-detail':
		saas::$row = wb_join_branches::detail(array(
			'id' => $_GET['id']
		));
		saas::$row['Language']!=c('lang') && js::location(url::set('', 'wb_join_branches.list'));
		saas::$page_url = url::set(saas::$row, 'wb_join_branches');
		saas::$row || saas::$is404 = 1;
		saas::$seo = db::seo('wb_join_branches', $_GET['id']);
		break;
	// 下载
	case 'download':
		saas::$seo = db::seo('wb_download_category', $_GET['cid']);
		saas::$seo || saas::$seo = db::seo('download');
		$_SESSION['saas_prev_next_wb_download_cid'] = (int)$_GET['cid'];
		break;
	// 案例
	case 'case':
		saas::$seo = db::seo('wb_case_category', $_GET['cid']);
		saas::$seo || saas::$seo = db::seo('case');
		$_SESSION['saas_prev_next_wb_case_cid'] = (int)$_GET['cid'];
		break;
	case 'case-detail':
		saas::$row = wb_case::detail(array(
			'id' => $_GET['id']
		));
		saas::$row['Language']!=c('lang') && js::location(url::set('', 'wb_case.list'));
		saas::$page_url = url::set(saas::$row, 'wb_case');
		saas::$row || saas::$is404 = 1;
		saas::$seo = db::seo('wb_case', $_GET['id']);
		break;
	// 常见问题
	case 'faq':
		saas::$seo = db::seo('faq');
		break;
	// 常见问题
	case 'about':
		saas::$seo = db::seo('about');
		break;
	// 常见问题
	case 'contact-us':
		saas::$seo = db::seo('contact-us');
		break;
	// 自定义页面
	case 'customized':
		saas::$seo = db::seo('wb_site_page', $_GET['page']);
		saas::$page_current = wb_site_page::detail(array('id'=>$_GET['page']));
		saas::$page_current || saas::$is404 = 1;
		saas::$page_url = url::set(saas::$page_current, 'wb_site_page');
		break;
	// 会员订单
	case 'member/orders-detail':
		saas::$row = wb_orders::detail_current(array(
			'OrderNumber' => $_GET['o']
		));
		saas::$row || saas::$is404 = 1;
		break;
}