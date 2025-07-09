<?php


class file {
	// 过滤 root ,主要是存在2中模式，
	// 一种是只对本站文件操作，一种是整个系统操作
	// 所以需要过滤一下网站文件夹
	public static function filter_root($path, $p=0) {
		$path = str_replace('\\', '/', $path);
		$path = ltrim(str_replace('^'.c('root'),'/','^'.$path),'^');
		$path = str_replace('//', '/', $path);
		return $p ? c('root').$path : $path;
	}

	//建立目录
	public static function mkdir ($dir, $not_in_root=0) {
		if (!$not_in_root) {
			$dir = self::filter_root($dir, 1);
		}
		$arr_dir = explode('/', $dir);
		for ($i=0; $i<count($arr_dir); $i++) {
			$base_dir = '';
			for ($j=0; $j<=$i; $j++) {
				$base_dir .= $arr_dir[$j].'/';
			}
			@is_dir($base_dir) || @mkdir($base_dir);
			/*if (!is_dir($base_dir)) {
				mkdir($base_dir);
				chmod($base_dir, 0777);
			}*/
		}
		return $dir;
	}
	
	//递归删除目录
	public static function rmdir ($path, $not_in_root=0) {
		if (!$not_in_root) {
			$path = self::filter_root($path, 1);
		}
		$path_name = '/'.trim(preg_replace('/[\\/]+/', '/', self::filter_root($path)),'/');
		//不允许删除的文件夹  
		if(!$path_name || !is_dir($path) || in_array($path_name, array('/','/file','/inc','/manage','/themes','/themes/module'))){
			return false;
		}
		if (preg_match('/^\\/(manage|inc|themes\/(api|defalut|__)|static|images|gateway)/', $path_name)) {
			return false;
		}
		$fh = opendir($path);  
		while (($row = readdir($fh))!==false) {
			if ($row=='.' || $row=='..') continue;
			if (!is_dir($path.'/'.$row)) {
				unlink($path.'/'.$row);
			}
			self::rmdir($path.'/'.$row);
		}
		//关闭目录句柄，否则出Permission denied  
		closedir($fh);
		//删除文件之后再删除自身  
		if(!rmdir($path)){
			return false;
		}
		return true;
	}

	// 复制文件夹
	public static function copydir ($path, $newsdir, $not_in_root=0) {
		if (!$not_in_root) {
			$path = self::filter_root($path, 1);
			$newsdir = self::filter_root($newsdir, 1);
		}
		//给定的目录不是一个文件夹  
		if(!is_dir($path)){  
			return false;
		}
		file::mkdir($newsdir, 1);
		$fh = opendir($path);  
		while (($v = readdir($fh))!==false) {
			if ($v=='.' || $v=='..') continue;
			if (is_dir($path.'/'.$v)) {
				self::copydir($path.'/'.$v, $newsdir.'/'.$v, $not_in_root);
			}
			else {
				copy($path.'/'.$v, $newsdir.'/'.$v);
			}
		} 
		closedir($fh);
		return true;
	}
	
	//返回文件后辍名（小写）
	public static function ext_name ($file='') {
		return strtolower(ltrim(strrchr((string)$file, '.'), '.'));
	}
	/**
	 * 转换文件大小的矢量
	 * @param {int|string} $size 文件大小或者文件路径
	 * @return {string}
	 */
	public static function size ($size, $not_in_root=0) {
		if (!is_numeric($size)) {
			if (!$not_in_root) {
				$size = self::filter_root($size, 1);
			}
			if (is_file($size)) {
				$size = filesize($size);
			}
			else $size = 0;
		}
		$size_unit=array('B', 'KB', 'MB', 'GB', 'TB');
		for ($i=0; $i<count($size_unit); $i++) {
			if ($size >= pow(2, 10*$i)-1) {
				$size_unit_str=(ceil($size/pow(2,10*$i)*100)/100).$size_unit[$i];
			}
		}
		return $size_unit_str;
	}
	/**
	 * 上传文件
	 * @param {array} $up_file_obj 文件的$_FILES上传对象
	 * @param {string} $save_dir 保存目录
	 * @param {bool} $not_in_root 是否在当前站点的根目录
	 * @return {string}
	 */
	public static function upload ($up_file_obj, $save_dir, $not_in_root=0) {
		if (preg_match('/\\.(exe|php|html?)$/', $up_file_obj['name'])) {
			if (is_file($up_file_obj['tmp_name'])) @unlink($up_file_obj['tmp_name']);
			return '';
		}
		else {
			if (!$not_in_root) {
				$save_dir = self::filter_root($save_dir, 1);
			}
			self::mkdir($save_dir, 1);
			if (0) { //按照文件名命名
				$name = str_replace(strrchr($up_file_obj['name'],'.'),'',$up_file_obj['name']);
			} else {
				$name = date('y_m_d_').str::rand();
			}
			$ext = self::ext_name($up_file_obj['name']);
			$filename = $save_dir.$name.'.'.$ext;
			if(is_file($filename)){
				$filename = $save_dir.$name.'_'.str::rand().'.'.$ext;
			}
			move_uploaded_file(str_replace('\\\\', '\\', $up_file_obj['tmp_name']), $filename);
			return is_file($filename) ? self::filter_root($filename) : '';
		}
	}
	
	//写文件
	public static function write ($filename, $contents, $not_in_root=0) {
		if (preg_match('#\\.php$#',$filename)) {
			return '';
		}
		else {
			if (!$not_in_root) {
				$filename = self::filter_root($filename, 1);
			}
			self::mkdir(dirname($filename), 1);
			$fp = fopen($filename, 'w');
			fwrite($fp, $contents);
			fclose($fp);
			return self::filter_root($filename);
		}
	}
	public static function write_php ($filename, $contents, $not_in_root=0) {
		if (!$not_in_root) {
			$filename = self::filter_root($filename, 1);
		}
		self::mkdir(dirname($filename), 1);
		$fp = fopen($filename, 'w');
		fwrite($fp, $contents);
		fclose($fp);
		return self::filter_root($filename);
	}
	/**
	 * 把文件路径转换成链接，需要绝对路径； 最好是 __FILE__
	 * @param {string} $path 一个系统路径 __FILE__
	 * @param {int} $num 移动的目录个数
	 * @return {string}
	 */
	public static function self_dir ($path, $file='') {
		$path = str_replace('\\', '/', dirname($path));
		$dir = rtrim(str_replace($base.'`$', '', $path.'`$'), '/');
		return str_replace(c('root'), '/', $dir.'/').$file;
	}
	/**
	 * 删除文件
	 * @param {string} $file 文件
	 * @param {int} $not_in_root 默认:0， 非本站点路径:1
	 * @return {string}
	 */
	public static function unlink ($file, $not_in_root=0) {
		if (!$not_in_root) {
			$file = self::filter_root($file, 1);
		}
		if (is_file($file)) @unlink($file);
	}
	/**
	 * 压缩 zip
	 * @param {string} $file 文件
	 * @param {int} $not_in_root 默认:0， 非本站点路径:1
	 * @return {string}
	 */
	public static function zip ($filepath, $not_in_root=0) {
		if (!$not_in_root) {
			$filepath = self::filter_root($filepath, 1);
		}
		$realpath = '';
		if (is_dir($filepath)) {
			function addFileToZip ($path, $zip, $cut_name) {
				$h = @dir($path); //打开当前文件夹由$path指定。
				$dirn = str_replace($cut_name, '', $path);
				while ($f = $h->read()) {
					if ($f != "." && $f != "..") {//文件夹文件名字为'.'和‘..'，不要对他们进行操作
						if (is_dir($path."/".$f)) {// 如果读取的某个对象是文件夹，则递归
							addFileToZip($path."/".$f, $zip, $cut_name);
						}
						else { //将文件加入zip对象
							$zip->addFile($path."/".$f, $dirn."/".$f);
						}
					}
				}
			}
			$name = ltrim(strrchr(rtrim($filepath, '/'), '/'), '/');
			// d('1', $name);
			if (!$name) {
				return '';
			}
			$realpath = $filepath.'/'.$name.'.zip';
			// d($realpath);
			// die;
			$zip = new ZipArchive();
			// if($zip->open($realpath, ZipArchive::OVERWRITE)===TRUE){
			if($zip->open($realpath, ZipArchive::CREATE)===TRUE){
				addFileToZip($filepath, $zip, $filepath); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
				$zip->close(); //关闭处理的zip文件
			}
			$realpath = is_file($realpath) ? self::filter_root($realpath) : '';
		}
		return $realpath;
	}
	public static function unzip ($filepath, $target_dir='', $not_in_root=0) {
		if (!$not_in_root) {
			$filepath = self::filter_root($filepath, 1);
			$target_dir && $target_dir = self::filter_root($target_dir, 1);
		}
		$realpath = '';
		$dir = $target_dir?:(dirname($filepath).'/'.basename($filepath,'.zip'));
		//是文件就解压
		if (is_file($filepath)) {
			$zip = new ZipArchive();
		    if ($zip->open($filepath)===true) {
		        $zip->extractTo($dir);
		        $zip->close();
		        return self::filter_root($dir);
		    }
		}
		return '';
	}
	public static function unzip_cn ($file, $target_dir='', $input_charset="GBK", $output_charset="utf-8", $not_in_root=0) {
		$filepath = $file;
		if (!$not_in_root) {
			$filepath = self::filter_root($filepath, 1);
			$target_dir && $target_dir = self::filter_root($target_dir, 1);
		}
		$realpath = '';
		$dir = $target_dir?:(dirname($filepath).'/'.basename($filepath,'.zip'));
		//是文件就解压
		if (is_file($filepath)) {
			$zip = new ZipArchive();
		    if ($zip->open($filepath)===true) {
				$fileNum = $zip->numFiles;
				for ($i = 0; $i < $fileNum; $i++) {
				    $statInfo = $zip->statIndex($i, ZipArchive::FL_ENC_RAW);
				    $name1 = $statInfo['name'];
			    	if (!preg_match("/^[\x{4E00}-\x{9FA5}]+$/u", $name1)) $name1 = iconv($input_charset, $output_charset, $name1);
				    $name2 = str_replace(array('%5C','%2F'), '/', urlencode($name1));
				    $zip->renameIndex($i, $name2);
				}
		        $zip->close();
		        return self::unzip($file);
		    }
		}
		return '';
	}
	public static function iconv_zip ($filepath, $input_charset="GBK", $output_charset="utf-8", $not_in_root=0) {
		if (!$not_in_root) {
			$filepath = self::filter_root($filepath, 1);
		}
		if (is_file($filepath)) {
			$zip = new \ZipArchive();
			$res = $zip->open($filepath);
			if ($res !== true){
			    return;
			}
			$fileNum = $zip->numFiles;
			for ($i = 0; $i < $fileNum; $i++) {
			    $statInfo = $zip->statIndex($i, ZipArchive::FL_ENC_RAW);
			    if (!preg_match("/^[\x{4E00}-\x{9FA5}]+$/u", $statInfo['name'])) {
			    	$name = iconv($input_charset, $output_charset, $statInfo['name']);
			    	$zip->renameIndex($i, $name);
			    }
			}
			$zip->close();
		}
	}

	//下载文件
	public static function download ($filepath, $save_name='', $not_in_root=0) {
		if (!$not_in_root) {
			$filepath = self::filter_root($filepath, 1);
		}
		!is_file($filepath) && exit();
		$save_name=='' && $save_name=basename($filepath);
		$file_size = filesize($filepath);
		$file_handle = fopen($filepath, 'r');
		header("Content-type: application/octet-stream; name=\"$save_name\"\n");
		header("Accept-Ranges: bytes\n");
		header("Content-Length: $file_size\n");
		header("Content-Disposition: attachment; filename=\"$save_name\"\n\n");
		while(!feof($file_handle)){
			echo fread($file_handle, 1024*100);
		}
		fclose($file_handle);
	}


	// 数据流文件的保存方式
	public static function base64 ($base64_data, $save_dir='', $not_in_root=0) {
		$save_dir || $save_dir = c('u_file_dir');
		$path='';
		if (preg_match('/^(data:\s*([a-zA-Z0-9]+)\/(\w+);base64,)/',$base64_data, $result)) {
			$type = $result[3];//后缀
			if($type && !preg_match('/(exe|php|html?)$/i', '.'.$type)){
				$path = self::write($save_dir.date('His').rand(10,99).'.'.$type, base64_decode(str_replace($result[1], '', $base64_data)), $not_in_root);
			}
		}
    	return $path;
    }
	/*
	 * 采集远程图片
	 * @param {string} $html 前端代码
	 * @param {string} $group 保存到jext_files的分组
	 * @return {string} 
	 */
	public static function get_remote_img ($html, $group='collection_files') {
		$html=stripslashes($html);
		$img_array=array();
		preg_match_all("/src=[\"|'| ]{0,}((https?:)?\/\/(.*)\.(gif|jpg|jpeg|png|bmp|webp))/isU", $html, $img_array);
		$img_array=array_unique($img_array[1]);
		@set_time_limit(600);
		foreach($img_array as $k => $v){
			if($save_name = self::save_remote_img($v,$group)){
				$html = str_replace($v, $save_name, $html);
			}
		}
		$html = addslashes($html);
		return $html;
	}
	public static function save_remote_img ($path,$group) {
		$ly = addslashes($path);
		$ext = strrchr($path, '.');
		if (!$ly || !preg_match('/^(https?:|\\/\\/)/', $path)) {
			return '';
		}
		if ($row = db::result("select * from jext_files where Ly='$ly'")) {
			return $row['Path'];
		}
		if (preg_match('/^\\/\\//', $path)) {
			$path = 'http:'.$path;
		}
		$save_name = '';
		$file_contents = curl::init($path);
		if ($file_contents[0]) {
			$save_name = self::write(c('collection_dir').date('/YmdHis').rand(10, 99).$ext, $file_contents[0]);
			db::insert('jext_files', array(
				'Name'	=>	$ly,
				'Type'	=>	1,
				'IsTmp'	=>	0,
				'GroupId'	=>	$group,
				'Path'	=>	$save_name,
				'Ly'	=>	$ly
			));
		}
		return $save_name;
	}

}