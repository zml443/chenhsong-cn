<?php

class dbm {
	// 
	public static $get_module_api_url = '';
	public static $get_module_api_key = '';
	public static $get_module_api_username = '';
	// 获取远程数据
	public static function db($name='', $_ARG=array()){
		$classname = get_called_class();
		$row = array();
		if (self::$get_module_api_url) {
			$row = curl::api(self::$get_module_api_url, self::$get_module_api_key, array(
				'ApiName' => 'index',
				'UserName' => self::$get_module_api_username,
				'ARG' => $_ARG
			));
		} else {
			$classnameAry = array($classname, $name);
			if (method_exists($classnameAry[0], $classnameAry[1])) {
				$row = call_user_func($classnameAry, $_ARG);
			}
		}
		return $row;
	}
}