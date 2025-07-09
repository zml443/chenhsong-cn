<?php

class check {
	// 检测密码强度
	// 0-3弱，4-6中，7以上强
	public static function password ($s) {
		$score=0;
       	if(preg_match("/[0-9]+/", $s)) 		$score++;
        if(preg_match("/[0-9]{3,}/", $s))	$score++;
       	if(preg_match("/[a-z]+/", $s)) 		$score++;
       	if(preg_match("/[a-z]{3,}/", $s))	$score++;
       	if(preg_match("/[A-Z]+/", $s)) 		$score++;
       	if(preg_match("/[A-Z]{3,}/", $s))	$score++;
       	if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/", $s)) 	$score+=2;
       	if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]{3,}/", $s)) 	$score++;
       	if(strlen($s)>=6) $score+=2;
       	return $score>3?$score:0;
	}

	// 检测特殊符号
	public static function str ($s) {
		return preg_match('/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\/|\;|\'| \`|\-|\=|\\\|\|/isu',$s);
	}

	// 检测邮箱格式
	public static function email ($s) {
		return preg_match('/^[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+)*@([a-zA-Z0-9]+[-.])+([a-z]{2,5})$/ims',$s);
	}

	// 检测手机格式
	public static function phone ($s) {
		return preg_match('/^[0-9]{11}$/ims',$s);
	}

	// 检测手机格式
	public static function mobile ($s) {
		return preg_match('/^[0-9]{11}$/ims',$s);
	}

	// 检测身份证
	public static function ID ($s) {
		return preg_match('/^\d{15}$)|(^\d{17}([0-9]|X)$/isu',$s);
	}

	// 检测银行卡
	public static function bankCard ($s) {
		return preg_match('/^(\d{15}|\d{16}|\d{19})$/isu',$s);
	}

	// 检测QQ
	public static function QQ ($s) {
		return preg_match('/^\d{5,12}$/isu',$s);
	}

	// 检测微信
	public static function weixin ($s) {
		return preg_match('/^[_a-zA-Z0-9]{5,19}+$/isu',$s);
	}
}