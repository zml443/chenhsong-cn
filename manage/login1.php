<?php

// 防止胡乱进入
isset($c) || exit;


if ($_GET['manage_token']) {
	$token = jwt::verifyToken($_GET['manage_token'], c('LYYApiKey'));
	if ($token) {
		$userinfo = db::get_one('wb_manage', "UserName='{$token['sub']}'");
		if ($userinfo) {
			$userinfo['LastLoginTime'] = c('time');
			$userinfo['LastLoginIp'] = ip::get();
			manage('', $userinfo);
			db::update('wb_manage', "UserName='{$p_UserName}'", array(
					'LastLoginTime'	=>	$userinfo['LastLoginTime'],
					'LastLoginIp'	=>	$userinfo['LastLoginIp'],
					'data_number_login' => $userinfo['data_number_login']+1
				)
			);
			log::manage('wb_manage', "管理员登录【{$p_UserName}】");
			js::location('/manage/');
		}
	}
}

if ($_POST) {
	extract($_POST, EXTR_PREFIX_ALL, 'p');
	// 验证码
	/*if (strtolower($p_Excode)!=strtolower($_SESSION['VCode']['manage']) || !$_SESSION['VCode']['manage']) {
		str::msg('验证码错误', 0);
	}
	unset($_SESSION['VCode']['manage']);*/
	$userinfo = db::get_one('wb_manage', "UserName='{$p_UserName}'");
	// 账号被锁定
	if ($userinfo['IsLoginLock']) {
		if (c('IsLYYMember')) {
			js::location(c('LYYwebsite.login'));
		} else {
			str::msg('账号被锁定', 0);
		}
	} else if ($userinfo['Password'] == str::password($p_Password)) {
		$userinfo['LastLoginTime'] = c('time');
		$userinfo['LastLoginIp'] = ip::get();
		manage('', $userinfo);
		db::update('wb_manage', "UserName='{$p_UserName}'", array(
				'LastLoginTime'	=>	$userinfo['LastLoginTime'],
				'LastLoginIp'	=>	$userinfo['LastLoginIp'],
				'data_number_login' => $userinfo['data_number_login']+1
			)
		);
		log::manage('wb_manage', "管理员登录【{$p_UserName}】");
		if (c('IsLYYMember')) {
			js::location('/manage/');
		} else {
			str::msg('', 1);
		}
	} else {
		if (!c('IsLYYMember')) {
			str::msg('账号密码错误', 0);
		}
	}
}

manage('Id') && js::location('/manage/');

if (c('IsLYYMember')) {
	js::location(c('LYYwebsite.login'));
}



?><!DOCTYPE HTML>
<html>
<head>
<?php
	include '__/inc/style_script.php';
	echo ly200::load_static('/manage/__/css/login.css');
?>
</head>
<style>
	body,html{height:100%;}
	.No000_wrap {width: 100vw;height: 100vh;}
	/* 轮播 */
	#No000_loop {width: calc(100vw - 640px);height: 100%;background: linear-gradient(135deg, #c591fc 0%, #974fe2 10%, #6b2cdd 25%, #3e4cff 50%, #6b52ff 70%, #5484ff 90%, #8572ff 100%);}
	#No000_loop .head {top: 60px;left: 60px;z-index: 5;}
	#No000_loop .head .logo {max-height: 50px;}
	#No000_loop .head .return {font-size: 16px;line-height: 1;color: #b5aeef;margin-left: 30px;width: 120px;height: 40px;border-radius: 20px;border: 1px solid rgba(255,255,255,0.2);}
	#No000_loop .head .return:hover {border-color: #fff;color: #fff;}
	#No000_loop .box {padding: 100px 60px 0;}
	#No000_loop .box .content {max-height: calc(100vh - 100px);}
	#No000_loop .box .title {font-size: 66px;line-height: 90px;color: #fff;margin-bottom: 12px;}
	#No000_loop .box .subtitle {font-size: 46px;line-height: 58px;color: #fff;margin-bottom: 30px;}
	#No000_loop .box .img {height: 71.42%;}
	#No000_loop .swiper-pagination {bottom: 40px;left: 60px;display: flex;width: auto;}
	#No000_loop .swiper-pagination .swiper-pagination-bullet {width: 8px;height: 8px;border-radius: 50%;background: #fff;margin: 0 5px;}
	#No000_loop .swiper-pagination .swiper-pagination-bullet-active {width: 26px;height: 8px;border-radius: 4px;}


	/* 登录 */
	#No000 {width: 640px;height: 100%;padding: 160px 0 50px;}
	#No000 .name {font-size: 30px;line-height: 1;color: #333;margin-bottom: 45px;}
	#No000 .input {font-size: 16px;line-height: 60px;color: #333;width: 380px;height: 60px;border-radius: 30px;background-color: #f6f6f6;padding: 0 30px;margin-bottom: 40px;}
	#No000 .submit {font-size: 16px;line-height: 1;color: #fff;width: 380px;height: 60px;border-radius: 30px;background-color: #2878ff;margin-bottom: 30px;}
	#No000 .register {font-size: 16px;line-height: 20px;color: #666;margin-bottom: 30px;}
	#No000 .register:hover {color: #ff0000;}
	#No000 .contact {font-size: 16px;line-height: 1;color: #666;width: 160px;height: 50px;border-radius: 25px;border: 1px solid #e4e4e4;margin-bottom:30px;}
	#No000 .contact .icon {font-size: 24px;color: #888;margin-right: 10px;}
	#No000 .contact:hover {color: #fff;background-color: #2878ff;border-color: #2878ff;}
	#No000 .contact:hover .icon {color: #fff;}
	#No000 .contact .QR {display: none;bottom: calc(100% + 30px);}
	#No000 .contact.cur .QR {display: block;}
	#No000 .contact .QR .qr_box {width: 260px;border-radius: 20px;padding: 30px;background-color: #fff;box-shadow: 0 0 10px rgba(0,0,0,0.2);z-index: 2;}
	#No000 .contact .QR .qr_box::after {content: '';position: absolute;bottom: -30px;left: 50%;transform: translateX(-50%);border-width: 15px;border-style: solid;border-color: rgba(0,0,0,0.2) transparent transparent transparent;z-index: 1;filter: blur(10px);}
	#No000 .contact .QR .qr_box::before {content: '';position: absolute;bottom: -30px;left: 50%;transform: translateX(-50%);border-width: 20px;border-style: solid;border-color: #fff transparent transparent transparent;z-index: 3;}
	#No000 .contact .QR .img {width: 100%;}
	#No000 .contact .QR .img::before {padding-top: 100%;}
	#No000 .contact .QR .text {font-size: 16px;line-height: 1;color: #888;margin-top: 15px;}
	#No000 .copy {font-size: 16px;line-height: 20px;color: #999;}

	@media screen and (max-height:750px) {
		#No000_loop .box .title {font-size: 42px;line-height: 60px;margin: 10px 0;}
		#No000_loop .box .subtitle {font-size: 30px;line-height: 42px;margin-bottom: 20px;}
		#No000_loop .box .img {height: calc(100vh - 240px);}
		#No000_loop .swiper-pagination {bottom: 20px;left: 60px;}

		#No000 {padding: 60px 0;}
		#No000 .name {margin-bottom: 30px;}
		#No000 .input {line-height: 50px;height: 50px;border-radius: 25px;padding: 0 20px;margin-bottom: 30px;}
		#No000 .submit {height: 50px;border-radius: 25px;}
		#No000 .contact {width: 140px;height: 40px;border-radius: 20px;}
	}
	@media screen and (max-width:1280px) {
		#No000_loop,
		#No000 {width: 50vw;}
	}
</style>
<body>

<div class="No000_wrap flex">
	<!-- 轮播 -->
	<section id="No000_loop" class='container relative' loop="">
		<div class="head flex-middle2 absolute">
			<div class="logo"><img src="/static/images/logo-white.png" alt=""></div>
			<a href="" class="return flex-max2 trans">返回主页</a>
		</div>
		<div class='wrapper'>
			<?php for($i=0;$i<3;$i++) {?>
				<div class='box slide flex-middle2'>
					<div class="content flex-column flex-top2">
						<div class="title">风格无限，自由切换</div>
						<div class="subtitle">一次建站，终身无忧</div>
						<div class="img m-pic">
							<img src="/static/images/login_bg_02.png" alt="">
						</div>
					</div>
				</div>
			<?php }?>
		</div>
	</section>
	<!-- end -->
	<!-- 注册 -->
	<section id="No000" class="flex-between flex-middle2 flex-column">
		<div class="name">联雅云 • 智能后台管理系统</div>
		<!-- 账号&密码 -->
		<div class="flex-max2 flex-column">
			<label class="input">
				<input type="text" name="username" placeholder="账号" value="" autocomplete="off">
			</label>
			<label class="input">
				<input type="text" name="password" placeholder="密码" value="" autocomplete="off">
			</label>
			<!-- 提交 -->
			<label class="submit flex-max2 pointer">
				<input class="pointer" type="submit" value="登录">
			</label>
			<a href="" class="register">还没有账号？点击注册</a>
		</div>
		<div class="flex-middle2 flex-column">
			<a class="contact flex-max2 relative trans">
				<div class="QR absolute">
					<div class="qr_box relative">
						<div class="img i-pic relative">
							<img class="absolute" src="/static/images/ke_fu2.jpg" alt="">
						</div>
						<div class="text text-center">售后--小雅</div>
					</div>
				</div>
				<div class="icon lyicon-customer-service"></div>
				<div>联系客服</div>
			</a>
			<div class="copy">
				Copyright © 2007-2023 深圳联雅网络科技有限公司
			</div>
		</div>
	</section>
	<!-- end -->
</div>

</body>
</html>
<script>
	$(document).on('click','#No000 .contact', function(){
		var el = $(this);
		if(el.hasClass('cur')){
			el.removeClass('cur');
		}else{
			el.addClass('cur');
		}
	})
</script>