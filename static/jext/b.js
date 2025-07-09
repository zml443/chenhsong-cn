

$.cfg = [
	// 动效
	{
		n: 'TweenMax',
		f: 'web/tweenmax/minified/TweenMax.min.js',
	},
	{
		n: 'TimelineLite',
		f: 'web/tweenmax/minified/TimelineLite.min.js',
	},
	{
		f: 'web/tweenmax/src/button.js, web/tweenmax/src/button.css',
		o: '.tweenmax-menu'
	},
	// 地址三级联动
	{
		f: 'web/address/distpicker.data.js, web/address/distpicker.js',
		o: '[address]'
	},
	// 文件功能
	{
		f: 'web/file/selector/selector.js',
		o: '[file-selector]'
	},
	{
		f: 'web/file/selector/ext.js',
		o: 'img[file-ext]'
	},
	{
		f: 'web/file/upload/index.js,web/file/upload/upload.css, web/file/upload/div.css',
		o: '[file-upload]'
	},
	{
		f: 'web/file/download/download.js',
		o: '[file-download]'
	},

	// 树状排列
	{
		f: 'web/tree/menu/1.js,web/tree/menu/1.css',
		o: '[tree-menu]'
	},

	// 图片功能
	{
		f: 'web/image/zoom/zoom.js, web/image/zoom/zoom.css',
		o: '[image-zoom]'
	},
	{
		f: 'web/image/show/index.js',
		o: '[image-show],[ly-image-show]'
	},
	{
		f: 'web/image/cropper/cropper.min.js, web/image/cropper/index.js, web/image/cropper/cropper.min.css, web/image/cropper/view.css',
		o: '[ly-image-cropper]'
	},
	{
		n: 'qrcode',
		f: 'web/qrcode/qrcode.min.js',
		o: '[qrcode],[ly-qrcode]'
	},

	// 画布
	{
		f: 'web/canvas/floating_colors.js',
		o: '[canvas-floating-colors]'
	},
	{
		f: 'web/canvas/particles.min.js',
		o: '[canvas-particles]'
	},
	{
		f: 'web/canvas/wave_move.js',
		o: '[canvas-wave-move]'
	},
	{
		n: 'canvas-circle',
		f: 'web/canvas/circle.js',
		o: '[canvas-circle]'
	},
	// three
	{
		n: 'three',
		f: 'web/three/three.min.js',
	},
	{
		n: 'threeOld',
		f: 'web/three/three.old.min.js',
	},
	{
		n: 'threeGUI',
		f: 'web/three/dat.gui.min.js',
	},
	// PIXI
	{
		n: 'pixi',
		f: 'web/pixi/pixi.min.js',
	},
	{
		f: 'web/pixi/src/liquid.js, web/pixi/src/liquid.css',
		o: '[liquid=1],[liquid=2],[liquid=3]'
	},
	{
		f: 'web/pixi/src/liquid4.js, web/pixi/src/liquid.css',
		o: '[liquid=4]'
	},
	{
		f: 'web/pixi/src/liquid5.js, web/pixi/src/liquid.css',
		o: '[liquid=5]'
	},
	{
		f: 'web/pixi/src/2.5d.js, web/pixi/src/2.5d.css',
		o: '[2-5d]'
	},
	{
		f: 'web/pixi/src/2.5d-float.js, web/pixi/src/2.5d.css',
		o: '[2-5d-float]'
	},

	// 时间
	{
		f: 'web/time/countdown.js',
		o: '[countdown]'
	},
	{
		n: 'laydate',
		f: 'web/time/laydate/laydate.js',
		o: '[ly-laydate]'
	},
	// 颜色
	{
		f: 'web/color/index.js',
		o: '[color-div]'
	},

	// input 的扩展
	{
		f: 'web/input/password/eye.js,web/input/password/eye.css',
		o: '[password-eye]'
	},
	{
		f: 'web/input/radio-checkbox.js',
		o: 'label [type=checkbox], label [type=radio]'
	},
	{
		f: 'web/input/int.js',
		o: 'input[int], input[float]'
	},
	{
		f: 'web/input/calc-number.js',
		o: '[calc-number]'
	},
	{
		f: 'web/input/radio-checkbox-all.js',
		o: '[type=checkbox][all]'
	},
	{
		f: 'web/input/color/jquery.minicolors.js, web/input/color/jquery.minicolors.css',
		o: '[color-selector],[ly-color-selector]'
	},
	{
		f: 'web/input/star/star.js,web/input/star/star.css',
		o: '[star-off-on]'
	},
	{
		f: 'web/input/placeholder/index.js, web/input/placeholder/index.css',
		o: '[input-placeholder]'
	},
	{
		f: 'web/input/tag/index.js, web/input/tag/index.css',
		o: '[ly-input-tag]'
	},
	{
		f: 'web/input/textarea/autoheight.js',
		o: 'textarea[autoHeight]'
	},
	{
		f: 'web/input/textarea/editor.js',
		o: '[myeditor]>[contenteditable]'
	},
	// 文本
	{
		n: 'clipboard',
		f: 'web/text/clipboard.min.js',
		o: '[ly-text-copy]'
	},
	/*{
		f: 'web/text/pre.js',
		o: '.editor pre'
	},*/
	/*{
		f: 'web/markdown/ifr.js',
		o: '[markdown],[editormd],[editorcode],[markdown-simple]',
	},*/
	{
		f: 'web/markdown/css/editormd.preview.min.css,web/markdown/ifr.js',
		o: '[ly-markdown]',
	},

	// dbs 的扩展
	// {
	// 	f: 'web/dbs/recommend/index.js',
	// 	o: '[lydbs-recommend]'
	// },
	// 下拉导航
	{
		f: 'web/header/nav/default.css, web/header/nav/default.js',
		o: '[ly-header-nav]'
	},
	{
		f: 'web/header/menu/index.css, web/header/menu/index.js',
		o: '[ly-header-menu]'
	},
	{
		f: 'web/header/menu2/index.css, web/header/menu2/index.js',
		o: '[ly-header-menu2]'
	},

	// iframe 的扩展
	/*{
		f: 'web/iframe/view.js',
		o: '[ly-iframe-view]'
	},*/

	// 验证码
	{
		f: 'web/code/drag.js',
		o: '[code-drag]'
	},
	{
		f: 'web/code/word.js',
		o: '[code-word]'
	},
	{
		f: 'web/code/sms/send.js',
		o: '[ly-code-sms]'
	},
	{
		f: 'web/code/picture/index.js, web/code/picture/index.css',
		o: '[ly-code-picture]'
	},

	// 提示效果
	{
		f: 'web/tip/for/e.js, web/tip/for/e.css',
		o: '[tip-for]'
	},
	{
		f: 'web/tip/bubble/index.js, web/tip/bubble/index.css',
		o: '[ly-tip-bubble]'
	},
	{
		f: 'web/tip/fload/fd.js',
		o: '[tip-fload]'
	},
	{
		f: 'web/drop/select/index.js, web/drop/select/index.css',
		o: '[ly-drop-select]'
	},
	{
		f: 'web/drop/default/index.js',
		o: '[ly-drop]'
	},

	// 滚动条
	{
		f: 'web/mcscroll/calc/index.js',
		o: '[ly-scroll-calc]'
	},
	{
		f: 'web/mcscroll/custom/index.css,web/mcscroll/custom/index.js',
		o: '[ly-scroll-custom]'
	},
	{
		f: 'web/mcscroll/anchor/a.js',
		o: 'a[href*="#"], area[href*="#"]'
	},
	// 布局
	{
		f: 'web/layout/masonry/imagesloaded.js,web/layout/masonry/masonry.pkgd.min.js,web/layout/masonry/index.js',
		o: '[ly-masonry]'
	},
	{
		f: 'web/tab/index.js',
		o: '[ly-tab],[tab]'
	},
	{
		f: 'web/layout/hover/mask.js,web/layout/hover/mask.css',
		o: '[hover-mask]'
	},
	{
		f: 'web/sticky/index.js',
		o: '[ly-sticky]'
	},
	// 书本翻页
	{
		n: 'turnjs',
		f: 'web/trun_page/lib/turn.min.js, web/trun_page/index.js, web/trun_page/index.css',
		o: '[turnjs]'
	},

	// ajax 效果
	{
		f: 'web/ajax/page.js',
		o: '[ajax-href], [ajax-page], [ajax-change], [ajax-append], [ajax-attr]'
	},

	// 轮播图
	{
		n: 'swiper',
		f: 'web/swiper5/swiper.min.css, '+/*web/swiper5/animate.min.js,*/'web/swiper5/swiper.min.js, web/swiper5/index.js',
		o: '.container .wrapper'
	},
	{
		n: 'carousel',
		f: 'web/carousel/index.js',
		o: '[ly-carousel] .wrapper'
	},
	{
		f: 'web/carousel/autoloop/index.css,web/carousel/autoloop/index.js',
		o: '[ly-carousel-autoloop]'
	},

	// 编辑器
	{
		n: 'ueditor',
		f: 'web/ueditor/ueditor.config.js,web/ueditor/ueditor.all.js, web/ueditor/index.js',
		o: '[ueditor], [MUeditor]'
	},
	{
		f: 'web/contenteditable/index.js',
		o: '[contenteditable][data]'
	},

	// 视频功能扩展
	{
		f: 'web/video/src/v.js, web/video/src/v.css',
		o: '[ly-video]'
	},

	// 代码编辑器
	{
		n: 'ace',
		f: 'web/ace/acode.js, web/ace/src/ace.js, web/ace/src/ext-language_tools.js',
		o: '[acode]'
	},

	// 搜索
	{
		f: 'web/form/search/s.js, web/form/search/s.css',
		o: '[ly-search-popup]'
	},

	// sitemap.xml
	{
		f: 'web/sitemap/index.js',
		o: '[ly-sitemap]'
	},

	// 区间效果
	/*{
		f: 'web/progress/default.js',
		o: '[progress]'
	},
	{
		f: 'web/progress/range-v.js',
		o: '[range=vertical]'
	},
	{
		f: 'web/progress/range-h.js',
		o: '[range=horizontal]'
	},*/
	// 分享
	{
		f: 'web/links/share/index.js',
		o: '[share],[ly-share]'
	},
	// 拖拽区域
	{
		f: 'web/drag/sort/dragsort-0.5.2.js, web/drag/sort/index.js',
		o: '[dragsort], [drag-sort], [ly-drag-sort]'
	},
	{
		f: 'web/drag/range/index.css, web/drag/range/index.js',
		o: '[drag-range]'
	},
	// 数字滚动
	{
		f: 'web/number/number.js',
		o: '[number*=","]:not(input), [data-number*=","]:not(input)'
	},
	{
		f: 'web/number/roll.css,web/number/roll.js',
		o: '[ly-number-roll]'
	},
	// 地图导航
	{
		f: 'web/baidu-map/index.js',
		o: '[ly-baidu-map]'
	},
	// 第三方接口
	{
		f: 'web/third/wechat/share.js',
		o: 'body[wx-share]'
	},
	{
		f: 'web/third/kd100/index.js',
		o: '[kd100]'
	},
];
$.cfg2 = {};
for (var i in $.cfg) {
	var v = $.cfg[i];
	if (v.n) {
		$.cfg2[v.n] = v.f;
	}
}
// 画布背景系列
var a = ['star','star2','star3','line-fractal','line-follow','line2','line3','line4','line5','line6','floating','technology', 'technology2','word','word2','dot','dot2','dot3','dot4'];
for (var i in a) {
	var v = a[i];
	$.cfg.push({
		f: 'web/canvas/src/'+v+'.js',
		o: '[canvas-src^="'+v+',"]'
	});
}



// 补充jq函数
$.extend({
	// 记录任务
	task: [],

	// 定时执行所有效果函数
	// 核心函数之一
	_all_index: 0,
	all: function(t, index) {
		$._include_load.ready = false;
		if ($._include_load.wait<=$._include_load.complete) {
			$._include_load.ready = true;
			$.is_loading_completed = 1;
			$('html,body').addClass('is-loading-completed');
		}
		if ($._include_load.ready&&!$._include_load.readied) {
			$._include_load.readied = true;
			setTimeout(function(){
				$('.jext_loading_box').fadeOut(300, function(){
					$('.jext_loading_box').remove();
				});
			}, 300);
		}
		// 調用函數
		var next_index = $._all_index + 9;
		for (var i in $.task) {
			if (i>=$._all_index && i<next_index) {
				try{
					$.task[i](); //防止某个函数报错导致全部都不能用
				}catch(err){
					console.log(err);
				}
			}
		}
		$._all_index = next_index;
		if (next_index>$.task.length) $._all_index = 0;
	},

	// 规范回调函数
	callbackfn: function (fn, opt) {
		if (!fn) return {};
		if (fn[0]=='{') {
			return $.json(fn,'simple');
		} else {
			var new_fn = {},
				opt = typeof(opt)=='string'?opt.split(','):opt;
			for (var i in opt) new_fn[opt[i]]=fn+'.'+opt[i];
			return new_fn;
		}
	},

	// 调用 eval 的函数
	_implement_eval_fn_logs: {},
	implement_eval_fn: function(ss, fn){
		var index = 1;
		for (var i in ss) {
			if (!$._include_ready[ss[i]]&&typeof ss[i]!='number') index=0;
		}
		if (index && !$._implement_eval_fn_logs[ss]) {
			$._implement_eval_fn_logs[ss]=true;
			fn();
		}
	},

	// 通过字符串执行函数
	eval: function(ss, fn) {
		if (!ss) return;
		if (typeof(fn)=='function') {
			ss = ss.split(' ');
			ss.sort(function (x,y) {return (x.toUpperCase() > y.toUpperCase()) ? 1 : -1});
			var rand = Math.random();
			for (var i in ss) {
				var v = ss[i],
					f = $.cfg2[v].split(','),
					u = [];
				for (var j in f) u.push($.path+f[j].replace(/^ | $/g, ''));
				$.include(u, function(){$.implement_eval_fn(ss.concat([rand]), fn)}, v);
			}
			return;
		}
		var arg = []; for (var i in arguments) if (i>0) arg.push(arguments[i]);
		var aa = ss.split(/;/);
		for(var kk in aa) {
			if (aa[kk].search(/^cl:/)>=0) {
				fn.attr('onerror', aa[kk].replace(/^cl:/, '')).trigger('onerror');
				console.log(aa[kk].replace(/^cl:/, ''));
				// a.removeAttr('onPaste');
				continue;
			}
			ss = aa[kk].replace(/\((.*?)\)|'\]/g, '').replace(/\['/g, '.').split('.');
			var ww = window, pp=ww;
			for (var ii in ss) {
				if (ss[ii]=='WP') {
					ww=WP;
					pp=WP;
					continue;
				}
				if (ww[ss[ii]]) {
					pp = ww;
					ww = ww[ss[ii]];
				} else {
					break;
				}
			}
			if (typeof(ww)=='function') {
				ww.apply(pp, arg);
			}
		}
	},

});



if ($('[jextstyle]').size()==0) {
	$.oo.after('<style jextstyle>[scalc],.wow,[wow],[vue],[number-roll]:not(.isstart){visibility:hidden}img{min-width:1px;min-height:1px;}[vue].visible{visibility: visible;}</style>');
}
if ($('meta[loading]').size()) {
	$('html').append('<div class="fixed max flex-middle2 jext_loading_box" style="z-index:9999999;background:#fff;padding-bottom:120px">'+$.loading({})+'</div>');
}
$('[jextstyle]').append('.container[loading]:after{background:url('+$.path+'images/l.gif) no-repeat center;}[masonry]:not(.isok):before{background:url('+$.path+'images/l.gif) no-repeat 50% 160px;position:absolute;left:0;right:0;top:0;bottom:10%;content:""}[jxloading],[map]{background:url('+$.path+'images/l.gif) no-repeat center;font-size:0;}[jxloading].isok{background-image:none;}');





// 获得焦点
$(document).on('focus', 'input,select,textarea', function(){
	$(this).parents('label').addClass('focus')
});
// 失去焦点
$(document).on('blur', 'input,select,textarea', function(){
	$(this).parents('label').removeClass('focus')
});



// 准备载入
$(document).ready(function(){
	// 进入可视范围
	var times = 0;
	var xxx = ()=>{
		times++;
		if (times==2) {
			$.all();
		} else if (times==7 && $.is_loading_completed) {
			$('[data-src]').each(function(){
				var a = $(this);
				if (a.parent().visible_clac({Y:200})) {
				    var src = a.attr('data-src');
				    if (a.is('img') || a.is('video')) {
				        a.attr('src', src);
				    } else {
				        a.css('background-image', 'url(' + src + ')');
				    }
				    a.removeAttr('data-src');
				    if (a.is('.IsMasonryImage')) {
				    	a.parents('[ly-masonry]').masonry_reload();
				    }
				}
			});
		} else if (times==15) {
			if (location.href.search(/&notwow=/) > 0 || $('meta[notwow]').size()) {
				$('[wow]').removeAttr('wow')
			}else{
				_('[wow]').visible({
					show(a){
						var delay = parseFloat(a.attr('data-delay') || a.attr('delay') || .1);
						var prev = a.prev();
						if (prev.is('[awow]') && !a.is('[delay]') && !a.is('[data-delay]')) {
							delay += parseFloat(prev.attr('data-delay') || prev.attr('delay') || .1);
							a.attr('data-delay', delay)
						}
						a.addClass('animated ' + a.attr('wow')).attr({
							'awow': a.attr('wow')
						}).removeAttr('wow').css({
							'animation-delay': delay + 's'
						});
						setTimeout(()=>{
							a.removeClass('animated ' + a.attr('awow')).removeAttr('awow')
						}, delay * 1000 + 1000)
					}
				});
			}
		} else if(times==20) {
			for (var i in $.cfg) {
				var v = $.cfg[i],
					a = v.o && $(v.o).size(),
					f = v.f.split(','),
					include_src = [];
				if (a) {
					for (var j in f) include_src.push($.path+f[j].replace(/^ | $/g, ''));
					$.include(include_src, '', v.n||'');
					delete($.cfg[i]);
				}
			}
		}
		$('iframe[autoheight]').each(function(){$(this).height($(this).contents().find('body').height())});
		if (times==25) times=0;
		requestAnimationFrame(xxx);
	};
	xxx();
});



// 定时任务
////////////////////////////////////////////////////////////
// 5.3.1.22.11.3 将timing请求的结果改成json
$.__timing = {
	// 请求
	data: {
		number: 0 //请求次数
	},
	// 请求频率
	time: 100 * 1000,
	init: function () {
		var thi = this;
		thi.data.number++;
		$.async('POST', $.path + 'php/timing.php', thi.data, function (result) {
			$._time=parseInt($.cookie('time'));
			thi.set_time();
		}, function (error) {
			thi.set_time();
		}, 'json');
	},
	set_time: function () {
		var thi = this;
		setTimeout(function () {
			thi.init();
		}, thi.time);
	}
};
if (WP==window) $.__timing.set_time();
////////////////////////////////////////////////////////////