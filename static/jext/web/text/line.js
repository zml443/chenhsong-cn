// 文字省略
$.__text_line = {
	/**
	 * 裁剪字数
	 * @param {DOM} o 目标节点
	 * @return {void}
	 */
	str: {},
	start: function (o) {
		if (o.is('[text-line-rand]')) {
			var r = o.attr('text-line-rand');
		}
		else {
			var r = Math.random();
			o.attr('text-line-rand', r);
			this.str[r] = $('<div>'+o.html().replace(/<br\s*>/g,'`')+'</div>').text();
		}
		o.addClass('line-isok');
		var t = this.str[r];
		var s = o.attr('text-line');
		var l = 0;
		if (s.indexOf('{')==0) {
			var winW = $(window).width();
			s = $.json(s, 'simple');
			s = Object.keys(s).sort().reduce(function(v, k){
				v[k]=s[k];
				return v;
			},{});
			for (var i in s) {
				if (parseInt(i)<winW) {
					l = parseInt(s[i]);
				}
			}
		}
		else {
			l = parseInt(s);
		}
		var f = parseInt(o.css('font-size'));
		var h = parseInt(o.css('line-height'));
		var w = o.width();
		var n = this.len(t);
		var c = parseInt(w/f)*l;
		var x = w>200 ? 1.7 : 1.6;
		if (!c) o.removeClass('line-isok');
		if (l==0 || !c) {
			o.html(t);
		}
		else if (c*2<n) {
			var s = this.cut(t, c*x);
			o.html(s.replace(/`/,'<br>')+'...');
		}
	},
	/**
	 * 计算字符串的长度
	 * @param {string} val 字符串
	 * @return {int}
	 */
	len: function (str) {
        var len = 0;
        for (var i=0; i<str.length; i++) {
            var a = str.charAt(i);
            if (a.match(/[^\x00-\xff]/ig)!=null) {
                len += 2;
            }
            else {
                len += 1;
            }
        }
        return len;
	},
	/**
	 * 字符串截取 包含对中文处理
	 * @param {string} str 字符串
	 * @param {int} n 截取的长度
	 * @return {string}
	 */
	cut: function (str, n) {
		let len = 0;
		let tmpStr = '';
		for (let i=0; i<str.length; i++) {
			if (/[\u4e00-\u9fa5]/.test(str[i])) { // 判断为中文  长度为三字节（可根据实际需求更换长度，将所加长度更改即可）
				len += 2;
			} else {  // 其余则长度为一字节
				len += 1;
			}
			if (len>n) {
				break;
			} else {
				tmpStr += str[i];
			}
		}
		return tmpStr;
	}
};
// 定时任务 - 初始执行文字缩略
$.task.push(function(){
	$('[text-line]:not(.line-isok)').each(function(){
		$.__text_line.start($(this));
	});
});
// 屏幕尺寸改变 - 执行文字缩略
$(window).resize(function(){
	$('[text-line-rand]').each(function(){
		$.__text_line.start($(this));
	});
});