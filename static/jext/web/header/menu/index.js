class ly_header_menu {
	constructor(el){
		var opt = $.json(el.attr('ly-header-menu'), 'simple');
		if (opt.color) {
			// 将颜色字符串转成数组
			if (typeof(opt.color)=='string') opt.color = [opt.color];
			if (!opt.color[1]) opt.color[1] = '#fff';
			if (!opt.color[2]) opt.color[2] = '#f1f1f1';
		}else{
			opt.color = [el.attr('data-color0')||'#fff',el.attr('data-color1')||'#333',el.attr('data-color2')||'#666'];
		}
		this.data = {
			el: el,
			bgColor: opt.color[0],
			fontColor: opt.color[1],
			numColor: opt.color[2],
			direction: opt.direction||el.attr('data-direction')||'right',
			fn: $.callbackfn(el.attr('fn'),'click, init'),
			data: $(el.attr('to')).json(),
			subnav_type_mb:1
		};
		this.data.data = Object.values(this.data.data);
		this.el = el;
		this.ohtml = '';
		this.html();
	}


	// 默认
	html(){
		var nav = [];
		function ec(arr){
			nav.push([]);
			var j = nav.length - 1;
			var li = [];
			for (var i in arr) {
				var v = arr[i];
				v.children_length = 0;
				if (v.children) {
					v.children = Object.values(v.children);
					var index = ec(v.children);
					v.children_length = v.children.length;
					v.nav_index = index;
					delete(v.children);
				}
				li.push(v);
			}
			nav[j] = li;
			return j;
		}
		ec(this.data.data, '0');
		// 子结构
		function li(arr){
			var next = '';
			if (arr.children_length) {
				next = `
					<span class="">${arr.children_length}</span>
					<i class="ly_header_menu_default_nav_li_i lyicon-arrow-right-bold"></i>
				`;
			}
			return `
				<div class="ly_header_menu_default_nav_li flex-middle2" data-index="${arr.nav_index||''}" data-long="${arr.children_length>0?true:false}" data-name="${arr.name}">
					<a class="flex-1" href="${arr.children_length>0?'javascript:':arr.href}" target="${arr.target||'_self'}">${arr.name}</a>
					${next}
				</div>
			`;
		}
		//
		function subnav(){
			var arr = nav.slice(1);
			var sub_nav_el = '';
			for(let i in arr){
				if(arr[i]){
					sub_nav_el += `
						<div class="ly_header_menu_default_subnav" data-index="${1+parseInt(i)}">
							<div class="ly_header_menu_default_subnav_back" data-index="${1+parseInt(i)}">
								<i class="ly_header_menu_default_subnav_back_i lyicon-direction-left pointer"></i>
								<span class="ly_header_menu_default_subnav_back_span"></span>
							</div>
							${arr[i].map(v=>{
								return li(v)
							}).join('')}
						</div>`
				}
			}
			return sub_nav_el
		}
		// 语言切换按钮
		if($.language.all.length>1){
			var lang_tab = `
				<div class="ly_header_menu_default_nav_li_btn flex-max2">
					${$.language.all.map(v => {return `<span class="${v==$.language.cur?'cur':''}">${$.lang.language.jianxie[v]}</span>`}).join('')}
				</div>
				<div class="ly_header_menu_default_nav_li_btn_drop hide2">
					<i class="lyicon-language"></i>
					<span>${$.lang.language[$.language.cur]}</span>
					<i class="lyicon-arrow-down"></i>
				</div>
				<div class="ly_header_menu_default_nav_li_btn_drop_box">
					${$.language.all.map(v => {return `<span class="${v==$.language.cur?'cur':''}">${$.lang.language[v]}</span>`}).join('')}
				</div>
				`;
		}else{
			var lang_tab = '';
		}
		var html = $(`
			<div>
			<style>
			.ly_header_menu_default{
				--bg_color:${this.data.bgColor};
				--font_color:${this.data.fontColor};
				--num_color:${this.data.numColor};
			}
			</style>
			<div class="ly_header_menu_ui ly_header_menu_default fixed hidden" data-direction="${this.data.direction}">
				<div class="ly_header_menu_default_wrap">
					<div class="ly_header_menu_default_nav">
						${this.data.data.map(v=>{
							return li(v)
						}).join('')}
						${lang_tab}
					</div>
					${subnav()}
				</div>
			</div>
			</div>
		`);
		// 语言切换事件
		html.find('.ly_header_menu_default_nav_li_btn_drop').click(function(){
			$(this).siblings('.ly_header_menu_default_nav_li_btn_drop_box').addClass('cur');
		})
		html.find('.ly_header_menu_default_nav_li_btn_drop_box').click(function(e){
			$(this).removeClass('cur');
		})
		html.on('click','.ly_header_menu_default_nav_li_btn_drop_box > *, .ly_header_menu_default_nav_li_btn > *',function(e){
			let index = $(this).index();
			ly2.language_change.post({lang:$.language.all[index]});
			// e.stopPropagation();
		})
		this.ohtml = html;
		$('body').after(html);
		$.eval(this.data.fn.init, this.data.el);
	}

	// 展示
	show(){
		this.ohtml.find('.ly_header_menu_ui').addClass('cur');
		$('body').addClass('ly_header_menu_close_pointer_event');

		// 语言切换 - 选项or展开
		let element = this.ohtml.find('.ly_header_menu_default_nav_li_btn');
		let height = element.innerHeight();
		if(parseInt(height) > 120){
			element.addClass('hide2').siblings('.ly_header_menu_default_nav_li_btn_drop').removeClass('hide2')
		}

		$.eval(this.data.fn.click, this.data.el, true);
	}
	// 隐藏
	hide(){
		this.set();
		this.ohtml.find('.ly_header_menu_ui').removeClass('cur');
		$('body').removeClass('ly_header_menu_close_pointer_event');

		// 语言切换 重置按钮
		setTimeout(()=>{
			this.ohtml.find('.ly_header_menu_default_nav_li_btn').removeClass('hide2').siblings('.ly_header_menu_default_nav_li_btn_drop').addClass('hide2');
		},100)

		$.eval(this.data.fn.click, this.data.el, false);
	}
	// 重置
	set(){
		this.ohtml.find('.ly_header_menu_ui .cur, .ly_header_menu_ui .prev').removeClass('cur prev');
	}
};


$(document).ready(()=>{
	$('[ly-header-menu]').each(function(){
		var a = new ly_header_menu($(this));
		$(this).o('ly-header-menu', a);
		a.ohtml.find('.ly_header_menu_default').o('ly-header-menu', a);
	});
});


// 点击出现侧边菜单
$(document).on('click',"[ly-header-menu]", function(event){
	var el = $(this);
	if ($('.ly_header_menu_ui').is('.cur')) {
		el.o('ly-header-menu').hide();
	} else {
		el.o('ly-header-menu').show();
	}
});

$(document).on('click',".ly_header_menu_default", function(){
	$(this).o('ly-header-menu').hide();
});
$(document).on('click',".ly_header_menu_default_wrap", function(event){
	event.stopPropagation();
});

// 侧拉导航目录点击
$(document).on('click',' .ly_header_menu_default_nav_li', function(){
	var index = $(this).attr('data-index');
	var long = $(this).attr('data-long');
	var name = $(this).attr('data-name');
	var wrap = $(this).parents('.ly_header_menu_default_wrap');
	// 有下一级的才会触发效果
	if(long == 'true'){
		var el = wrap.children(`[data-index="${index}"]`);
		var prev = el.prevAll('.cur');
		el.find('.ly_header_menu_default_subnav_back_span').html(name)
		el.addClass('cur');
		prev.addClass('prev');
		wrap.find('.ly_header_menu_default_nav').addClass('cur');
	}

});

// 侧拉导航二级目录关闭按钮
$(document).on('click','.ly_header_menu_default_subnav_back', function(){
	let index = $(this).attr('data-index');
	let wrap = $(this).parents('.ly_header_menu_default_wrap');
	let el = wrap.children(`[data-index="${index}"]`);
	let prev = el.prevAll('.prev').eq(0);
	el.removeClass('cur');
	prev.removeClass('prev');
	if(!wrap.find('.ly_header_menu_default_subnav.cur').size()){
		wrap.find('.ly_header_menu_default_nav').removeClass('cur');
	}
});