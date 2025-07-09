
/********************屏幕自适应**********************/
var viewport = {
	init: function(width) {
		var thi = this;
		thi.width = width;
		$(window).on('orientationchange resize', function(e) {
			thi.set();
		});
		thi.set();
	},
	set: function() {
		var thi = this;
		$('meta[name="viewport"]').remove();
		if(thi.orient()){
			var phoneWidth = parseInt(window.screen.height);
		}else{
			var phoneWidth = parseInt(window.screen.width);
		}
		var phoneScale = phoneWidth / thi.width;
		var userAgent = navigator.userAgent;
		var index = userAgent.indexOf('Android');
		if (index >= 0) {
			var androidVersion = parseFloat(userAgent.slice(index+8));
			if (androidVersion > 2.3) {
				$('head:eq(0)').append('<meta name="viewport" content="width='+thi.width+', initial-scale='+phoneScale+', minimum-scale='+phoneScale+', maximum-scale='+phoneScale+',user-scalable=no, target-densitydpi=device-dpi">');
			} else {
				$('head:eq(0)').append('<meta name="viewport" content="width='+thi.width+', target-densitydpi=device-dpi">');
			}
		} else {
			$('head:eq(0)').append('<meta name="viewport" content="width='+thi.width+', initial-scale='+phoneScale+', minimum-scale='+phoneScale+', maximum-scale='+phoneScale+',user-scalable=no, target-densitydpi=device-dpi">');
		}
		// $('html').css({margin:'auto', width:thi.width});
	},
	orient: function() {
		if (window.orientation == 90 || window.orientation == -90) {
			return 1;
		} else if (window.orientation == 0 || window.orientation == 180) {
			return 0;
		}
	}
};
VIEWPORTWIDTH=typeof(VIEWPORTWIDTH)=='undefined'?750:(VIEWPORTWIDTH||750);
viewport.init(VIEWPORTWIDTH);
/********************屏幕自适应**********************/