<?php

class url {
	/**
	 * 组织url参数
	 * @param {string} $un 以逗号隔开的字符串，然后将对应的url参数去掉
	 * @return {string}
	 */
	public static function query_string ($un='') {
		!is_array($un) && $un=explode(',', str_replace(' ','',$un));//$un=array($un);
		if ($_SERVER['QUERY_STRING']) {
			$q = explode('&', $_SERVER['QUERY_STRING']);
			$v = '';
			for ($i=0; $i<count($q); $i++) {
				$t = explode('=', $q[$i]);
				if ( in_array($t[0], $un) || $t[0] == 'weburl'){ continue; }
				$v .= $t[0].'='.$t[1].'&';
			}
			$v = substr($v, 0, -1);
			$v == '=' && $v = '';
			return self::filter($v);
		} else {
			return '';
		}
	}
	/**
	 * 设置链接
	 * @param {array} $v 一个二维数组，一般是直接从数据库里面查询出来的
	 * @param {string} $type 链接类型
	 * @return {string}
	 */
	public static function set ($v, $type='wb_product.detail') {
		$file = c('url:set_tmp') ? c('url:set_tmp') : c('url:set');
		if (is_file($file)) {
			return include $file;
		}
		else {
			return '';
		}
	}

	// url::saas('lysaas-service:1', array('Id'=>1, 'TableName'=>'wb_products'))
	public static function saas($url,$type=array()){
		// http://
		// xxx:
		// 没有冒号
		// lysaas-service:1
		if (strpos($url,':')!==false) {
			$para = explode(':', $url);
			switch ($para[0]) {
				case 'lysaas-product-taobo':
					$table = $type['TableName'];
					$id = (int)$type['Id'];
					$res = db::result("select * from $table where Id=$id");
					break;
				case 'lysaas-service':
					$id = (int)$para[1];
					$res = wb_service::id(array(
						'id' => $id,
					));
					if($res['Type']=='feedback' && $type['TableName']=='wb_products'){
						$id = (int)$type['Id'];
						$res = array(
							'Href' => "lysaas-feedbackInquiry:$id",
						);
					}
					break;
				// case 'lysaas-inquiry':
				// 	$id = (int)$para[1];
				// 	$res = wb_service::id(array(
				// 		'id' => $id,
				// 	));
				// 	break;
				default:
					break;
			}
			return $res;
		}else{
			return array(
				'Href' => $url,
			);
		}
	}


	/**
	 * 获取当前页面的链接
	 * @return {string}
	 */
	public static function get () {
		return $_SERVER['REQUEST_URI'];
	}
	/**
	 * 获取当前页面的网址路径
	 * @return {string}
	 */
	public static function get_jext_path () {
		return self::path_to_url(dirname(__FILE__),-2);
	}
	/**
	 * 把文件路径转换成链接，需要绝对路径； 最好是 __FILE__
	 * @param {string} $path 一个系统路径
	 * @param {int} $num 移动的目录个数
	 * @return {string}
	 */
	public static function path_to_url ($path, $num=0) {
		$path = str_replace('\\','/', $path);
		if (is_file($path)) {
			$base = ltrim(strrchr($path,'/'),'/');
		}
		else {
			$base = '';
		}
		$dir = rtrim(str_replace($base.'`$', '', $path.'`$'), '/');
		$num = abs($num);
		if (!$base) for ($i=0; $i<$num; $i++) {
			$d = strrchr($dir, '/');
			$dir = str_replace($d.'`$', '', $dir.'`$');
		}
		return str_replace(c('root'), '/', $dir.'/').$base;
	}
	/**
	 * 判断页面刷新
	 * @return {bool}
	 */
	public static function reload () {
		return isset($_SERVER['HTTP_CACHE_CONTROL']);
	}
	/**
	 * 将参数转换成数组
	 * @param {string} $str 一个url参数字串， 如：index.html?a=1&b=2
	 * @return {array}
	 */
	public static function to_array ($str) {
		if (strpos($str,'?')!==false) {
			$str = substr(strstr($str, '?'), 1);
		}
		$str = @explode('&', $str);
		$ary = array();
		foreach ($str as $v) {
			$v = @explode('=', $v);
			if ($v[0]&&$v[0]!=' ') $ary[$v[0]] = $v[1];
		}
		return $ary;
	}
	/**
	 * URL插入参数
	 * @param {string} $str 一个url参数字串， 如：a=1&b=2
	 * @param {string} $can 一个url参数字串
	 * @return {array}
	 */
	public static function add_query_string ($str, $can) {
		$can = self::to_array($can);
		// d($can);
		foreach ($can as $k => $v) {
			if (preg_match("/(^|&|\?)$k=/", $str)) {
				$str = preg_replace("/(^|&|\?)($k=)([^&]+)?/", "$1$2".$v, $str);
			} else {
				$str .= (strstr($str,'?')?'&':'?').$k.'='.$v;
			}
		}
		return self::filter($str);
	}
	/**
	 * 链接单双引号过滤
	 * @param {string} $str 一个url参数字串， 如：a=1&b=2
	 * @param {string} $type 默认encode， encode加码，或者 encode转码
	 * @return {string}
	 */
	public static function filter ($url, $type='encode') {
		if ($type=='decode') {
			return str_replace(array('%27', '%22'), array('"',"'"), $url);
		}
		else {
			return str_replace(array('"',"'"), array('%27', '%22'), $url);
		}
	}
	/**
	 * 获取链接的域名部分
	 * @param {string} $url 链接
	 * @return {string}
	 */
	public static function domain ($url, $protocol=1) {
		if ($url) {
			$res = parse_url($url);
			$res['scheme'] || $res['scheme'] = 'http';
			if ($res['host']) {
				return $res['scheme'].'://'.$res['host'];
			} else {
				return '';
			}
		} else {
			return ($protocol == 1 ? ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 'https://' : 'http://') : '').$_SERVER['HTTP_HOST'];
		}
	}
}