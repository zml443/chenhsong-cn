$.fn.extend({
	// 鼠标移的距离
	// $('.title').move('.div',{});
	moveDIV: function(a, option) {
		var thi = this,
			option = $.extend({
				x: 1,
				y: 1,
				space: [0,0,0,0],
			}, option),
			a = $(a),
			box = option.box==window ? $(window) : a.parent(),
			isbox = option.box && box.size(),
			boxi = {},
			x, y, l, t, start, end, left, top, xy0, xy1,
			down = $.mobile() ? 'touchstart' : 'mousedown',
			move = $.mobile() ? 'touchmove' : 'mousemove',
			up = $.mobile() ? 'touchend' : 'mouseup';
		function get_xy (e) {
			if ($.mobile()) {
				var x = e.originalEvent.changedTouches[0].pageX;
				var y = e.originalEvent.changedTouches[0].pageY;
			} else {
				var x = e.pageX;
				var y = e.pageY;
			}
			return [x, y];
		}
		function ratio (lt) {
			var l0 = boxi.maxL - boxi.minL,
				t0 = boxi.maxT - boxi.minT,
				l1 = lt[0] - boxi.minL,
				t1 = lt[1] - boxi.minT,
				l = l0?l1/l0:1,
				t = t0?t1/t0:1;
			return {left:l>1?1:l, top:t>1?1:t};
		}
		thi.find('input,textarea,.stopmove').on(down, function(e) {
			e.stopPropagation();
		});
		thi.addClass('notcopy').on(down, function(e0) {
			if (e0.which==3 || thi.is('.stopmove') || a.is('.stopmove')) { //右键
				return;
			}
			var mx = a.matrix();
			var lt = [mx[4], mx[5]];
			if (isbox) {
				boxi.minL = (box.offset().left||0) - (a.offset().left||0) + lt[0] + (option.space[0]||0);
				boxi.minT = (box.offset().top||0) - (a.offset().top||0) + lt[1] + (option.space[1]||0);
				boxi.maxL = box.outerWidth() - a.outerWidth() + boxi.minL - (option.space[2]||0);
				boxi.maxT = box.outerHeight() - a.outerHeight() + boxi.minT - (option.space[3]||0);
			}
			e0.preventDefault();
			var xy0 = get_xy(e0);
			if ($.mobile() && e0.originalEvent.touches.length > 1) {
				start = e0.originalEvent.touches;
				var hy0 = 0, hy1 = 0;
			}
			$('body').addClass('notcopy');
			a.removeClass('donotmove trans5');
			if (option.down) {
				option.down.call(thi,{x:0, y:0, left:lt[0], top:lt[1], scale:1, ratio:ratio(lt)});
			}
			$(window).on(move, function(e1) {
				if (a.is('.donotmove')) {
					return;
				}
				if ($.mobile() && e1.originalEvent.touches.length>1) {
					function distance(p1, p2) {
						var x = p2.pageX - p1.pageX,
							y = p2.pageY - p1.pageY;
						return Math.sqrt((x*x) + (y*y));
					}
					end = e1.originalEvent.touches;
					if (!hy0) hy0 = distance(start[0], start[1]);
					hy1 = distance(end[0], end[1]);
					var scale = hy0 > hy1 ? -0.05 : 0.05;
					if (hy0!=hy1 && option.scale) {
						hy0 = hy1;
						option.scale(hy0 > hy1 ? -scale : scale);
					}
					return;
				}
				var xy1 = get_xy(e1);
				x = xy1[0] - xy0[0];
				y = xy1[1] - xy0[1];
				l = lt[0] + x;
				t = lt[1] + y;
				if (isbox) {
					if (l<boxi.minL) l = boxi.minL; 
					if (l>boxi.maxL) l = boxi.maxL;
					if (t<boxi.minT) t = boxi.minT; 
					if (t>boxi.maxT) t = boxi.maxT;
				}
				if (option.x) {
					mx[4] = l;
				}
				if (option.y) {
					mx[5] = t;
				}
				a.matrix(mx);
				if (option.move) {
					option.move.call(thi, {x:x, y:y, left:l, top:t, scale:1, ratio:ratio([l,t])});
				}
			}).off(up).on(up, function(e2) {
				$(window).off(move);
				$(window).off(up);
				$('body').removeClass('notcopy');
				a.addClass('donotmove');
				if (option.up) {
					option.up.call(thi, {x:x, y:y, left:l, top:t, scale:1, ratio:ratio([l,t])});
				}
			});
		});
		return thi;
	}
});