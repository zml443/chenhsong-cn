<?php
// 
function_exists('c')||exit();

////////////////////////////////////////////////////////////////////
ob_start();
$_side_fload_file = c('root').'themes/__/side_fload/'.g('wb_service.type').'.php';
if (!$config['is_only_content'] && is_file($_side_fload_file) && !$_GET['_inline_view_']) include $_side_fload_file;
if ($_SESSION['website_preview_model'] && !$_GET['_inline_view_']) include c('root').'themes/__/website_preview_model.php';
$__side_fload = ob_get_contents();
ob_clean();

// 移动端底部栏客服
ob_start();
include c('root').'themes/__/service_mobile/01.php';
$html['service_mobile'] = ob_get_contents();
ob_clean();

$language_pack = c('language_pack.manage').c('lang').'/0.php';
$language_pack_cn = c('language_pack.manage').'cn/0.php';
$language_array = is_file($language_pack) ? include $language_pack : include $language_pack_cn;


return '<!DOCTYPE HTML><html class="scrollbar" lang="'.(in_array(c('lang'),array('cn','tc')) ? 'zh-cn' : c('lang')).'">
	<head>
		'.(saas::$page_url?'<link rel="canonical" href="'.url::domain('', 1).saas::$page_url.'" />':'').'
		<meta loading="2">
		<meta charset="utf-8" website-language="'.implode(',',c('language')).'" language='.c('lang').'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="renderer" content="webkit" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta content="telephone=no" name="format-detection" />
		<meta name="screen-orientation" content="portrait">
		<meta name="x5-orientation" content="portrait">
		<link rel="shortcut icon" href="'.g('wb_site_config.ico').'" />
		<link rel="stylesheet" href="/static/jext/css/global.css" />
		<link rel="stylesheet" href="/static/jext/css/lyicon/iconfont.css" />
		<link rel="stylesheet" href="/static/jext/css/thicon/iconfont.css" />
		<link rel="stylesheet" href="/static/jext/css/animated.min.css" />
		<link rel="stylesheet" href="/static/jext/css/lycss.min.css" />
		<script src="/static/jext/a.js"></script>
		<script src="/static/jext/b.js"></script>
		<script>
			$.language.cur = \''.c('lang').'\';
			$.language.all = '.str::json(c('language')).';
			$.global = '.str::json(array(
				'HostTag' => c('HostTag'),
				'AppOpen' => array(),
			)).';
			$.lang = '.str::json($language_array).';
		</script>
		<script src="/static/jext/org/viewport.js"></script>
		<!-- <script src="/static/jext/luxy.js"></script> -->
		'.implode(' ', self::$header_include).'
		<link rel="stylesheet" href="/themes/default/css/style.css" />
		<script src="/themes/default/js/web.js"></script>
		<link rel="stylesheet" href="/static/css/page/rectangle.css" />
		'.ly200::seo(self::$seo).'
	</head>
	<style class="main_style">
		:root{
			--mainColor:'.(g('website.mainColor')?:'#739962').';
			--bgColor:'.(g('website.bgColor')?:'#f6f7f9').';
		}
		html{font-size:100px;}
		.lyui_paging{font-size: 18px}
	</style>
	'.(g('wb_site_config.notcopy')?'
	<script type="text/javascript">
		var omitformtags=["input","textarea", "select"];//过滤掉的标签
		omitformtags=omitformtags.join("|")
		function disableselect(e){
			var e=e || event;//IE 中可以直接使用 event 对象 ,FF e
			var obj=e.srcElement ? e.srcElement : e.target;//在 IE 中 srcElement 表示产生事件的源,FF 中则是 target
			if(omitformtags.indexOf(obj.tagName.toLowerCase())==-1){
				if(e.srcElement) document.onselectstart=new Function ("return false");//IE
				return false;
			}else{
				if(e.srcElement) document.onselectstart=new Function ("return true");//IE
				return true;
			}
		}
		function reEnable(){return true}
		document.onmousedown=disableselect;//按下鼠标上的设备(左键,右键,滚轮……)
		document.onmouseup=reEnable;//设备弹起
		document.oncontextmenu=new Function("event.returnValue=false;");
		document.onselectstart=new Function("event.returnValue=false;");
		document.oncontextmenu=function(e){return false;};//屏蔽鼠标右键
	</script>
	':'').'
	<body>
	'.$html['header'].'
	<div class="saasbody" id="saasbody">
		'.$html['content'].$html['footer'].$__side_fload.ly200::out_put_third_code().'
	</div>
	<module class="lyfooterfloadbox">'.$html['service_mobile'].'<module>
	'.(
		!$config['inline'] ? '
			<link rel="stylesheet" href="'.c('website.path').'/page/'.$config['id'].'/css.css?t='.g('website.id').'" />
			<script src="'.c('website.path').'/page/'.$config['id'].'/js.js?t='.g('website.id').'"></script>
		' : ''
	).'
	</body>
	<script src="/themes/api/analytics/index.js"></script>
	<!-- <script>
		luxy.init({
			wrapper: "#saasbody",
			targets : ".luxy-el",
			wrapperSpeed:  0.08
		});
	</script> -->
</html>';