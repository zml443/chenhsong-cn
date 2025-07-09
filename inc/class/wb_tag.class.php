<?php

class wb_tag{
	// 普通对外字段整理
	public static function fields($v){
		// $href = url::set($v, 'wb_tag.detail');
		// $v['Href'] = url::set($v, 'wb_tag.detail');
		// $v['Category'] = '';
		return $v;
	}
	// 追加参数
	public static function append(&$row, $data){
		// 分类
		$category = array();
		if ($data['wb_tag_category_id']) {
			$category_res = db::query("
				select * from wb_tag_category 
				where Id in({$data['wb_tag_category_id']})
			");
			while ($v=db::result($category_res)) {
				$category[$v['Id']] = $v;
			}
		}
		foreach ($row as $k=>$v) {
			$id = $v['Id'];
			$cid = $v['wb_tag_category_id'];
			if ($category[$cid]) {
				$row[$k]['Category'] = $category[$cid][ln('Name')];
			}
		}
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
			$where .= " and wb_tag_category_id='$cid'";
		}
		if ($_ARG['keyword']) {
			$keyword = $_ARG['keyword'];
			$where .= " and (Name like '%{$keyword}%' or BriefDescription like '%{$keyword}%')";
		}
		if ($_ARG['GroupId']) {
			$group = (string)$_ARG['GroupId'];
			$where .= " and GroupId='$group'";
		}
		$res = db::query("
			select * from wb_tag
			where {$where}
			order by {$orderby}
		");
		$row = array();
		$wb_tag_id = '0';
		$wb_tag_category_id = '0';
		while ($v=db::result($res)) {
			$wb_tag_id .= ','.$v['Id'];
			$wb_tag_category_id .= ','.$v['wb_tag_category_id'];
			$row[] = self::fields($v);
		}
		// self::append($row, array(
		// 	'wb_tag_id' => $wb_tag_id,
		// 	'wb_tag_category_id' => $wb_tag_category_id,
		// ));
		return $row;
	}
}
?>