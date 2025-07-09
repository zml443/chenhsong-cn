<?php

// d(curl::init('https://www.cnlaunch.com/news_view.aspx?TypeId=4&Id=17315&Fid=t2:4:2'));

// curl::init('https://www.cnlaunch.com/news_view.aspx?TypeId=4&Id=17315&Fid=t2:4:2'
// ,array(

// 	)
// 	,array(
//		CURLOPT_COOKIE => '',
// 	)
// 	,"
// 	User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36
// 	Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
// 	Upgrade-Insecure-Requests: 1
// 	Sec-Fetch-Site: same-origin
// 	Sec-Fetch-Mode: navigate
// 	Sec-Fetch-User: ?1
// 	Sec-Fetch-Dest: document
// 	Referer: https://www.baidu.com
// 	Accept-Encoding: gzip, deflate, br
// 	Accept-Language: zh-CN,zh;q=0.9
// 	"
// ), '125.200.86.56');

class curl {
	/*
	 * curl请求
	 * @param {string} $url 请求网址
	 * @param {array|string} $post 提交post数据
	 * @param {array} $curl_opt curl的配置参数
	 * @param {string} $httphead 请求标头，一般复制浏览器给的就好
	 * @param {ip} $ip 模拟其它IP
	 * @return {array}
	 * 
	 */
	public static function init ($url, $post='', $curl_opt=array(), $httphead='', $ip='') {	//post或get，读取数据
		if (!$url) {
			return '';
		}
		$httphead = self::httphead_exploce($httphead, $url, $ip);
		$options = array(
			CURLOPT_URL				=>	$url,
			// CURLOPT_PROXY			=>	'125.200.86.56',
			// CURLOPT_PROXYPORT		=>	'80',
			CURLOPT_HEADER			=>	true,
			CURLOPT_RETURNTRANSFER	=>	true,
			CURLOPT_CONNECTTIMEOUT	=>	30,
			CURLOPT_TIMEOUT			=>	30,
			CURLOPT_POST			=>	$post?true:false,
			CURLOPT_SSL_VERIFYPEER	=>	false,
			// CURLOPT_NOBODY			=>	1,
			// CURLOPT_CUSTOMREQUEST	=>	$post?'POST':'GET',
			// CURLOPT_HTTP_VERSION	=>	CURL_HTTP_VERSION_1_0,
			// CURLOPT_IPRESOLVE		=>	CURL_IPRESOLVE_V4,
			CURLOPT_HTTPHEADER		=>	$httphead[0],
			// CURLOPT_VERBOSE			=>	1,
		);
		// 将请求标头的数据同步到配置里面
		$change_httphead = array(
			'referer' => CURLOPT_REFERER,
			'user-agent' => CURLOPT_USERAGENT,
			'accept-encoding' => CURLOPT_ENCODING,
			'cookie' => CURLOPT_COOKIE,
		);
		foreach ($change_httphead as $k => $v) if ($httphead[$k]) $options[$v] = $httphead[$k];
		// POST提交
		$post && $options[CURLOPT_POSTFIELDS] = is_array($post)?http_build_query($post):$post;
		// curl配置
		foreach((array)$curl_opt as $k => $v) $options[$k] = $v;
		$ch = curl_init();
		curl_setopt_array($ch, $options);
		// 结果
		$result = curl_exec($ch);
		$handle = curl_getinfo($ch);
		$error = curl_error($ch);
		if ($options[CURLOPT_HEADER]) {
			$header = substr($result, 0, $handle['header_size']);
			$cookie = $options[CURLOPT_COOKIE];
			if (preg_match('/Set-Cookie:(.*)/i', $header, $cookie_match)) {
				$cookie = $cookie_match[1];
			}
			$result=substr($result, $handle['header_size']);
		}
		curl_close($ch);
		return array(
			0 => $result,
			'handle' => $handle,
			'cookie' => $cookie,
			'options' => $options,
			'header' => $header,
			'error' => $error
		);
	}

	public static function api($url, $key, $data){	//返回结果如果是数组，则表示成功，非数组，则是错误的提示语
		$data['timestamp'] = c('time');
		$data = str::code($data, 'trim');
		$data['sign'] = curl::sign($key, $data);
		$result = curl::init($url, $data);
		if (!$result[0]) {
			return '';
		} else {
			return $result[0];
		}
	}


	public static function manage_api($url, $key, $data){	//返回结果如果是数组，则表示成功，非数组，则是错误的提示语
		$data['ly_manage_timestamp'] = c('time');
		$data = str::code($data, 'trim');
		$data['ly_manage_sign'] = curl::sign($key, $data);
		$result = curl::init($url, $data);
		if (!$result[0]) {
			return '';
		} else {
			return $result[0];
		}
	}

	public static function sign($key, $data){	//生成签名
		$str = '';
		$data = str::code($data, 'trim');
		ksort($data);
		foreach ((array)$data as $k => $v) {
			if ($k=='sign' || $k=='ly_manage_sign' || $v===''){ continue; }
			$str .= "$k=$v&";
		}
		return md5($str.'key='.$key);
	}

	/*
	 * 将字符串根据按照换行分割成数组
	 * @param {string} $httphead 请求头格式
	 * @param {string} $httphead 请求头格式
	 * @param {string} $httphead 请求头格式
	 * @return {array}
	 * 
	 */
	public static function httphead_exploce ($httphead, $url, $ip='') {
		$httphead || $httphead = '
			Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7
			Accept-Encoding: gzip, deflate, br
			Accept-Language: zh-CN,zh;q=0.9,en;q=0.8
			Cache-Control: no-cache
			Pragma: no-cache
			Sec-Ch-Ua: "Not/A)Brand";v="99", "Google Chrome";v="115", "Chromium";v="115"
			Sec-Ch-Ua-Mobile: ?0
			Sec-Ch-Ua-Platform: "Windows"
			Sec-Fetch-Dest: document
			Sec-Fetch-Mode: navigate
			Sec-Fetch-Site: none
			Sec-Fetch-User: ?1
			Upgrade-Insecure-Requests: 1
			User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36
		';
		// $httphead || $httphead = "
		// 	User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36
		// 	Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
		// 	Referer: https://docimg10.docs.qq.com
		// ";
		$httphead .= "
			Referer: ".url::domain($url)."
		";
		$ip && $httphead .= "
			CLIENT-IP: {$ip}
			X-FORWARDED-FOR: {$ip}
		";
		$str = explode("\n", $httphead);
		$ary = array(0=>array());
		foreach ($str as $v) {
			$v = trim(str_replace(array("\r", "\t"), '', $v));
			if ($v) {
				if (preg_match("/^:?([^:]+):(.*+)$/", $v, $v1)) {
					$k1 = strtolower($v1[1]);
					$v1 = $v1[2];
					$ary[$k1] = ltrim(ltrim($v1, ':'));
					$ary[0][] = $k1.':'.$v1;
				}
			}
		}
		return $ary;
	}
}
?>