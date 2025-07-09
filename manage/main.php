<?php

// 防止胡乱进入
isset($c) || exit;

?><!DOCTYPE HTML>
<html>
<head>
	<?php
		include '__/inc/style_script.php';
		echo "<link href='/manage/__/css/frame.css' rel='stylesheet' type='text/css'  />";
		//echo "<script src='/manage/account/message/js.js' /></script>";
	?>
</head>
<body class="main_layout maxvh scrollbar flex-column" data-manage-type="<?=c('manage.layout.style')?>">

	<!-- 头部栏 开始 -->
	<div id="header" class="maxw flex-middle">
		<a class="logo m-pic --text-left relative" hr-ef='?u0=dashboard&u1=&u2=&m=account&a=index'>
			<?php /*/?><img src="<?=g('wb_site_config.logo-white')?:'/static/images/lianyayun.png'?>"><?php */?>
			<img src="/static/images/lianyayun.png">
		</a>
		<?php /*/?>
		<div class="language flex-middle2 mr_30px ml_30px">
			<span><?=language('{/panel.front_end_language/}')?>：</span>
			<span class="ly_btn" bg="light" size="mini">
				<span><?=language('{/language.'.c('lang').'/}')?></span>
				<i class="downicon lyicon-arrow-down-bold"></i>
			</span>
			<div class='ly_drop_inner'>
				<div>
					<?php
					$language = c('language');
					foreach ($language as $k => $v) {
					?>
						<a class='ly_drop_item' front-end-language="<?=$v?>"><?=language('{/language.'.$v.'/}')?></a>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php /*/?>
		<div class="version flex-middle2 ml_30px">版本号：<span></span></div>
		
		<?php 
		$language = c('manage.language');
		if (count($language)>1) { ?>
		<div class="language flex-middle2 mr_30px">
			<span><?=language('{/panel.manage_language/}')?>：</span>
			<span class="ly_btn" bg="light" size="mini">
				<span><?=language('{/language.'.c('manage.lang').'/}')?></span>
				<i class="downicon lyicon-arrow-down-bold"></i>
			</span>
			<div class='ly_drop_inner'>
				<div>
					<?php
					foreach ($language as $k => $v) {
					?>
						<a class='ly_drop_item' manage-language="<?=$v?>"><?=language('{/language.'.$v.'/}')?></a>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php } ?>
		
		<div class="flex-1"></div>

		<div class='info flex-middle2'>
			<div class='ly_btn_radius mr_30px pointer' size="mini" border="default" file-selector='manage' data-not-choice=""><?=language('menu.jext_files.module_name')?></div>
			<a class="mr_30px" color="main" href='/' target='_blank'><?=language('panel.website_home')?></a>
			<?php if (c('HostType')=='saas') { ?>
				<a class="mr_30px" href='https://www.lianyayun.com/help/' target='_blank'><?=language('panel.website_help')?></a>
			<?php } ?>
			<?php if (c('FnType.ai_assistant')) { ?>
				<a class="zml_click_to_ai mr_30px pointer"><?=language('panel.ai.assistant')?></a>
			<?php } ?>
			<!-- <a class="wcb_click_to_message mr_30px pointer"><?=language('panel.website_message')?></a> -->
			<div class='man flex-middle2 relative'>
				<i class="ic lyicon-yonghu"></i>
				<span class='na ml_5px mr_5px'><?=manage('UserName')?></span>
				<i class="xl lyicon-arrow-down-bold"></i>
				<div class='ly_drop_inner'>
					<div>
						<a class='ly_drop_item' lydbs-password="?ma=manage/index&d=post" data-id="<?=manage('Id')?>"><?=language('member.mod_password')?></a>
						<a class='ly_drop_item' manage-logout><?=language('member.logout')?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 头部栏 结束 -->

	<div class="flex-1 maxw flex" style="height:0;">
		<!-- 左侧栏 开始 -->
		<div id="lefter" class="notcopy">
			<?php
				// 链接权限
				$menu = p('manage.permit.url');
				foreach ((array)$menu as $k => $v) {
					if($k=='_'){
						continue;
					}
					$ico = c('manage.permit.ico.'.$k);
					$count = count($v);
					$na = language('menu.'.$k);
			?>
				<div class="item" u0="<?=$k?>">
					<div class="u0_name flex-max2" <?=$count>3?"":"hr-ef='{$v['_']}'"?>>
						<i class="svg relative <?=$na['module_iconfont']?>"></i>
						<div class="font flex-1"><?=$na['s_module_name']?></div>
						<?php if ($count>3) { ?><i class="u0_arw trans lyicon-arrow-right"></i><?php } ?>
					</div>
					<?php if ($count>3) { ?>
						<dl class="dl">
							<?php
								foreach ($v as $k1 => $v1) {
									if($k1==='_'){
										continue;
									}
								?>
								<dd class="dd" u1="<?=$k1?>">
									<div class="u1_name flex" hr-ef="<?=$v1['_']?>"><span><?=language('menu.'.$k.'.'.$k1.'.module_name')?></span></div>
								</dd>
							<?php } ?>
						</dl>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
		<!-- 左侧栏 结束 -->


		<!-- 右侧栏 开始 -->
		<div id='righter' class='maxw flex-1' data-manage-type="<?=c('manage.layout.style')?>">
			<iframe src="?<?=url::query_string('iframe')?>&_ifr_=1" width="100%" height="100%" name='main_iframe' frameborder="0"></iframe>
		</div>
		<!-- 右侧栏 结束 -->

	</div>

	<!-- 底部声明 开始 -->
	<div id='maxw footer'></div>
	<!-- 底部声明 结束 -->


</body>
</html>

<script>
var manage = new function () {
	var thi = this,
		righter = $('#righter'),
		lefter = $('#lefter');
	setTimeout(function(){$('#lefter, #lefter .box, #righter').addClass('trans')});
	// 链接整理
	this.href = function (href) {
		return (href||'').replace(/&?(_ifr_|_alt_|_popup_)=1/g,'').replace(/([&\?]?)ma=/g,'$1mg=').replace(/&$/g,'&').replace(/\\$/g,'');
	}
	// 切换链接
	this.src = function (href) {
		var href = this.href(href);
		if (href=='back()') {
			history.back();
			return;
		} else if (!href) {
			return;
		}
		thi.status(href);
		$('[name="main_iframe"]').attr({src: href+'&_ifr_=1'});
	}
	// 切换链接
	this.src2 = function (href, go) {
		var go = go||-1;
		history.go(go);
		setTimeout(()=>{
			this.src(href);
		},100);
	}
	// 拆分请求链接
	this.query_string = function (href) {
		var xxx = (href||"").replace(/^(.*)\?/,'').split('&'),
			ary = {};
		for (var i in xxx) {
			var v = xxx[i].split('=');
			ary[v[0]] = v[1];
		}
		return ary;
	}
	// 
	this.u0_u1_u2 = function (href) {
		var ary = thi.query_string(href);
		if (!ary.u) {
			var similar_href = lefter.find('[hr-ef*="&m='+ary.m+'"][hr-ef*="&a='+ary.a+'"]').last().attr('hr-ef');
			ary = thi.query_string(similar_href);
		}
		return (ary.u||'').split(/[,\.]/);
	}
	// 左侧栏与右侧栏的状态切换
	this.status = function (href) {
		var u0_u1_u2 = thi.u0_u1_u2(href);
		var u0 = lefter.find('[u0="'+u0_u1_u2[0]+'"]'),
			u1 = u0.find('[u1="'+u0_u1_u2[1]+'"]'),
			u2 = u1.find('[u2="'+u0_u1_u2[2]+'"]');
		lefter.find('[u0],[u1],[u2]').removeClass('cur');
		if (u0.size()) {
			u0.addClass('cur');
			u1.addClass('cur');
			u2.addClass('cur');
			if (u0.children('.dl').is(':hidden')) {
				u0.children('.u0_name').change();
				u1.children('.u1_name').change();
			}
		}
		return [u0, u1, u2];
	}
	// 点击展开2级菜单
	$(document).on('click change', '[u0] >.u0_name', function(event){
		var el = $(this);
		if ($('body').is('.is-loading-completed')) {
			el.parent().siblings().children('.u0_name').removeClass('slide_down').next().slideUp();
			el.toggleClass('slide_down').next().slideToggle();
		} else {
			el.parent().siblings().children('.u0_name').removeClass('slide_down').next().hide();
			el.toggleClass('slide_down').next().toggle();
		}
	});
	// hr-ef 监控
	var u0_u1_u2 = thi.status(location.href, 1);
};
$('[name="main_iframe"]').iframe('task', function(){
	var el = $(this);
	WP.history.replaceState(null, '', manage.href(this.contentWindow.location.href));
});
</script>