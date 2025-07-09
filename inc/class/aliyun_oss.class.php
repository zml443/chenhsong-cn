<?php
use OSS\OssClient;
use OSS\Core\OssException;
class aliyun_oss{
	
	
	public static function upload_file($file_path, $ossdir){
		include_once(c('root').'/inc/class/aliyun/aliyun-php-sdk-core/Config.php');
		$ossdir=preg_replace('#/+#', '/', trim($ossdir, '/'));
		$ary=array();
		$oss=new OssClient(c('aliyun_oss.id'), c('aliyun_oss.key'), c('aliyun_oss.endpoint'));
		if(!$oss->doesObjectExist(c('aliyun_oss.bucket'), $ossdir.'/')){
			$oss->createObjectDir(c('aliyun_oss.bucket'), $ossdir);
		}
		$path = $ossdir.'/'.basename($file_path);
		if (is_file($file_path) && !$oss->doesObjectExist(c('aliyun_oss.bucket'), $path)) {
			$oss->uploadFile(c('aliyun_oss.bucket'), $path, $file_path);
			$oss->putObjectAcl(c('aliyun_oss.bucket'), $path, 'public-read');
			file::unlink($file_path);
			$path=$oss->signUrl(c('aliyun_oss.bucket'), $path);
			$new_file_path = str_replace(strrchr($path, '?'), '', $path);
		} else {
			$new_file_path = $file_path;
		}
		return $new_file_path;
	}
	
	public static function delete_file($OssObject){
		if(!$OssObject){return false;}
		$OssObject = ltrim(preg_replace('#^(.*)aliyuncs\\.com/#', '', $OssObject),'/');
		include_once(c('root').'/inc/class/aliyun/aliyun-php-sdk-core/Config.php');
		$oss=new OssClient(c('aliyun_oss.id'), c('aliyun_oss.key'), c('aliyun_oss.endpoint'));
		if($oss->doesObjectExist(c('aliyun_oss.bucket'), $OssObject)){
			$oss->deleteObject(c('aliyun_oss.bucket'), $OssObject);
		}
		return true;
	}
	
	public static function sign_url($osspath){
		include_once(c('root').'/inc/class/aliyun/aliyun-php-sdk-core/Config.php');
		$oss=new OssClient(c('aliyun_oss.id'), c('aliyun_oss.key'), c('aliyun_oss.endpoint'));
		$path=$oss->signUrl(c('aliyun_oss.bucket'), $osspath, 3600);
		return $path;
	}
	
	/*
	@param array $options
	其中options中的参数如下
	$options = array(
          'max-keys'  => max-keys用于限定此次返回object的最大数，如果不设定，默认为100，max-keys取值不能大于1000。
          'prefix'    => 限定返回的object key必须以prefix作为前缀。注意使用prefix查询时，返回的key中仍会包含prefix。
          'delimiter' => 是一个用于对Object名字进行分组的字符。所有名字包含指定的前缀且第一次出现delimiter字符之间的object作为一组元素
          'marker'    => 用户设定结果从marker之后按字母排序的第一个开始返回。
    )
	*/
	//获取oss文件对象列表
	public static function get_list($options=array()){	
		include_once(c('root').'/inc/class/aliyun/aliyun-php-sdk-core/Config.php');
		$ary=array();
		$oss=new OssClient(c('aliyun_oss.id'), c('aliyun_oss.key'), c('aliyun_oss.endpoint'));
		$objectinfo=$oss->listObjects(c('aliyun_oss.bucket'), $options);
		$list=$objectinfo->getObjectList();
		foreach($list as $v){
			$ary[]=$v->getKey();
		}
		return $ary;
	}
	
	//获取oss文件夹对象列表
	public static function list_prefix($options=array()){	
		include_once(c('root').'/inc/class/aliyun/aliyun-php-sdk-core/Config.php');
		$ary=array();
		$oss=new OssClient(c('aliyun_oss.id'), c('aliyun_oss.key'), c('aliyun_oss.endpoint'));
		$objectinfo=$oss->listObjects(c('aliyun_oss.bucket'), $options);
		$prefix_list=$objectinfo->getPrefixList();
		foreach($prefix_list as $v){
			$ary[]=$v->getPrefix();
		}
		return $ary;
	}

	// 获取oss文件内容
	public static function file_contents($object){
		include_once(c('root').'/inc/class/aliyun/aliyun-php-sdk-core/Config.php');
		$object = ltrim(preg_replace('#^(.*)aliyuncs\\.com/#', '', $object),'/');
		$oss=new OssClient(c('aliyun_oss.id'), c('aliyun_oss.key'), c('aliyun_oss.endpoint'));
		return $oss->getObject(c('aliyun_oss.bucket'), $object);
	}
}
?>