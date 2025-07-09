/*
 * 图片拆分组合效果
 * <div images='asd' size='5*5'></div>
 */
$('[jextstyle]').append('body{overflow-x:hidden}');
$.task.push(function(){
	_('div[images*="."]','effect').each(function(i,a){
		if($.mobile() || typeof($(a).attr('stop'))!='undefined'){
			$(a).css({'background-image':'url('+$(a).attr('images')+')','background-size':'cover'});
		}else{
			imageSplit($(a));// 拆分
		}
	});
};
function imageSplit(a){
	var src = a.attr('images');
	var size= (a.attr('size')||'5*5').split('*');
		size[0] = parseInt(size[0]) || 0;
		size[1] = parseInt(size[1]) || 0;
	var	total = size[0] * size[1],
		width = a.outerWidth(),
		height= a.outerHeight(),
		div = $('<div class="trans" style="position:absolute;left:0;right:0;top:0;bottom:0;z-index:2"></div>');
	var iw = 1 / size[0],
		ih = 1 / size[1];
	var timemax=0;
	for(var i=0;i<size[1];i++){
		for(var j=0;j<size[0];j++){
			var p_l = parseInt(-j*iw*width)+'px',
				p_t = parseInt(-i*ih*height)+'px',
				left= 0,
				top = 0,
				rand= Math.random()*10,
				pom = Math.random()*10,
				time= Math.round(Math.random()*800)+300,
				image = $("<div class='fl trans' style='background-image:url("+src+");position:relative;'></div>");
			if(rand<5){
				top=Math.round(Math.random()*300+300);
			}else{
				left=Math.round(Math.random()*300+300);
			}
			if(timemax<time) timemax=time;
			if(pom<5){
				top=-top;
				left=-left;
			}
			var dataLeft=left+',',
				dataTop =top+',';
			for(var n=2;n<=3;n++){
				dataLeft+=Math.round(left/n)+',';
				dataTop +=Math.round(top/n)+',';
			}
			image.css({
				position:'absolute',
				backgroundSize:width+'px auto',
				backgroundPosition:p_l+' '+p_t,
				left:-parseInt(p_l),
				top:-parseInt(p_t),
				opacity:0,
				height:ih*height,
				width:iw*width
			})
			.attr({
				'data-dept':(i*size[1]+j)%3==1?'3':'1,2,3',
				'data-left':dataLeft+'0',
				'data-top':dataTop+'0',
				'i':(i*size[1]+j)
			})
			.css($.wcss('transform','translate3d('+left+'px,'+top+'px,0px)'))
			.css($.wcss('transition','all '+time+'ms ease 0s'));
			div.append(image);
		}
	}
	a.css({position:'relative'}).attr({'data-time':timemax}).html(div).append('<div img style="position:absolute;left:0;right:0;top:0;bottom:0;background-size:100% auto;background-image:url('+src+');opacity:0"></div>');
	a.find('[img]').css($.wcss('transition','all 900ms ease 0s'))
}

setInterval(function(){
	$('div[images*="."][exec]').each(function(i,a){
		imageMerge($(a));
	});
},120);
// 合并
function imageMerge(a){
	var top   = a[0].getBoundingClientRect().top;
	var	width = a.outerWidth(),
		height= a.outerHeight();
	
	if(top<0){
		var viewH=top+height;
	}else{
		var viewH=$(window).height()-top;
	}
	viewH=viewH>height?height:viewH;

	var op=[0,.3,.6,1], i;
	if(viewH>height*0.7) i=3;
	else if(viewH>height*0.55) i=2;
	else if(viewH>height*0.35) i=1;
	else i=0;
	if(i>0){
		var src = a.attr('images');
		if(width!=a.attr('data-width')){
			var size= (a.attr('size')||'5*5').split('*');
				size[0] = parseInt(size[0]) || 0;
				size[1] = parseInt(size[1]) || 0;
			var iw = 1 / size[0],
				ih = 1 / size[1];
		}else{
			var size='';
		}
		a.attr('is-split', 0).find('.fl').each(function(n){
			var e = $(this);
			var left = e.attr('data-left').split(',');
			var top  = e.attr('data-top').split(',');
			var dept = e.attr('data-dept');
			if(dept.indexOf(i)>=0){
				if(size){
					k=Math.floor(n/size[0]);
					j=n%size[0];
					var p_l = parseInt(-j*iw*width)+'px',
						p_t = parseInt(-k*ih*height)+'px';
					e.css({
						backgroundSize:width+'px auto',
						backgroundPosition:p_l+' '+p_t,
						left:-parseInt(p_l),
						top:-parseInt(p_t),
						height:ih*height,
						width:iw*width
					});
				}
				e.css({opacity:op[i]}).css($.wcss('transform','translate3d('+(left[i])+'px,'+(top[i])+'px,0)'));
			}else{
				e.css({opacity:op[0]}).css($.wcss('transform','translate3d('+(left[0])+'px,'+(top[0])+'px,0)'));
			}
		});
		if(i==3){
			a.attr('is-change',0).children().show();
			setTimeout(function(){
				if(a.attr('is-change')!='1') a.children('[img]').css({opacity:1});
			}, parseInt(a.attr('data-time'))-900);
		}else{
			a.attr('is-change',1).children('[img]').css({opacity:0}).hide();
		}
	}else if(a.attr('is-split')!='1'){
		a.attr('is-change',1).children('[img]').css({opacity:0}).hide();
		a.attr('is-split',1).find('.fl').each(function(){
			var e = $(this);
			var left = e.attr('data-left').split(',');
			var top  = e.attr('data-top').split(',');
			e.css({transform:'translate3d('+(left[0])+'px,'+(top[0])+'px,0)', opacity:0});
		});
	}
}