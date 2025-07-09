<?php

class wb_partner{
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
		if ($data['wb_partner_category_id']) {
			$category_res = db::query("
				select * from wb_partner_category 
				where Id in({$data['wb_partner_category_id']})
			");
			while ($v=db::result($category_res)) {
				$category[$v['Id']] = $v;
			}
		}
		foreach ($row as $k=>$v) {
			$id = $v['Id'];
			$cid = $v['wb_partner_category_id'];
			if ($category[$cid]) {
				$row[$k]['Category'] = $category[$cid][ln('Name')];
			}
		}
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
		// $where = "Language='".c('lang')."'";
		$where = "1";
		if ($_ARG['cid']) {
			$where .= " and wb_partner_category_id='{$_ARG['cid']}'";
		}
		$res = db::query("
			select * from wb_partner
			where {$where}
			order by {$orderby}
		");
		$row = array();
		$wb_partner_id = '0';
		$wb_partner_category_id = '0';
		while ($v=db::result($res)) {
			$wb_partner_id .= ','.$v['Id'];
			$wb_partner_category_id .= ','.$v['wb_partner_category_id'];
			$row[] = self::fields($v);
		}
		return $row;
	}
}
?>