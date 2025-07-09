<?php

class wb_products_comment{
	// 普通对外字段整理
	public static function fields($v){
		$pictures = str::json($v['Pictures'], 'decode');
		$v['Picture'] = $pictures[0]?:array('path'=>'','alt'=>$v[ln('Name')]);
		$v['Pictures'] = $pictures;
		if (!$v['IpInfo']) {
			$v['IpInfo'] = ip::info($v['Ip']);
		} else {
			$v['IpInfo'] = str::json($v['IpInfo'], 'decode');
		}
		if ($v['wb_manage_id']) {
			$v['UserName'] = '店铺商家';
		} else if ($v['wb_member_id']) {
			$v['UserName'] = '';
		} else {
			$v['UserName'] = '游客';
		}
		return $v;
	}
	// 追加参数
	public static function append(&$row, $data){
		$wb_member_id = member('Id');
		if ($data['wb_member_id']) {
			$member_res = db::query("select * from wb_member where Id in({$data['wb_member_id']})");
			while ($v=db::result($member_res)) {
				$member[$v['Id']] = $v;
			}
		}
		// 点赞状态
		$ups = array();
		$downs = array();
		if ($wb_member_id && $data['wb_products_comment_id']) {
			$ups_res = db::query("
				select wb_products_comment_id,wb_member_id from wb_products_comment_ups_log 
				where wb_member_id='{$wb_member_id}' and wb_products_comment_id in({$data['wb_products_comment_id']})
			");
			while ($v=db::result($ups_res)) {
				$ups[$v['wb_products_comment_id']] = true;
			}
			$downs_res = db::query("
				select wb_products_comment_id,wb_member_id from wb_products_comment_downs_log 
				where wb_member_id='{$wb_member_id}' and wb_products_comment_id in({$data['wb_products_comment_id']})
			");
			while ($v=db::result($downs_res)) {
				$downs[$v['wb_products_comment_id']] = true;
			}
		}
		foreach ($row as $k=>$v) {
			$id = $v['Id'];
			$wb_member_id = $v['wb_member_id'];
			if ($member[$wb_member_id]) {
				if ($member[$wb_member_id]['Name']) {
					$row[$k]['UserName'] = $member[$wb_member_id]['Name'];
				} else if ($member[$wb_member_id]['Email']) {
					$row[$k]['UserName'] = str::hide_email($member[$wb_member_id]['Email']);
				} else {
					$row[$k]['UserName'] = substr_replace($member[$wb_member_id]['Mobile'], '*****', 3, -4);
				}
			}
			if ($ups[$id]) {
				$row[$k]['is_data_number_ups'] = true;
			}
			if ($downs[$id]) {
				$row[$k]['is_data_number_downs'] = true;
			}
		}
	}
	// 分页
	public static function limit($_ARG=array()){
		$pg = (int)$_ARG['pg']?:1;
		$limit = (int)$_ARG['limit']?:9;
		if ($limit>50) {
			$limit = 50;
		}
		switch ($_ARG['orderby']) {
			case 'desc':
			case 'asc':
				$orderby = db::get_order_by($_ARG['orderby']);
				break;
			case 'hot':
				$orderby = 'MyOrder asc,data_number_views desc,Id desc';
				break;
			default:
				$orderby = db::get_order_by('desc');
				break;
		}
		$wb_products_id = (int)$_ARG['wb_products_id'];
		$all_where = "IsShow=1 and wb_products_id='{$wb_products_id}'";
		$where = $all_where;
		if ($_ARG['IsHasPictures']) {
			$where .= " and IsHasPictures=1";
		}
		if ($_ARG['IsMaxStar']) {
			$where .= " and Star=10";
		}
		$res = db::query("
			select * from wb_products_comment
			where {$where}
			order by {$orderby}
			limit ".(($pg-1)*$limit).", {$limit}
		");
		$row = array();
		$wb_member_id = '0';
		$wb_products_comment_id = '0';
		while ($v=db::result($res)) {
			$wb_member_id .= ','.$v['wb_member_id'];
			$wb_products_comment_id .= ','.$v['Id'];
			$row[] = self::fields($v);
		}
		self::append($row, array(
			'wb_member_id' => $wb_member_id,
			'wb_products_comment_id' => $wb_products_comment_id,
		));
		$data = array(
			'limit' => $limit,
			'total' => db::get_row_count('wb_products_comment', $where),
			'star' => db::get_value('wb_products', "Id='{$wb_products_id}'", 'Star'),
			'all_total' => db::get_row_count('wb_products_comment', $all_where),
			'is_has_pictures_total' => db::get_row_count('wb_products_comment', $all_where." and IsHasPictures=1"),
			'is_max_star_total' => db::get_row_count('wb_products_comment', $all_where." and Star=10"),
			'children' => $row
		);
		$data['is_has_data'] = $data['limit']*$pg<$data['total'];
		return $data;
	}
}
?>