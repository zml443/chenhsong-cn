<?php

/*
 * 一个比较简单的自制爬虫程序
 * 需要结合 js
 * By Zinn
**/
include '../../../php/init.php';
/*
 * 导入数据表
 * 
**/
set_time_limit(0);


sitemap::init();

class sitemap {
	public static $www = '';
	public static $cur = '';
	public static $bat = array();
	public static $urlarray = array();
	/*
	 * 入口文件
	 * 
	**/
	public static function init () {
		self::$www = $_POST['WWW'];
		if ($_POST['URL'] && is_array($_POST['URL'])) {
			$urlarray = '';
			foreach ($_POST['URL'] as $k => $v) {
				foreach ((array)$v as $k1 => $v1) {
					$urlarray .= ",'".self::url_replace($url)."'";
				}
			}
			$urlarray = ltrim($urlarray, ',');
			if ($urlarray) {
				$r = db::query("SELECT Href, Id FROM jext_sitemap WHERE Href IN($urlarray)");
				while ($v = db::result($r)) {
					self::$urlarray[$v['Id']] = $v['Href'];
				}
			}
			foreach ($_POST['URL'] as $k => $v) {
				foreach ((array)$v as $k1 => $v1) {
					self::insert($v1);
				}
			}
		}
		if ($_POST['OVR'] && is_array($_POST['OVR'])) {
			foreach ((array)$_POST['OVR'] as $k => $v) {
				self::update($k, $v);
			}
		}
		self::insert(self::$www . '/');
		self::insert_bat();
		self::callback();
	}
	/*
	 * 返回需要采集的链接
	 * 
	**/
	public static function callback () {
		$total = db::get_row_count('jext_sitemap');
		$isok = db::get_row_count('jext_sitemap', 'IsOk=1');
		$wait = $total - $isok;
		$data = array(
			'subtotal'	=>	0,
			'total'		=>	(int)$total,
			'isok'		=>	(int)$isok,
			'wait'		=>	$wait,
		);
		$row = db::query("SELECT * FROM jext_sitemap WHERE IsOk = 0 LIMIT 0, 9");
		$array = array();
		while ($v = db::result()) {
			$array[] = $v;
			$data['subtotal']++;
		}
		if ($array) {
			$data['array'] = $array;
			str::msg($data, 1);
		} else {
			str::msg($data, 2);
		}
	}
	/*
	 * 添加
	 * 
	**/
	public static function insert ($url) {
		$url = self::url_replace($url);
		$count = db::result("SELECT count(Id) as t FROM jext_sitemap WHERE Href='{$url}'");
		if (self::$urlarray) {
			if (!self::$urlarray[$url]) {
				self::$bat[] = array(
					'Href'	=>	$url,
				);
			}
		} else if (!$count['t']) {
			self::$bat[] = array(
				'Href'	=>	$url,
			);
		}
	}
	public static function insert_bat () {
		if (self::$bat) {
			db::insert_bat('jext_sitemap', self::$bat);
		}
	}
	/*
	 * 修改
	 * 
	**/
	public static function update ($url, $status) {
		$url = self::url_replace($url);
		db::update('jext_sitemap', "Href='$url'", array(
			'Status'	=>	$status,
			'IsOk'		=>	1
		));
	}
	/*
	 * 修改
	 * 
	**/
	public static function url_replace ($url) {
		if ($url) {
			$url = str_replace('&amp;', '&', $url);
		}
		return $url;
	}
}