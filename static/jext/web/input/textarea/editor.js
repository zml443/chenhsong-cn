
$.__my_editor = function (obj, option) {
	this.cfg = {
		obj: obj.children('[contenteditable]'),
		textarea: obj.children('textarea'),
		type: obj.attr('editor'),
		option: option || {}
	};
	this.init();
};
$.__my_editor.prototype = {
	change_time: '',
	init: function () {
		var thi = this;
		clearTimeout(thi.change_time);
		thi.change_time = setTimeout(function () {
			thi.change();
		},600);
	},
	change: function () {
		// var thi = this;
		var html = this.html();
		// this.cfg.obj.html(html);
		this.cfg.textarea.val(html).trigger('change');
	},
	// 
	html: function () {
		var html = '';
		switch (this.cfg.type) {
			case 'xxx':
				break;

			// 默认
			default: 
				this.cfg.obj.children().each(function (i) {
					var a = $(this);
					a.removeAttr('style');
					if (a.is('br')) {
						a.remove();
					}
					else if (!a.is('div') || a.children().size()) {
						a.replaceWith(function() { return '<div>'+(a.text()||'<br>')+'</div>'; });
					}
				});
				break;
		}
		return this.cfg.obj.html();
	}
};

// 事件
$(document).on('input', '[myeditor]>[contenteditable]', function () {
	if (!$(this).is('.is-composition-ing')) new $.__my_editor($(this).parent());
});
$(document).on('compositionstart', '[myeditor]>[contenteditable]', function () {
	$(this).addClass('is-composition-ing');
});
$(document).on('compositionend', '[myeditor]>[contenteditable]', function () {
	$(this).removeClass('is-composition-ing').trigger('input');
});