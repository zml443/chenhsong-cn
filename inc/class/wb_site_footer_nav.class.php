<?php

class wb_site_footer_nav{
	public static function fields($v){
		return array(
			'name' => $v[ln('Name')],
			'href' => $v['Url'],
			'target' => $v['Target']?:'_self'
		);
	}
	// 获取导航
	public static function all($_ARG=array()){
		$where = "1";
		$res = db::query("select * from wb_site_footer_nav where {$where} order by Dept asc,MyOrder asc,Id asc");
		$row = array();
		while ($v=db::result($res)) {
			$uid = explode(',', ltrim($v['UId'],'0,'));
			$aa = &$row;
			foreach ($uid as $id) {
				if (!$aa[$id]) {
					break;
				}
				$aa = &$aa[$id]['children'];
			}
			$v['children'] = array();
			$aa[$v['Id']] = self::fields($v);
		}
		return $row;
	}
}
?>