<?php

class ace {
	// 判断是否有权限
	public static function allow() {
		if ((int)$_SESSION['JextAce'] == 0) {
			echo 'NEED TO LOGIN!';
			exit;
		}
		self::file();
	}

	// 文件是否存在
	public static function file() {
		// $_POST['file'] = str_replace('../','',$_POST['file']);
		if (preg_match("#/jext/php/ace#", $_POST['file']) || !is_file(c('root') . $_POST['file'])) {
			echo 'THE FILE DOES NOT EXIST!';
			exit;
		}
	}

	// 读取文件内容
	public static function read() {
		self::allow();
		echo file_get_contents(c('root') . $_POST['file']);
		exit;
	}
	
	// 保存文件
	public static function save() {
		self::allow();
		file_put_contents(c('root') . $_POST['file'], stripslashes($_POST['data']));
		echo 'SAVED SUCCESSFULLY!';
		exit;
	}
}