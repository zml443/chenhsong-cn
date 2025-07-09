
var header_nav = {
	data: '',
	keep: 0,
	init(el){
		var key = el.attr('ly-header-nav')
		if (!this.data) {
			this.data = $(el.attr('to')).json()
		}
		return {
			key: key,
			data: this.data[key]
		}
	},
	// 默认的下拉方式
	html_default(opt){
		function li(arr){
			var subnav = '';
			if (arr.children) {
				arr.children = Object.values(arr.children)
				if (arr.children.length) subnav = `
					<i class="ico lyicon-arrow-right-bold"></i>
					<div class="subnav">
						<div class="subcon">
							${arr.children.map(v=>{
								return li(v)
							}).join('')}
						</div>
					</div>
				`
			}
			return `
				<div class="li flex-middle2">
					<a class="flex-1" href="${arr.href}" target="${arr.target||'_self'}">${arr.name}</a>
					${subnav}
				</div>
			`
		}
		return `
			<div class="ly_header_nav_ui ly_header_nav_default fixed hidden" data-key="${opt.key}">
				${opt.data.children.map(v=>{
					return li(v)
				}).join('')}
			</div>
		`
	},
	// 图片下拉
	html_picture(opt){
		if (!opt.data.picture.length) {
			opt.data.picture = Object.values(opt.data.picture)
			var img = `
				<div class="img">
					${opt.picture.map(v=>{
						return `
							<div class="dl">
								<a class="dt" href="${v.href}" target="${v.target||'_self'}">${v.name}</a>
								${v.children && v.children.length ? v.children.map(v=>{
									return `<a class="dd" href="${v.href}" target="${v.target||'_self'}">${v.name}</a>`
								}).join('') : ''}
							</div>
						`
					}).join('')}
				</div>
			`
		} else {
			var img = ''
		}
		return `
			<div class="ly_header_nav_ui ly_header_nav_picture fixed flex hidden" data-key="${opt.key}">
				<div class="nav flex-1">
					${opt.data.children.map(v=>{
						return `<a class="dt flex-middle2" href="${v.href}" target="${v.target||'_self'}">
							<span class="flex-1">${v.name}</span>
							<i class="i lyicon-direction-right"></i>
						</a>`
					}).join('')}
				</div>
				<div class="img"><img class="maxw" src="${opt.data.picture[0].path}" alt="" /></div>
			</div>
		`
	},
	// 创建下拉的 html 布局
	html(el){
		var opt = this.init(el)
		this.keep = 1
		if (!opt.data || !opt.data.children) {
			return;
		}
		opt.data.children = Object.values(opt.data.children)
		if (!opt.data.children.length) {
			return;
		}
		switch(opt.data.subnav_type){
			case 'picture':
				var html = this.html_picture(opt)
				break;
			default:
				var html = this.html_default(opt)
				break;
		}
		if (html) $('body').after(html)
	},
	// 处理定位
	position(el){
		var opt = this.init(el)
		var obj = $('.ly_header_nav_ui[data-key="'+opt.key+'"]')
		if (obj.size()==0) {
			return;
		}
		switch(opt.data.subnav_type){
			case 'picture':
				var top = el[0].getBoundingClientRect().top + el.outerHeight()
				var left = el[0].getBoundingClientRect().left + (el.outerWidth() - obj.outerWidth()) / 2
				if (left<0) {
					left = 0
				}
				break;
			default:
				var top = el[0].getBoundingClientRect().top + el.outerHeight()
				var left = el[0].getBoundingClientRect().left + (el.outerWidth() - obj.outerWidth()) / 2
				break;
		}
		obj.css({top:top, left:left})
	},
	// 展示下拉
	show(el){
		var opt = this.init(el)
		this.keep = 1
		this.position(el)
		if (el.is('[ly-header-nav]')) {
			$('.ly_header_nav_ui').addClass('hidden')
			$('[ly-header-nav]').removeClass('nav_hover')
			$('.ly_header_nav_ui[data-key="'+opt.key+'"]').removeClass('hidden')
			el.addClass('nav_hover')
		}
	},
	// 隐藏下拉
	hide(el){
		// var opt = this.init(el)
		this.keep = 0
		setTimeout(()=>{
			if (!this.keep) {
				$('.ly_header_nav_ui').addClass('hidden')
				$('[ly-header-nav]').removeClass('nav_hover')
			}
		}, 100)
	}
};

$(document).ready(()=>{
	$('[ly-header-nav]').each(function(){
		header_nav.html($(this))
	})
});


// 鼠标移入
$(document).on('mouseenter', '[ly-header-nav], .ly_header_nav_ui', function () {
	header_nav.show($(this))
});

// 鼠标移出
$(document).on('mouseleave', '[ly-header-nav], .ly_header_nav_ui', function () {
	header_nav.hide($(this))
});

// 鼠标滚动，隐藏下拉导航
$('html, body').on("mousewheel DOMMouseScroll", function (e) {
	// $('.ly_header_nav_ui').addClass('hidden')
	$('[ly-header-nav].nav_hover').each(function(){
		header_nav.position($(this))
	})
});