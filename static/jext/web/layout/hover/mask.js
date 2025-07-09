// 鼠标移过事件 - 导航鼠标移过效果
$(document).on('mouseover', '[hover-mask]>*:not(.thehovermaskbg)', function () {
	var a = $(this);
	var p = a.parent();
	var i = p.find('.thehovermaskbg'),
		i = i.size() ? i : p.siblings('.thehovermaskbg'),
		p = i.parent();
	var jso = $.json(p.attr('hover-mask'), 'simple');

	if (jso.outer) {
		var w = a.outerWidth();
		var h = a.outerHeight();
		var l0 = p[0].getBoundingClientRect().left;
		var l1 = a[0].getBoundingClientRect().left;
	}
	else {
		var w = a.width();
		var h = a.height();
		var l0 = p[0].getBoundingClientRect().left;
		var l1 = a[0].getBoundingClientRect().left + parseInt(a.css('padding-left')||0);
	}
	a.addClass('tmp-cur').siblings().removeClass('tmp-cur');
	
	if (jso.block) {
		if (!jso.outer) {
			w += 30;
			l1 -= 15;
		}
		i.css({width:w, height:h, left:l1-l0});
	}
	else if (jso.line) {
		i.css({width:9999+l1-l0+w});
	}
	else {
		i.css({width:w, left:l1-l0});
	}
	if (typeof(jso.top)!='undefined') {
		i.css({top:jso.top+'px'});
	}
	if (typeof(jso.bottom)!='undefined') {
		i.css({bottom:jso.bottom+'px'});
	}
});

// 鼠标移过事件 - 导航鼠标移过效果
$(document).on('mouseleave', '[hover-mask]>*:not(.thehovermaskbg)', function () {
	var a = $(this);
	var p = a.parent();
	var jso = $.json(p.attr('hover-mask'), 'simple');
	a.removeClass('tmp-cur');
	p.find('.mask-cur').trigger('mouseover');
});

// 为目标效果添加效果标签
$.task.push(function () {
	_('[hover-mask]').each(function(){
		var p = $(this);
		var c = p.children('.cur');
		var jso = $.json(p.attr('hover-mask'), 'simple');
		if (c.size()==0 && jso.line) {
			c = p.children(':not(.thehovermaskbg)').eq(0);
		}
		if (p.is('.wrapper') && p.parent().is('.container')) {
			p.before('<i class="thehovermaskbg absolute trans"></i>');
		}
		else {
			p.prepend('<i class="thehovermaskbg absolute trans"></i>');
		}
		c.addClass('mask-cur').trigger('mouseover');
	});
});

$.eval('ready', function () {
	$('[hover-mask]>*.cur:not(.thehovermaskbg)').trigger('mouseover');
});