var _ajax_page_result = {
	decode: function (html) {
		return (html||'').replace(/ -src/g, ' src').replace(/myscript/g, 'script');
	},
	encode: function (html) {
		return (html||'').replace(/ src/g, ' -src').replace(/<script/g, '<myscript').replace(/<\/script/g, '<\/myscript');
	}
};

$.task.push(()=>{
	_('[ajax-append][visible]').visible({
		loop: 1,
		show(el){
			if (!el.is('.isstart') && !el.is('.isend')) el.click();
		},
	});
});

// 简单的ajax加载分页
$(document).on('click dblclick', '[ajax-append],[ajax-page]', function (e) {
	var el = $(this),
		option = $.json(el.attr('ajax-append')||el.attr('ajax-page'),'simple'),
		to = el.attr('to'),
		fn = $.callbackfn(el.attr('fn'),'success,start,end'),
		formdata = el.is('form')?el.serializeArray():{},
		href = (el.attr('href')||window.location.href).replace(/#(.*)$/,'').replace(/[\?&]pg=[^&]*/g,''),
		cur;
	option.page = parseInt(el.attr('data-page')||option.page||option.pg||0);
	option.total_page = parseInt(option.total_page);
	if (el.is('.isstart') || el.is('.isend') || (location.href.search(/iframe-view=/)>0&&location.href.search(/preview=/)<0)) {
		return false;
	}
	if (href.indexOf('?')>=0) {
		href += '&';
	} else {
		href += '?';
	}
	el.addClass('isstart');
	$.eval(fn.start, el, $(to));
	$.async('POST', href+'pg='+option.page, formdata, result=>{
		el.removeClass('isstart');
		result = $.htmlbody(_ajax_page_result.encode(result), 1);
		con = _ajax_page_result.decode($(result).find(to).html()||"").replace(/^\s+|\s+$/g, '');
		if (con) {
			if ($(to).is('[masonry-rand]')) {
				$.masonry_append(to, con);
			} else if ($(to).parents('[masonry-rand]').size()) {
				$.masonry_append($(to).parents('[masonry-rand]:eq(0)'), con);
			} else if (el.is('[ajax-page]')) {
				$(to).html(con);
			} else {
				$(to).append(con);
				$(to).css({height:'auto'});
			}
			$.eval(fn.success, el, $(to));
			el.attr('data-page', ++option.page);
			if (option.total_page&&option.page>option.total_page) {
				el.addClass('isend');
				$.eval(fn.end, el, $(to));
			}
		} else {
			el.addClass('isend');
			$.eval(fn.end, el, $(to));
		}
		setTimeout(function(){
			el.removeClass('visible-stop visible-executed');
		}, 600);
	}, 'html');
	return false;
});


$(document).on('click dblclick', '[ajax-href]', function (e) {
	var el = $(this),
		href = el.attr('href')||'',
		to = el.attr('to'),
		tos = (to||'').split(','),
		title;
	if (el.is('.isstart')) {
		return false;
	}
	el.addClass('isstart');
	window.history.replaceState(null, '', href);
	$.async('GET', href, {}, function(result){
		title = result.match(/<title>(.*)<\/title>/i);
		if (title&&title[1]) {
			$('title').html(title[1]);
		}
		el.removeClass('isstart');
		result = _ajax_page_result.encode(result);
		result = $.htmlbody(result,1);
		for (var i in tos) {
			var content = _ajax_page_result.decode($(result).find(tos[i]).html());
			$(tos[i]).html(content);
		}
	}, 'text');
	return false;
});