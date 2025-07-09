$.eval('TweenMax pixi', function () {
$.task.push(function () {
_('[2-5d]').each(function () {
    var playground = $(this);
    var wh = $.json(playground.attr('wh')||'[1652,1074]','simple');
    var isrc = $.json(playground.attr('2-5d')||'[,]', 'simple');
        isrc[0]=isrc[0]||$.path+'web/pixi/img/photo.jpg';
        isrc[1]=isrc[1]||$.path+'web/pixi/img/photo2.jpg';

	var option = {
		width: wh[0],
		height: wh[1],
		transparent: true,
	}
	var app = new PIXI.Application(option);
	var renderer = app.renderer;
	var preview;
	var displacementSprite;
	var displacementFilter;
	var stage;

    playground.addClass('_2-5d').html(renderer.view);

    stage = new PIXI.Container();
    preview = PIXI.Sprite.fromImage(isrc[0]);
    displacementSprite = PIXI.Sprite.fromImage(isrc[1]);
    displacementSprite.texture.baseTexture.wrapMode = PIXI.WRAP_MODES.REPEAT;
    displacementFilter = new PIXI.filters.DisplacementFilter(displacementSprite);
    stage.addChild(preview);
    stage.addChild(displacementSprite);
    app.stage.addChild(stage);

	cmWidth = document.body.clientWidth / 2
	cmHeight = document.body.clientHeight / 2

	var velocity = -0.05;
	var move = {
		x: 0,
		y: 0
	};
	document.onmousemove = function (e) {
		TweenMax.to(move, 2, {
			x: e.clientX,
			y: e.clientY,
			ease: Sine.easeOut,
			onUpdate: function (param1) {
				stage.filters = [displacementFilter];
				displacementSprite.position.set((move.x -  cmWidth) * velocity * 0.5, (move.y - cmHeight) * velocity * 0.5)
				preview.position.set((move.x -  cmWidth) * velocity * 0.5, (move.y - cmHeight) * velocity * 0.5)
				
				displacementFilter.scale.set(-(move.x -  cmWidth) * velocity, -(move.y - cmHeight) * velocity);
				
			},
		});
	}
});
});
});