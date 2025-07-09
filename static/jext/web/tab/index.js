__tab_fn_ = {
	trans_name: '.trans,.trans3-3,.trans3-4,.trans3-5,.trans3-6,.trans3-7,.trans3-8,.trans5-3,.trans5-4,.trans5-5,.trans5-6,.trans5-7,.trans5-8',
	deal: function (type, current) {
		var el = current.parent(),
			to_el = $(el.attr('to')),
			index = current.attr('tab-index'),
			fn = $.callbackfn(el.attr('fn'),'init,change'),
			currented = current.is('.cur');
		var data = {};
		var to_cur_el = [];
		current.addClass('cur').siblings().removeClass('cur').addClass('not_cur');
		el.children('[tab-index="'+index+'"]').addClass('cur');
		to_el.each(function(){
			$(this).children('[tab-index="'+index+'"]').addClass('cur').removeClass('absolute goaway').siblings().removeClass('cur').addClass('absolute goaway');
			to_cur_el.push($(this).children('[tab-index="'+index+'"]'));
		});
		setTimeout(function() {
			if (type=='init') {
				if (!el.is('[data-not-init-cur]')) current.find(__tab_fn_.trans_name).addClass('clear-delay');
			} else {
				current.find(__tab_fn_.trans_name).addClass('clear-delay');
			}
			current.siblings().find(__tab_fn_.trans_name).removeClass('clear-delay');
		}, 500);
		data.el = el;
		data.cur_el = current;
		data.to_el = to_el;
		data.to_cur_el = to_cur_el;
		data.index = index;
		switch (type) {
			case 'init':
				if (to_el.size()) $.eval(fn.init, el, data);
				else $.eval(fn.init, el, data);
				break;
			case 'change':
				if (currented) break;
				if (to_el.size()) $.eval(fn.change, el, data);
				else $.eval(fn.change, el, data);
				break;
		}
	}
};
$.task.push(function () {
	_('[tab],[ly-tab]').each(function () {
		var el = $(this),
			bind = $(el.attr('to')),
			fn = $.callbackfn(el.attr('fn'),'init,change');
		if (el.find('[tab-index]').size()==0) {
			el.children().each(function(i){
				$(this).attr('tab-index', i);
			});
			bind.each(function(){
				$(this).children().show().each(function(i){
					$(this).attr('tab-index', $(this).attr('index')||i);
				});
			});
		}
		var cur = el.children('.cur');
		if (cur.size()==0) cur = el.children().eq(0);
		if (!el.is('[data-not-init-cur]')) cur.find(__tab_fn_.trans_name).addClass('clear-delay');
		__tab_fn_.deal('init', cur);
	});
});

$(document).on('click', '[tab] >*,[ly-tab] >*', function (event) {
	__tab_fn_.deal('change', $(this));
});
$(document).on('mouseover', '[tab*="hover:"] >*,[tab*="hover :"] >*, [ly-tab*="hover:"] >*,[ly-tab*="hover :"] >*', function(e) {
	__tab_fn_.deal('change', $(this));
});
$(document).on('mouseleave', '[ly-tab][data-leave] >*', function(e) {
	$(this).removeClass('cur not_cur').siblings().removeClass('cur not_cur');
	setTimeout(()=> {
		// $(this).find(__tab_fn_.trans_name).addClass('clear-delay');
		$(this).parent().find(__tab_fn_.trans_name).removeClass('clear-delay');
	}, 500);
});