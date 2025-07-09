

$.task.push(function () {
	_('[input-placeholder]').each(function() {
		var el = $(this),
			parent = el.parent(),
			input = parent.find('input');
		el.addClass('visible');
		input.on('focus', function () {
			el.addClass('focus');
		}).on('keyup keydown blur load', function (event) {
			var val = ($(this).val()||'').replace(/\s+/g,'');
			if (val) {
				el.addClass('has_value');
			} else {
				el.removeClass('has_value');
			}
			if (event.type=='blur') el.removeClass('focus');
		});
		input.trigger('load');
	});
});

$(document).on('reset', 'form', function () {
	$(this).find('[input-placeholder]').each(function () {
		var el = $(this),
			parent = el.parent(),
			input = parent.find('input'),
			val = (input.val()||'').replace(/\s+/g,'');
		if (val) {
			el.addClass('has_value');
		} else {
			el.removeClass('has_value');
		}
	});
});