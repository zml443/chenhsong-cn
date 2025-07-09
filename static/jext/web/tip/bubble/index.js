$(document).on('mouseenter', '[ly-tip-bubble]', function(){
	__tip_bubble.init($(this));
});
$(document).on('mouseleave', '[ly-tip-bubble]', function(){
	__tip_bubble.hide($(this));
});

var __tip_bubble = {
	init: function(el){
		var content = el.attr('data-tip-contents'),
			id = el.attr('data-ly-tip-bubble-id')||$.rand('tip_bubble'),
			option = $.extend({
				direction:'top_center'
			}, $.json(el.attr('ly-tip-bubble'), 'simple')),
			position = {
				left: el[0].getBoundingClientRect().left,
				top: el[0].getBoundingClientRect().top,
				height: el.outerHeight(),
				width: el.outerWidth(),
				window_width: $(window).width(),
				window_height: $(window).height(),
			};
		el.attr('data-ly-tip-bubble-id', id);
		this.create(id, content);
		switch(option.direction){
			case 'top_center':
				this.top_center(id, position);
				break;
		}
	},
	// 生成标签
	create: function(id, content){
		if ($('.'+id).size()==0) {
			$('body').append('<div class="__tip_bubble fixed hidden '+id+'"><div class="content">'+content+'</div><div class="toward"></div></div>');
		}
	},
	// 隐藏标签
	hide: function(el){
		var id = el.attr('data-ly-tip-bubble-id'),
			bubble_el = $('.'+id);
		bubble_el.addClass('hidden').removeClass('cur');
		setTimeout(function(){
			if (bubble_el.is('.hidden')) bubble_el.removeAttr('style')
		}, 300);
	},
	// 定位 - 顶部
	top_center: function(id, position){
		var bubble_el = $('.'+id),
			bottom = position.window_height-position.top,
			left = position.left + (position.width - bubble_el.outerWidth())/2;
		bubble_el.removeClass('hidden').addClass('cur').css({left:left, bottom:bottom}).attr('data-tip-position','top_center');
	}
};