<meta charset="utf-8" website-language='<?=@implode(',', c('language'))?>' language='<?=c('manage.lang')?>'>
<title><?=g('wb_site_config.webname');?></title>
<meta content="telephone=no" name="format-detection" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<link rel='shortcut icon' href='<?=img::ary(g('wb_site_config.ico'), 0);?>' />

<link rel="stylesheet" href="/static/jext/css/global.css" />
<link rel="stylesheet" href="/static/jext/css/lyicon/iconfont.css" />
<link rel="stylesheet" href="/static/jext/css/thicon/iconfont.css" />
<link rel="stylesheet" href="/static/jext/css/ly2ui.css" />
<script src="/static/jext/a.js"></script>
<script src="/static/jext/b.js"></script>
<!-- <script src="/static/jext/c.js"></script> -->
<script src="/static/vue/vue.min.js"></script>
<script>
	$.language.cur = '<?=c('manage.lang')?>';
	$.language.all = <?=str::json(c('language'))?>;
	$.lang = <?php
		$pack = c('language_pack.manage').c('manage.lang').'/0.php';
		$pack_cn = c('language_pack.manage').'cn/0.php';
		$language_array = is_file($pack) ? include $pack : include $pack_cn;
		echo str::json($language_array);
	?>;
	$.C = {};
	$.G = {
		// 事件
		event:{
			// 搜索
			search:{
				// Ajax更新的 ajax-change 部分
				ajax_change: '',
				// 提交前的回调函数
				before: '',
				// 提交后的回调函数
				after: '',
				// 删除前
				deleteBefore: '',
				// 删除后
				deleteAfter: ''
			},
			// 分页
			paging:{
				ajax_change: '',
				before: '',
				after: ''
			}
		}
	};
</script>

<link rel="stylesheet" href="/manage/__/css/mgicon/iconfont.css" />
<link rel="stylesheet" href="/manage/__/css/style.css" />
<link rel="stylesheet" href="/manage/__/css/orders.css" />
<script src="/manage/__/css/ly2ui.js"></script>
<script src="/manage/__/js/index.js"></script>

<link rel="stylesheet" href="/static/css/page/rectangle.css" />