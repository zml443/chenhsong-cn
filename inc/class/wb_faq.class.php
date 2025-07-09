<?php

class wb_faq{
	// 普通对外字段整理
	public static function fields($v){
		// $pictures = str::json($v['Pictures'], 'decode');
		$href = url::set($v, 'wb_faq.detail');
		// $v['Picture'] = $pictures[0]?:array('path'=>'','alt'=>$v[ln('Name')]);
		// $v['Pictures'] = $pictures;
		$v['Href'] = url::set($v, 'wb_faq.detail');
		$v['Category'] = '';
		return $v;
	}
	// 追加参数
	public static function append(&$row, $data){
		// 分类
		$category = array();
		if ($data['wb_faq_category_id']) {
			$category_res = db::query("
				select * from wb_faq_category 
				where Id in({$data['wb_faq_category_id']})
			");
			while ($v=db::result($category_res)) {
				$category[$v['Id']] = $v;
			}
		}
		foreach ($row as $k=>$v) {
			$id = $v['Id'];
			$cid = $v['wb_faq_category_id'];
			if ($category[$cid]) {
				$row[$k]['Category'] = $category[$cid][ln('Name')];
			}
		}
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
			$where .= " and wb_faq_category_id='$cid'";
		}
		if ($_ARG['keyword']) {
			$keyword = $_ARG['keyword'];
			$where .= " and (Name like '%{$keyword}%' or BriefDescription like '%{$keyword}%')";
		}
		$total = db::get_row_count('wb_faq', $where);
		$res = db::query("
			select * from wb_faq
			where {$where}
			order by {$orderby}
			limit ".(($pg-1)*$limit).", {$limit}
		");
		$row = array();
		$wb_faq_id = '0';
		$wb_faq_category_id = '0';
		while ($v=db::result($res)) {
			$wb_faq_id .= ','.$v['Id'];
			$wb_faq_category_id .= ','.$v['wb_faq_category_id'];
			$row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_faq_id' => $wb_faq_id,
			'wb_faq_category_id' => $wb_faq_category_id,
		));
		$data = array(
			'limit' => $limit,
			'total' => $total,
			'children' => $row
		);
		$data['is_has_data'] = $data['limit']*$pg<$data['total'];
		return $data;
	}

	// 全部
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
			$where .= " and wb_faq_category_id='$cid'";
		}
		if ($_ARG['keyword']) {
			$keyword = $_ARG['keyword'];
			$where .= " and (Name like '%{$keyword}%' or BriefDescription like '%{$keyword}%')";
		}
		$total = db::get_row_count('wb_faq', $where);
		$res = db::query("
			select * from wb_faq
			where {$where}
			order by {$orderby}
		");
		$row = array();
		$wb_faq_id = '0';
		$wb_faq_category_id = '0';
		while ($v=db::result($res)) {
			$wb_faq_id .= ','.$v['Id'];
			$wb_faq_category_id .= ','.$v['wb_faq_category_id'];
			$row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_faq_id' => $wb_faq_id,
			'wb_faq_category_id' => $wb_faq_category_id,
		));
		return $row;
	}

	// 单条的详细数据
	public static function detail(){
		$id = (int)$_ARG['id'];
		$row = array();
		$res = db::query("select * from wb_faq where Id=$id limit 0,1");
		$row = array(array());
		while ($v=db::result($res)) {
			$row[0] = self::fields($v);
		}
		// $row[0] = db::get('wb_faq::id', array('id'=>$id));
		if (!$row[0]) {
			return array();
		}
		self::append($row, array(
			'wb_faq_id' => $row[0]['Id'],
			'wb_faq_category_id' => $row[0]['wb_faq_category_id'],
		));
		return $row[0];
	}
}
?>