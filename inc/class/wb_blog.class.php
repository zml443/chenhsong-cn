<?php

class wb_blog extends dbm {
	// 普通对外字段整理
	public static function fields($v){
		$pictures = str::json($v['Pictures'], 'decode');
		$v['Picture'] = $pictures[0]?:array('path'=>'','alt'=>$v[ln('Name')]);
		$v['Pictures'] = $pictures;
		$v['Href'] = url::set($v, 'wb_blog.detail');
		$v['Category'] = '';
		return $v;
	}
	// 追加参数
	public static function append(&$row, $data){
		// 分类
		$category = array();
		if ($data['wb_blog_category_id']) {
			$category_res = db::query("
				select * from wb_blog_category 
				where Id in({$data['wb_blog_category_id']})
			");
			while ($v=db::result($category_res)) {
				$category[$v['Id']] = $v;
			}
		}
		foreach ($row as $k=>$v) {
			$id = $v['Id'];
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
		$res = db::query("select * from wb_blog where {$where}{$cfg['where']} order by FIELD(`Id`, $id)");
		$row = array();
		$wb_blog_id = '0';
		$wb_blog_category_id = '0';
		while ($v=db::result($res)) {
			$wb_blog_id .= ','.(int)$v['Id'];
			$wb_blog_category_id .= ','.(int)$v['wb_blog_category_id'];
			if ($_ARG['id_index']) $row[$v['Id']] = self::fields($v);
			else $row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_blog_id' => $wb_blog_id,
			'wb_blog_category_id' => $wb_blog_category_id,
		));
		return $row;
	}

	// 通过指定id获取数据
	public static function id($_ARG=array()){
		$id = (int)$_ARG['id'];
		$res = db::query("select * from wb_blog where Id=$id limit 0,1");
		$row = array(array());
		while ($v=db::result($res)) {
			$row[0] = self::fields($v);
		}
		self::append($row, array(
			'wb_blog_id' => (int)$row[0]['Id'],
			'wb_blog_category_id' => (int)$row[0]['wb_blog_category_id'],
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
			if (is_array($_ARG['cid'])) {
				$cid = ''; 
				foreach ($_ARG['cid'] as $k => &$v) {
					$v = (int)$v;
					$cid .= ($k?',':'').$v;
				}
				if ($cid) $where .= " and wb_blog_category_id in($cid)";
			} else {
				$cid = (int)$_ARG['cid'];
				$where .= " and wb_blog_category_id='$cid'";
			}
		}
		if ($_ARG['keyword']) {
			$keyword = $_ARG['keyword'];
			$where .= " and (Name like '%{$keyword}%' or Brief like '%{$keyword}%' or BriefDescription like '%{$keyword}%')";
		}
		$total = db::get_row_count('wb_blog', $where);
		$res = db::query("select * from wb_blog where {$where} order by {$orderby} limit ".(($pg-1)*$limit).", {$limit}");
		$row = array();
		$wb_blog_id = '0';
		$wb_blog_category_id = '0';
		while ($v=db::result($res)) {
			$wb_blog_id .= ','.(int)$v['Id'];
			$wb_blog_category_id .= ','.(int)$v['wb_blog_category_id'];
			$row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_blog_id' => $wb_blog_id,
			'wb_blog_category_id' => $wb_blog_category_id,
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
		$res = db::query("select * from wb_blog where Id=$id limit 0,1");
		$row = array(array());
		while ($v=db::result($res)) {
			$row[0] = self::fields($v);
		}
		// $row[0] = db::get('wb_blog::id', array('id'=>$id));
		if (!$row[0]) {
			return array();
		}
		self::append($row, array(
			'wb_blog_id' => (int)$row[0]['Id'],
			'wb_blog_category_id' => (int)$row[0]['wb_blog_category_id'],
		));
		return $row[0];
	}

	// 详情
	public static function editor($_ARG=array()){
		$id = (int)$_ARG['id'];
		$editor = db::editor('wb_blog', $id, 'Detail');
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
		$row = db::get_one('wb_blog', "Id='{$id}'");
		// $row = \saas::$row;
		// $id = $row['Id'];
		$myorder = $row['MyOrder'];
		$add_time = $row['AddTime'];
		$where = "Language='".c('lang')."' and IsSaleOut != 1";
		if ($row['wb_blog_category_id']) {
			$where .= " and wb_blog_category_id='{$row['wb_blog_category_id']}'";
		}
		$prev = array();
        $prev[0] = db::get_one('wb_blog', $where." and MyOrder='{$myorder}' and AddTime='{$add_time}' and Id>'{$id}'", '*', 'Id asc');
        $prev[0] || $prev[0] = db::get_one('wb_blog', $where." and MyOrder='{$myorder}' and AddTime>'{$add_time}'", '*', 'AddTime asc,Id asc');
        $prev[0] || $prev[0] = db::get_one('wb_blog', $where." and MyOrder<'{$myorder}'", '*', 'MyOrder desc,AddTime asc,Id asc');
        if ($prev[0]) {
        	$prev[0] = self::fields($prev[0]);
			self::append($prev, array(
				'wb_blog_id' => (int)$prev[0]['Id'],
				'wb_blog_category_id' => (int)$prev[0]['wb_blog_category_id'],
			));
        }
		return $prev[0];
	}
	
	// 查询下一页
	public static function next($_ARG=array()){
		$id = (int)$_ARG['id'];
		$row = db::get_one('wb_blog', "Id='{$id}'");
		// $row = \saas::$row;
		// $id = $row['Id'];
		$myorder = $row['MyOrder'];
		$add_time = $row['AddTime'];
		$where = "Language='".c('lang')."' and IsSaleOut != 1";
		if ($row['wb_blog_category_id']) {
			$where .= " and wb_blog_category_id='{$row['wb_blog_category_id']}'";
		}
		$next = array();
        $next[0] = db::get_one('wb_blog', $where." and MyOrder='{$myorder}' and AddTime='{$add_time}' and Id<'{$id}'", '*', 'Id desc');
        $next[0] || $next[0] = db::get_one('wb_blog', $where." and MyOrder='{$myorder}' and AddTime<'{$add_time}'", '*', 'AddTime desc,Id desc');
        $next[0] || $next[0] = db::get_one('wb_blog', $where." and MyOrder>'{$myorder}'", '*', 'MyOrder asc,AddTime desc,Id desc');
        if ($next[0]) {
        	$next[0] = self::fields($next[0]);
			self::append($next, array(
				'wb_blog_id' => (int)$next[0]['Id'],
				'wb_blog_category_id' => (int)$next[0]['wb_blog_category_id'],
			));
        }
		return $next[0];
	}
}
?>