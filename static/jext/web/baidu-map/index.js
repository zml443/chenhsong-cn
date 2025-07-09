
$.task.push(function(){
	_('[ly-baidu-map]').each(function() {
		var a = $(this);
		var ary = $.json(a.html()) || {};
		mapInit(a, ary);
	});
});

// 百度地图入口函数
function mapInit(a, ary) {
	var id = ('map' + Math.random()).replace('.', '');
	var type = a.attr('map');
	a.addClass('relative').html('<div id="'+id+'" class="absolute max" style="font-size:12px;"></div>');
	if (type == '其他的地图类型') {
		// mapDefault(a, id, ary);
	} else if (type == 'GetPoint') {
		$.include($.path + 'web/map/GetPoint.js', function(){
			mapGetPoint().begin(a, id, ary);
		});
	} else {
		mapDefault(a, id, ary);
	}
}

// 默认功能
function mapDefault(a, id, ary) {
	if (typeof(ary)!='object' || !ary[0]) {
		return ;
	}
    var map = new BMap.Map(id);
    // 设置中心点
    mapPoint(ary[0], function(point, one) {
		map.addControl(new BMap.ScaleControl({anchor:BMAP_ANCHOR_TOP_LEFT}));
		map.addControl(new BMap.NavigationControl());
    	map.centerAndZoom(point, one.zoom?one.zoom:16);
		mapInfoWindow(map, one, point);
    });
    for (var i in ary) {
	    mapPoint(ary[i], function(point, one) {
			var marker = new BMap.Marker(point);
			map.addOverlay(marker);
			mapInfoWindowCilck(marker, map, one, point);
	    });
	}
}

// 设置坐标点，在不知道是否存在坐标的情况下
function mapPoint(one, callback) {
	var type = typeof(one.point);
	if (type.search(/array|object/) >= 0 && one.point.length > 1) {
		var point = new BMap.Point(one.point[0], one.point[1]);
		callback(point, one);
	}else mapGeocoder(one, callback);
}

// 地址解析器
function mapGeocoder(one, callback) {
	new BMap.Geocoder().getPoint(typeof(one) == 'object' ? one.address : one, function(point) {
		var point = new BMap.Point(point.lng, point.lat);
		if (point) {
			callback(point, one);
		} else {
			WP.$.alert("您选择地址没有解析到结果!", 2500);
		}
	}, "");
}

// 给覆盖物添加点击事件
function mapInfoWindowCilck(marker, map, one, point) {
    marker.addEventListener('click', function(e) {
	    mapInfoWindow(map, one, point);
    });
}
// 信息窗口
function mapInfoWindow(map, one, point) {
	if (one.tips == 'search') {
		mapInfoWindow0(map, one, point);
	} else {
		mapInfoWindow1(map, one, point);
	}
}
// 带搜索框
function mapInfoWindow0(map, one, point) {
	one = one || {message:one};
	var a = new BMapLib.SearchInfoWindow(map, one.message, {
		title  : one.title,
		width  : 290,
		height : 105,
		panel  : 'panel',
		enableAutoPan : true,
		searchTypes   :[
			BMAPLIB_TAB_SEARCH,
			BMAPLIB_TAB_TO_HERE,
			BMAPLIB_TAB_FROM_HERE
		]
	});
	a.open(point);
}
// 很普通的弹窗
function mapInfoWindow1(map, one, point) {
	one = one || {message:one};
	var opts = {
		title : one.title,
	};
	map.openInfoWindow(new BMap.InfoWindow(one.message, opts), point);
}
