<?php
class saas_arr {
	// 填充字段
	public static function deal($dat, $cfg){
		switch ($cfg['Type']) {
			case 'json':
				$dat['children'] || $dat['children'] = array();
				$dat = self::tool_json($dat, $cfg);
				break;
		}
		return $dat;
	}

	// json
	public static function tool_json ($dat, $cfg) {
		if ($cfg['Value'] && $cfg['Value']['children'] && $cfg['Value']['children'][0]) {
			$value = $cfg['Value']['children'][0];
			foreach ($dat['children'] as $k => &$v) {
				$v = str::ary_cover($value, $v);
			}
		}
		return $dat;
	}
}
