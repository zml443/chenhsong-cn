<?php

class wb_join{
	// 普通对外字段整理
	public static function fields($v){
		$v['Province'] = '';
		$v['Category'] = '';
		return $v;
	}
	// 追加参数
	public static function append(&$row, $data){
		// 地区
		$address = array();
		$category = array();
		if ($data['wb_join_address_id']) {
			$address_res = db::query("
				select * from wb_join_address 
				where Id in({$data['wb_join_address_id']})
			");
			while ($v=db::result($address_res)) {
				$address[$v['Id']] = $v;
			}
		}
		if ($data['wb_join_category_id']) {
			$category_res = db::query("
				select * from wb_join_category 
				where Id in({$data['wb_join_category_id']})
			");
			while ($v=db::result($category_res)) {
				$category[$v['Id']] = $v;
			}
		}
		foreach ($row as $k=>$v) {
			$id = $v['Id'];
			$cid = $v['wb_join_address_id'];
			if ($address[$cid]) {
				$row[$k]['Province'] = $address[$cid][ln('Name')];
			}
			$cid = $v['wb_blog_category_id'];
			if ($category[$cid]) {
				$row[$k]['Category'] = $category[$cid][ln('Name')];
			}
		}
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
		$res = db::query("select * from wb_join where {$where}{$cfg['where']} order by FIELD(`Id`, $id)");
		$row = array();
		$wb_join_id = '0';
		$wb_join_address_id = '0';
		$wb_join_category_id = '0';
		while ($v=db::result($res)) {
			$wb_join_id .= ','.(int)$v['Id'];
			$wb_join_address_id .= ','.(int)$v['wb_join_address_id'];
			$wb_join_category_id .= ','.(int)$v['wb_join_category_id'];
			if ($_ARG['id_index']) $row[$v['Id']] = self::fields($v);
			else $row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_join_id' => $wb_join_id,
			'wb_join_address_id' => $wb_join_address_id,
			'wb_join_category_id' => $wb_join_category_id,
		));
		return $row;
	}

	// 通过指定id获取数据
	public static function id($_ARG=array()){
		$id = (int)$_ARG['id'];
		$res = db::query("select * from wb_join where Id=$id limit 0,1");
		$row = array(array());
		while ($v=db::result($res)) {
			$row[0] = self::fields($v);
		}
		self::append($row, array(
			'wb_join_id' => (int)$row[0]['Id'],
			'wb_join_address_id' => (int)$row[0]['wb_join_address_id'],
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
			default:
				$orderby = db::get_order_by('desc');
				break;
		}
		$where = "Language='".c('lang')."'";
		if ($_ARG['cid']) {
			$cid = (int)$_ARG['cid'];
			$where .= " and wb_join_address_id='$cid'";
		}
		if ($_ARG['keyword']) {
			$keyword = $_ARG['keyword'];
			$where .= " and (Name like '%{$keyword}%' or Brief like '%{$keyword}%' or BriefDescription like '%{$keyword}%')";
		}
		$total = db::get_row_count('wb_join', $where);
		$res = db::query("
			select * from wb_join
			where {$where}
			order by {$orderby}
			limit ".(($pg-1)*$limit).", {$limit}
		");
		$row = array();
		$wb_join_id = '0';
		$wb_join_address_id = '0';
		while ($v=db::result($res)) {
			$wb_join_id .= ','.(int)$v['Id'];
			$wb_join_address_id .= ','.(int)$v['wb_join_address_id'];
			$row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_join_id' => $wb_join_id,
			'wb_join_address_id' => $wb_join_address_id,
		));
		$data = array(
			'limit' => (int)$limit,
			'total' => (int)$total,
			'children' => $row
		);
		$data['is_has_data'] = $pg*$data['limit']<$data['total'];
		return $data;
	}
}
?>