<?php

class wb_markdown{
	// 通过指定id获取数据
	public static function id($_ARG=array()){
		$where = '1';
		if($_ARG['id']){
			$id = (int)$_ARG['id'];
			$where .= " and Id=$id";
		}
		// 拿文件目录
		$res = db::result("select * from wb_markdown where $where limit 0,1");
		return $res;
	}


	public static function detail($_ARG=array()){
		$where = '1';
		if($_ARG['id']){
			$id = (int)$_ARG['id'];
			$where .= " and Id=$id";
		}
		// 拿文件目录
		$res = db::result("select * from wb_markdown where $where limit 0,1");
		$res['Data'] = str::json($res['Data'],'decode');
		return $res;
	}
}
?>