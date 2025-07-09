<?php

class wb_keywords{
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
		if ($_ARG['IsUsed']) {
			$where .= " and IsUsed=1";
		}
		if ($_ARG['IsHot']) {
			$where .= " and IsHot=1";
		}
		$res = db::query("select * from wb_keywords where {$where} order by {$orderby}");
		$row = array();
		while ($v=db::result($res)) {
			$row[] = $v;
		}
		return $row;
	}
}
?>