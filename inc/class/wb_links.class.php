<?php

class wb_links{
	// 普通对外字段整理
	public static function fields($v){
		return $v;
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
		$res = db::query("
			select * from wb_links
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