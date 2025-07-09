<?php

class wb_corporate_culture{
	// 普通对外字段整理
	public static function fields($v){
		$pictures = str::json($v['Pictures'], 'decode');
		$v['Picture'] = $pictures[0]?:array('path'=>'','alt'=>$v[ln('Name')]);
		$v['Pictures'] = $pictures;
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
		$where = "Language='".c('lang')."'";
		$res = db::query("
			select * from wb_corporate_culture
			where {$where}
			order by {$orderby}
		");
		$row = array();
		while ($v=db::result($res)) {
			$row[] = self::fields($v);
		}
		return $row;
	}
}
?>