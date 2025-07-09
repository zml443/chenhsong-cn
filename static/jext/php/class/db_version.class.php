<?php
class db_version {
	public static $a = array(
		'',
		'1'=>'1.php',
	);
	// 填充多语言字段
	public static function alter(){
		$version = g('dbVersion.v');
		$isinc = 0;
		foreach (self::$a as $k => $v) {
			if (!$v || $k==$version) {
				$isinc = 1;
				continue;
			}
			if ($isinc) {
				self::inc($v);
				$version = $k;
			}
		}
		if ($isinc) {
			g('dbVersion.v', $version);
		}
	}

	public static function inc($v){
		include __DIR__.'/db_version/'.$v;
	}
}
?>