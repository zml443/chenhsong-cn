<?php

class time {
	
	// 计算2个时间段之间的月份列表
	public static function month_list ($t0, $t1) {
		if ($t0 >= $t1) {
			return array(array($t0, $t0));
		}
		$y0 = date('Y', $t0);
		$y1 = date('Y', $t1);
		$m0 = date('m', $t0);
		$m1 = date('m', $t1);
		if ($y0 != $y1) {
			$mon = 12*($y1-$y0) - $m0 + $m1;
		} else {
			$mon = $m1 - $m0;
		}
		$arr = array();
		for ($i=0; $i<$mon; $i++) {
			$lt = strtotime('+1 month', $t0);
			if ($lt > $t1) {
				$lt = $t1;
			}
			$arr[] = array($t0, $lt);
			$t0 = $lt;
			if ($lt==$t1) break;
		}
		return $arr;
	}

	// 时间的整理
	public static function format ($num, $format='Y/m/d') {
		$time=time()-$num;
		$a = array('年','月','天','小時','分鐘','秒');
		$d = array(31104000,2592000,86400,3600,60,1);
		foreach($d as $k=>$v){
			if($t=floor($time/$v)) break;
		}
		$t=$t?$t:1;
		return $k<3 ? date($format,$num) : $t.$a[$k].'前';
	}

	// 时间段
	public static function period ($num, $format='Y.m') {
		$time=time()-$num;
		$yesterday = time()-strtotime(date('Y-m-d'));
		$a = array('很久以前', '一个月前', '最近', '昨天','今天');
		$d = array(5184000, 2592000, 86500+$yesterday, $yesterday, 1);
		foreach ($d as $k=>$v) {
			if (floor($time/$v)) break;
		}
		return $k ? $a[$k] : date($format, $num);
	}
}