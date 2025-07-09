<?php


// 管理员信息
// 为了兼容多个站点在同一个服务器 获取 $_SESSION 不起冲突
function manage ($k='', $v=null) {
	$n = c('manage.name').c('Number');
	if (!c('manage.name')) {
		return array();
	}
	if ($v!==null) {
		if ($k) $_SESSION[$n][$k] = $v;
		else $_SESSION[$n] = $v;
	} else if ($k) return $_SESSION[$n][$k];
	else return $_SESSION[$n];
}
function unset_manage () {
	$n = c('manage.name').c('Number');
	unset($_SESSION[$n]);
}

// 会员
function member ($k='', $v=null) {
	$n = c('member.name').c('Number');
	if ($v!==null) {
		if ($k) $_SESSION[$n][$k] = $v;
		else $_SESSION[$n] = $v;
	} else if ($k) return $_SESSION[$n][$k];
	else return $_SESSION[$n];
}
function unset_member () {
	$n = c('member.name').c('Number');
	unset($_SESSION[$n]);
}

// 表名
function t($ma){
	if (strstr('^'.$ma, '^wb_')) {
		return $ma;
	} else {
		return 'wb_'.str_replace('/', '_', preg_replace('/\\/index$/', '', $ma));
	}
}


// $c
function c ($k='', $m=null) {
	global $c;
	if (!$k) return $c;
	$k = explode('.', trim($k,'.'));
	if ($m===null) {
		$a = &$c;
		foreach ($k as $v) {
			if (is_array($a) && isset($a[$v])) {
				$a = &$a[$v];
			} else {
				return '';
			}
		}
		return $a;
	} else {
		$a = &$c;
		foreach ($k as $v) {
			if (!is_array($a)) $a = array("$v"=>array());
			$a = &$a[$v];
		}
		$a = $m;
	}
}


// $m
$__m__ = array();
function m ($k='', $m=null) {
	global $__m__;
	if (!$k) return $__m__;
	$k = explode('.', trim($k,'.'));
	if ($m===null) {
		$a = &$__m__;
		foreach ($k as $v) {
			if (is_array($a) && isset($a[$v])) {
				$a = &$a[$v];
			}
			else {
				$a = '';
				break;
			}
		}
		return $a;
	}
	else {
		$a = &$__m__;
		foreach ($k as $v) {
			if (!is_array($a)) $a = array("$v"=>array());
			$a = &$a[$v];
		}
		$a = $m;
	}
}






// 获取全局可变参数
// 一般情况用这个就足够了
function g ($kstr, $m=null, $dbname='') {
	$kstr = explode('.', trim($kstr,'.'));
	$istr = addslashes($kstr[0]);
	$table = '`'.($dbname?$dbname:c('db_cfg.database')).'`.data_global_config';
	$gbl = 'global-'.$table;
	unset($kstr[0]);
	if (!$GLOBALS[$gbl] || !isset($GLOBALS[$gbl][$istr])) {
		if (!$GLOBALS[$gbl]) {
			$GLOBALS[$gbl] = array();
		}
		db::query("select * from $table where GroupId='$istr'");
		while ($v = db::result()) {
			$g = $v['GroupId'];
			$v = str::json($v['Data'], 'decode');
			$GLOBALS[$gbl][$g] = $v;
		}
	}
	if ($m===null) { //获取内容
		$val = $GLOBALS[$gbl][$istr];
		foreach ($kstr as $v) {
			$val = isset($val[$v]) ? $val[$v] : '';
		}
		return $val;
	} else { // 修改，插入内容
		// unset($k[1]);
		$val = $GLOBALS[$gbl][$istr];
		$a = &$val;
		foreach ($kstr as $v) {
			if (!is_array($a)) $a = array("$v"=>array());
			$a = &$a[$v];
		}
		$a = $m;
		$id = db::result("select Id from $table where GroupId='$istr'",'Id');
		// $val = str::code($val,'stripslashes');
		$GLOBALS[$gbl][$istr] = $val;
		$data = array(
			'GroupId'	=>	$istr,
			// 'Data'		=>	str::json_code(str::json(str::code($val, 'addslashes')))
			'Data'		=>	$val?str::code(str::json($val),'addslashes'):''
		);
		if ($id) {
			db::update($table, "Id=$id", $data);
		} else {
			db::insert($table, $data);
		}
	}
}







// 多语言切换
function l () {
	$args = (array)func_get_args();
	foreach ((array)c('language') as $k => $v) {
		if ($v == c('lang')) {
			$str = $args[$k];
			break;
		}
	}
	return $str;
}
// name_cn name_en
function ln ($name) {
	return $name.'_'.c('lang');
}
// 后台可能用得到
function lm ($name) {
	return $name.'_'.c('manage.lang');
}



// 调用后台语言包
function language ($str, $need_check=0) {
	language_all('');
	if (substr($str,0,1)=='{') {
		$s = rtrim(ltrim($str, '{/'), '/}');
		$s = c('language-manage-cur.'.$s);
		return $s?$s:$str;
	} else if ($str=='all' || $str==='') {
		return c('language-manage-cur');
	} else if (strpos($str,'.') || $need_check) {
		return c('language-manage-cur.'.$str);
	} else {
		return $str;
	}
}
function language_all ($html) {
	if (!c('language-manage-cur')) {
		$pack = c('language_pack.manage').c('manage.lang').'/0.php';
		$pack_cn = c('language_pack.manage').'cn/0.php';
		c('language-manage-cur', is_file($pack) ? include $pack : include $pack_cn);
	}
	if (!$html) return '';
	$replace = array();
	preg_match_all("/{\/(.*)\/}/isU", $html, $lang);
	foreach($lang[1] as $v){
		if (!$n = c('language-manage-cur.'.$v)) {
			continue;
		}
		$replace[0][] = "{/$v/}";
		$replace[1][] = $n;
	}
	return str_replace($replace[0], $replace[1], $html);
}
function lang ($str, $need_check=0) {
	if (!c('language-manage-cur')) {
		$pack = c('language_pack.manage').c('lang').'/0.php';
		$pack_cn = c('language_pack.manage').'cn/0.php';
		c('language-manage-cur', is_file($pack) ? include $pack : include $pack_cn);
	}
	if (substr($str,0,1)=='{') {
		$s = rtrim(ltrim($str, '{/'), '/}');
		$s = c('language-manage-cur.'.$s);
		return $s?$s:$str;
	} else if (strpos($str,'.') || $need_check) {
		return c('language-manage-cur.'.$str);
	} else {
		return $str;
	}
}




// 后台权限
function p ($str='') {
	// 导入权限文件，只需要导入一次
	require_once c('manage.permit_path');
	if (!$str) {
		return c('manage.permit.operation');
	} else if ($str=='cur') {
		return c('manage.permit.operation_cur');
	} else if ($str=='url') {
		return c('manage.permit.url');
	} else if (strstr('^'.$str, '^manage.permit')) {
		return c($str);
	}
	$str = str_replace(',,', ',', rtrim(str_replace(array('.', '/'), ',', $str), ','));
	if (c('manage.permit.operation.'.$str)) {
		if (manage('Level')==1 || c('manage.permit.operation_cur.'.$str)) {
			return c('manage.permit.operation.'.$str);
		}
	}
	return 0;
}
function p_all ($str='') {
	// 导入权限文件，只需要导入一次
	require_once c('manage.permit_path');
	if (!$str) {
		return c('manage.permit.operation');
	}
	else {
		return c('manage.permit.operation.'.$str);
	}
}




// 打印
function d () {
	$args = (array)func_get_args();
	foreach ($args as $v) {
		echo '<pre>';
		print_r($v);
		echo '</pre>';
		echo "\r\n";
	}
}
function dd () {
	$args = (array)func_get_args();
	foreach ($args as $v) {
		echo '<pre>';
		var_dump($v);
		echo '</pre>';
		echo "\r\n";
	}
}


// 应用商店
function a($s=''){
	if (!m('__app_store__')) {
		if (c('HostTag')=='shop') {
		    $app = include c('root').'manage/__/app-shop.php';
		} else {
		    $app = include c('root').'manage/__/app-web.php';
		}
		// 解析全部权限
		$u = array();
		foreach ($app as $k => $v) {
			if ($k=='_') continue;
			foreach ($v as $k1=>$v1) {
				$u[$k1] = array('key'=>$v1['key']);
				if ($v1['children']) {
					foreach ($v1['children'] as $k2=>$v2) $u[$k2] = array('key'=>$v2['key']);
				}
			}
		}
		// 按需开启权限
		if (c('IsAllFn')) {
			$n = $u;
		} else {
			$a = g("app_store");
			$n = array();
			foreach ((array)$a as $k => $v) {
				if (is_array($v)) foreach ($v as $k1 => $v1) $n[$k1] = $v1;
				else $n[$k] = $v;
			}
			foreach ((array)$app['_'] as $k => $v) $n[$k] = 1;
		}
		c('__app_store__', array(
			'__current__' => $n,
			'__use__' => $u,
			'__all__' => $app
		));
	}
	if ($s=='__all__') {
		return c('__app_store__.__all__');
	} else if (strpos($s, '__use__')!==false) {
		return c('__app_store__.'.$s);
	} else if ($s) {
		return c('__app_store__.__current__.'.$s);
	} else {
		return c('__app_store__.__current__');
	}
}


function r($arr, $xx=''){
	$str = '';
	is_string($xx) && $xx=explode(',',$xx);
	foreach ((array)$arr as $k => $v) $str .= " {$k}='$v'";
	return $str;
}

// 链接
function href($key, $query_string=''){
	$url = c('manage.permit.allurl.'.$key.'._');
	$query_string && $query_string = (strstr($url, '?')?'&':'?').$query_string;
	return $url.$query_string;
}

?>