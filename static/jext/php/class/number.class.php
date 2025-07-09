<?php

class number {
	/*
	 * 数字的整理
	 * @param int $num 整型数字
	 * @return string
	 */
	public static function format ($num) {
		$a = array('','万','亿');
		$k = $num;
		for ($i=10000,$j=0;$k>$i;$j++) {
			$i*=10000;
		}
		return $k>10000?ceil($k/$i*10000).$a[$j]:$k;
	}
	/**
	 * 数字的整理
	 * @param int $num 整型数字
	 * @return string
	 */
	public static function split ($num) {
		$num = (string)$num;
		if (strpos($num,'.')) {
			$len = strlen(strrchr($num,'.'))-1;
			return number_format($num, $len);
		}
		return number_format($num);
	}
}