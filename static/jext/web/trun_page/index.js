$('[jextstyle]').append(
	"[turnjs] .even .gradient{background-image:url("+$.path+"web/turn_page/pics/right-border.png);}" +
	"[turnjs] .odd .gradient{background-image:url("+$.path+"web/turn_page/pics/left-loader.png);}" +
	"[turnjs] .loader{background-image:url("+$.path+"web/turn_page/pics/loader.gif);}"
);
$.task.push(function () {
	_('[turnjs]').each(function () {
		var a = $(this);
		var wh = $.json(a.attr('wh')||'[300,400]','simple');
		a.addClass('notcopy trans').turn({
			width: wh[0]*2,
			height: wh[1],
			acceleration: false,
			gradients: true,
			autoCenter: true,
		});
	});
});
