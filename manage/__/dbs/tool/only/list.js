var _type_for_only = {
	click: function (el, checked) {
		var name = el.attr('name');
		el.addClass('tmpl-class-');
		var tm = $('[name="'+name+'"]:not(.tmpl-class-)');
		tm.removeAttr('checked').parents('label').removeClass('cur');
		el.removeClass('tmpl-class-');
	}
};