<?php
namespace system;
use server;
use js;
use ip;

class web{

	// 302重定向
	public static function jump302 () {	
		if (!preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$|localhost$|^sy[a-z]{2}[0-9]{3}\./", $_SERVER['HTTP_HOST']) && g('Web301')) {
			$www = explode('.', $_SERVER['HTTP_HOST']);
			$www = reset($www);
			$sub = c('sub_domain_list');
			if (!in_array($www, $sub)) {
				if (server::mobile()) {
					$w = g('wwwMobile');
				} else {
					$w = g('wwwPc');
				}
				$w || $w=$sub[0];
				js::location("//{$w}.{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
			}
		}
	}


	// 关闭网站
	public static function close () {
		if (!manage('Id')) {
			$ip = ip::info();
			if ( ($ip['country']=='中国' && g('set.web.LockChineseIp')) || (g('set.web.LockChineseBrowser') && preg_match("/zh-cn/i", $_SERVER['HTTP_ACCEPT_LANGUAGE'])) ) {
				include c('root') . "/404.php";
				exit;
			} else if (g('set.web.close')) {
				if (g('set.web.close_detail')) {
					// echo '';
					include c('root') . "/403.php";
				} else {
					include c('root') . "/404.php";
				}
				// echo g('set.web.closeHtml');
				exit;
			}
		}
	}
}
