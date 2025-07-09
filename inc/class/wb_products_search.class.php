<?php

class wb_products_search{
	// 普通对外字段整理
	public static function fields($v){
		return $v;
	}

	// 全部
	public static function all($_ARG=array()){
		switch ($_ARG['orderby']) {
			case 'desc':
			case 'asc':
				$orderby = db::get_order_by($_ARG['orderby']);
				break;
			default:
				$orderby = db::get_order_by('desc');
				break;
		}
		$where = "Language='".c('lang')."' and Used='1'";
		if ((int)$_ARG['cid']) {
			$cid = (int)$_ARG['cid'];
			$where .= " and (wb_products_category_id='' or find_in_set('$cid', wb_products_category_id))";
		} else {
			$where .= " and wb_products_category_id=''";
		}
		$res = db::query("
			select * from wb_products_search
			where {$where}
			order by {$orderby}
		");
		$row = array();
		while ($v=db::result($res)) {
			$v['Data'] = str::json($v['Data'],'decode');
			foreach($v['Data'] as $k1 => $v1){
				$extid = explode('.',$v1['type']);
				switch ($extid[0]) {
					// 关联条件
					case 'param_id':
						$extarr = [];
						$result = db::query("select * from wb_products_search_where_extid where find_in_set('{$extid[1]}', wb_products_search_where_id)");
						while ($val=db::result($result)) {
							$extarr[] = array(
								'Id' => $val['Id'],
								'Name' => $val['Name'],
							);
						}
						$row[$extid[1]] = array(
							'Name' => $v1['name'],
							'Type' => $extid[0],
							'children' => $extarr,
						);
						break;
					// 分类
					case 'cid':
						$result = wb_products_category::all();
						$row[] = array(
							'Name' => $v1['name'],
							'Type' => $extid[0],
							'children' => $result,
						);
						break;
					case 'tag':
						$result = wb_tag::all(array('GroupId' => 'wb_products'));
						$row[] = array(
							'Name' => $v1['name'],
							'Type' => $extid[0],
							'children' => $result,
						);
						break;
					default:
						$row[] = array(
							'Name' => $v1['name'],
							'Type' => $extid[0],
						);
						break;
				}
			}
		}
		return $row;
	}
}
?>