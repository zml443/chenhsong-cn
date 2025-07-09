<?php
include '../../../php/init.php';

class v_code{
	public static $cfg;

	public static function init(){
		self::$cfg = array(
			'width' 		=>	40,	//每个字所占的宽度
			'height'		=>	50,	//图片高度
			'noise_count'	=>	30,	//杂点数量
			'line_count'	=>	3,	//干扰线数量
			'ttf'			=>	dirname(__FILE__) . '/simfang.ttf',	//随机验证码使用的字体
			'length'		=>	4,	//随机验证码默认长度
			'charset'		=>	'en',	//随机验证码默认使用的字符集
			'char_table'	=>	array(
									'en'	=>	'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
									'num'	=>	'0123456789',
									'mix'	=>	'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'
								)
		);
	}
	
	public static function create_run($name, $length, $charset){
		$name=='' && exit();
		self::init();
		($length<1 || $length>6) && $length=self::$cfg['length'];
		isset(self::$cfg['char_table'][$charset]) || $charset=self::$cfg['charset'];
		
		$img_width=$length*self::$cfg['width'];	//图片宽度
		$img_height=self::$cfg['height'];	//图片高度
		
		$image=imagecreate($img_width+2, $img_height+2);
		imagecolorallocate($image, 0xff, 0xff, 0xff);		//设定背景颜色
		// imagerectangle($image, 0, 0, $img_width+1, $img_height+1, imagecolorallocate($image, 0xcc, 0xcc, 0xcc));   //加个边框
		
		for($i=0; $i<self::$cfg['noise_count']; $i++){	//加入杂点
			imagesetpixel($image, mt_rand(1, $img_width), mt_rand(1, $img_height), self::rand_color($image));
		}
		
		for($i=0; $i<self::$cfg['line_count']; $i++){	//加入干扰线
			imageline($image, mt_rand(1, $img_width), mt_rand(1, $img_height), mt_rand(1, $img_width), mt_rand(1, $img_height), self::rand_color($image));
		}
		
		$posX=self::$cfg['width']/2-10;	//posX，posY代表了首字符的基本点，即第一个字符的左下角
		$posY=self::$cfg['width']/2+10;
		
		// d($_SESSION);
		if (!$_SESSION['VCode']) $_SESSION['VCode']=array();
		if (count($_SESSION['VCode'])>20) {
			array_shift($_SESSION['VCode']);
		}
		$_SESSION['VCode'][$name]='';
		
		for($i=0; $i<$length; $i++){
			$code=substr(self::$cfg['char_table'][$charset], mt_rand(0, strlen(self::$cfg['char_table'][$charset])-1), 1);
			imagettftext($image, mt_rand(16, 22), mt_rand(-30, 30), $posX, $posY, self::rand_color($image), self::$cfg['ttf'], $code);
			$posX+=self::$cfg['width'];
			$_SESSION['VCode'][$name].=$code;
		}
		header('Content-type: image/png');
		imagepng($image);
		imagedestroy($image);
	}
	
	public static function rand_color($image){	
		$R=mt_rand(0, 200);
		$G=mt_rand(0, 200);
		$B=mt_rand(0, 200);
		//($R>200 && $G>200 && $B>200) && $R=$G=$B=0;
		return imagecolorallocate($image, $R, $G, $B);
	}
}
v_code::create_run($_GET['name'], (int)$_GET['length'], $_GET['charset']);
?>