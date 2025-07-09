// 文字省略
$.__text_scale = {
	/*
	 * 裁剪字数
	 * @param {DOM} o 目标节点
	 * @return {void}
	 */
	start: function (o) {
		if (o.is('[text-scale-rand]')) {
			var r = o.attr('text-scale-rand');
		}
		else {
			var r = Math.random();
			o.attr('text-scale-rand', r);
			this.str[r] = $('<div>'+o.html().replace(/<br\s*>/g,'`')+'</div>').text();
		}
		var t = this.str[r];
		var l = parseInt(o.attr('text-scale'));
		var f = parseInt(o.css('font-size'));
		var h = parseInt(o.css('line-height'));
		var w = o.width();
		var n = this.len(t);
		var c = parseInt((w/f)*l);
		if (c*2<n) {
			var s = this.cut(t, c*1.7);
			o.height(h*l).html(s.replace(/`/,'<br>')+'...');
		}
	},
};

$.task.push(function(){
	_('[text-scale]').each(function(){
		$.__text_scale.start($(this));
	});
});
$(window).resize(function(){
	$('[text-scale]').each(function(){
		$.__text_scale.start($(this));
	});
});