<?php

class vcode {
	// 来源签名ID
	public static function cca() {
		$az = range('A','Z');
		$ua = array();
		$ij = 65;
		foreach ($az as $v) {
			$ua[$v] = $ij++;
		}
		$url = preg_replace('/[^A-Z]/','',strtoupper(str_replace(array('/','\\'), 'l', $_SERVER['HTTP_REFERER'])));
		$len = strlen($url);
		return $ua[$url{$len % 5}] ^ $ua[$url{$len % 3}] ^ $ua[$url{$len % 8}];
	}
	public static function referer_id() {
		$az = range('A','Z');
		$ua = array();
		$ij = 65;
		foreach ($az as $v) {
			$ua[$v] = $ij++;
		}
		$url = preg_replace('/[^A-Z]/','',strtoupper(str_replace(array('/','\\'), 'JZ', $_SERVER['HTTP_REFERER'])));
		$len = strlen($url);
		if (!$len || !$url) {
			return '';
		}
		$g = explode('.', $_POST['REFERERID']);
		$g = ($g[0]>c('time')+10||$g[0]<c('time')-10) ? 0 : $g[0];
		$d = array(29,6,3,12,7,4,5,22,11);
		$a = '';
		$k = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		foreach ($d as $i) {
			$l = ($i+$g)%$len;
			$n = substr($url,$l,1);
			$a .= $n . $k{$ua[$n] % 24} . $k{$l%36};
		}
		return $g.'.'.$a;
	}
	// 身份验证
	public static function check() {
		$VCodeID = $_SESSION['VCode']['ID'];
		unset($_SESSION['VCode']['ID']);
		if (!$VCodeID || $VCodeID != $_POST['VCodeID']) {
			self::msg('请重新提交，多次提交无效请联系管理员！', 0);
		}
	}
	// 验证 jext 令牌
	public static function token($token){
		// 
		$h = preg_replace('/[^A-Z]/','',strtoupper($_SERVER['HTTP_REFERER']));
		$l = strlen($h);
		$t = c('time') - ((int)(c('time')/10000))*10000;
		for ($i=0;$i<3;$i++) {
			$s = (($l%5)^($t-$i)).''.(($l%3)^($t-$i)).''.(($l%8)^($t-$i));
			if ($s==$token) {
				return 1;
			}
		}
		return 0;
	}
}