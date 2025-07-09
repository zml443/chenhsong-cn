// 窗口弹出类型
$.__video_pop = function(el) {
	var fn = $.callbackfn(el.attr('fn'), 'start,end,ended,play,pause');
	var json = $.json(el.attr('ly-video'),'simple');
	var u = el.attr('src')||'';
	if (u.search(/\.mp4$/) > 0) {
		str = '<video class="maxw maxh" controls src="' + u + '" autoplay controlslist="nodownload"></video>';
	} else {
		str = '<iframe class="maxw maxh" scroll="no" frameborder="0" allowfullscreen="allowfullscreen" src="' + u + '"></iframe>';
	}
	var obj = $(`
		<section id="jex-video-pop" class="fixed max flex-max2">
			<div class="videobox">
				<div class="video relative">
					${str}
					<div class="close_i pointer lyicon-guanbi"></div>
				</div>
				<div class="title"></div>
				<div class="brief"></div>
			</div>
		</section>
	`);
	$('html').append(obj);
	if ($(window).width() < 990) {
		obj.find('.close_i').hide();
	}
	// 开始弹窗
	$.eval(fn.start, el, obj);
	// 视频播放
	obj.find('video').get(0).addEventListener('play',function(){
		$.eval(fn.play, el, obj);
	});
	// 视频暂停
	obj.find('video').get(0).addEventListener('pause',function(){
		$.eval(fn.pause, el, obj);
	});
	// 视频结束
	obj.find('video').get(0).addEventListener('ended',function(){
		$.eval(fn.ended, el, obj);
	});
	// 弹窗关闭
	obj.on('click', function(e){
		var close = $( e.target ).closest(".videobox .close_i").size()
		var videobox = $( e.target ).closest(".videobox").size()
		if (!close && videobox) {
			e.stopPropagation();
		} else {
			obj.remove();
			$.eval(fn.end, el, obj);
		}
	});
};

$(document).on('click','[ly-video]', function(){
	$.__video_pop($(this));
});
