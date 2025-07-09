$('[jextstyle]').append('img{min-height:1px;min-width:1px;display:inline-block}');
/*
 * 图片懒加载
 * 目前还没有加载前的提示效果和加载后的入场效果
**/
$.task.push(function(){
	var o = $('[data-src]'),
		wh = $(window).height(),
		ww = $(window).width();
	if (o.size() == 0) {
		return;
	}
	o.each(function() {
		var t = $(this);
		var h = t[0].getBoundingClientRect().top;
		var w = t[0].getBoundingClientRect().left;
		var i = t.attr('data-src');
		if (!i) {
			t.removeAttr('data-src');
			return false;
		}
		if (i && t.is('img') && !t.is('[isljz]') && !t.parents('.wrapper').size()) {
			t.css({opacity:0});
		}
		if (t.is(':visible') && (h >= 0 && h <= wh) && (w >= 0 && w <= ww)) {
			if (t.is('img')) {
				IMAGELJZ.LOAD(t, i);
			} else {
				t.css('background-image', 'url(' + i + ')');
				t.removeAttr('data-src');
			}
		}
	});
});

IMAGELJZ = {
	NUM:[0,0,0],
	LOAD: function(obj, url) {
		if (obj.is('[isljz]')) return;
		var thi = this;
		obj.attr('isljz','1');
		if (obj[0].complete) {
			thi.CALLBACK(obj, img);
		}
		else {
			obj.load(function () {
				thi.CALLBACK(obj, img);
			});
		}
	},
	CALLBACK: function(obj, img) {
		obj[0].src = img.src;
		obj.removeAttr('data-src');
		if (obj.is('[trans]') || obj.is('.trans')) {
			obj.css({opacity:1});
		} else {
			obj.animate({opacity:1});
		}
	}
};