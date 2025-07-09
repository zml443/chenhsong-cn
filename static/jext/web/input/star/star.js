var star_off = `<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="20"><path d="M0 384 1024 384 192 1024 512 0 832 1024Z" fill="#dbdbdb"></path></svg>`;

var star_on = `<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="20"><path d="M0 384 1024 384 192 1024 512 0 832 1024Z" fill="var(--mainColor)"></path></svg>`



$.task.push(function () {
	// 评星 1-10
	// <div star-off-on='10' fn='fn()' name='Name'></div>
	_('[star-off-on]').each(function (event) {
		var el = $(this),
			num = el.attr('star-off-on')||el.find('input').val(),
			de = '',
			re = '',
			inp = el.find('input'),
			fn = $.callbackfn(el.attr('fn'),['init','change']);
		for(var i=0; i<5; i++){
			de += `<div class="lyui-star">`+star_off+`</div>`;
			re += `<div class="lyui-star">`+star_on+`</div>`;
		}
		el.append('<div class="star-default relative max flex">'+de+'</div>');
		el.append('<div class="star-red trans absolute max flex over" style="width:'+(num*10)+'%">'+re+'</div>');
		el.addClass('relative inline-block pointer');
		$.eval(fn.init, el, num);
	});
});

$(document).on('click', '[star-off-on]', function (event) {
	var el = $(this),
		inp = el.find('input'),
		fn = $.callbackfn(el.attr('fn'),['init','change']),
		num = el.attr('data-value');
	if (!inp.is('[disabled],[readonly]')) {
		inp.val(num);
		$.eval(fn.change, el, num);
	}
});

$(document).on('mousemove', '[star-off-on]', function (event) {
	var el = $(this),
		inp = el.find('input'),
		left = el[0].getBoundingClientRect().left,
		w = el.width(),
		x = event.clientX||event.originalEvent.changedTouches[0].clientX,
		p = Math.ceil((x-left)/w*10);
	if (inp.size()==0) {
		return false;
	}
	if (!inp.is('[disabled],[readonly]')) {
		el.find('.star-red').css({width:p*10+'%'});
	}
	el.attr('data-value', p);
});

$(document).on('mouseleave', '[star-off-on]', function (e) {
	var el = $(this),
		inp = el.find('input');
	if (!inp.is('[disabled],[readonly]')) {
		el.find('.star-red').css({width:parseInt(inp.val())*10+'%'});
	}
});