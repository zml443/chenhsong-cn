<?php

namespace system;
use server;


class uri {
	// 初始化
	public static function init () {
		if (strpos($_GET['weburl'], '?')) {
			$u = explode('?', $_GET['weburl']);
			$_GET['weburl'] = $u[0];
			$u = explode('&', $u[1]);
			foreach ($u as $v) {
				$a = explode('=', $v);
				$_GET[$a[0]] = $a[1];
			}
			unset($u);
		}

		// 去掉后缀
		$_GET['weburl'] = '/' . trim(str_replace('..', '', $_GET['weburl']), '/');
		if (preg_match('/\.(html?|php|js|css|tpl)$/i', $_GET['weburl'])) {
			$_GET['weburl'] = str_replace(strrchr($_GET['weburl'], '.'), '', $_GET['weburl']);
		}

		// 匹配自定义伪静态链接
		foreach ((array)c('rewrite') as $k=>$v) {
			$u = preg_replace("#{$k}#", "{$v}", $_GET['weburl']);
			if ($u != $_GET['weburl']) {
				$_GET['weburl'] = $u;
				break;
			}
		}

		$u = explode('/', ltrim($_GET['weburl'], '/'));
		// 找出对应的 themes(主题) 文件夹
		$www = explode('.', $_SERVER['HTTP_HOST']);
		$www = reset($www);
		$theme = c('root') . c('themes');
		if ($u[0] && is_dir($theme . $u[0])) {
			$p = $u[0].'/';
			unset($u[0]);
		} else if (!c('h5') && (server::mobile() || in_array($www, array('m', 'mobile'))) ) {	//手机版设置
			$p = 'mobile/';
		} else {
			$p = 'default/';
		}
		$theme .= $p;
		c('theme', $theme);
		c('theme_cur', c('themes').$p);

		// 匹配出对应的文件
		if (!$_GET['m']) {
			$exfile = $oofile = '';
			$_GET['m'] = 'index';
			foreach ((array)$u as $k=>$v) {
				$exfile = ltrim($exfile.'/'.$v, '/');
				if (is_file($theme . $exfile . '.php')) {
					$oofile = $_GET['m'] = $exfile;
					break;
				}
				if (is_file($theme . $exfile . '/index.php')) {
					$oofile = $exfile;
					$_GET['m'] = ltrim($exfile.'/index', '/');
				}
			}
			if ($_GET['m']=='index' && count($u)>0 && $u[0] && ($u[0]!='index' || (!isset($u[0]) && $u[1]!='index'))) {
				$_GET['m'] = '404';
			}
			$u = implode('/', $u);
			$u = preg_replace("#{$oofile}#", '', $u, 1);
			$u = preg_replace('#([^\\-=]*)[-=]([^/]*)#', '$1/$2', $u, 4);
			$u = explode('/', ltrim($u, '/'));
		}
		// 将多余的链接字符转换成参数格式
		for ($k=0; $k < count($u); $k++) {
			$_GET[$u[$k]] = $u[++$k];
		}
	}

}