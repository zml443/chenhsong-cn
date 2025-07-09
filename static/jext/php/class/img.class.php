<?php

class img {

	/**
	 * 缩略图管理
	 * @param {string} $source_img 原图路径
	 * @param {int} $width 缩略宽度
	 * @param {int} $height 缩略高度
	 * @param {int} $cut_type 缩略类型 3:高斯模糊 1:原图按照比例截取中间部分缩略  0:默认
	 * @param {bool} $is_watermark 自定义缩略图文件名
	 * @param {string} $RePath 自定义缩略图文件名
	 * @return {string}
	 */
	public static function cut ($source_img, $width=200, $height=200, $cut_type=0, $is_watermark=1, $new_path='') {
		$r = c('root');
		if (!is_file($r . $source_img) || !preg_match('/\.(gif|jpe?g|png|webp)$/i', $source_img)) return $source_img;
		$ext = strrchr($source_img, '.');
		if (!$new_path) {
			if ($is_watermark && g('watermark.config.open')) {
				$new_path = c('tmp_dir').'water/'.md5(g('watermark.config.img').g('watermark.config.position').$source_img).".{$width}x{$height}.{$cut_type}".$ext;
			} else {
				$new_path = c('tmp_dir').'thumbnail/'.md5($source_img).".{$width}x{$height}.{$cut_type}".$ext;
			}
		}
		if (!is_file($r.$new_path)) {
			file::mkdir($r.c('tmp_dir').'water/');
			file::mkdir($r.c('tmp_dir').'thumbnail/');
			if ($is_watermark && g('watermark.config.open') && (!$width || !$height)) {
				copy($r.$source_img, $r.$new_path);
			} else {
				img::resize($source_img, $width, $height, $cut_type, $new_path);
			}
			if ($is_watermark && g('watermark.config.open')) {
				self::add_watermark($new_path);
			}
		}
		if (is_file($r.$new_path)) {
			return $new_path;
		} else return $source_img;
	}
	// 生成 img 标签
	public static function tag ($source_img, $dest_width=200, $dest_height=200, $dest_type=0, $water=0, $attr='') {
		$path = img::cut($source_img, $dest_width, $dest_height, $dest_type, $water);
		return "<img src='{$path}' width='$dest_width' height='$dest_height' source-src='$source_img' $attr>";
	}

	// 批量处理内容图片水印
	public static function water_by_html ($html) {
		phpQuery::newDocumentHtml("<div id='water_by_html'>{$html}</div>");
		$html = pq('#water_by_html');
		foreach (pq($html)->find('img') as $img) {
			$src = pq($img)->attr('src');
			$src = self::cut($src,0,0,0,1);
			pq($img)->attr('src', $src);
		}
		return $html;
	}
	/**
	 * 压缩图片
	 * @param {string} $path 原图路径
	 * @param {int} $percent 压缩比例
	 * @return {string} 返回新的文件路径
	 */
	public static function rar ($path, $percent=1) {
		$r = c('root');
		if (!preg_match('/\.gif|\.jpe?g|\.png|\.webp$/', $path)) return $path;
		if (!is_file($r . $path)) return $path;
		$new_name = $path . '.compress' . strrchr($path,'.');
		if (is_file($r . $new_name)) return $new_name;
		$compress = new compress($r . $path, $percent);
		$compress->init($r . $new_name);
		return $new_name;
	}
	/**
	 * webp
	 * @param {string} $path 原图路径
	 * @param {int} $yt 覆盖原图
	 * @return {string} 返回新的文件路径
	 */
	public static function webp ($path, $yt=0) {
		$r = c('root');
		if (!function_exists('imagewebp') || !preg_match('/\.gif|\.jpe?g|\.png|\.webp$/', $path)) return $path;
		if (!is_file($r . $path)) return $path;
		$new_name = $path . '.l.webp';
		if (is_file($r . $new_name)) return $new_name;
		$ext=getimagesize($r.$path);
		file::mkdir($root.dirname($dest_img));
		if(preg_match('/jpe?g/i',$ext['mime'])){
			$im=imagecreatefromjpeg($r.$path);
		}elseif(preg_match('/png/i',$ext['mime'])){
			$im=imagecreatefrompng($r.$path);
		}elseif(preg_match('/gif/i',$ext['mime'])){
			$im=imagecreatefromgif($r.$path);
		}else{
			$im=imagecreatefromwebp($r.$path);
		}
		imagewebp($im, $r.$new_name);
		imagedestroy($im);
		if ($yt) {
			$s0 = filesize($r.$new_name);
			$s1 = filesize($r.$path);
			if ($s1<$s0) {
				rename($r.$path, $r.$new_name);
			}
			else file::unlink($path);
		}
		return $new_name;
	}


	// 获取图片链接
	public static function get ($img, $key=0) {
		return self::ary($img, $key);
	}
	public static function ary ($img, $key=0) {
		if(!$img) return '';
		if(!is_array($img)){
			if (preg_match('/^[^\\{\\[]/', $img)) {
				return $img;
			}
			$arr=str::json($img, 'decode');
			$arr||$arr=str::json(htmlspecialchars_decode($img),'decode');
			$img=$arr;
		}
		if(is_array($img[$key])){
			return $img[$key]['path'];
		}else{
			return $img[$key];
		}
	}

	// 读取 svg 文件
	public static function svg ($img, $class='') {
		if (!preg_match('/\\.svg$/',$img)) return '';
		is_file($img) || $img = c('root').$img;
		return is_file($img) ? preg_replace('/<svg/', '<svg class="'.$class.'"', file_get_contents($img)) : '';
	}
	/**
	 * 源图片必须相对于网站根目录
	 * @param {string} $source_img 原图路径
	 * @param {int} $dest_width 缩略宽度
	 * @param {int} $dest_height 缩略高度
	 * @param {int} $dest_type 缩略类型 3:高斯模糊 1:原图按照比例截取中间部分缩略  0:默认
	 * @param {string} $dest_img 自定义缩略图文件名
	 * @return {string}
	 */
	public static function resize($source_img, $dest_width=200, $dest_height=150, $dest_type=0, $dest_img=''){
		ini_set('memory_limit', '2000M');
		ini_set('gd.jpeg_ignore_warning', true);
		$root = c('root');
		if(!is_file($root.$source_img)){
			return $source_img;
		}
		$ext_name=file::ext_name($source_img);
		$ext=getimagesize($root.$source_img);
		$dest_img=='' && $dest_img=$source_img.".{$dest_width}x{$dest_height}.{$ext_name}";
		file::mkdir($root.dirname($dest_img));
		if(preg_match('/jpe?g/i',$ext['mime'])){
			$im=imagecreatefromjpeg($root.$source_img);
		}elseif(preg_match('/png/i',$ext['mime'])){
			$im=imagecreatefrompng($root.$source_img);
		}elseif(preg_match('/gif/i',$ext['mime'])){
			$im=imagecreatefromgif($root.$source_img);
		}else{
			copy($root.$source_img, $root.$dest_img);
			chmod($root.$dest_img, 0777);
			return $dest_img;
		}
		$source_width=imagesx($im);	//源图片宽
		$source_height=imagesy($im);	//源图片高
		if($source_width<=$dest_width && $source_height<=$dest_height){
			copy($root.$source_img, $root.$dest_img);
			chmod($root.$dest_img, 0777);
			return $dest_img;
		}
		/*if($dest_type==3){
			self::blur($im, 3);
			$dest_type=1;
		}*/
		if($dest_width>=$source_width&&$dest_type==1){
			$dest_height=($source_width-1)/$dest_width*$dest_height;
			$dest_width=($source_width-1);
		}
		if($dest_height>=$source_height&&$dest_type==1){
			$dest_width=($source_height-1)/$dest_height*$dest_width;
			$dest_height=($source_height-1);
		}
		if($source_width>$dest_width || $source_height>$dest_height){
			// 类型处理 开始
			$source_x=0;
			$source_y=0;
			// =======================
			// 原图按照比例截取中间部分缩略
			if($dest_type==1){
				if($dest_height/$dest_width>$source_height/$source_width){
					$log_width=$source_width;
					$source_width=$source_height/$dest_height*$dest_width;
					if($log_width>$source_width) $source_x=($log_width-$source_width)/2;
				}else{
					$log_height=$source_height;
					$source_height=$source_width/$dest_width*$dest_height;
					if($log_height>$source_height) $source_y=($log_height-$source_height)/2;
				}
			}
			// =======================
			if($source_width>$dest_width){
				$width_ratio=$dest_width/$source_width;
				$resize_width=true;
			}
			if($source_height>$dest_height){
				$height_ratio=$dest_height/$source_height;
				$resize_height=true;
			}
			if($resize_width && $resize_height){
				$ratio=min($width_ratio, $height_ratio);
			}elseif($resize_width){
				$ratio=$width_ratio;
			}elseif($resize_height){
				$ratio=$height_ratio;
			}else{
				$ratio=1;
			}
			$new_width=ceil($source_width*$ratio);	//优先保持所定义的宽度
			$new_height=floor($source_height*$ratio);
			// 类型处理 结束 

			$new_im=imagecreatetruecolor($new_width, $new_height);
			if(preg_match('/(gif|png)/i',$ext['mime'])){
				imagealphablending($new_im, false);
				imagesavealpha($new_im, true);
			}
			imagecopyresampled($new_im, $im, 0, 0, $source_x, $source_y, $new_width, $new_height, $source_width, $source_height);
			if(preg_match('/jpe?g/i',$ext['mime'])){
				imagejpeg($new_im, $root.$dest_img, 100);
			}elseif(preg_match('/webp/i',$ext['mime'])){
				imagewebp($new_im, $root.$dest_img);
			}elseif(preg_match('/png/i',$ext['mime'])){
				imagepng($new_im, $root.$dest_img);
			}else{
				$bgcolor=imagecolorallocate($new_im, 0, 0, 0);
				$bgcolor=imagecolortransparent($new_im, $bgcolor);
				$bgcolor=imagecolorallocatealpha($new_im, 0, 0, 0, 127);
				imagefill($new_im, 0, 0, $bgcolor);
				imagegif($new_im, $root.$dest_img);
			}
			imagedestroy($new_im);
		}else{
			copy($root.$source_img, $root.$dest_img);
		}
		imagedestroy($im);
		chmod($root.$dest_img, 0777);
		return $dest_img;	//返回调整后的文件名
	}
	
	public static function add_watermark($source_img){	//图片添加水印
		ini_set('gd.jpeg_ignore_warning', true);
		$root = c('root');
		$watermark=array(
			'allowed_width'		=>	240,	//源图片宽度小于此值不添加水印直接返回
			'allowed_height'	=>	240,	//源图片高度小于此值不添加水印直接返回
			'padding_border'	=>	40,		//水印离图片边缘的像素数
			'img'				=>	self::ary(g('watermark.config.img')),//img::cut(self::ary(g('watermark.config.img')), 150, 150),	//图片水印路径
			'img_alpha'			=>	1,	//图片水印透明度（PNG水印时此参数无效）
			'position'			=>	g('watermark.config.position'),	//水印的位置印
		);
		($watermark['position']<1 || $watermark['position']>9) && $watermark['position']=0;
		
		if(!is_file($root.$source_img)){	//源文件不存在则直接返回
			return $source_img;	//返回源文件路径
		}
		$ext_name=file::ext_name($source_img);
		
		if($ext_name=='jpg' || $ext_name=='jpeg'){
			$source_im=imagecreatefromjpeg($root.$source_img);
		}elseif($ext_name=='png'){
			$source_im=imagecreatefrompng($root.$source_img);
		}elseif($ext_name=='gif'){
			$source_im=imagecreatefromgif($root.$source_img);
		}else{
			return $source_img;	//返回源文件路径
		}
		
		$source_width=imagesx($source_im);	//源图片宽
		$source_height=imagesy($source_im);	//源图片高
		
		if($source_width<$watermark['allowed_width'] || $source_height<$watermark['allowed_height']){
			return $source_img;	//返回源文件路径
		}
		
		$watermark_img_ext_name=file::ext_name($watermark['img']);
		
		if($watermark_img_ext_name=='jpg' || $watermark_img_ext_name=='jpeg'){
			$watermark_im=imagecreatefromjpeg(is_file($root.$watermark['img'])?$root.$watermark['img']:$watermark['img']);
		}elseif($watermark_img_ext_name=='png'){
			$watermark_im=imagecreatefrompng(is_file($root.$watermark['img'])?$root.$watermark['img']:$watermark['img']);
		}elseif($watermark_img_ext_name=='gif'){
			$watermark_im=imagecreatefromgif(is_file($root.$watermark['img'])?$root.$watermark['img']:$watermark['img']);
		}else{
			return $source_img;	//返回源文件路径
		}
		
		$watermark_width=imagesx($watermark_im);	//水印图片宽
		$watermark_height=imagesy($watermark_im);	//水印图片高
		
		switch($watermark['position']){	//水印位置
			case 1:	//1为顶端居左
				$posX=$watermark['padding_border'];
				$posY=$watermark['padding_border'];
				break;
			case 2:	//2为顶端居中
				$posX=($source_width-$watermark_width)/2;
				$posY=$watermark['padding_border'];
				break;
			case 3:	//3为顶端居右
				$posX=$source_width-$watermark_width-$watermark['padding_border'];
				$posY=$watermark['padding_border'];
				break;
			case 4:	//4为中部居左
				$posX=$watermark['padding_border'];
				$posY=($source_height-$watermark_height)/2;
				break;
			case 5:	//5为中部居中
				$posX=($source_width-$watermark_width)/2;
				$posY=($source_height-$watermark_height)/2;
				break;
			case 6:	//6为中部居右
				$posX=$source_width-$watermark_width-$watermark['padding_border'];
				$posY=($source_height-$watermark_height)/2;
				break;
			case 7:	//7为底端居左
				$posX=$watermark['padding_border'];
				$posY=$source_height-$watermark_height-$watermark['padding_border'];
				break;
			case 8:	//8为底端居中
				$posX=($source_width-$watermark_width)/2;
				$posY=$source_height-$watermark_height-$watermark['padding_border'];
				break;
			case 9:	//9为底端居右
				$posX=$source_width-$watermark_width-$watermark['padding_border'];
				$posY=$source_height-$watermark_height-$watermark['padding_border'];
				break;
			default:	//随机
				$posX=mt_rand($watermark['padding_border'], $source_width-$watermark_width-$watermark['padding_border']);
				$posY=mt_rand($watermark['padding_border'], $source_height-$watermark_height-$watermark['padding_border']);
		}
		
		/*if($ext_name=='png' || $ext_name=='gif'){
			@imagealphablending($source_im, false);
			@imagesavealpha($source_im, true);
		}*/
		
		if($watermark_img_ext_name=='png'){
			imagecopyresampled($source_im, $watermark_im, $posX, $posY, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
		}else{
			imagecopymerge($source_im, $watermark_im, $posX, $posY, 0, 0, $watermark_width, $watermark_height, $watermark['img_alpha']);	//拷贝水印到目标文件
		}
		imagedestroy($watermark_im);
		
		if($ext_name=='jpg' || $ext_name=='jpeg'){
			imagejpeg($source_im, $root.$source_img, 100);
		}elseif($ext_name=='png'){
			imagepng($source_im, $root.$source_img);
		}else{
			imagegif($source_im, $root.$source_img);
		}
		
		imagedestroy($source_im);
		
		return $source_img;	//返回源文件路径
	}

	// 让图片模糊
	public static function blur($gdImageResource, $blurFactor = 3){
		$blurFactor = round($blurFactor);
		$originalWidth = imagesx($gdImageResource);
		$originalHeight = imagesy($gdImageResource);
		$smallestWidth = ceil($originalWidth * pow(0.5, $blurFactor));
		$smallestHeight = ceil($originalHeight * pow(0.5, $blurFactor));
		$prevImage = $gdImageResource;
		$prevWidth = $originalWidth;
		$prevHeight = $originalHeight;
		for($i = 0; $i < $blurFactor; $i += 1){
			$nextWidth = $smallestWidth * pow(2, $i);
			$nextHeight = $smallestHeight * pow(2, $i);
			$nextImage = imagecreatetruecolor($nextWidth, $nextHeight);
			imagecopyresized($nextImage, $prevImage, 0, 0, 0, 0, $nextWidth, $nextHeight, $prevWidth, $prevHeight);
			imagefilter($nextImage, IMG_FILTER_GAUSSIAN_BLUR);
			$prevImage = $nextImage;
			$prevWidth = $nextWidth;
			$prevHeight = $nextHeight;
		}
		imagecopyresized($gdImageResource, $nextImage, 0, 0, 0, 0, $originalWidth, $originalHeight, $nextWidth, $nextHeight);
		imagefilter($gdImageResource, IMG_FILTER_GAUSSIAN_BLUR);
		imagedestroy($prevImage);
		return $gdImageResource;
	}
}