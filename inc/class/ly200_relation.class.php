<?php

class ly200_relation{

    // 相关方案
    public static function relation_solution($_ARG=array()){
        $limit = (int)$_ARG['limit']?:9;
        $where = "Language='".c('lang')."'";
        $res = db::query("select * from wb_solution where {$where} order by rand() limit {$limit}");
        $row = array();
        $wb_solution_id = '0';
		$wb_solution_category_id = '0';
        while ($v=db::result($res)) {
            $wb_solution_id .= ','.(int)$v['Id'];
            $wb_solution_category_id .= ','.(int)$v['wb_solution_category_id'];
            $row[] = wb_solution::fields($v);
        }
        wb_solution::append($row, array(
            'wb_solution_id' => $wb_solution_id,
            'wb_solution_category_id' => $wb_solution_category_id,
        ));
        return $row;
    }

    // 相关新闻
	public static function relation_blog($_ARG=array()){
		$limit = (int)$_ARG['limit']?:9;
		$where = "Language='".c('lang')."'";
		$res = db::query("select * from wb_blog where {$where} order by rand() limit {$limit}");
		$row = array();
        $wb_blog_id = '0';
			$wb_blog_category_id = '0';
		while ($v=db::result($res)) {
			$wb_blog_id .= ','.(int)$v['Id'];
			$wb_blog_category_id .= ','.(int)$v['wb_blog_category_id'];
			$row[] = wb_blog::fields($v);
		}
		wb_blog::append($row, array(
			'wb_blog_id' => $wb_blog_id,
			'wb_blog_category_id' => $wb_blog_category_id,
		));
		return $row;
	}

    // 相关案例
	public static function relation_case($_ARG=array()){
		$limit = (int)$_ARG['limit']?:9;
		// $where = "IsSaleOut=0 and Language='".c('lang')."'";
		$where = "Language='".c('lang')."'";
		$res = db::query("select * from wb_case where {$where} order by rand() limit {$limit}");
		$row = array();
        $wb_case_id = '0';
		$wb_case_category_id = '0';
		while ($v=db::result($res)) {
			$wb_case_id .= ','.(int)$v['Id'];
			$wb_case_category_id .= ','.(int)$v['wb_case_category_id'];
			$row[] = wb_case::fields($v);
		}
		wb_case::append($row, array(
			'wb_case_id' => $wb_case_id,
			'wb_case_category_id' => $wb_case_category_id,
		));
		return $row;
	}

	// 相关产品
	public static function relation_product($_ARG=array()){
		$limit = (int)$_ARG['limit']?:9;
		$where = "IsSaleOut=0 and Language='".c('lang')."'";
		$res = db::query("select * from wb_products where {$where} order by rand() limit {$limit}");
		$row = array();
        $wb_products_id = '0';
		$wb_products_category_id = '0';
		while ($v=db::result($res)) {
			$wb_products_id .= ','.(int)$v['Id'];
			$wb_products_category_id .= ','.(int)$v['wb_products_category_id'];
			$row[] = wb_products::fields($v);
		}
		wb_products::append($row, array(
			'wb_products_id' => $wb_products_id,
			'wb_products_category_id' => $wb_products_category_id,
		));
		return $row;
	}

    // 相关服务
	public static function relation_server($_ARG=array()){
		$limit = (int)$_ARG['limit']?:9;
		$where = "Language='".c('lang')."'";
		$res = db::query("select * from wb_server where {$where} order by rand() limit {$limit}");
		$row = array();
        $wb_server_id = '0';
		$wb_server_category_id = '0';
		while ($v=db::result($res)) {
			$wb_server_id .= ','.(int)$v['Id'];
			$wb_server_category_id .= ','.(int)$v['wb_server_category_id'];
			$row[] = wb_server::fields($v);
		}
		wb_server::append($row, array(
			'wb_server_id' => $wb_server_id,
			'wb_server_category_id' => $wb_server_category_id,
		));
		return $row;
	}
}