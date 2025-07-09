<?php

class ly200_search{
	// 分页
	public static function init($_ARG=array()){
		$page_limit = $_ARG['limit']?:9;
		$page_total = 0;
		$keyword = $_ARG['keyword'];
		$lang = c('lang');
		if (!$keyword) {
			// 返回结果
			return array(
				'type' => array(),
				'result' => array(),
				'limit' => $page_limit,
				'total' => $page_total,
			);
		}
		// 查询条件
		$type_ary = array(
		    'all' =>  array(
                'name' => lang('{/global.all/}'),
            ),
		    'wb_products' =>  array(
                'name' => lang('{/page.products/}'),
                'where' => "Language='{$lang}' and (Name like '%{$keyword}%' or Brief like '%{$keyword}%' or BriefDescription like '%{$keyword}%')",
                'used' => $app_store_ary['_']['wb_products'] || g('app_store.wb_products'),
            ),
		    'wb_blog' => array(
                'name' => lang('{/page.blog/}'),
                'where' => "Language='{$lang}' and (Name like '%{$keyword}%' or BriefDescription like '%{$keyword}%')",
                'used' => g('app_store.wb_blog'),
            ),
		    'wb_solution' => array(
                'name' => lang('{/page.solution/}'),
                'where' => "Language='{$lang}' and (Name like '%{$keyword}%' or BriefDescription like '%{$keyword}%')",
                'used' => g('app_store.wb_solution'),
            ),
		    'wb_case' => array(
                'name' => lang('{/page.case/}'),
                'where' => "Language='{$lang}' and (Name like '%{$keyword}%' or BriefDescription like '%{$keyword}%')",
                'used' => g('app_store.wb_case'),
            ),
		);
		// 所有类型查询数量统计
		$_ARG['type'] || $_ARG['type'] = 'all';
		if ($_ARG['type']=='all') {
			$type_ary['all']['_cur_'] = 1;
		}
		foreach ($type_ary as $k=>$v) {
			if ($k=='all') {
				continue;
			}
			if (!$v['used']) {
				unset($type_ary[$k]);
				continue;
			}
			$type_ary[$k]['count'] = db::get_row_count($k, $v['where']);
			$k==$_ARG['type'] && $type_ary[$k]['_cur_'] = 1;
			$page_total += $type_ary[$k]['count'];
		}
		// d($page_total);
		$type_ary['all']['count'] = $page_total;
		// 页数计算
		$total_pages = ceil($page_total / $page_limit);
		$page = $_GET['pg']?(int)$_GET['pg']:1;
		($page<1 || $page>$total_pages) && $page=1;
		$page_start = ($page-1) * $page_limit;
		// 开始查询
		$search_ary = array();
		$page_limit2 = $page_limit;
		foreach ($type_ary as $key => $val) {
			if ($key=='all') {
				continue;
			}
			if ($page_limit2 == 0){
				break;
			}
			if ($val['count'] == 0) {
				continue;
			}
			if($_ARG['type'] == $key || $_ARG['type'] == 'all'){
				if ($page_start >= $val['count']) {
					$page_start -= $val['count'];
					continue;
				}
			}
			// 查询
			switch ($key) {
				// 产品
				case 'wb_products':
					$res = db::query("select * from wb_products where {$val['where']} order by Id desc limit {$page_start}, {$page_limit}");
					$row = array();
					$wb_products_id = '0';
					$wb_products_category_id = '0';
					while ($v=db::result($res)) {
						$wb_products_id .= ','.(int)$v['Id'];
						$wb_products_category_id .= ','.(int)$v['wb_products_category_id'];
						$v['_search_type_'] = 'wb_products';
						$row[] = wb_products::fields($v);
					}
					wb_products::append($row, array(
						'wb_products_id' => $wb_products_id,
						'wb_products_category_id' => $wb_products_category_id,
					));
					break;
				// 新闻博客
				case 'wb_blog':
					$res = db::query("select * from wb_blog where {$val['where']} order by Id desc limit {$page_start}, {$page_limit}");
					$row = array();
					$wb_blog_id = '0';
					$wb_blog_category_id = '0';
					while ($v=db::result($res)) {
						$wb_blog_id .= ','.(int)$v['Id'];
						$wb_blog_category_id .= ','.(int)$v['wb_blog_category_id'];
						$v['_search_type_'] = 'wb_blog';
						$row[] = wb_blog::fields($v);
					}
					wb_blog::append($row, array(
						'wb_blog_id' => $wb_blog_id,
						'wb_blog_category_id' => $wb_blog_category_id,
					));
					break;
				// 解决方案
				case 'wb_solution':
					$res = db::query("select * from wb_solution where {$val['where']} order by Id desc limit {$page_start}, {$page_limit}");
					$row = array();
					$wb_solution_id = '0';
					$wb_solution_category_id = '0';
					while ($v=db::result($res)) {
						$wb_solution_id .= ','.(int)$v['Id'];
						$wb_solution_category_id .= ','.(int)$v['wb_solution_category_id'];
						$v['_search_type_'] = 'wb_solution';
						$row[] = wb_solution::fields($v);
					}
					wb_solution::append($row, array(
						'wb_solution_id' => $wb_solution_id,
						'wb_solution_category_id' => $wb_solution_category_id,
					));
					break;
				// 案例
				case 'wb_case':
					$res = db::query("select * from wb_case where {$val['where']} order by Id desc limit {$page_start}, {$page_limit}");
					$row = array();
					$wb_case_id = '0';
					$wb_case_category_id = '0';
					while ($v=db::result($res)) {
						$wb_case_id .= ','.(int)$v['Id'];
						$wb_case_category_id .= ','.(int)$v['wb_case_category_id'];
						$v['_search_type_'] = 'wb_case';
						$row[] = wb_case::fields($v);
					}
					wb_case::append($row, array(
						'wb_case_id' => $wb_case_id,
						'wb_case_category_id' => $wb_case_category_id,
					));
					break;
				default:
					$row = array();
					break;
			}
			if($_ARG['type'] == $key || $_ARG['type'] == 'all'){
				// 数据合并
				$row && $search_ary = array_merge($search_ary, $row);
				$number = $val['count'] - $page_start;
				if ($number > $page_limit2) {
					$page_limit2 = 0;
				} else {
					$page_limit2 -= $number;
					$page_start = 0;
				}
			}
		}
		// 所有类型查询数量统计
		/*foreach ($type_ary as $k=>$v) {
			unset($type_ary[$k]['where']);
		}*/
		// 返回结果
		return array(
			'type' => $type_ary,
			'result' => $search_ary,
			'limit' => $page_limit,
			'total' => $type_ary[$_ARG['type']]['count'],
		);
	}

	// 处理_GET
	public static function query_string($_ARG=array()){
		$row = array();
		if($_ARG['param_id']){
			$ext = $_ARG['param_id'];
			$extid = array();
			is_array($ext) || $ext = explode('|', $_ARG['param_id']);
			foreach ($ext as $k => $v) {
				is_array($v) || $v = explode(',', $v);
				foreach ($v as $kk => $vv) {
					$extid[] = (int)$vv;
				}
			}
			$row['param_id'] = $extid;
		}

		if($_ARG['cid']){
			$row['cid'] = explode(',',$_ARG['cid']);
		}

		if($_ARG['tag']){
			$row['tag'] = explode(',',$_ARG['tag']);
		}

		if($_ARG['price']){
			$price = $_ARG['price'];
			is_array($price) || $price = explode(',',$_ARG['price']);
			$row['price'] = array(
				'min' => $price[0],
				'max' => $price[1],
			);
		}

		if($_ARG['cols']){
			$row['cols'] = explode(',',$_ARG['cols']);
		}

		if($_ARG['orderby']){
			$row['orderby'] = explode('-',$_ARG['orderby']);
		}

		return $row;
	}
}
?>