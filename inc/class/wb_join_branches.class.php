<?php

class wb_join_branches{
	// 普通对外字段整理
	public static function fields($v){
		$pictures = str::json($v['Pictures'], 'decode');
		$v['Picture'] = $pictures[0]?:array('path'=>'','alt'=>$v[ln('Name')]);
		$v['Pictures'] = $pictures;
		$v['Href'] = url::set($v, 'wb_join_branches.detail');
		$v['Province'] = '';
		return $v;
	}
	// 追加参数
	public static function append(&$row, $data){
		// 地区
		$address = array();
		if ($data['wb_join_address_id']) {
			$address_res = db::query("
				select * from wb_join_address 
				where Id in({$data['wb_join_address_id']})
			");
			while ($v=db::result($address_res)) {
				$address[$v['Id']] = $v;
			}
		}
		foreach ($row as $k=>$v) {
			$id = $v['Id'];
			$cid = $v['wb_join_address_id'];
			if ($address[$cid]) {
				$row[$k]['Province'] = $address[$cid][ln('Name')];
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
		$res = db::query("select * from wb_join_branches where {$where}{$cfg['where']} order by FIELD(`Id`, $id)");
		$row = array();
		$wb_join_branches_id = '0';
		$wb_join_address_id = '0';
		while ($v=db::result($res)) {
			$wb_join_branches_id .= ','.(int)$v['Id'];
			$wb_join_address_id .= ','.(int)$v['wb_join_address_id'];
			if ($_ARG['id_index']) $row[$v['Id']] = self::fields($v);
			else $row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_join_branches_id' => $wb_join_branches_id,
			'wb_join_address_id' => $wb_join_address_id,
		));
		return $row;
	}

	// 通过指定id获取数据
	public static function id($_ARG=array()){
		$id = (int)$_ARG['id'];
		$res = db::query("select * from wb_join_branches where Id=$id limit 0,1");
		$row = array(array());
		while ($v=db::result($res)) {
			$row[0] = self::fields($v);
		}
		self::append($row, array(
			'wb_join_branches_id' => (int)$row[0]['Id'],
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
		$total = db::get_row_count('wb_join_branches', $where);
		$res = db::query("
			select * from wb_join_branches
			where {$where}
			order by {$orderby}
			limit ".(($pg-1)*$limit).", {$limit}
		");
		$row = array();
		$wb_join_branches_id = '0';
		$wb_join_address_id = '0';
		while ($v=db::result($res)) {
			$wb_join_branches_id .= ','.(int)$v['Id'];
			$wb_join_address_id .= ','.(int)$v['wb_join_address_id'];
			$row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_join_branches_id' => $wb_join_branches_id,
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

	// 单条的详细数据
	public static function detail($_ARG=array()){
		$id = (int)$_ARG['id'];
		$row = array();
		$res = db::query("select * from wb_join_branches where Id=$id limit 0,1");
		$row = array(array());
		while ($v=db::result($res)) {
			$row[0] = self::fields($v);
		}
		// $row[0] = db::get('wb_join_branches::id', array('id'=>$id));
		if (!$row[0]) {
			return array();
		}
		self::append($row, array(
			'wb_join_branches_id' => (int)$row[0]['Id'],
			'wb_join_address_id' => (int)$row[0]['wb_join_address_id'],
		));
		return $row[0];
	}

	// 详情
	public static function editor($_ARG=array()){
		$id = (int)$_ARG['id'];
		$editor = db::editor('wb_join_branches', $id, 'Detail');
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

	// 查询上一页
	public static function prev($_ARG=array()){
		$id = (int)$_ARG['id'];
		$row = db::get_one('wb_join_branches', "Id='{$id}'");
		// $row = \saas::$row;
		// $id = $row['Id'];
		$myorder = $row['MyOrder'];
		$add_time = $row['AddTime'];
		$where = "1";
		if ($_SESSION['saas_prev_next_wb_join_branches_cid'] && $row['wb_join_address_id']) {
			$where .= " and wb_join_address_id='{$row['wb_join_address_id']}'";
		}
		$prev = array();
        $prev[0] = db::get_one('wb_join_branches', $where." and MyOrder='{$myorder}' and AddTime='{$add_time}' and Id>'{$id}'", '*', 'Id asc');
        $prev[0] || $prev[0] = db::get_one('wb_join_branches', $where." and MyOrder='{$myorder}' and AddTime>'{$add_time}'", '*', 'AddTime asc,Id asc');
        $prev[0] || $prev[0] = db::get_one('wb_join_branches', $where." and MyOrder<'{$myorder}'", '*', 'MyOrder desc,AddTime asc,Id asc');
        if ($prev[0]) {
        	$prev[0] = self::fields($prev[0]);
			self::append($prev, array(
				'wb_join_branches_id' => (int)$prev[0]['Id'],
				'wb_join_address_id' => (int)$prev[0]['wb_join_address_id'],
			));
        }
		return $prev[0];
	}
	
	// 查询下一页
	public static function next($_ARG=array()){
		$id = (int)$_ARG['id'];
		$row = db::get_one('wb_join_branches', "Id='{$id}'");
		// $row = \saas::$row;
		// $id = $row['Id'];
		$myorder = $row['MyOrder'];
		$add_time = $row['AddTime'];
		$where = "1";
		if ($_SESSION['saas_prev_next_wb_join_branches_cid'] && $row['wb_join_address_id']) {
			$where .= " and wb_join_address_id='{$row['wb_join_address_id']}'";
		}
		$next = array();
        $next[0] = db::get_one('wb_join_branches', $where." and MyOrder='{$myorder}' and AddTime='{$add_time}' and Id<'{$id}'", '*', 'Id desc');
        $next[0] || $next[0] = db::get_one('wb_join_branches', $where." and MyOrder='{$myorder}' and AddTime<'{$add_time}'", '*', 'AddTime desc,Id desc');
        $next[0] || $next[0] = db::get_one('wb_join_branches', $where." and MyOrder>'{$myorder}'", '*', 'MyOrder asc,AddTime desc,Id desc');
        if ($next[0]) {
        	$next[0] = self::fields($next[0]);
			self::append($next, array(
				'wb_join_branches_id' => (int)$next[0]['Id'],
				'wb_join_address_id' => (int)$next[0]['wb_join_address_id'],
			));
        }
		return $next[0];
	}
}
?>