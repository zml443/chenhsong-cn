$.task.push(function () {
	_('[canvas-circle]').each(function () {
		var el = $(this),
			fn = $.callbackfn(el.attr('fn'), 'pause,play,end,start'),
			option = $.json(el.attr('canvas-circle'), 'simple'),
			arc;
		arc = {
			b: option.border || 2,
			color: option.color || '#f00',
			fill: option.fill || '',
			color2: option.color2 || '#ccc',
			s: parseFloat(option.start||0) * Math.PI + 1.5 * Math.PI,
			e: parseFloat(option.angle||1) * 2 * Math.PI,
			r: 0,
			radius: 0,
			scale: 1,
			speed: 20,
			stopping: option.stop,
			init: function () {
				var thi = this;
				// 初始变量
		    	thi.width = el.width();
		    	thi.height = el.height();
		    	thi.e += thi.s;
		    	// 创建画布
				thi.canvas = $('<canvas width="'+thi.width+'" height="'+thi.height+'" absolute max style="height:100%;width:100%;"></canvas>');
			    thi.canvas.width = thi.width;
			    thi.canvas.height = thi.height;
		    	thi.ctx = thi.canvas[0].getContext('2d');
		    	el.addClass('relative').append(thi.canvas);
		    	if (thi.width < thi.height) {
		    		thi.radius = (thi.width - thi.b) / 2;
		    	} else {
		    		thi.radius = (thi.height - thi.b) / 2;
		    	}
		    	// thi.ctx.translate(thi.width/2,thi.height/2);
				// 画⚪
		    	thi.draw();
			},
			// 画⚪
			draw: function () {
				var thi = this;
				var x = thi.width / 2;
				var y = thi.height / 2;
				if (option.dot) {
					var r = thi.radius - 6;
				}
				else var r = thi.radius;
				thi.ctx.clearRect(0, 0, thi.canvas.width, thi.canvas.height);
				// 底层圆形
				thi.cir(x, y, r, 0, 2 * Math.PI, thi.fill, thi.color2, thi.b);
				var angle = thi.r;
				if (angle < thi.s) {
					angle = thi.s;
				} else if (angle > thi.e) {
					angle = thi.e;
				}
				if (window.devicePixelRatio) {
					devicePixelRatio = window.devicePixelRatio;
				}
				// 上层圆形
				thi.cir(x, y, r, thi.s, angle, '', thi.color, thi.b);
				// 圆点
				if (option.dot) {
		            var x1 = x + r * Math.cos(thi.s);
		            var y1 = y + r * Math.sin(thi.s);
					thi.cir(x1, y1, thi.b+3, 0, Math.PI*2, '#fff', thi.color, thi.b);
		            var x1 = x + r * Math.cos(angle);
		            var y1 = y + r * Math.sin(angle);
					thi.cir(x1, y1, thi.b+3, 0, Math.PI*2, '#fff', thi.color, thi.b);
				}
				// 停止转动
				if (this.stopping) {
					return;
				}
				if (thi.r==0) {
					$.eval(fn.start, el, arc);
				}
				// thi.r = r + (Math.PI / 10);
				// console.log(1);
				thi.r = angle + (2 * Math.PI / (option.time / thi.speed));
				if (angle!=thi.e) {
					clearTimeout(thi.set_time_var);
					thi.set_time_var=setTimeout(function () {
						thi.draw();
					}, thi.speed);
				} else {
					$.eval(fn.end, el, arc);
					thi.is_end = 1;
				}
			},
			cir: function (x, y, r, r0, r1, fill, color, border) {
				var thi = this;
				thi.ctx.beginPath();
				thi.ctx.arc(x, y, r, r0, r1);
            	if (fill) {
					thi.ctx.fillStyle = fill;
            		thi.ctx.fill();
            	}
				if (color!='none') {
					thi.ctx.strokeStyle = color;
					thi.ctx.lineWidth = border;
					thi.ctx.stroke();
				}
	    		thi.ctx.closePath();
			},
			reset: function () {
				this.r = 0;
				this.is_end = 1;
				this.stopping = 1;
				$.eval(fn.reset, el, this);
				this.draw();
			},
			play: function() {
				if (this.stopping) $.eval(fn.play, el, this);
				this.stopping = 0;
				this.is_end = 0;
				this.draw();
			},
			pause: function() {
				if (!this.stopping) $.eval(fn.pause, el, this);
				this.stopping = 1;
				this.is_end = 0;
			}
		};
		arc.init();
		$.eval(fn.init, el, arc);
		el.click(function () {
			if(arc.is_end==1){return;}
			arc.stopping = !arc.stopping;
			if (arc.stopping) {
				$.eval(fn.pause, el, arc);
			} else {
				arc.draw();
				$.eval(fn.play, el, arc);
			}
		});
		el.on('pause', function(){arc.pause()});
		el.on('play', function(){arc.play()});
		el.on('reset', function(){arc.reset()});
		el.o('canvas-circle', arc);
	});
});
// 可视范围
_visible_canvas_circle = {
	visible: function(el){
		if (el.is('[jx-o-canvas-circle]')) el.removeAttr('visible').o().play();
	}
};