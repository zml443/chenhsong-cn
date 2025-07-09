

$(document).on('click', '[image-show], [ly-image-show]', function () {
	$.__image_show.init($(this));
});

$.__image_show = {
	// 初始化
	init: function (el) {
		var thi = this;
		if (thi.do && thi.html) {
			thi.do(el);
			return;
		}
		$.include($.path + 'web/image/show/picture.js');
		// $.include($.path + 'web/image/picture/picture.css');
		$.async('GET', $.path + 'web/image/show/picture.html', {}, function(html){
			thi.html = html;
		}, 'html');
		thi.go(el);
		thi.loading = $.alert('loading...');
	},
	// 执行
	go: function (el) {
		var thi = this;
		if (thi.do && thi.html) {
			thi.loading.popup_remove(function(){
				thi.do(el)
			});
		} else {
			setTimeout(function(){thi.go(el)},300);
		}
	}
};

