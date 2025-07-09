<?php

// 防止胡乱进入
isset($c) || exit;



manage('Id') && js::location('/manage/');




?><!DOCTYPE HTML>
<html>
<head>
<?php
	include '__/inc/style_script.php';
	echo ly200::load_static('/manage/__/css/login.css');
?>
</head>
<style>
	body,html{height:100%; background:url(/static/images/login/login_bg.jpg) no-repeat center 0; background-size:cover;}
</style>
<body>


	<div id="login">
		<div class="login_title_en">LY NETWORK</div>
		<div class="login_title_cn">联雅网络 • 后台管理系统</div>
		<div class="login_form_div">
			<form name="login_form">
				<div class="item_rows">
					<input type="text" name="UserName" class="username" value="" tabindex="1" autocomplete="off" placeholder="账号">
				</div>
				<div class="item_rows">
					<input type="password" name="Password" class="password" value="" tabindex="2" autocomplete="off" placeholder="密码">
				</div>
				<div class="item_rows">
					<input type="text" name="Excode" class="excode fl" maxlength="4" value="" tabindex="3" autocomplete="off" placeholder="验证码">
					<div class="code fr">
						<a href="javascript:void(0);" class="imgs"  code-word='manage'></a>&nbsp;&nbsp;
						<a href="javascript:void(0);" class="blue">看不清验证码？刷新</a>&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					<div class="clear"></div>
				</div>
				<div class="icon_rows">
					<input type="image" class="fl" src="/static/images/login/new_login.png">
					<!-- <input type="hidden" name="do_action" value="account.login"> -->
				</div>
			</form>
		</div>
	</div>

	<?php $week=array("日","一","二","三","四","五","六");?>
	<div id="login-info" style="left: 7%; bottom: 6%; display: block;">
		<div class="time" id="timeElem"><?=date('H:i')?></div>
		<div class="date"><?=date('m月d日')?> / 星期<?=$week[date('w')]?></div>
		<div class="con">被溶解的华丽，都沉淀在繁华和现实的阴影里。</div>
	</div>

	<div id="login-copyright">©2018 深圳联雅网络科技有限公司 技术支持：联雅网络</div>

	<script type="text/javascript">
		if (window!=WP) {
			window.top.location.href = '/manage/';
		}
		$('form').submit(function(){
			var load=$.alert('loading...');
			$.async('POST', '/manage/', $(this).serialize(), function(result){
				if (result.ret==1) {
					setTimeout(function () {
						// window.top.location.href = '/manage/';
						location.reload();
					}, 600);
				}
				else {
					load.popup_remove(function () {
						WP.$.alert(result.msg, 3000);
					});
					$('.code .imgs img').trigger('click');
				};
			}, 'json');
			return false;
		});
	</script>


</body>
</html>