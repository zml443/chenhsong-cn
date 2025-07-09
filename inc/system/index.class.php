<?php
namespace system;
use file;

class index {

	// 开始
	public static function init () {
		uri::init(); // 路由处理
		if (!self::show()) {
			$file = c('theme').$_GET['m'].'.php';
			if (is_file($file)) {
				self::make($file);
			} else {
				include c('root').'404.php';
			}
		}
	}

	// 允许生成缓存文件
	public static function allow () {
		return c('cache_timeout') && in_array($_GET['m'], (array)c('cache_file'));
	}

	// 生成文件名称
	public static function name () {
		$n='';
		foreach ($_GET as $k => $v) $n .= $k.'='.$v.'&';
		return md5($n.'lang='.c('lang'));
	}

	// 管理文件夹
	public static function path () {
		return c('cache_dir') . c('theme_cur') . $_GET['m'] . '/';
	}

	// 缓存文件调用
	private static function show () {
		if (!self::allow()) return 0;
		$file = c('root') . self::path() . self::name();
		if (is_file($file)) {
			$time = filemtime($file);
			if ($time+c('cache_timeout') > c('time')) {
				require $file;
				return 1;
			}
		}
		return 0;
	}

	// 生成缓存文件
	private static function make ($file) {
		if ($html = self::html($file)) {
			if (self::allow()) {
				$html = self::rar($html);
				$path = self::path();
				$file = c('root') . self::path() . self::name();
				file::mk_dir($path);
				file_put_contents($file, $html);
			}
			echo $html;
		}else{
			include c('root') . '404.php';
		}
	}

	/* 
	 * 获取内容
	 * @param string $file 文件路径
	 * @return string html缓存
	 */
	private static function html ($file) {
		global $c;
		ob_start();
		include $file;
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	/* 
	 * 部分缓存的处理
	 * @param string $a 文件路径
	 * @param int $all 全部页面同时使用相同的缓存文件
	 * @param int $time 缓存保存时间，按秒计算
	 */
	private static function part ($a, $all=0, $time=259200) {
		$name = $all ? md5($a) : md5($a . self::name());
		$path = self::path();
		$file = c('root') . $path . $name;
		if (is_file($file) && filemtime($file)>(c('time') - $time)) {
			include $file;
		} else if (is_file($a)) {
			ob_start();
			include $a;
			$html = self::rar(ob_get_contents());
			ob_end_clean();
			file::mk_dir($path);
			file_put_contents($file, $html);
			echo $html;
		}
	}

	// 文件压缩
	private static function rar ($html_source) {
		return $html_source;
		// 后面不用看了，这个压缩函数有问题，等待修复
		$chunks   = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
	    $compress = '';
	    foreach ($chunks as $c) {
	        if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
	            $c = substr($c, 19, strlen($c) - 19 - 20);
	            $compress .= $c;
	            continue;
	        } else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
	            $c = substr($c, 12, strlen($c) - 12 - 13);
	            $compress .= $c;
	            continue;
	        } else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
	            $compress .= $c;
	            continue;
	        } else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) { // JS代码，包含“//”注释的，单行代码不处理
	            $compress .= $c;
	            continue;
	            /*$tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
	            $c    = '';
	            foreach ($tmps as $tmp) {
	                if (strpos($tmp, '//') !== false) { // 对含有“//”的行做处理
	                    if (substr(ltrim($tmp), 0, 2) == '//') { // 开头是“//”的就是注释
	                        continue;
	                    }
	                    $chars   = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
	                    $is_quot = $is_apos = false;
	                    foreach ($chars as $key => $char) {
	                        if ($char == '"' && !$is_apos && $key > 0 && $chars[$key - 1] != '\\') {
	                            $is_quot = !$is_quot;
	                        } elseif ($char == '\'' && !$is_quot && $key > 0 && $chars[$key - 1] != '\\') {
	                            $is_apos = !$is_apos;
	                        } elseif ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
	                            $tmp = substr($tmp, 0, $key); // 不是字符串内的就是注释
	                            break;
	                        }
	                    }
	                }
	                $c .= $tmp;
	            }*/
	        }
	        $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c); // 清除换行符，清除制表符
	        $c = preg_replace('/\\s{2,}/', ' ', $c); // 清除额外的空格
	        $c = preg_replace('/>\\s</', '> <', $c); // 清除标签间的空格
	        $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c); // 清除 CSS & JS 的注释
	        $c = preg_replace('/<!--[^!]*-->/', '', $c); // 清除 HTML 的注释
	        $compress .= $c;
	    }
	    return $compress;
	}
}