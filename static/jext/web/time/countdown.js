;
/*
 * 倒计时
 * By L.t
 */
$.task.push(function () {
	_("[countdown]").each(function(index){
		var el = $(this),
			time = parseInt(el.attr('countdown')),
			day, hour, minite, second,
			sys_time = new Date().getTime(),
			fn = $.callbackfn(el.attr('fn'), 'init,change'),
			format = el.attr('format') || $.lang.notes.countdown_time;
		el.addClass('isok');
		if (time < 1000000000*10) {
			time *= 1000;
		}
		time -= sys_time;
		time /= 1000;
		time = parseInt(time);
		var si = setInterval(function () {
			ss();
			$.eval(fn.change, el, day, hour, minite, second, time);
		}, 1000);
		function nn (s) {
			if (s < 0 || isNaN(s)) s = 0; 
			return s < 10 ? '0'+s:s;
		}
		function ss () {
			time -= 1;
			// 秒
			second = Math.floor(time % 60);
			// 分
			minite = Math.floor((time / 60) % 60);
			// 小时
			hour = Math.floor((time / 3600) % 24);
			// 天
			day = Math.floor((time / 3600) / 24);
			if (day<=0 && hour<=0 && minite<=0 && second<=0) {
				clearInterval(si);
			}
			// 布局
			el.html( format.replace('{{day}}',nn(day)).replace('{{hour}}',nn(hour)).replace('{{minite}}',nn(minite)).replace('{{second}}',nn(second)) )
			// el.html(nn(day) + '天' + nn(hour) + '小时' + nn(minite) + "分" + nn(second) + "秒");
		}
		ss();
		$.eval(fn.init, el, day, hour, minite, second, time);
	});
})