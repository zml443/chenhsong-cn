<?php

class wb_site_nav{
	public static function fields ($v) {
		$v['Url'] || $v['Target'] = '_self';
		$current = self::url_match($v);
		return array(
			'name' => $v[ln('Name')],
			'href' => $v['Url']?:'javascript:;',
			'subnav_type' => $v['SubnavType'],
			'picture' => str::json($v['Pictures'],'decode'),
			'target' => $v['Target']?:'_self',
			'_cur_' => $current,
			'_children_cur_' => 0,
		);
	}

	// 匹配链接
	public static function url_match ($v) {
		$url = $_GET['weburl'];
		$current = 0;
		switch ($_GET['m']) {
			case 'index':
				$current = $v['page_url_type']=='index';
				break;
			case 'products':
			case 'products-detail':
				$current = $v['page_url_type']=='products';
				break;
			case 'blog':
			case 'blog-detail':
				$current = $v['page_url_type']=='blog';
				break;
			case 'case':
			case 'case-detail':
				$current = $v['page_url_type']=='case';
				break;
			case 'download':
			case 'download-detail':
				$current = $v['page_url_type']=='download';
				break;
			case 'team':
			case 'team-detail':
				$current = $v['page_url_type']=='team';
				break;
			case 'about':
				$current = $v['page_url_type']=='about';
				break;
			case 'contact-us':
				$current = $v['page_url_type']=='contact-us';
				break;
			case 'faq':
				$current = $v['page_url_type']=='faq';
				break;
			case 'solution':
			case 'solution-detail':
				$current = $v['page_url_type']=='solution';
				break;
			default:
				$current = 0;
				break;
		}
		return $current;
	}

	// 获取导航
	public static function all ($_ARG=array()) {
		$where = "1";
		$res = db::query("select * from wb_site_nav where {$where} order by Dept asc,MyOrder asc,Id asc");
		$row = array();
		while ($v=db::result($res)) {
			$uid = explode(',', ltrim($v['UId'],'0,'));
			$aa = &$row;
			foreach ($uid as $id) {
				if (!$aa[$id]) {
					break;
				}
				$aa = &$aa[$id]['children'];
			}
			$v['children'] = array();
			$aa[$v['Id']] = self::fields($v);
		}
		$row = str::ary_values($row, 'children', 1);
		return $row;
	}
}
?>