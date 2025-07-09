<?php

class wb_products_category{
	// 普通对外字段整理
	public static function fields($v){
		$v['Name'] = $v[ln('Name')];
		$v['Href'] = url::set($v, 'wb_products.list');
		return $v;
	}

	// 全部
	public static function all($_ARG=array()){
		if ($_ARG['cid']) {
			$cid = (int)$_ARG['cid'];
			$parent_uid = ','.db::result("select UId from wb_products_category where Id='{$cid}' limit 1", 'UId');
		} else {
			$parent_uid = ',0,';
		}
		$where = "1";
		$res = db::query("select * from wb_products_category where {$where} order by Dept asc,MyOrder asc,Id asc");
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
			if ($cid==$v['Id']) {
				$v['_cur_'] = 1;
			} else if (strstr($parent_uid, ','.$v['Id'].',')) {
				$v['_children_cur_'] = 1;
			}
			$v['children'] = array();
			$aa[$v['Id']] = self::fields($v);
			$aa[$v['Id']]['products_children'] = $pro_all[$v['Id']];
		}
		$row = str::ary_values($row, 'children', 1);
		return $row;
	}

	// 全部分类产品
	public static function all_products($_ARG=array()){
		// 有分类的产品
		$pro = wb_products::all_in_category(array(
			'id' => $_ARG['wb_products_id'],
			'cid' => $_ARG['cid']
		));

		// if ($pro['current']['wb_products_category_id']) {
		// 	$cid = (int)$_ARG['cid'];
		// 	$parent_uid = ','.db::result("select UId from wb_products_category where Id='{$cid}' limit 1", 'UId');
		// } else {
		// 	$parent_uid = ',0,';
		// }
		$where = "1";
		$res = db::query("select * from wb_products_category where {$where} order by Dept asc,MyOrder asc,Id asc");
		$row = array();
		$i = $pro['current']?1:0;
		while ($v=db::result($res)) {
			$uid = explode(',', ltrim($v['UId'],'0,'));
			$aa = &$row;
			foreach ($uid as $id) {
				if (!$aa[$id]) {
					break;
				}
				$aa = &$aa[$id]['children'];
			}
			// if ($cid==$v['Id']) {
			// 	$v['_cur_'] = 1;
			// } else if (strstr($parent_uid, ','.$v['Id'].',')) {
			// 	$v['_children_cur_'] = 1;
			// }
			// if (strstr($pro['current']['wb_products_category_id'], $v['Id'])) {
			// 	$v['_children_cur_'] = 1;
			// }
			$v['children'] = array();
			$aa[$v['Id']] = self::fields($v);
			$aa[$v['Id']]['products_children'] = $pro['all'][$v['Id']];
			if ($i==0 && $aa[$v['Id']]['products_children']) {
				if (!$_ARG['cid'] || $_ARG['cid']==$v['Id']) {
					$aa[$v['Id']]['products_children'][0]['_cur_'] = 1;
					$pro['current'] = $aa[$v['Id']]['products_children'][0];
					$i++;
				}
			}
		}
		$row = str::ary_values($row, 'children', 1);
		return array(
			'current' => $pro['current'],
			'all' => $row,
		);
	}

	public static function all_url($_ARG=array()){
		$pro_c = db::query("select * from wb_products_category order by Dept asc,MyOrder asc,Id asc");
		$pro_x = array();
		while ($v=db::result($pro_c)) {
			$uid = explode(',', ltrim($v['UId'],'0,'));
			$aa = &$pro_x;
			foreach ($uid as $id) {
				if (!$aa[$id]) {
					break;
				}
				$aa = &$aa[$id]['children'];
			}
			$v['children'] = array();
			$aa[$v['Id']] = array(
				'label' => $v[ln('Name')],
				'type' => 'products-'.$v['Id'],
				'value' => url::set($v, 'wb_products.list'),
			);
		}
		$pro_x = str::ary_values($pro_x, 'children', 1);
		return $pro_x;
	}

	// 单条数据
	public static function one($_ARG=array()){
		$cid = (int)$_ARG['cid'];
		$row = db::result("select * from wb_products_category where Id='{$cid}' limit 1");
		return self::fields($row);
	}
}
?>