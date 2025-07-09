function _image_cloud_zoom(el, opts) {
	var thi = this,
		zoomDiv,
		$mouseTrap,
		appendTo,
		lens,
		controlTimer = 0,
		cw,
		ch,
		destU = 0,
		destV = 0,
		currV = 0,
		currU = 0,
		mx,
		my,
		mLeft,
		mTop;
	this.controlLoop = function () {
		if (lens) {
			var x = (mx - el.offset().left - (cw * 0.5)) >> 0;
			var y = (my - el.offset().top - (ch * 0.5)) >> 0;
		   
			if (x < 0) {
				x = 0;
			} else if (x > (el.outerWidth() - cw)) {
				x = (el.outerWidth() - cw);
			}
			if (y < 0) {
				y = 0;
			} else if (y > (el.outerHeight() - ch)) {
				y = (el.outerHeight() - ch);
			}

			x += mLeft;
			y += mTop;
			lens.css({
				left: x,
				top: y
			});
			lens.css('background-position', (-x) + 'px ' + (-y) + 'px');

			destU = (((x - mLeft) / el.outerWidth()) * zoom_image.width) >> 0;
			destV = (((y - mTop) / el.outerHeight()) * zoom_image.height) >> 0;
			currU += (destU - currU) / opts.smoothMove;
			currV += (destV - currV) / opts.smoothMove;

			zoomDiv.css('background-position', (-(currU >> 0) + 'px ') + (-(currV >> 0) + 'px'));			  
		}
		controlTimer = setTimeout(function () {
			thi.controlLoop();
		}, 30);
	};

	/* Init function start.  */
	this.init = function () {

		///////////////////////////////////////////////////////
		//设置布局
		appendTo = $('<div class="absolute"></div>').css({pointerEvents:'none',zIndex:12});
		zoomDiv = $('<div class="image-zoom-big hide absolute" style="background:#fff url('+zoom_image.src+') no-repeat;z-index:8;"></div>');
		$('html').append(appendTo.append(zoomDiv));

		$mouseTrap = $("<div class='mousetrap absolute' style='z-index:9;\'></div>").css({
				width: el.outerWidth(),
				height: el.outerHeight(),
	        	left: 0,
	        	top: el.offset().top - el.parent().offset().top
	        });
		lens = $("<div class='image-zoom-lens hide absolute' style='z-index:7;opacity:.5;'></div>");
		el.parent().append($mouseTrap).append(lens);
		///////////////////////////////////////////////////////

		//////////////////////////////////////////////////////////////////////			
		/* Do as little as possible in mousemove event to prevent slowdown. */
		$mouseTrap.on('mousemove', function(event){
			mx = event.pageX;
			my = event.pageY;
		});
		//////////////////////////////////////////////////////////////////////					
		$mouseTrap.on('mouseleave', function(event){
			clearTimeout(controlTimer);		
			lens.hide();
			zoomDiv.hide();
			return false;
		});
		//////////////////////////////////////////////////////////////////////
		$mouseTrap.on('mouseenter', function(event){
			mx = event.pageX;
			my = event.pageY;
			zw = event.data;
			mLeft = el.offset().left - el.parent().offset().left;
			mTop = el.offset().top - el.parent().offset().top;
			zoomDiv.stop(true, false);

			var xPos = parseFloat(opts.adjustX),
				yPos = parseFloat(opts.adjustY);
						 
			var siw = el.outerWidth();
			var sih = el.outerHeight();

			var w = opts.zoomWidth;
			var h = opts.zoomHeight;
			if (opts.zoomWidth == 'auto') {
				w = siw;
			}
			if (opts.zoomHeight == 'auto') {
				h = sih;
			}
			appendTo.css({
				left: el.parent().offset().left,
				top: el.parent().offset().top,
				width: el.parent().width(),
				height: el.parent().height(),
			});
            setTimeout(function(){
                appendTo.css({
                    left: el.parent().offset().left,
                    top: el.parent().offset().top
                });
            },400);
            $mouseTrap.css({
            	left: mLeft,
            	top: mTop
            });
			switch (opts.position) {
				case 'top':
					yPos -= h;
					break;
				case 'right':
					xPos += appendTo.outerWidth();
					break;
				case 'bottom':
					yPos += sih;
					break;
				case 'left':
					xPos -= w;
					break;
				case 'inside':
					w = siw;
					h = sih;
					// appendTo = el.parent();
					break;
			}
			zoomDiv.css({
				left: xPos,
				top: yPos,
				width: w,
				height: h,
			}).show();
			cw = (el.outerWidth() / zoom_image.width) * zoomDiv.width();
			ch = (el.outerHeight() / zoom_image.height) * zoomDiv.height();
			lens.css({
				width: cw,
				height: ch
			});
			if ( opts.position !== 'inside' ) { lens.show(); }
			// Start processing. 
			thi.controlLoop();
			return;
		});
	};

	var original_image = new Image(),
		zoom_image = new Image(),
		load_number = 0;
	$(original_image).load(function () {
		load_number++;
		if (load_number==2) thi.init();
	});
	$(zoom_image).load(function(){
		if(zoom_image.width < opts.zoomWidth && zoom_image.height < opts.zoomHeight){
			return;
		}
		load_number++;
		if (load_number==2) thi.init();
	});
	original_image.src = el.attr('src');
	zoom_image.src = el.attr('src');
}

$.task.push(function () {
	_('[image-zoom]').each(function () {
		var el = $(this),
			opts = $.extend({
				zoomWidth: 'auto',
				zoomHeight: 'auto',
				position: 'right',
				smoothMove: 3,
				adjustX: 0,
				adjustY: 0
			}, $.json(el.attr('image-zoom'),'simple'));
		new _image_cloud_zoom(el, opts);
	});
});