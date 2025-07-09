
$.task.push(function(){
	_('[mine-scroll]').minescroll();
});

$.fn.extend({
	/**************************************************
	独自一人的滚动
	$('.asd').minescroll();
	**************************************************/
	minescroll: function() {
		var a = {
			obj: this,
			x: 0,
			y: 0
		};
		var s = {
			i: function() {
				if (a.obj.length <= 0) {
					return 0;
				}
				var $sj = $.mobile() ? 'touchmove' : 'mousewheel';
				a.obj.on('touchstart', function(e) {
					a.y = e.pageY ? e.pageY : e.originalEvent.changedTouches[0].pageY;
					a.x = e.pageX ? e.pageX : e.originalEvent.changedTouches[0].pageX;
				});
				a.obj.on($sj, function(event, delta, x, y) {
					return s.m(event, delta, x, y, this);
				});
			},
			m: function(e, delta, x, y, s) {
				if ($.mobile()) {
					y = e.pageY ? e.pageY : e.originalEvent.changedTouches[0].pageY;
					x = e.pageX ? e.pageX : e.originalEvent.changedTouches[0].pageX;
					s.scrollTop = s.scrollTop - y + a.y;
					a.y = y;
					a.x = x;
					e.stopPropagation();
					e.preventDefault();
					$(s).scrollTop(s.scrollTop);
				} else {
					if (window.mineisbegin) {
						return false;
					}
					window.mineisbegin = 1;
					$(s).animate({scrollTop: s.scrollTop - (y>0 ? 120 : -120)}, 150, function() {
						window.mineisbegin = 0;
					});
				}
			    return false;
			}
		};
		s.i();
		return this;
	}
});