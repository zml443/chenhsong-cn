$('[jextstyle]').append(
	".placeHolder{background-color: white !important;border:dashed 1px gray !important;}"
);
$.task.push(function() {
	_('[dragsort],[drag-sort],[ly-drag-sort]').each(function(i) {
		var el = $(this),
			fn = $.callbackfn(el.attr('fn'),'change,init'),
			data = {};
		if (el.children('li,td').size()==0) {
			if (el.is('tbody')) el.prepend('<tr data-tmp></tr>');
			else el.prepend('<li data-tmp></li>');
		}
		el.addClass('notcopy');
		data.dragSelector = 'li:not([stop-drag],.stop-drag,[stopPropagation]),tr:not([stop-drag],.stop-drag,[stopPropagation])';
		data.dragSelectorExclude = '.stop-drag,[stop-drag],[stopPropagation]';
		data.dragBetween = true;
		data.dragEnd = function () {
			$.eval(fn.change, el);
		};
		if (el.is('tbody')) data.placeHolderTemplate = "<tr class='li placeHolder'></tr>";
		else data.placeHolderTemplate = "<li class='li placeHolder'></li>";
		el.dragsort(data);
		el.find('[data-tmp]').remove();
		$.eval(fn.init, el);
	});
});