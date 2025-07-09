<?php
// 添加
if ($this->is_add) {
	$language = array_merge($this->language, array('cn','en'));
	$address = db::query("select * from wb_address_country where UId='0,1,7,'");
	$address_bat = array();
	$k = -1;
	while ($v=db::result($address)) {
		$k++;
		$address_bat[$k] = array(
			'wb_address_id' => (int)$v['Id'],
			'wb_shipping_id' => (int)$_POST['Id'],
			'FirstPrice' => (float)$_POST['FirstPrice'],
			'FirstWeight' => (float)$_POST['FirstWeight'],
			'ExtWeightPrice' => (float)$_POST['ExtWeightPrice'],
			'ExtWeight' => (float)$_POST['ExtWeight'],
		);
		foreach ($language as $l) {
			$address_bat[$k]['Name_'.$l] = addslashes($v['Name_'.$l]);
		}
	}
	db::insert_bat('wb_shipping_price', $address_bat);
	// 
	$country = db::query("select * from wb_address_country where Dept=2");
	$country_bat = array();
	$k = -1;
	while ($v=db::result($country)) {
		$k++;
		$country_bat[$k] = array(
			'wb_address_country_id' => (int)$v['Id'],
			'wb_shipping_id' => (int)$_POST['Id'],
			// 'Name2' => addslashes($v['Name2']),
			'FirstPrice' => (float)$_POST['FirstPrice'],
			'FirstWeight' => (float)$_POST['FirstWeight'],
			'ExtWeightPrice' => (float)$_POST['ExtWeightPrice'],
			'ExtWeight' => (float)$_POST['ExtWeight'],
		);
		foreach ($language as $l) {
			$country_bat[$k]['Name_'.$l] = addslashes($v['Name_'.$l]);
		}
	}
	db::insert_bat('wb_shipping_country_price', $country_bat);
}