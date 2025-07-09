// 百度地图检索坐标
function mapGetPoint(){
var BDGp = {
	// 状态记录
	state: {},
	// 将用户选择的信息都放在这里
	marker: {
		box: '',
		list: {},
		marker: {},
		point: {}
	},
	// 开始执行
	begin: function(a, id, ary){
	    var map = BDGp.map = new BMap.Map(id);
	    BDGp.a = a;
	    BDGp.b = $('<div absolute></div>').css({width:300, right:-500, top:0, bottom:0, background:'#fff', boxShadow:'0 0 29px rgba(0,0,0,.4)'});
	    a.append(BDGp.b).addClass('over relative');
	    // {}
	    mapGeocoder('深圳市', function(point){
	    	map.centerAndZoom(point, 12);
	    });
	    map.addControl(new BMap.NavigationControl({
			anchor: BMAP_ANCHOR_TOP_LEFT,
			offset: new BMap.Size(10, 20)
		}));
		map.enableScrollWheelZoom();
		map.addControl(new BMap.CityListControl({
			anchor: BMAP_ANCHOR_TOP_LEFT,
			offset: new BMap.Size(80, 27)
		}));
		// 自定义搜索框
		function searchControl(){
			this.defaultAnchor = BMAP_ANCHOR_TOP_LEFT;
			this.defaultOffset = new BMap.Size(80, 56);
		}
		searchControl.prototype = new BMap.Control();
		searchControl.prototype.initialize = function(map) {
			var div = $('<div text></div>');
			var mia = $(
				'<div marker relative text-center>' +
					'<i class="jxi-dingwei" pointer></i>' +
					'<div list hide absolute text-left><div mcscroll><div cont></div></div></div>' +
				'</div>'
			);
			div.append('<input type="text" maxh maxw v-top /><div class="jxi-search v-top inline-block pointer"></div>');
			div.css({height:'24px', lineHeight:'24px', border:'1px solid #c4c7cc', backgroundColor:'#fff', zIndex:9});

			div.find('input').css({textIndent:'10px',width:'200px'}).
			focus(function(){
				$(this).select();
			});

			div.find('div').css({padding:'0 8px',fontSize:'14px'}).
			click(function(e){
				var v = div.find('input').val();
				if(v) mapGeocoder(v, function(point) {
					map.centerAndZoom(point, 15);
				});
			});

			mia.css({width:40, height:40, lineHeight:'40px', border:'1px solid #c4c7cc', backgroundColor:'#fff', borderRadius:3, marginTop:3}).
			hover(function(){
				$(this).find('[list]').show().find('[cont]').css({padding:'12px'});
			}, function(){
				$(this).find('[list]').hide();
			}).
			children('i').css({fontSize:'23px', color:'#999'}).end().
			find('[list]').css({left:'100%', top:0, lineHeight:1.8}).
			find('[mcscroll]').css({marginLeft:5, width:160, maxHeight:300, minHeight:200, backgroundColor:'#fff', borderRadius:3, border:'1px solid #c4c7cc'});

			BDGp.marker.box = $('<div></div>').append(div).append(mia);
			map.getContainer().appendChild(BDGp.marker.box[0]);
			return BDGp.marker.box[0];
		};
    	map.addControl(new searchControl());
    	BDGp.mapClick(map);
	    for(var i in ary){
	    	mapPoint(ary[i], function(point, one){
    			BDGp.markerLog(point, one);
				BDGp.markerList();
	    	});
	    }
	},
	// 给地图添加点击事件
	mapClick: function(map){
    	map.addEventListener('click', function(e){
    		// 判断是否允许添加覆盖物
    		if(BDGp.state.addMarker != 1){
    			BDGp.state.addMarker = 1;
    			var marker = BDGp.markerLog(e.point);
				new BMap.Geocoder().getLocation(e.point, function(rs){
					var addComp = rs.addressComponents;
					BDGp.marker.list[marker.ba].address = addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber;
					BDGp.listInfo(marker);
					BDGp.callback();
					BDGp.state.addMarker = 0;
				});
    		}
    	});
	},
	// 添加覆盖物，并且记录
	markerLog: function(point, one){
		var marker = new BMap.Marker(point);
		BDGp.map.addOverlay(marker);
		marker.enableDragging();
		BDGp.markerListener(marker);
		BDGp.marker.point[marker.ba] = point;
		BDGp.marker.marker[marker.ba] = marker;
		BDGp.marker.list[marker.ba] = one||{};
		BDGp.marker.list[marker.ba].ba = marker.ba;
		BDGp.marker.list[marker.ba].point = [point.lng, point.lat];
		return marker;
	},
	// 给新建的覆盖物添加监听事件
	markerListener: function(marker){
		marker.addEventListener('click', function(){
			event.stopPropagation();
			BDGp.listInfo(marker);
		});
		marker.addEventListener("dragend", function(){
			var p = marker.getPosition();
			BDGp.marker.list[marker.ba].point = [p.lng, p.lat];
			BDGp.listInfo(marker);
			// BDGp.windowInfo(marker);
			BDGp.callback();
		});
	},
	// 展示所有选择的点
	markerList: function(marker){
		var htm = '',
			j = 0;
		for(var i in BDGp.marker.list){
			j++;
			var val = BDGp.marker.list[i];
			htm += '<div pointer ba="'+val.ba+'" text-over>'+j+'. '+(val.title||val.address||val.message||'未编辑信息')+'</div>';
		}
		BDGp.marker.box.find('[marker] [list] [cont]').html(htm).
		find('[ba]').css({lineHeight:'22px', color:'#888'}).
		click(function(){
			var ba = $(this).attr('ba');
			BDGp.listInfo(BDGp.marker.marker[ba]);
		});
	},
	// 编辑覆盖物的信息
	listInfo: function(marker) {
		var htm = '', list = BDGp.marker.list[marker.ba];
		htm += '<div><input type="hidden" name="ba" value="'+(list.ba||'')+'" /></div>';
		htm += '<div a><span remove pointer>移除标点</span></div>';
		htm += '<div a>标题：<input type="text" maxw name="title" value="'+(list.title||'')+'" /></div>';
		htm += '<div a>地址：<input type="text" maxw name="address" value="'+(list.address||'')+'" /></div>';
		htm += '<div a>内容：<textarea type="text" maxw name="message">'+(list.message||'')+'</textarea></div>';
		htm += '<div b over pointer absolute><div class="jxi-youjiantou-01"></div></div>';
		BDGp.b.html('<form>'+htm+'</form>').animate({right:0},300);
		BDGp.b.find('form').css({padding:'18px', fontSize:'12px'});
		BDGp.b.find('[a]').css({marginTop:9, lineHeight:'24px'});

		BDGp.b.find('[b]').css({top:'50%', marginTop:-25, right:'100%', width:20}).
		click(function(){
			BDGp.listInfoClose(marker);
		}).
		children().css({lineHeight:'51px', height:50, width:50, textIndent:9, borderRadius:50, background:'#fff'});

		BDGp.b.find('[remove]').css({color:'red'}).click(function(){
			BDGp.listInfoClose(marker, 1);
		});

		BDGp.b.find('input,textarea').css({border:'1px solid #c4c7cc', height:26, lineHeight:'26px', textIndent:'6px'});
		BDGp.b.find('textarea').css({height:120, lineHeight:'20px', padding:'6px 0', resize:'none'});
		BDGp.b.find('input,textarea').on('change keyup',function(){
			var fo = BDGp.b.find('form').serializeArray();
			for(var i in fo){
				var name = fo[i].name, value = fo[i].value;
				BDGp.marker.list[marker.ba][name] = value;
			}
			BDGp.callback();
		});
		BDGp.windowInfo(marker);
	},
	// 删除覆盖物的信息
	listInfoClose: function(marker,isRemove){
		if(isRemove==1){
			delete(BDGp.marker.list[marker.ba]);
			delete(BDGp.marker.marker[marker.ba]);
			BDGp.map.removeOverlay(marker);
		}
		BDGp.map.closeInfoWindow(BDGp.marker.point[marker.ba]);
		BDGp.b.animate({right:-500}, 300, function(){
			BDGp.b.html('');
			BDGp.callback();
		});
	},
	// 窗口提示
	windowInfo: function(marker){
		BDGp.marker.point[marker.ba] = marker.point;
		var list = BDGp.marker.list[marker.ba];
		var infoWindow = new BMap.InfoWindow(list.title||list.address||list.message||'未编辑信息', {});
		BDGp.map.openInfoWindow(infoWindow, BDGp.marker.point[marker.ba]);
		BDGp.map.centerAndZoom(BDGp.marker.point[marker.ba], 15);
	},
	// 回调函数
	callback: function(){
		BDGp.markerList();
		$.eval(BDGp.a.attr('fn'), BDGp.a, BDGp.marker.list);
	}
};
return BDGp;
}