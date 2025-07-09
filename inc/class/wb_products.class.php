<?php

class wb_products{
	// 普通对外字段整理
	public static function fields($v){
		$pictures = str::json($v['Pictures'], 'decode');
		$v['Picture'] = $pictures[0]?:array('path'=>'','alt'=>$v[ln('Name')]);
		$v['Pictures'] = $pictures;
		$v['Href'] = url::set($v, 'wb_products.detail');
		$v['AddCartHref'] = $v['Href']; //加入购物车链接
		$v['TaoBaoHref'] = $v['Href']; //淘宝购物车链接
		$v['Category'] = '';
		$v['wb_products_parameter'] = str::json($v['wb_products_parameter'], 'decode');
		$v['wb_products_parameter_price'] = str::json($v['wb_products_parameter_price'], 'decode');
		if ($v['ProPriceType']==1) {
			$v['Price'] = $v['wb_products_parameter_min_price'];
			$v['CostPrice'] = $v['wb_products_parameter_min_cost_price'];
			$v['OriginalPrice'] = $v['wb_products_parameter_min_original_price'];
			$v['Stock'] = $v['wb_products_parameter_total_stock'];
		}
		return $v;
	}
	
	// 追加参数
	public static function append(&$row, $data){
		$wb_member_id = member('Id');
		$session_id = c('session_id');
		// 收藏状态
		$collection = array();
		if ($wb_member_id && $data['wb_products_id']) {
			$collection_res = db::query("
				select wb_products_id,wb_member_id from wb_products_collection_log 
				where wb_member_id='{$wb_member_id}' and wb_products_id in({$data['wb_products_id']})
			");
			while ($v=db::result($collection_res)) {
				$collection[$v['wb_products_id']] = true;
			}
		}
		// 分类
		if ($data['wb_products_category_id']) {
			$category_res = db::query("
				select * from wb_products_category 
				where Id in({$data['wb_products_category_id']})
			");
			while ($v=db::result($category_res)) {
				$category[$v['Id']] = $v;
			}
		}
		foreach ($row as $k=>$v) {
			$id = $v['Id'];
			if ($collection[$id]) {
				$row[$k]['is_data_number_collection'] = true;
			}
			$cid = $v['wb_products_category_id'];
			if ($category[$cid]) {
				$row[$k]['Category'] = $category[$cid][ln('Name')];
			}
			$row[$k]['SearchWhere'] = self::extpara_all(array(
				'id' => $data['wb_products_id'],
			))[$id];
		}
	}

	// where条件整理
	public static function where($_ARG, $xxx=''){
		$where = $xxx?:"IsSaleOut=0 and Language='".c('lang')."'";
		if ($_ARG['cid']) {
			$ww = '';
			if (is_array($_ARG['cid'])) {
				$cid = ''; 
				foreach ($_ARG['cid'] as $k => &$v) {
					$v = (int)$v;
					$cid .= ($k?',':'').$v;
					if ($v) $ww .= " or find_in_set('$v', UId)";
				}
				if ($cid) $ww = "Id in($cid)".$ww;
			} else {
				$cid = (int)$_ARG['cid'];
				$ww .= "Id='$cid' or find_in_set('$cid', UId)";
			}
			$cr = db::query("select * from wb_products_category where $ww");
			$w = '';
			$i = 0;
			while ($v=db::result($cr)) {
				$w .= ($i?' or ':'')." find_in_set({$v['Id']}, `wb_products_category_id`)";
				$i++;
			}
			if ($w) $where .= " and ({$w})";
		}
		if ($_ARG['keyword']) {
			$keyword = $_ARG['keyword'];
			$where .= " and (Name like '%{$keyword}%' or Brief like '%{$keyword}%' or BriefDescription like '%{$keyword}%')";
		}
		if ($_ARG['price']) {
			// price='0,10'、第一个最小
			$price = explode(',',$_ARG['price']);
			$pmin = (float)$price[0];
			$pmax = (float)$price[1];
			$pmin && $where .= " and wb_products_parameter_max_price>{$pmin}";
			$pmax && $where .= " and wb_products_parameter_min_price<{$pmax}";
		}

		// 拓展筛选 -> 多条件筛选
		if($_ARG['param_id']){
			// 三种传参方式
			// （1）1,2,3,4|7,8|14,34
			// （2）['1,2,3,4','7,8',14,34]
			// （3）[[1,2,3,4],[7,8],[14,34]]
			$mix = array();
			// 1、通过 | 拆分筛选参数，形成固定结构（3），方便分组筛选条件
			$param_id = $_ARG['param_id'];
			is_array($param_id) || $param_id = explode('|', $param_id);
			foreach ($param_id as $k => $v) {
				$extid = '';
				is_array($v) || $v = explode(',', $v);
				foreach ($v as $kk => $vv) {
					if($extid){
						$extid .= ','.(int)$vv;
					}else{
						$extid .= (int)$vv;
					}
				}
				// 通过id拿取对应的wb_products_search_where_extid结果
				$extname = db::query("select * from wb_products_search_where_extid where Id in($extid)");

				// 合并wb_products_id中的id
				$product_ids = [];
				while ($v=db::result($extname)) {
					if($v['wb_products_id']) $product_ids = array_merge($product_ids,explode(',',$v['wb_products_id']));
				}
				if(!$product_ids) return array(
					'ret' => 0,
					'where' => $where,
				);
				// 去重id
				$product_ids = array_unique($product_ids);
				if(!$mix){
					$mix = $product_ids;
				}else{
					// 取交集
					$mix = array_intersect($mix,$product_ids);
					if(!$mix) return array(
						'ret' => 0,
						'where' => $where,
					);
				}
			}
			// 筛选条件交集所绑的产品id
			$products_ids = implode(",",$mix);
			if ($products_ids) $where .= " and Id in($products_ids)";
		}

		// 拓展筛选 -> 自定排序
		$param_id_arr = explode('-',$_ARG['orderby']);

		if(in_array('param_id',$param_id_arr)){
			$xx = (int)$param_id_arr[1];
			$extname = db::query("select * from wb_products_search_where_extid where wb_products_search_where_id={$xx}  order by Name asc");

			// 2、通过对wb_products_search_where_extid的排序，将结果集中的wb_products_id分组，再通过case分组排序组成临时排序字段
			$orderby = [];
			while ($v=db::result($extname)) {
				if($v['wb_products_id']) $orderby[] = explode(',',$v['wb_products_id']);
			}
		}

		return array(
			'ret' => 1,
			'where' => $where,
			'custom_order' => $orderby,
		);
	}

	// 通过指定id获取数据
	public static function ids($_ARG=array()){
		$where = '1';
		if ($_ARG['id']) {
			$ids = is_array($_ARG['id'])?$_ARG['id']:explode(',', $_ARG['id']);
			$id = '0';
			foreach ($ids as $v) {
				$id .= ','.(int)$v;
			}
			$where = "Id in ($id)";
		} else {
			$id = '0';
			$where = '0';
		}
		$res = db::query("select * from wb_products where {$where} order by FIELD(`Id`, $id)");
		$row = array();
		$wb_products_id = '0';
		$wb_products_category_id = '0';
		while ($v=db::result($res)) {
			$wb_products_id .= ','.(int)$v['Id'];
			$wb_products_category_id .= ','.(int)$v['wb_products_category_id'];
			if ($_ARG['id_index']) $row[$v['Id']] = self::fields($v);
			else $row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_products_id' => $wb_products_id,
			'wb_products_category_id' => $wb_products_category_id,
		));
		return $row;
	}


	// 通过指定id获取数据
	/**
	 * wb_products::rand(array('limit'=>1))
	 */
	public static function rand($_ARG=array()){
		$limit = $_ARG['limit']?:1;
		$where = '1';
		$res = db::query("select * from wb_products where {$where} order by rand() limit {$limit}");
		$row = array();
		$wb_products_id = '0';
		$wb_products_category_id = '0';
		while ($v=db::result($res)) {
			$wb_products_id .= ','.(int)$v['Id'];
			$wb_products_category_id .= ','.(int)$v['wb_products_category_id'];
			if ($_ARG['id_index']) $row[$v['Id']] = self::fields($v);
			else $row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_products_id' => $wb_products_id,
			'wb_products_category_id' => $wb_products_category_id,
		));
		return $row;
	}

	// 通过指定id获取数据
	public static function id($_ARG=array()){
		$id = (int)$_ARG['id'];
		$row = array(array());
		$row[0] = self::fields(db::result("select * from wb_products where Id=$id limit 0,1"));
		self::append($row, array(
			'wb_products_id' => (int)$row[0]['Id'],
			'wb_products_category_id' => (int)$row[0]['wb_products_category_id'],
		));
		return $row[0];
	}

	// 分页
	public static function limit($_ARG=array()){
		$pg = (int)$_ARG['pg']?:1;
		$limit = (int)$_ARG['limit']?:9;
		switch ($_ARG['orderby']) {
			case 'desc':
			case 'asc':
				$orderby = db::get_order_by($_ARG['orderby']);
				break;
			case 'hot':
				$orderby = 'MyOrder asc,data_number_views desc,Id desc';
				break;
			default:
				$orderby = db::get_order_by('desc');
				break;
		}


		// 追加 where条件
		$res = self::where($_ARG);
		if ($res['ret']==0) {
			$data = array(
				'limit' => $limit,
				'total' => 0,
				'children' => array()
			);
			$data['is_has_data'] = $data['limit']*$pg < $data['total'];
			return $data;
		}

		// 2、通过临时表排序
		$select_case = '';
		if(strstr($_ARG['orderby'],'param_id') && count($res['custom_order'],1)>0){
			$select_case = 'case ';
			foreach ($res['custom_order'] as $k => $v) {
				$x = $k+1;
				$xx = implode(',',$v);
				$select_case .= " when Id In ($xx) then $x";
			}
			$select_case .= ' else 0 end as _temp_field_custom_order';
			// desc or asc
			$by = (explode('-',$_ARG['orderby'])[2]) == 'desc'?'desc':'asc';
			$orderby = "_temp_field_custom_order $by";
		}
		$where = $res['where'];
		$total = db::get_row_count('wb_products', $where);

		// 自定义排序 select_case
		if(strstr($_ARG['orderby'],'param_id') && count($res['custom_order'],1)>0){
			$res = db::query("select *,$select_case from wb_products where {$where} order by {$orderby} limit ".(($pg-1)*$limit).", {$limit}");
		}else{
			$res = db::query("select * from wb_products where {$where} order by {$orderby} limit ".(($pg-1)*$limit).", {$limit}");
		}

		$row = array();
		$wb_products_id = '0';
		$wb_products_category_id = '0';
		while ($v=db::result($res)) {
			$wb_products_id .= ','.(int)$v['Id'];
			$wb_products_category_id .= ','.(int)$v['wb_products_category_id'];
			$row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_products_id' => $wb_products_id,
			'wb_products_category_id' => $wb_products_category_id,
		));
		$data = array(
			'limit' => $limit,
			'total' => $total,
			'children' => $row
		);
		$data['is_has_data'] = $data['limit']*$pg < $data['total'];
		return $data;
	}



	// 分页
	public static function limit_collection_current($_ARG=array()){
		$pg = (int)$_ARG['pg']?:1;
		$limit = (int)$_ARG['limit']?:9;
		$wb_member_id = (int)member('Id');
		$where = "wb_member_id='$wb_member_id' and b.IsSaleOut=0 and b.Language='".c('lang')."'";
		if ($_ARG['keyword']) {
			$where .= " and b.Name like '%{$_ARG['keyword']}%'";
		}
		$total = db::result("
			select count(*) as total_page from wb_products_collection_log a
			left join wb_products b on a.wb_products_id = b.Id
			where {$where}
		", 'total_page');
		$res = db::query("
			select b.*, a.AddTime as CollectionTime from wb_products_collection_log a
			left join wb_products b on a.wb_products_id = b.Id
			where {$where}
			order by a.AddTime desc
			limit ".(($pg-1)*$limit).", {$limit}
		");
		$row = array();
		$wb_products_id = '0';
		$wb_products_category_id = '0';
		while ($v=db::result($res)) {
			$wb_products_id .= ','.(int)$v['Id'];
			$wb_products_category_id .= ','.(int)$v['wb_products_category_id'];
			$row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_products_id' => $wb_products_id,
			'wb_products_category_id' => $wb_products_category_id,
		));
		$data = array(
			'limit' => $limit,
			'total' => $total,
			'children' => $row
		);
		$data['is_has_data'] = $data['limit']*$pg < $data['total'];
		return $data;
	}

	// 产品价格信息
	public static function  deal_with_price($_ARG=array()){
		$row = $_ARG['row'];

		// 处理参数与价格
		$data = ly200::products_parameter_price(array(
			'row' => $_ARG['row'],
			'wb_products_parameter_id' => $_ARG['wb_products_parameter_id'],
			'qty' => $_ARG['qty'],
		));
		$row['Picture'] = $data['Picture'];
		$row['Price'] = $data['Price'];
		$row['Stock'] = $data['Stock'];
		$row['SKU'] = $data['SKU'];
		$row['wb_products_parameter_id_buy'] = $data['wb_products_parameter_id_buy'];
		$row['wb_products_parameter_buy'] = $data['wb_products_parameter_buy'];

		// 批发价
		if ($_ARG['qty']) {
			// $row['WholesalePrice']
		}
		return $row;
	}

	// 购物车使用
	public static function price($_ARG=array()){
		$row = self::id(array(
			'id' => $_ARG['id']
		));
		if (!$row) {
			return array();
		}
		$row = self::deal_with_price(array(
			'row' => $row,
			'qty' => $_ARG['qty'],
			'wb_products_parameter_id' => $_ARG['wb_products_parameter_id']
		));
		return $row;
	}

	// 单条的详细数据
	public static function detail($_ARG=array()){
		if ($_GET['is_copy_module']) {
			$table = 'wb_products__copy';
		} else {
			$table = 'wb_products';
		}
		$id = (int)$_ARG['id'];
		$row = array();
		$res = db::query("select * from {$table} where Id=$id limit 0,1");
		$row = array(array());
		while ($v=db::result($res)) {
			$row[0] = self::fields($v);
		}
		if (!$row[0]) {
			return array();
		}
		self::append($row, array(
			'wb_products_id' => $row[0]['Id'],
			'wb_products_category_id' => $row[0]['wb_products_category_id'],
		));
		return $row[0];
	}

	// 详情
	public static function editor($_ARG=array()){
		$id = (int)$_ARG['id'];
		$editor = db::editor('wb_products', $id, 'Editor');
		if ($editor) {
			return array(
				array(
					'Name' => lang('front_end.products.detail'),
					'Editor' => $editor,
				)
			);
		} else {
			return array();
		}
	}

	// 传入产品id
	// 通过wb_products_search_where_extid找到产品绑定的筛选条件
	// 通过wb_products_search_where_id来分组每个筛选条件
	// 返回产品的参数

	// 传入多个产品id
	// 要找到这些产品的绑定条件


	// 单个id绑定的筛选条件
	public static function extpara($_ARG=array()){
		$where = "1";
		if ($_ARG['id']) {
			$where .= " and find_in_set('{$_ARG['id']}',wb_products_id)";
		}else{
			return array();
		}
		$res = db::query("select * from wb_products_search_where_extid where {$where} order by MyOrder asc");
		$row = array();
		$wb_products_search_where_id = '0';
		while ($v=db::result($res)) {
			$wid = (int)$v['wb_products_search_where_id'];
			$wb_products_search_where_id .= ','.$wid;
			if (!$row[$wid]) $row[$wid] = array('Id'=>$wid, 'Name'=>'', 'children'=>array());
			$row[$wid]['children'][] = array(
				'Id' => $v['Id'],
				'Name' => $v['Name'],
			);
		}
		// 
		$res = db::query("select * from wb_products_search_where where Language='".c('lang')."' and Id in($wb_products_search_where_id) order by MyOrder asc,Id asc");
		while ($v=db::result($res)) {
			$wid = (int)$v['Id'];
			$row[$wid]['Name'] = $v['Name'];
		}
		$row = array_values($row);
		return $row;
	}

	// 多个id绑定的筛选条件
	public static function extpara_all($_ARG=array()){
		$res = db::query("select * from wb_products_search_where_extid order by MyOrder asc");
		$res2 = db::query("select * from wb_products_search_where where Language='".c('lang')."' order by MyOrder asc,Id asc");
		while ($v=db::result($res2)) {
			$res_where[$v['Id']] = $v;
		}

		// 传入产品id
		$ids = explode(',',$_ARG['id']);

		$data = array();
		$row = array();

		while ($v=db::result($res)) {
			$v_ids = explode(',',$v['wb_products_id']);
			$wid = (int)$v['wb_products_search_where_id'];
			$name = $res_where[$wid]['Name'];

			foreach ($ids as $k1 => $v1) {
				if(in_array($v1,$v_ids)) {
					$data[$v1] || $data[$v1] = array();
					$data[$v1][$wid] || $data[$v1][$wid] = array(
						'Id' => $wid,
						'Name' => $name,
						'children' => array(),
					);
					$data[$v1][$wid]['children'][] = array(
						'Id' => $v['Id'],
						'Name' => $v['Name']
					);
				}
			}
		}

		return $data;
	}

	// 拥有分类的全部产品
	public static function all_in_category($_ARG=array()){
		$where = "IsSaleOut=0 and wb_products_category_id>'0' and Language='".c('lang')."'";
		$orderby = db::get_order_by('desc');
		$res = db::query("select * from wb_products where {$where} order by {$orderby}");
		$current = array();
		$row = array();
		while ($v=db::result($res)) {
			if($v['Id'] == $_ARG['id']) $current = self::fields($v);
			$cate = explode(',',$v['wb_products_category_id']);
			foreach($cate as $v1){
				if($v['Id'] == $_ARG['id']) {
					$v['_cur_'] = 1;
				}
				$row[$v1][] = self::fields($v);
			}
		}
		return array(
			'current' => $current,
			'all' => $row
		);
	}

}
?>