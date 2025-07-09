$.task.push(function () {
	$('.container:not(.isok)').each(function(i, e) {
		var container = $(this),
			wrapper = container.children('.wrapper'),
			slide = wrapper.children(),
			fn = $.callbackfn(container.attr('fn'),'init,end,start,progress,transition,transitionEnd,transitionStart,translate,touchStart,touchEnd,touchMove');
		container.addClass('swiper');
		wrapper.addClass('swiper-wrapper');
		slide.addClass('swiper-slide mr0');
		slide.each(function(i){
			$(this).attr('index', i);
		});
		// 焦点 - 横向滚动
		if (container.is('[fn*="swiper_heng_xiang_jiao_dian"]')) {
			$.include($.path + 'web/swiper/swiperFunction/swiper_heng_xiang_jiao_dian.js');
			if (typeof(swiper_heng_xiang_jiao_dian)=='undefined') return;
		}
		// 百叶窗
		if (container.is('[fn*="swiper_folding"]')) {
			$.include($.path+'web/swiper/swiperFunction/swiper_folding.js');
			if (typeof(swiper_folding)=='undefined') return;
		}
		// 时间进度条 - 圆圈(新概念)
		if (container.is('[fn*="swiper_circle"')) {
			$.include($.path + 'web/swiper/swiperFunction/swiper_circle.js');
			if (typeof(swiper_circle)=='undefined') return;
		}
		// 时间进度条
		if (container.is('[fn*="swiper_time_bar"')) {
			$.include($.path + 'web/swiper/swiperFunction/swiper_time_bar.js');
			if (typeof(swiper_time_bar)=='undefined') return;
		}
		var pagination = container.attr('pagination') || container.attr('page'),
			index = parseInt(container.attr('index')||0),
			cur = wrapper.children('[cur],.cur'),
			cur = parseInt(cur.index()) - parseInt(cur.attr('cur')||0),
			view = container.attr('view'),
			group = container.attr('group'),
			autoHeight = container.attr('autoHeight'),
			thumbs = $(container.attr('thumbs')),
			control = $(container.attr('control'));
		var h5 = function () {
			var h1 = {view:'slidesPerView',group:'slidesPerGroup',space:'spaceBetween',center:'centeredSlides',cols:'slidesPerColumn'},
				h2 = container.attr('h5')||'';
				for (var i in h1) h2=h2.replace(new RegExp(i,'g'),h1[i]);
			return h2;
		}

		if ((thumbs.size() && !thumbs.is('[jx-o-swiper]')) || (control.size() && !control.is('[jx-o-swiper]'))) {
			return;
		} else {
			container.addClass('isok');
		}
		if (pagination != 'none') {
			container.append('<div class="swiper-pagination"></div>');
		}
		if (container.is('[nav]')) {
			container.append('<div class="swiper-button-prev notcopy"></div>');
			container.append('<div class="swiper-button-next notcopy"></div>');
		}
		var b = Math.random().toString().replace(/\./g, '');
		container.attr({'swiper': b});

		var data = {
			// 如果需要分页器
			pagination: {
				el: (container.attr('page-el')?container.attr('page-el'):'[swiper="' + b + '"] .swiper-pagination'),
				clickable: true,
				dynamicBullets: pagination=='dynamic' ? true : false,
			},
			// wasLocked: false,
			// allowSlideNext: false,
			// 如果需要前进后退按钮
			navigation: {
				nextEl: '[swiper="' + b + '"] .swiper-button-next'+(container.attr('next')?','+container.attr('next'):''),
				prevEl: '[swiper="' + b + '"] .swiper-button-prev'+(container.attr('prev')?','+container.attr('prev'):''),
			},
			mousewheel: container.is('[mousewheel]')?true:false,
			zoom: container.is('[zoom]'),
			autoHeight: container.is('[autoHeight]'),
			centeredSlides: container.is('[center]'),
			freeMode: container.is('[free]'),
			parallax: container.is('[parallax]'),
			slidesPerColumn: container.attr('cols')||1,
			slidesPerColumnFill: container.attr('colsfill')||'row',
			breakpoints: $.json(h5(), 'simple'),
			initialSlide: (index>0?index:(cur>0?cur:0)),
			roundLengths: container.is('[roundLengths]'),//true,
			observer: container.is('[observer]'),
			followFinger: !container.is('[followFinger]'),
			// observeParents: true, // 这个导致拖拽出问题
			// observeParents: container.is('[observeParents]'),
			// observeSlideChildren: true,
			slideToClickedSlide: container.is('[click]'),
			spaceBetween: parseInt(container.attr('space')) || 0,
			speed: parseFloat(container.attr('speed')||.3) * 1000,
			noSwipingSelector: container.attr('noSwipingSelector') || '',
			watchSlidesProgress: true,
			// watchSlidesProgress: container.is('[watchSlidesProgress]'),
			on:{
				progress: function (swiper,progress) {
					var s = this;
        			for (i = 0; i < s.slides.length; i++) {
			            s.slides.eq(i).attr({'progress':s.slides[i].progress, 'data-number':Math.round(s.slides[i].progress)});
			        }
					$.eval(fn.progress, container, this, progress);
				},
				observerUpdate: function () {
					$.eval(fn.update, container, this);
				},
				resize: function () {
					$.eval(fn.resize, container, this);
				},
				setTranslate: function(swiper,translate){
					if (fn.translate) $.eval(fn.translate, container, this, translate);
				},
				setTransition: function (swiper,transition) {
					$.eval(fn.transition, container, this, transition);
				},
				init: function () {
					var thi = this;
					container.attr({'active-index': thi.activeIndex});
					setTimeout(function(){
						var page = $(data.pagination.el);
						if (page.children().size()<2) page.hide();
						$.eval(fn.init, container, thi);
					}, 60);
					if (container.is('[page-hover]')) {
						$(document).on('mouseenter', data.pagination.el + '>*', function(){
							$(this).click();
						});
					}
					if (typeof(swiperAnimate)=='function') swiperAnimate(thi);
				},
				slideChangeTransitionStart: function () {
					// 回调函数
					$.eval(fn.start, container, this);
				},
				transitionEnd: function () {
        			for (i = 0; i < this.slides.length; i++) {
			            this.slides.eq(i).attr({'progress':this.slides[i].progress, 'data-number':Math.ceil(this.slides[i].progress)});
			        }
					container.attr({'active-index':this.activeIndex});
					$.eval(fn.end, container, this);
					$.eval(fn.transitionEnd, container, this);
				},
				transitionStart:function(){
					$.eval(fn.transitionStart, container, this);
				},
				touchStart: function (swiper,event) {
					$.eval(fn.touchStart, container, this);
				},
				touchMove: function (swiper,event) {
					$.eval(fn.touchMove, container, this);
				},
				touchEnd: function (swiper,event) {
					$.eval(fn.touchEnd, container, this);
				}
			},
			watchSlidesVisibility: true
		};
		// 如果需要滚动条
		if (container.is('[scrollbar]')) {
			container.append('<div class="swiper-scrollbar"></div>');
			data.scrollbar = {
				el: (container.attr('scrollbar')?container.attr('scrollbar'):'[swiper="' + b + '"] .swiper-scrollbar'),
				draggable: true,
			};
		}
		// 分页方式
		if (pagination!='dynamic' && pagination && typeof(pagination)!='undefined') {
			data.pagination.type = pagination;
		}
		// 切换方式
		if (container.is('[effect]')) {
			data.effect = container.attr('effect');
			data.fadeEffect = {crossFade:true};
		}
		// 垂直滚动
		if (container.is('[vertical]')) data.direction = 'vertical';
		// 循环模式选项
		if (container.is('[loop], [loops]')) {
			data.loop = true;
			data.roundLengths = false;
			data.loopedSlides = parseInt(container.attr('loop')||container.attr('loops')||9);
			data.loopAdditionalSlides = 9;
		}
		// 展示数量
		if (container.is('[view]')) data.slidesPerView = parseInt(container.attr('view')) || 'auto';
		// 展示数量
		if (container.is('[group]')) {
			data.slidesPerGroup = parseInt(container.attr('group')||1);
		}
		// 整屏滚动效果
		if (container.find('img[data-src]').size()) {
			container.find('img[data-src]').addClass('swiper-lazy');
			data.lazy = true;
		}
		// 整屏滚动效果
		if (container.is('[vertical]') && container.is('[autoHeight]') && container.is('[mousewheel]')) {
			var wh = $(window).height();
			wrapper.children().each(function () {
				if (!$(this).is('[autoHeight]')) $(this).height(wh);
			});
		}
		// 自动播放
		if (container.is('[delay]')) {
			var delay = parseInt(container.attr('delay')||0);
			if (delay) data.autoplay = {
				delay: delay * 1000,
				disableOnInteraction: false,
				stopOnLastSlide: false
			};
		}
		if (thumbs.size()) {
			data.thumbs = {swiper:thumbs.o('swiper')}
		}

		// 手机版去掉禁止滑动的样式
		if ($.mobile()) {
			container.find('.swiper-no-swiping').addClass('swiper-no-swiping-').removeClass('swiper-no-swiping');
		}

		// 执行
		var swi = new Swiper(container[0], data);
		// var swi = new Swiper('.swiper', data);
		container.o('swiper', swi);
		if (container.is('[page-hover]')) {
			for (i=0; i<swi.pagination.bullets.length; i++) {
				swi.pagination.bullets[i].onmouseover = function () {
					this.click();
				};
			}
		}
		container.find('.wrapper').animate({opacity:1});

		// 其他效果
		container.find('[s-tab]').each(function () {
			$(this).attr({tab: $(this).attr('s-tab')}).removeAttr('s-tab');
		});

		if (container.is('[stop-btn]')) $(container.attr('stop-btn')).click(function () {
			if (swi.autoplay.running) _swiper_hover_stop_fn_(container, 1);
			else _swiper_hover_stop_fn_(container, 0);
		});

		// 鼠标移入停止自动播放
		if(control.size()){
			swi.controller.control=control.o('swiper');
			control.o('swiper').controller.control=swi;
			_swiper_hover_stop_(control, container);
			_swiper_hover_stop_(container, control);
		}
		else _swiper_hover_stop_(container);
	});
});


var _swiper_hover_stop_ = function (a, b) {
	if (!a.is('[hover-stop]')) return;
	a.hover(function () {
		_swiper_hover_stop_fn_(a, 1);
		if (b) _swiper_hover_stop_fn_(b, 1);
	}, function () {
		_swiper_hover_stop_fn_(a, 0);
		if (b) _swiper_hover_stop_fn_(b, 0);
	});
};

var _swiper_hover_stop_fn_ = function (el, stop) {
	var fn = $.callbackfn(el.attr('fn'), 'stop'),
		swiper = el.o('swiper');
	if (stop) swiper.autoplay.stop();
	else swiper.autoplay.start();
	$.eval(fn.stop, el, swiper, stop);
};