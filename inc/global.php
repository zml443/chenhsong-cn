<?php

header('Access-Control-Allow-Origin: http://localhost:8080');
// header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
// header('Access-Control-Allow-Headers: Content-Type');
// header('Access-Control-Allow-Origin: your_origin');
// header('Access-Control-Allow-Credentials: true');
// header('Access-Control-Allow-Headers: *');
// header('Access-Control-Allow-Headers: Authorization, X-Custom-Header');
header('Content-Type: text/html; charset=utf-8');
header("Set-Cookie: hidden=value; Secure; httpOnly");

phpversion()<'5.3.0' && set_magic_quotes_runtime(0);
date_default_timezone_set('PRC');	//5.1.0

// 网站配置
$root = str_replace('\\','/',substr(dirname(__FILE__), 0, -4).DIRECTORY_SEPARATOR);
include $root.'static/jext/php/inc/common.php';

$c=array(
	// 网站配置
	'HostName' => '',
	'HostTag' => 'web',		//网站类型 web shop
	'HostType' => 'customized',		//网站类型   saas    customized
	// 功能组
	'FnType' => array(
		'language' => array(),
	),
	'HostStorageSize' => 0,
	// 'LYYUnifyApiKey' => '',

	'debug'				=>	true,	//程序报错提示，上线后请填写false，开启：true，关闭：false
	'h5'				=>	true,	//是否为h5网站，开启：true，关闭：false
	'time'				=>	time(),
	'root'				=>	$root,
	'sub_domain_list'	=>	array('www', 'm', 'mobile'),	//二级域名列表
	'language'			=>	array('cn','en'), //array('cn'tc, 'cn', 'en', 'es', 'ru', 'jp', 'de', 'fr', 'pt');	//前端可用的语言列表
	'language_name'		=>	array(
								'cn' => '中文-简体',
								'tc' => '中文-繁体',
								'en' => 'English',
								'jp' => '日本語',
								'de' => 'Deutsch',
								'fr' => 'Français',
								'es' => 'Español',
								'ru' => 'русский язык',
								'pt' => 'Português',
							),
	'language_pack'		=>	array(
								'manage'	=>	$root.'manage/__/lang/', //后台语言包
								// 'themes'	=>	$root.'themes/__/lang/', //前端语言包
	),
	'member'			=>	array(
								'name'			=>	'Member',
							),
	'manage'			=>	array(
								'name'			=>	'Manage',
								'language'		=>	array('cn'), //array();	//后台可用的语言列表
								'permit_path'	=>	$root.'manage/__/permit.php', //权限文件
								'permit'		=>	array(), //权限
								'type'			=>	'normal', // normal:正常登录     sign:密钥登录
							),
	'authorization' => '',

	'aliyun' => array(
		'id' => '',
		'secret' => '',
	),
);

c('FnType.language', c('language'));



//系统设置类
class ly200_web_init {
	public static function init(){
		if (isset($_REQUEST['GLOBALS']) || isset($_FILES['GLOBALS'])) exit;
		if (c('debug')) {
			if (phpversion()<'8.0.0') {
				error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
			} else {
				// error_reporting(E_ERROR | E_NOTICE | E_STRICT);
				error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT ^ E_WARNING);
			}
		} else {
			error_reporting(0);
		}
		self::slashes_gpcf($_GET);
		self::slashes_gpcf($_POST);
		self::slashes_gpcf($_COOKIE);
		self::slashes_gpcf($_FILES);
		self::slashes_gpcf($_REQUEST);
		spl_autoload_register('self::class_auto_load');	//5.1.2
	}
	
	private static function class_auto_load($class_name){
		$n = ltrim(str_replace('\\', '/', $class_name), '/');
		$r = c('root');
		$f = $r.'inc/class/'.$n.'.class.php';
		is_file($f) || $f = $r.'static/jext/php/class/'.$n.'.class.php';
		is_file($f) || $f = $r.'static/jext/php/class/'.$n.'.php';
		is_file($f) || $f = $r.'inc/'.$n.'.class.php';
		is_file($f) || $f = $r.'inc/class/'.$n.'.php';
		is_file($f) && include $f;
	}
	
	private static function slashes_gpcf(&$ary){
		foreach ($ary as $k => $v) {
			if (is_array($v)) {
				self::slashes_gpcf($ary[$k]);
			}
			else {
				$ary[$k] = trim($ary[$k]);
				if (phpversion()<'8.0.0') {
					get_magic_quotes_gpc() || $ary[$k] = addslashes($ary[$k]);
				} else {
					$ary[$k] = addslashes($ary[$k]);
				}
			}
		}
	}
}
ly200_web_init::init();


// 获取 OAuth2
if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
	c('authorization', $_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
	c('authorization', $_SERVER['HTTP_AUTHORIZATION']);
} else if ($_GET['manage_token']) {
	c('authorization', $_GET['manage_token']);
} else if ($_GET['authorization']) {
	c('authorization', $_GET['authorization']);
} else if ($_POST['authorization']) {
	c('authorization', $_POST['authorization']);
}


// 配置
include $c['root'].'inc/config.php';
// 常规配置
$c=array_merge($c, array(
	'module'			=>	array(
								'dir' => c('root').'module/',
								'path' => '/module/',
							),
	'website'			=>	array(
								'name' => $website_name,
								'dir' => c('root').'website/'.$website_name.'/',
								'path' => '/website/'.$website_name.'/',
							),
	'theme_cur'			=>	'/themes/default/',
	'theme'				=>	c('root').'themes/default/',
	'themes'			=>	'/themes/',
	'tmp_dir'			=>	'/file/_tmp/',
	'collection_dir'	=>	'/file/collection/',
	'cache_dir'			=>	'/file/_cache/',
	'cache_timeout'		=>	172800,		//172800, 缓存开启，单位：秒
	'orders_file'		=>	'/file/orders/'.$website_name.'/',
	'u_file_dir'		=>	'/file/upload/'.$website_name.'/',
	'mysql_data'		=>	'/file/_mysql_data/'.$website_name.'/',
	'mysql_data_size'	=>	5242880, //5MB
	'rewrite'			=>	array(),
	'dbs'				=>	array(
								'dir'	=>	c('root').'manage/',  //数据库配置目录
								'inc'	=>	c('root').'manage/__/dbs/inc/',  //数据库配置目录
								'list'	=>	c('root').'manage/__/dbs/list/',  //数据库配置目录
								'edit'	=>	c('root').'manage/__/dbs/edit/',  //数据库配置目录
							),
	'url:set'			=>	c('root').'inc/url.php',
));




// 会话id=====================================
$SERVER_NAME = $_SERVER['HTTP_HOST']?:$_SERVER['SERVER_NAME'];
ini_set('session.cookie_domain', $SERVER_NAME);
ini_set('session.name', $SERVER_NAME);
// ini_set('session.cookie_path', c('website.path'));
if($_GET['session_id'] || $_COOKIE['sessid']){
	c('session_id', $_GET['session_id'] ? $_GET['session_id'] : $_COOKIE['sessid']);
	session_id(c('session_id'));
	session_start();
} else {
	session_start();
	c('session_id', session_id());
	setcookie('sessid', c('session_id'), c('time') + 43200, '/');
}
setcookie('time', c('time'), c('time') + 43200, '/');
// =====================================

// 语言包，后台开启情况 
// ==============
$fn_type_language = (array)(c('FnType.language')?:c('language'));

$language_name = c('language_name');
foreach ($language_name as $k => $v) {
	if (!in_array($k, $fn_type_language)) {
		unset($language_name[$k]);
	}
}
c('language_name', $language_name);


$language_used = (array)g('wb_language.used');
$language_default = g('wb_language.default');
$language_used_ary = array();
foreach ($language_used as $v) {
	if ($v && c('language_name.'.$v)) {
		$language_used_ary[] = $v;
	}
}

if ($language_default && !in_array($language_default, $language_used_ary)) {
	$language_used_ary[] = $language_default;
}
if ($language_used_ary) {
	c('language', $language_used_ary);
} else if ($language_name) {
	reset($language_name);
	c('language', array(key($language_name)));
}
// ==============
// if ($_GET['lang']) {
// 	$_SESSION['lang'] = $_GET['lang'];
// }
$_SESSION['lang'] = "cn";
c('lang', in_array($_SESSION['lang'],c('language'))?$_SESSION['lang'] : (in_array($language_default,c('language'))?$language_default:c('language.0')));
c('manage.lang', in_array($_SESSION['manage.lang'],c('manage.language'))?$_SESSION['manage.lang'] : c('manage.language.0'));




// 网站使用的初始变量
include $c['root'].'inc/var.php';