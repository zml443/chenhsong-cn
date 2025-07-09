
// 输入框跳转分页
$(document).on('keyup', '.lyui_paging_label input', function(event){
	var el = $(this);
	var parent_el = el.parent();
	var go_el = parent_el.next();
	var val = parseInt(el.val())||0;
	var pm = parent_el.attr('data-pm')||'';
	var href = pm.replace(/\{#pm#\}/,val);
	go_el.attr({'href': href});
	el.val(val);
	if (event.keyCode=='13') {
		go_el.trigger('click');
	}
});

// 点击分页无刷新效果
$(document).on('click dblclick', '.lyui_paging_btn, .lyui_paging_go, .lyui_paging_prev, .lyui_paging_next', function(){
	var el = $(this);
	var fn = $.callbackfn(el.attr('fn'),'before,after,error');
	var href = el.attr('hr-ef')||el.attr('href');
	if (!href) {
		return false;
	}
	if ($.G.event.paging.ajax_change) {
		$.eval(fn.before, el, '');
		if ($.G.event.paging.before) $.G.event.paging.before();
		$.async('GET', href, {}, result=>{
			var body = $($.htmlbody(result));
			$.G.event.paging.ajax_change.map(v=>{
				$('[ajax-change="'+v+'"]').html(body.find('[ajax-change="'+v+'"]').html());
			});
			$.eval(fn.after, el, result);
			if ($.G.event.paging.after) $.G.event.paging.after(result);
		});
	} else {
		location.href = href
	}
	return false;
});