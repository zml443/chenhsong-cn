<?php

// 统一链接

// $v, $type



switch($type){
	// 产品
	// case 'wb_products_category':
	// case 'wb_products.list':
	// 	if ($v) {
	// 		if ($v['PageUrl']) {
	// 			$url = page_url::merge($v['PageUrl'], 'wb_products_category');
	// 		} else {
	// 			$url = '/products/cid-' . $v['Id'] . '.html';
	// 		}
	// 	} else {
	// 		$url = '/products/';
	// 	}
	// 	break;

	case 'wb_products':
	case 'wb_products.detail':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_products');
			} else {
				$url = '/products-detail/pid-'.$v['Id'].'.html';
			}
		} else {
			$url = '/products-detail/id-0.html';
		}
		break;

	case 'wb_industry':
	case 'wb_industry.detail':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_industry');
			} else {
				$url = '/industry-detail/id-'.$v['Id'].'.html';
			}
		} else {
			$url = '/industry-detail/id-0.html';
		}
		break;

	// 新闻博客
	case 'wb_blog_category':
	case 'wb_blog.list':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_blog_category');
			} else {
				$url = '/blog/bid-' . $v['Id'] . '.html';
			}
		} else {
			$url = '/blog/';
		}
		break;
	case 'wb_blog.detail':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_blog');
			} else {
				$url = '/blog-detail/bid-'.$v['Id'].'.html';
			}
		} else {
			$url = '/blog-detail/id-0.html';
		}
		break;

	case 'wb_invest_category2.category':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_blog');
			} else {
				$url = '/announcements/aid-'.$v['Id'].'.html';
			}
		} else {
			$url = '/announcements/aid-0.html';
		}
		break;

	case 'wb_factory_category':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_factory_category');
			} else {
				$url = '/smart-factory-automation/aid-'.$v['Id'].'.html';
			}
		} else {
			$url = '/smart-factory-automation/id-0.html';
		}
		break;

	case 'wb_products_category.down':
		if ($v) {
			$url = '/download/cid-' . $v['Id'] . '.html';
		} else {
			$url = '/download/';
		}
		break;

	case 'wb_about_director.detail':
		if ($v) {
			$url = '/introduce/id-' . $v['Id'] . '.html';
		} else {
			$url = '/introduce/';
		}
		break;

	case 'wb_about_responsibility.detail':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_about_responsibility');
			} else {
				$url = '/responsibility-detail/rid-'.$v['Id'].'.html';
			}
		} else {
			$url = '/responsibility-detail/id-0.html';
		}
		break;
/*
	// 行业服务
	case 'wb_server_category':
	case 'wb_server.list':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_server_category');
			} else {
				$url = '/server/cid-' . $v['Id'] . '.html';
			}
		} else {
			$url = '/server/';
		}
		break;
	case 'wb_server':
	case 'wb_server.detail':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_server');
			} else {
				$url = '/server-detail/id-'.$v['Id'].'.html';
			}
		} else {
			$url = '/server-detail/id-0.html';
		}
		break;

	
	// 会员中心，订单
	case 'wb_orders.detail':
		$url = '/member/orders-detail/o-' . $v['OrderNumber'] . '.html';
		break;

	// 案例
	case 'wb_case_category':
	case 'wb_case.list':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_case_category');
			} else {
				$url = '/case/cid-' . $v['Id'] . '.html';
			}
		} else {
			$url = '/case/';
		}
		break;
	case 'wb_case':
	case 'wb_case.detail':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_case');
			} else {
				$url = '/case-detail/id-'.$v['Id'].'.html';
			}
		} else {
			$url = '/case-detail/id-0.html';
		}
		break;

	// 常见问题
	case 'wb_faq_category':
	case 'wb_faq.list':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_faq_category');
			} else {
				$url = '/faq/cid-' . $v['Id'] . '.html';
			}
		} else {
			$url = '/faq/';
		}
		break;
	case 'wb_faq':
	case 'wb_faq.detail':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_faq');
			} else {
				$url = '/faq-detail/id-'.$v['Id'].'.html';
			}
		} else {
			$url = '/faq-detail/id-0.html';
		}
		break;

	// 团队
	case 'wb_team_category':
	case 'wb_team.list':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_team_category');
			} else {
				$url = '/team/cid-' . $v['Id'] . '.html';
			}
		} else {
			$url = '/team/';
		}
		break;
	case 'wb_team':
	case 'wb_team.detail':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_team');
			} else {
				$url = '/team-detail/id-'.$v['Id'].'.html';
			}
		} else {
			$url = '/team-detail/id-0.html';
		}
		break;

	// 解决方案
	case 'wb_solution_category':
	case 'wb_solution.list':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_solution_category');
			} else {
				$url = '/solution/cid-' . $v['Id'] . '.html';
			}
		} else {
			$url = '/solution/';
		}
		break;
	case 'wb_solution':
	case 'wb_solution.detail':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_solution');
			} else {
				$url = '/solution-detail/id-'.$v['Id'].'.html';
			}
		} else {
			$url = '/solution-detail/id-0.html';
		}
		break;
	
	// 联系我们
	case 'contact-us':
		$url = '/contact-us.html';
		break;

	// 关于我们
	case 'about':
		$url = '/about.html';
		break;

	// 搜索
	case 'search':
		$url = '/search.html';
		break;

	// 搜索
	case 'form':
		$url = '/form.html';
		break;

	// 自定义页面
	case 'customized':
	case 'wb_site_page_data':
		if ($v) {
			if ($v['PageUrl']) {
				$url = page_url::merge($v['PageUrl'], 'wb_site_page_data');
			} else {
				$url = '/customized/page-'.$v['Id'];
			}
		} else {
			$url = '/customized/page-0.html';
		}
		break;
*/
	default:
		$url = '';
		break;

}
return $url;
