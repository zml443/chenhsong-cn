<?php

class wb_enterprise_personage{
	// 普通对外字段整理
	public static function fields($v){
		$pictures = str::json($v['Pictures'], 'decode');
		$v['Picture'] = $pictures[0]?:array('path'=>'','alt'=>$v[ln('Name')]);
		$v['Pictures'] = $pictures;
		return $v;
	}
	// 追加参数
	public static function append(&$row, $data){
		// 分类
		$category = array();
		if ($data['wb_enterprise_category_id']) {
			$category_res = db::query("
				select * from wb_enterprise_category 
				where Id in({$data['wb_enterprise_category_id']})
			");
			while ($v=db::result($category_res)) {
				$category[$v['Id']] = $v;
			}
		}
		foreach ($row as $k=>$v) {
			$id = $v['Id'];
			$cid = $v['wb_enterprise_category_id'];
			if ($category[$cid]) {
				$row[$k]['Category'] = $category[$cid][ln('Name')];
			}
		}
	}

	// 获取全部
	public static function all(){
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
			$where .= " and wb_enterprise_category_id='$cid'";
		}
		if ($_ARG['keyword']) {
			$keyword = $_ARG['keyword'];
			$where .= " and (Name like '%{$keyword}%' or BriefDescription like '%{$keyword}%')";
		}
		$total = db::get_row_count('wb_enterprise_personage', $where);
		$res = db::query("
			select * from wb_enterprise_personage
			where {$where}
			order by {$orderby}
		");
		$row = array();
		$wb_enterprise_personage_id = '0';
		$wb_enterprise_category_id = '0';
		while ($v=db::result($res)) {
			$wb_enterprise_personage_id .= ','.$v['Id'];
			$wb_enterprise_category_id .= ','.$v['wb_enterprise_category_id'];
			$row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_enterprise_personage_id' => $wb_enterprise_personage_id,
			'wb_enterprise_category_id' => $wb_enterprise_category_id,
		));
		return $row;
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
		$res = db::query("select * from wb_enterprise_personage where {$where}{$cfg['where']} order by FIELD(`Id`, $id)");
		$row = array();
		$wb_enterprise_personage_id = '0';
		$wb_enterprise_category_id = '0';
		while ($v=db::result($res)) {
			$wb_enterprise_personage_id .= ','.(int)$v['Id'];
			$wb_enterprise_category_id .= ','.(int)$v['wb_enterprise_category_id'];
			if ($_ARG['id_index']) $row[$v['Id']] = self::fields($v);
			else $row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_enterprise_personage_id' => $wb_enterprise_personage_id,
			'wb_enterprise_category_id' => $wb_enterprise_category_id,
		));
		return $row;
	}

	// 通过指定id获取数据
	public static function id($_ARG=array()){
		$id = (int)$_ARG['id'];
		$res = db::query("select * from wb_enterprise_personage where Id=$id limit 0,1");
		$row = array(array());
		while ($v=db::result($res)) {
			$row[0] = self::fields($v);
		}
		self::append($row, array(
			'wb_enterprise_personage_id' => (int)$row[0]['Id'],
			'wb_enterprise_category_id' => (int)$row[0]['wb_enterprise_category_id'],
		));
		return $row[0];
	}

	// 单条的详细数据
	public static function detail($_ARG=array()){
		$id = (int)$_ARG['id'];
		$row = array();
		$res = db::query("select * from wb_enterprise_personage where Id=$id limit 0,1");
		$row = array(array());
		while ($v=db::result($res)) {
			$row[0] = self::fields($v);
		}
		// $row[0] = db::get('wb_enterprise_personage::id', array('id'=>$id));
		if (!$row[0]) {
			return array();
		}
		self::append($row, array(
			'wb_enterprise_personage_id' => (int)$row[0]['Id'],
			'wb_enterprise_category_id' => (int)$row[0]['wb_enterprise_category_id'],
		));
		return $row[0];
	}

	// 详情
	public static function editor($_ARG=array()){
		$id = (int)$_ARG['id'];
		$editor = db::editor('wb_enterprise_personage', $id, 'Detail');
		if ($editor) {
			return array(
				array(
					'Name' => '详情内容',
					'Editor' => $editor,
				)
			);
		} else {
			return array();
		}
	}
}
?>