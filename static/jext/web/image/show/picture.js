
$.__image_show.do = function (a) {
	var thi = this;
	var pic = (a.attr('ly-image-show')||a.attr('image-show')).split('|');
	var img = [],
		t = 0;
	$('[ly-image-show],[image-show]').each(function () {
		var p = ($(this).attr('ly-image-show')||$(this).attr('image-show')).split('|');
		if (p[0]==pic[0]) {
			img.push(p[1]);
			if (p[1]==pic[1]) t=img.length-1;
		}
	});
	var p = {
		scale: 1,
		i: function(){
			p.m();
		},
		m:function(){
			WP.$('body').append(thi.html);
			p.im = WP.$('#jximageshow .imgbox img');
			if ($.mobile()) {
				$('#jximageshow .icobox').addClass('hover_cur hover_cur_1');
			}
			WP.$('#jximageshow [zoom]').on('click',function(){
				p.s(p.scale+=parseFloat($(this).attr('zoom')));
			});
			WP.$('#jximageshow [zoomto]').on('click',function(){
				p.s(parseFloat($(this).attr('zoomto')));
			});
			WP.$('#jximageshow [jp-close]').on('click',function(){
				WP.$('#jximageshow').remove();
			});
			WP.$('#jximageshow .prev').on('click',function(){
				if(t>0&&!p.go){
					p.a(--t);
				}
			});
			WP.$('#jximageshow .next').on('click',function(){
				if(t<img.length-1&&!p.go){
					p.a(++t);
				}
			});
			WP.$('#jximageshow .imgbox').move(WP.$('#jximageshow .imgbox img'), {
				scale:function(scale){
					p.s(p.scale+=scale);
				}
			});
			WP.$('#jximageshow .imgbox').mousewheel(function(a,b,x,y){
				if(y>0) p.s(p.scale+=.15);
				else p.s(p.scale-=.15);
				return false;
			});
			WP.$('#jximageshow .icobox').on('mouseover', function () {
				$(this).addClass('hover_cur hover_cur_1');
			});
			WP.$('#jximageshow .icobox').on('mouseleave', function () {
				if ($.mobile()) {
					return;
				}
				var a = $(this);
				a.removeClass('hover_cur_1');
				setTimeout(function () {
					if (!a.is('.hover_cur_1')) a.removeClass('hover_cur');
				}, 600);
			});
			p.a(t);
		},
		s:function(scale){
			if(scale<1) p.scale=scale=1;
			var mx = p.im.matrix();
			mx[0] = scale;
			mx[3] = scale;
			p.im.matrix(mx);
		},
		r: function () {
			p.im.matrix([1,0,0,1,0,0]);
			p.go=0;
		},
		a:function(i){
			if(p.go) return;
			p.go=1;
			if(i<0) i=0;
			if(i>img.length-1) i=img.length-1;
			t=i%img.length;
			WP.$('#jximageshow .number').html((t+1)+' / '+img.length);
			p.im.attr({src:img[t]});
			p.s(p.scale=1);
			p.r();
		}
	};
	p.i();
};
