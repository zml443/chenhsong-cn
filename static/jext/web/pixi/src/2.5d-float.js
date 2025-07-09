$.eval('TweenMax pixi', function () {
$.task.push(function () {
_('[2-5d-float]').each(function () {
    var playground = $(this);
    var wh = $.json(playground.attr('wh')||'[1920,905]','simple');
    // var isrc = (playground.attr('2-5d')||'').split(',');
    var isrc = $.json(playground.attr('2-5d-float')||'[,]', 'simple');
        isrc[0]=isrc[0]||$.path+'web/pixi/img/float.jpg';
        isrc[1]=isrc[1]||$.path+'web/pixi/img/float2.jpg';
    console.log(isrc);

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
	move = {
		x: 0,
		y: 0
	};
	document.onmousemove = function (e) {
		TweenMax.to(move, 1, {
			x: e.clientX,
			y: e.clientY,
			ease: Sine.easeOut,
			onUpdateParams: ["{self}"]
		});
	}
	auto = {
		x: 0,
		y: 0
	}
	TweenMax.to(auto, 2, {
		x: 20,
		y: 70,
		repeat: -1,
		yoyo: true,
		ease: Sine.easeInOut,
		onUpdate: function (param1) {
			stage.filters = [displacementFilter];
			displacementFilter.scale.set(param1.target.x + (move.x - cmWidth) * velocity, param1.target.y + (move.y - cmHeight) * velocity);

		}, onUpdateParams: ["{self}"]
	})
});
});
});