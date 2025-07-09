<?php

class wb_shipping{
	// 获取运费价格
	public static function price($_ARG=array()){
		$weight = (float)$_ARG['weight'];
		$country = $_ARG['country'];
		$province = $_ARG['province'];
		$price = (float)$_ARG['price'];
		$shipping_row = db::query("select * from wb_shipping order by Id asc");
		$shipping = array();
		$ids = '0';
		$k = -1;
		while ($v=db::result($shipping_row)) {
			$k++;
			$ids .= ','.$v['Id'];
			$shipping[$v['Id']] = array(
				'Id' => $v['Id'],
				'Name' => $v[ln('Name')],
				'Price' => 0,
				'FreeOpen' => $v['FreeOpen'],
				'FreeStartPrice' => $v['FreeStartPrice'],
				'Picture' => $v['Picture'],
			);
		}
		$field = ln('Name');
		// if ($country && preg_match("/(中国|中國|China)/", $country)) {
		if ($country) {
			$shipping_price = db::query("select * from wb_shipping_country_price where wb_shipping_id in({$ids}) and ($field like '%{$country}%' or '{$country}' like CONCAT('%',{$field},'%'))");
		} else {
			$shipping_price = db::query("select * from wb_shipping_price where wb_shipping_id in({$ids}) and ($field like '%{$province}%' or '{$province}' like CONCAT('%',{$field},'%'))");
		}
		$row = array();
		while($v = db::result($shipping_price)){
			if ($ship = $shipping[$v['wb_shipping_id']]) {
				$ship['FirstWeight'] = $v['FirstWeight'];
				$ship['FirstPrice'] = $v['FirstPrice'];
				$ship['ExtWeight'] = $v['ExtWeight'];
				$ship['ExtWeightPrice'] = $v['ExtWeightPrice'];
				$row[] = $ship;
			}
		}
		return $row;
	}


	// 获取运费价格
	public static function one_price($_ARG=array()){
		$weight = $_ARG['weight'];
		$country = $_ARG['country'];
		$province = $_ARG['province'];
		$price = (float)$_ARG['price'];
		$wb_shipping_id = (int)$_ARG['wb_shipping_id'];
		$v = db::result("select * from wb_shipping where Id='{$wb_shipping_id}' limit 0,1");
		if (!$v) {
			return array();
		}
		$row = array(
			'Id' => $v['Id'],
			'Name' => $v[ln('Name')],
			'Price' => 0,
			'FreeOpen' => $v['FreeOpen'],
			'FreeStartPrice' => $v['FreeStartPrice'],
			'Picture' => $v['Picture'],
		);
		$field = ln('Name');
		// if ($country && preg_match("/(中国|中國|China)/", $country)) {
		if ($country) {
			$shipping_price = db::result("select * from wb_shipping_country_price where wb_shipping_id='{$row['Id']}' and ($field like '%{$country}%' or '{$country}' like CONCAT('%',{$field},'%'))");
		} else {
			$shipping_price = db::result("select * from wb_shipping_price where wb_shipping_id='{$row['Id']}' and ($field like '%{$province}%' or '{$province}' like CONCAT('%',{$field},'%'))");
		}
		if ($shipping_price) {
			$row['FirstWeight'] = $shipping_price['FirstWeight'];
			$row['FirstPrice'] = $shipping_price['FirstPrice'];
			$row['ExtWeight'] = $shipping_price['ExtWeight'];
			$row['ExtWeightPrice'] = $shipping_price['ExtWeightPrice'];
			// 免运费
			if ($row['FreeOpen'] && $row['FreeStartPrice']<=$price) {
				$row['Price'] = 0;
			} else {
				$row['Price'] = $row['FirstPrice'];
				if ($weight>$row['FirstWeight']) {
					$row['Price'] += ($weight-$row['FirstWeight'])*$row['ExtPrice'];
				}
			}
		} else {
			return array();
		}
		return $row;
	}
}
?>