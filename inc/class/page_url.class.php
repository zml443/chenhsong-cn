<?php

class page_url {
	public static $is_used = 0;
	// 获取前缀与后缀
	public static function ext ($table) {
		$ext = g('wb_site_page_url.'.$table);
		if ($ext) {
			return $ext;
		}
		switch ($table) {
			// 
			case 'wb_site_page_data':
				$ext = array(
					'prefix' => '',
					'suffix' => 'html',
				);
				break;
			// 
			case 'wb_products':
				$ext = array(
					'prefix' => 'products',
					'suffix' => 'html',
				);
				break;
			case 'wb_products_category':
				$ext = array(
					'prefix' => 'products',
					'suffix' => '/',
				);
				break;
			// 
			case 'wb_blog':
				$ext = array(
					'prefix' => 'blog',
					'suffix' => 'html',
				);
				break;
			case 'wb_blog_category':
				$ext = array(
					'prefix' => 'blog',
					'suffix' => '/',
				);
				break;
			// 
			case 'wb_case':
				$ext = array(
					'prefix' => 'case',
					'suffix' => 'html',
				);
				break;
			case 'wb_case_category':
				$ext = array(
					'prefix' => 'case',
					'suffix' => '/',
				);
				break;
			// 
			case 'wb_download':
				$ext = array(
					'prefix' => 'download',
					'suffix' => 'html',
				);
				break;
			case 'wb_download_category':
				$ext = array(
					'prefix' => 'download',
					'suffix' => '/',
				);
				break;
			// 
			case 'wb_server':
				$ext = array(
					'prefix' => 'server',
					'suffix' => 'html',
				);
				break;
			// 
			default:
				$ext = array(
					'prefix' => '/',
					'suffix' => '',
				);
				break;
		}
		$ext['prefix'] || $ext['prefix'] = '/';
		return $ext;
	}

	// 组合
	public static function merge($url, $table){
		$ext = self::ext($table);
		$prefix = '/'.$ext['prefix'].($ext['prefix']?'/':'');
		$suffix = ($ext['suffix']&&$ext['suffix']!='/'?'.':'').$ext['suffix'];
		$res = $prefix.$url.$suffix;
		return $res;
	}
	
	// xxx
	public static function init(){
		$url = trim(str_replace(strrchr($_GET['weburl'], '.'), '', $_GET['weburl']),'/');
		if (!$url) {
			return;
		}
		$url_1 = strstr($url, '/');
		if ($url_1) {
			$url_dir = str_replace($url_1, '', $url);
			$url_path = trim($url_1, '/');
		} else {
			$url_dir = '';
			$url_path = $url;
		}
		// 获取链接指定的表
		$page = db::result("select * from page_url where Url='{$url_path}' and PrefixUrl='{$url_dir}' limit 1");
		$page || $page = db::result("select * from page_url where Url='{$url}' and PrefixUrl='' limit 1");
		if ($page) {
			self::$is_used = 1;
			switch ($page['ExtTable']) {
				case 'wb_products':
					$_GET['weburl'] = '/products-detail/id-'.$page['ExtId'];
					break;
				case 'wb_products_category':
					$_GET['weburl'] = '/products/cid-'.$page['ExtId'];
					break;

				case 'wb_blog':
					$_GET['weburl'] = '/blog-detail/id-'.$page['ExtId'];
					break;
				case 'wb_blog_category':
					$_GET['weburl'] = '/blog/cid-'.$page['ExtId'];
					break;

				case 'wb_case':
					$_GET['weburl'] = '/case-detail/id-'.$page['ExtId'];
					break;
				case 'wb_case_category':
					$_GET['weburl'] = '/case/cid-'.$page['ExtId'];
					break;

				case 'wb_download':
					$_GET['weburl'] = '/download-detail/id-'.$page['ExtId'];
					break;
				case 'wb_download_category':
					$_GET['weburl'] = '/download/cid-'.$page['ExtId'];
					break;

				case 'wb_server':
					$_GET['weburl'] = '/server-detail/id-'.$page['ExtId'];
					break;

				case 'wb_site_page_data':
					$_GET['weburl'] = '/customized/page-'.$page['ExtId'];
					break;
			}
		}
	}
}