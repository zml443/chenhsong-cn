

!function () {
	var lastHeight = 0;
	function fixsize (r, height, width, lineWidth, json) {
		var c = $('[jfiximg="'+r+'"]');
		var len = c.length;
		var percent = width/lineWidth;//参与的缩放比例
		var lastHeight = Math.round(height*percent);
		var lastBoxWidth = width;
		c.each(function(index,em){
			var emObj = $(em);
			emObj.height(lastHeight);
			emObj.attr('x', percent);
			if(index == len-1){
				emObj.width(lastBoxWidth);
			}else{
				var boxWidth = Math.round(parseInt(emObj.attr('w'))*percent);
				lastBoxWidth=lastBoxWidth-boxWidth;
				emObj.width(boxWidth);
			}
			emObj.children('img').css('width','100%');
		});
		return lastHeight;
	}
	function init () {
		$('[image-fix]').each(function () {
			var a = $(this);
			var json = $.json(a.attr('image-fix'),'simple');
				json.error = parseInt(json.error)||100; // 容错误差
			var width = a.width();
			var rand = $.rand('fiximg'), lineWidth=0, ge=0, allWidth=0, tWidth=width;
			var has_new = a.children().size() - a.children('[r]').size();
			var count = a.children().not('[jfiximg]').size(), ii = 0;
			if (has_new) {
				a.children().not('[jfiximg]').removeAttr('style');
				a.find('.-img-fix-more').remove();
			}
			if (a.find('.-img-fix-more').size()==0) {
				a.append('<div class="-img-fix-more fl hide m-pic" jfiximg="1" r="1"><span v-middle>NOT MORE</span></div>');
			}
			a.children().not('[jfiximg]').each(function (i) {
				var c = $(this);
				var w = c.width();
				var h = c.height();
				if (lineWidth==0) {
					c.css({'margin-left':0});
				}
				var l = parseInt(c.css('margin-left'))||0;
				var r = parseInt(c.css('margin-right'))||0;
				ge++;
				ii++;
				c.attr({r:rand, w:w});
			 	lineWidth += w;
			 	allWidth += w + l + r;
			 	tWidth -= (l + r);
				if (allWidth>width-json.error) {
					c.css({'margin-right':0});
				 	allWidth -= r;
				 	tWidth += r;
					$('[r="'+rand+'"]').attr('jfiximg', rand);
					lastHeight = fixsize(rand, h, tWidth, lineWidth, json);
					lineWidth = 0;
					allWidth = 0;
					ge = 0;
					tWidth = width;
					rand = $.rand('fiximg');
					a.find('.-img-fix-more').hide();
				}
				else if (has_new&&count==ii) {
					var lh = h+(lastHeight-h)/2;
					$('[r="'+rand+'"]').each(function () {
						$(this).height(lh);
					});
					var tw = lh/h*lineWidth + ge * r + (ge-1)*l;
					a.find('.-img-fix-more').show().css({width:width-tw,height:lh,background:'#555',fontSize:'14px',color:'#fff'});
				}
			});
			a.addClass('isok');
		});
	}
	setInterval(function () {
		// init();
		$('[image-fix]').img_load(function () {
			init();
		});
	}, 600);
}();


/*$.task.push(function () {
	_('[image-fix]').each(function () {
		var a = $(this);
		// var r = $.rand('fixedpic');
		var json = $.json(a.attr('image-fix'),'simple');
		var width = a.width();
		var b = $('['+r+']');
		if (b.size()==0) {
			var b = $('<div '+r+' absolute goaway></div>').html(a.html());
			$('body').append(b);
		}
		b.children().css({float:'left',height:a.children().eq(0).height()});
		var c = b.children();
		a.children().each(function (i) {
			var w = c.eq(i).width();
			var v = c.eq(i)
		});
	});
});*/