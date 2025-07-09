<?php

class wb_address_country{
	// 按照下拉方式组合地址
	public static function drop_select($_ARG=array()){
		$where = '1';
		if ($_ARG['Dept']) {
			$dept = (int)$_ARG['Dept'];
			$where .= " and Dept<={$dept}";
		}
		$country = db::query("select * from wb_address_country where {$where} order by Dept asc,Id asc");
		$json = array();
		while ($v=db::result($country)) {
			$a = &$json;
			if ($v['Dept']>1) {
				$uid = explode(',', $v['UId']);
				foreach ($uid as $v1) {
					if ($v1) {
						$a = &$a[$v1]['children'];
						if (!$a) $a = array();
					}
				}
			}
			$a[$v['Id']] = array(
				'label' => $v[ln('Name')],
				'value' => $v[ln('Name')],
				'pinyin' =>  pinyin::get($v[ln('Name')])
			);
		}
		return $json;
	}
}
?>