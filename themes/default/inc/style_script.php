<head>
	<meta loading="2">
	<meta charset="utf-8" website-language="<?=implode(',',c('language'))?>" language='<?=c('lang')?>'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="renderer" content="webkit" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta content="telephone=no" name="format-detection" />
	<meta name="screen-orientation" content="portrait">
	<meta name="x5-orientation" content="portrait">
	<meta name="referrer" content="never">
	<link rel="shortcut icon" href="<?=g('wb_site_config.ico')?>" />
	<link rel="stylesheet" href="/static/jext/css/global.css" />
	<link rel="stylesheet" href="/static/jext/css/lyicon/iconfont.css" />
	<link rel="stylesheet" href="/static/jext/css/thicon/iconfont.css" />
	<link rel="stylesheet" href="/static/jext/css/animated.min.css" />
	<link rel="stylesheet" href="/static/jext/css/lycss.min.css" />
	<?php if(server::mobile()){?><meta notwow /><?php }?>
	<script src="/static/jext/a.js"></script>
	<script src="/static/jext/b.js"></script>
	<script>
		$.language.cur = '<?=c('lang')?>';
		$.language.all = <?=str::json(c('language'))?>;
		$.global = <?=str::json(array(
			'HostTag' => c('HostTag'),
			'AppOpen' => array(),
		))?>;
		<?php
			$language_pack = c('language_pack.manage').c('lang').'/0.php';
			$language_pack_cn = c('language_pack.manage').'cn/0.php';
			$language_array = is_file($language_pack) ? include $language_pack : include $language_pack_cn;
		?>
		$.lang = <?=str::json($language_array)?>;
	</script>
	<link rel="stylesheet" href="/themes/default/css/style.css" />
	<link rel="stylesheet" href="/themes/default/css/<?=c('lang')?>.css" />
	<link rel="stylesheet" href="/static/jext/css/ly2ui.css" />
	<link rel="stylesheet" href="/static/css/page/rectangle.css" />
	<script src="/themes/default/css/lyui.js"></script>
	<script src="/themes/default/js/web.js"></script>
	<script src="/static/jext/org/viewport.js"></script>
	<?=ly200::seo($seo);?>
</head>
<style class="main_style">
	:root{
		--mainColor:<?=g('website.mainColor')?:'#739962'?>;
		--bgColor:<?=g('website.bgColor')?:'#f6f7f9'?>;
	}
	html{font-size:100px;}
	.lyui_paging{font-size: 18px}
</style>

<script>
$(window).load(function(){
	$('img[src$=".svg"]:not([onload*="SVGInject"])').load(function () {
		SVGInject($(this)[0]);
	}).each(function () {
		SVGInject($(this)[0]);
	});
})
</script>

<?php if (g('wb_site_config.notcopy')) { ?>
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
<?php } ?>