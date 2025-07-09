<?php

class wb_site_page{
	// 网站全部页面
	public static function get_page($_ARG=array()){
		include c('root').'inc/page/sys.php';
		return $row;
	}

	// 当前页面信息
	/*public static function current($_ARG=array()){
		if ($_GET['']) {

		}
		return array(
			'label' => '首页',
			'type' => 'index',
			'value' => '/',
		);
	}*/
	// 页面链接
	public static function url($_ARG=array()){
		include c('root').'inc/page/url.php';
		return $row;
	}

	// 获取面包屑
	public static function crumb($_ARG=array()){
		include c('root').'inc/page/crumb.php';
		return $nav;
	}

	// 获取类别
	public static function category($_ARG=array()){
		include c('root').'inc/page/category.php';
		return $row;
	}

	// 获取当前页面的列表页
	public static function current_url($_ARG=array()){
		switch ($_ARG['m']) {
			case 'products':
			case 'products-detail':
				$row = url::set('', 'wb_products.list');
				break;
			case 'solution':
			case 'solution-detail':
				$row = url::set('', 'wb_solution.list');
				break;
			case 'blog':
			case 'blog-detail':
				$row = url::set('', 'wb_blog.list');
				break;
			case 'download':
			case 'download-detail':
				$row = url::set('', 'wb_download.list');
				break;
			case 'faq':
				$row = url::set('', 'wb_faq.list');
				break;
			default:
				$row = $row = url::set('', 'wb_products.list');
				break;
		}
		return $row;
	}

	// 相关案例
	// 由系统推送
	public static function relation_case($_ARG=array()){
		return array();
	}

	// 相关案例
	// 由系统推送
	public static function relation_product($_ARG=array()){
		return array();
	}

	public static function detail($_ARG=array()){
		$id = (int)$_ARG['id'];
		$res = db::result("select * from wb_site_page_data where Id=$id limit 0,1");
		$res['Name'] = $res[ln('Name')];
		$res['Href'] = url::set($res, 'wb_site_page');
		$res['Editor'] = db::editor('wb_site_page_data', $id, ln('Editor'));
		return $res;
	}
}
?>