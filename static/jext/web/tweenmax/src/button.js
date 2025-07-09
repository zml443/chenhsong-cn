$.eval('TweenMax', function () {
$.task.push(function () {
	_(".tweenmax-menu").each(function () {
		var o1 = $(this),
			o2 = o1.children().not('.closebtn'),
			o3 = $("<div class='closebtn block pointer m-pic'></div>"),
			o4 = $('<svg class="svg" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M98 480.86h829.99v63.79H98z"></path><path d="M481.48 98.15h63.79V927h-63.79z"></path></svg>');
		var len=o2.length,
			len2 = len/2,
			angle;
		if (len>4) angle=360;
		else if (len>3) angle=200;
		else angle=180;
		
		var distance=90;
		var slice=angle/len;
		var startingAngle=slice/2+180;
		var on=false;

		TweenMax.globalTimeScale(0.8);
		o1.append(o3.append(o4));
		o2.each(function(i){
			var angle=startingAngle+(slice*(i-len2));
			$(this).css({transform:"rotate("+(angle)+"deg)"});
			$(this).children().css({transform:"rotate("+(-angle)+"deg)"});
			$(this).append("<div class=''></div>");
		});

		o3.on("mousedown",function(e){
			on=!on;
			TweenMax.to(o4,0.4,{
				rotation:on?45:0,
				ease:Quint.easeInOut,
				// force3D:true
			});
			on?openMenu():closeMenu();
		});
		o3.on("touchstart",function (e) {
			$(this).trigger("mousedown");
			e.preventDefault();
			e.stopPropagation();
		});
		function openMenu () {
			o2.each(function (i) {
				var delay = i*0.08,
					$div = $(this).children().eq(0),
					$bounce = $(this).children().eq(1);
				TweenMax.fromTo($bounce, 0.2, {
					transformOrigin:"50% 50%"
				},{
					delay:delay,
					scaleX:0.8,
					scaleY:1.2,
					// force3D:true,
					ease:Quad.easeInOut,
					onComplete:function () {
						TweenMax.to($bounce, 0.15, {
							// scaleX:1.2,
							scaleY:0.7,
							// force3D:true,
							ease:Quad.easeInOut,
							onComplete:function(){
								TweenMax.to($bounce,3,{
									// scaleX:1,
									scaleY:0.8,
									// force3D:true,
									ease:Elastic.easeOut,
									easeParams:[1.1,0.12]
								})
							}
						})
					}
				});
				TweenMax.to($div, 0.5, {
					delay:delay,
					y:distance,
					// force3D:true,
					ease:Quint.easeInOut
				});
			})
		}
		function closeMenu () {
			o2.each(function (i) {
				var delay = i*0.08,
					$div = $(this).children().eq(0),
					$bounce = $(this).children().eq(1);
				TweenMax.fromTo($bounce,0.2,{
					transformOrigin:"50% 50%"
				},{
					delay:delay,
					scaleX:1,
					scaleY:0.8,
					// force3D:true,
					ease:Quad.easeInOut,
					onComplete:function(){
						TweenMax.to($bounce, 0.15, {
							// scaleX:1.2,
							scaleY:1.2,
							// force3D:true,
							ease:Quad.easeInOut,
							onComplete:function(){
								TweenMax.to($bounce,3,{
									// scaleX:1,
									scaleY:1,
									// force3D:true,
									ease:Elastic.easeOut,
									easeParams:[1.1,0.12]
								})
							}
						})
					}
				});
				TweenMax.to($div, 0.3, {
					delay:delay,
					y:0,
					// force3D:true,
					ease:Quint.easeIn
				});
			});
		}
	});
});
});