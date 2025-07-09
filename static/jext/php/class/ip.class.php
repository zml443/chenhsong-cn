<?php

class ip {
	/*
	 * 获取访问ip
	 * @return {ip}
	 * 
	 */
	public static function get () {
		if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if ($_SERVER['HTTP_CLIENT_IP']) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return preg_match('/^[\d]([\d\.]){5,13}[\d]$/', $ip) ? $ip : '';
	}

	/*
	 * ip信息
	 * @param {ip} 输入IP地址
	 * @return {array}
	 * 
	 */
	public static function info ($ip='') {
		require_once 'ip/src/IpLocation.php';
		return \itbdw\Ip\IpLocation::getLocation($ip ? $ip : self::get());
	}
}