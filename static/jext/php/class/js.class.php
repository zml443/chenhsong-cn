<?php

class js{
	public static function contents_code($str){
		return str_replace('\'', '\\\'', str_replace(array("\r\n", "\r", "\n"), '', $str));
	}
	
	public static function location($url, $alert='', $top=''){
		if($alert=='' && $top=='' && headers_sent()==false){
			header("Location: $url");
			exit;
		}
		echo '<script language="javascript">';
		if($alert){
			echo 'alert(\''.self::contents_code($alert).'\');';
		}
		$top && $top = '.'.$top;
		echo "window{$top}.location='$url';";
		echo '</script>';
		exit;
	}
	
	public static function back($alert=''){
		echo '<script language="javascript">';
		if($alert){
			echo 'alert(\''.self::contents_code($alert).'\');';
		}
		echo 'history.back();';
		echo '</script>';
		exit;
	}
	public static function close($alert=''){
		echo '<script language="javascript">';
		if($alert){
			echo 'alert(\''.self::contents_code($alert).'\');';
		}
		echo 'window.close();';
		echo '</script>';
		exit;
	}

	public static function meta($url, $time=1){
		echo "<meta http-equiv='Refresh' content='$time;url=$url'/>";
		exit;
	}
}