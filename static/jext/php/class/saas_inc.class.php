<?php
class saas_inc {
	// append
	public static function append($v){
		$str = '';
		switch ($v['Type']) {
			case 'map':
				if ($v['Value']['type']=='baidumap') {
					$str = self::baidumap($v['Value']);
				}
				break;
		}
		return $str;
	}
	// 百度地图
	public static $hasbaidumap = 0;
	public static function baidumap($cfg){
		if (self::$hasbaidumap) {
			return '';
		}
		self::$hasbaidumap = 1;
		$str = "
			<!--主要api-->
			<script type='text/javascript' src='//api.map.baidu.com/api?v=2.0&ak=".$cfg['baidumap']['apikey']."'></script>
			<!--特殊窗口才用的api-->
			<script type='text/javascript' src='//api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js'></script>
			<!--特殊窗口才用的api样式-->
			<link href='//api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css' rel='stylesheet' type='text/css' />
		";
		return $str;
	}

}
