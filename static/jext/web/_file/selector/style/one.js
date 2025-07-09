


$.task.push(function() {
	_('[file-selector][data-is-one]').each(function() {
		WP.$.__file_selector_style_one.init($(this));
	});
});


if (!WP.$.__file_selector_style_one) WP.$.__file_selector_style_one = {
	// 初始化
	init: function (a) {
		this.ui(a);
	},
	// ui样式
	ui: function (a) {
		var div = $('<div absolute max maxh maxw m-pic></div>');
		var val = (a.html()||'').replace(/^\s+|\s+$/g, '');
		a.html(div);
		if (val) {
			div.append('<img file-ext="'+val+'" />');
		}
		else {
			div.append('<i></i>');
		}
		a.attr('fn', 'WP.$.__file_selector_style_one.change(this)').append('<input type="hidden" name="'+(a.attr('name')||'')+'" value="'+val+'" />');
	},
	// 更换图片
	change: function (a, b) {
		// console.log(a);
		a.find('[m-pic]').html('<img file-ext="'+b[0].path+'">');
		a.find('input').val(b[0].path);
		a.trigger('change');
		// a.find('input,textarea').trigger('change');
	}
};