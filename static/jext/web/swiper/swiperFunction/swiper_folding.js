var swiper_folding = undefined;
$.eval('swiper TweenMax', function () {
	swiper_folding = {
	    tweenmax: {
	        translate: 0
	    },
		init: function (el, swiper) {
			var thi = this;
			thi.aW = el.width();
			thi.aH = el.height();
			thi.len = 5;
			thi.canvas = $('<canvas class="absolute maxw maxh" style="top:0;left:0;z-index:7;"></canvas>');
			thi.canvas[0].width = this.aW;
			thi.canvas[0].height = this.aH;
			el.append(thi.canvas);
			thi.ctx = thi.canvas[0].getContext("2d");
			thi.tmpdiv = $('<div class="tmp absolute max" style="z-index:9;"></div>');
			el.append(thi.tmpdiv);
			thi.img = [];
		    el.find('.swiper-slide').each(function(i) {
				thi.img[i] = new Image();
				thi.img[i].src = $(this).find('img').attr('src');
				//使用附加文本替换virtualTranslate，避免鼠标滚轮失效
				thi.tmpdiv.append('<div class="box hide">' + $(this).html() + '</div>')
		    });
		    thi.ok=1;
		    thi.resize(el, swiper);
		},
		// 屏幕尺寸改变
		resize: function (el, swiper) {
			this.draw(swiper);
		},
		// 过度
		translate: function (el, swiper) {
			if (this.ok) {
				this.draw(swiper, 1);
			}
		},
		/**
		 * 绘画
		 * @param {obj} swiper 对象
		 * @param {int} speed 速度
		 * @return {void}
		 */
		draw: function (swiper, speed) {
			var thi = this;
			var aW = thi.aW,
				aH = thi.aH,
				sW = $(swiper.$el).width(),
				blockW = thi.blockW,
				ctx  = thi.ctx,
				img  = thi.img;
			var slidesLength = thi.img.length;
			if (typeof(speed) == "undefined") {
				speed = 0.3;
			}
			TweenMax.to(thi.tweenmax, speed, {tlanslate:swiper.translate, ease:Power4.easeOut, onUpdate:function() {
					//如果超出显示范围添加黑色背景
					ctx.fillStyle = "#000000";
					ctx.fillRect(0, 0, aW, aH);

					var tlanslate = thi.tweenmax.tlanslate;
					// console.log(tlanslate);
					var blockW = thi.aW / thi.len,
						cutW = aH * aW / aH,
						cutX = (aW - cutW) / 2,
						cutY = 0;
					for (i = 0; i <= slidesLength; i++) {
						if (!img[i]) continue;
						var percent = -tlanslate / sW - i;
						if (Math.abs(percent) <= 1 ) {
							var n2scale = 2 - Math.abs(percent) * 2;
							if (n2scale > 1) {
								n2scale = 1;
							}
							var n1scale = 1 - Math.abs(percent) * 2;
							if (n1scale < 0) {
								n1scale = 0;
							}
							var moveW = (aW * i + tlanslate)*.6;
							// 画5个块，裁剪出位移差
							ctx.drawImage(img[i], cutX + sW*percent + blockW*Math.abs(percent)*2, cutY, blockW*n1scale, aH, moveW + blockW*(1 - n1scale), 0, blockW*n1scale, aH);
							ctx.drawImage(img[i], cutX + blockW - sW*percent*0.1, 0, blockW*n2scale, aH, moveW + blockW + blockW - blockW*n2scale, 0, blockW * n2scale, aH);
							ctx.drawImage(img[i], cutX + blockW*2 - sW*percent*0.4, cutY, blockW, aH, moveW + blockW*2, 0, blockW, aH);
							ctx.drawImage(img[i], cutX + blockW*3 - sW*percent*0.1, cutY, blockW*n2scale, aH, moveW + blockW*3, 0, blockW*n2scale, aH);
							ctx.drawImage(img[i], cutX + blockW*4 + sW*percent*0.2, cutY, blockW*n1scale, aH, moveW + blockW*4, 0, blockW*n1scale, aH);
							/*for (var j=0; j<thi.len; j++) {
								ctx.drawImage(img[i], blockW*j - blockW*percent, 0, blockW*n1scale, aH, blockW*j, 0, blockW*n1scale, aH);
							}*/
						}
					}
				}
			});
		}
	};
});