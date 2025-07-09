
$.task.push(function () {
	_('[canvas-src^="word,"]').each(function () {
		var thi = $(this);
		thi.append('<canvas width="1920" height="572"></canvas>');
		var canvas = thi.find('canvas');
		var q = canvas[0].getContext('2d');

		var width = canvas[0].width = thi.width();
		var height = canvas[0].height = thi.height();
		var letters = Array(256).join(1).split('');

		$(window).resize(function () {
			width = canvas[0].width = thi.width();
			height = canvas[0].height = thi.height();
		});

		var draw = function () {
			q.fillStyle='rgba(0,0,0,.05)';
			q.fillRect(0,0,width,height);
			q.fillStyle='#0F0';
			letters.map(function(y_pos, index){
				text = String.fromCharCode(3e4+Math.random()*33);
				x_pos = index * 10;
				q.fillText(text, x_pos, y_pos);
				letters[index] = (y_pos > 758 + Math.random() * 1e4) ? 0 : y_pos + 10;
			});
			requestAnimationFrame(draw);
		};
		draw();
	});
});