
// 懒加载时 加上类名 .is-masonry-image
// <img class="is-masonry-image" data-src="" />

$.task.push(function () {
	_('[ly-masonry]').each(function () {
		var thi = $(this);
		var rand = ('ly-masonry'+Math.random()).replace('.','');
		var width = thi.attr('width')||'';
		var space = thi.attr('space')||'';
		var data = {
			itemSelector: '.'+rand+' ' + thi.attr('ly-masonry'),
			percentPosition: (width+space).indexOf('%')>0
		};
		if (thi.is('[width]')) {
			thi.append('<div class="'+rand+'-grid-sizer" style="width:'+width+'"></div>');
			data.columnWidth = '.'+rand+'-grid-sizer';
		}
		if (thi.is('[space]')) {
			thi.append('<div class="'+rand+'-gutter-sizer" style="width:'+space+'"></div>');
			data.gutter = '.'+rand+'-gutter-sizer';
		}
		thi.find('img').addClass('IsMasonryImage');
		var $grid = thi.addClass(rand+' isok').masonry(data);
		thi.o('masonry', $grid);
		$grid.imagesLoaded().progress( function() {
			$grid.masonry('layout');
		});
	});

	$('[ly-masonry][settimeout], [ly-masonry][h5]').each(function(){
		var el = $(this);
		var ind = parseInt(el.attr('data-ind')||0);
		var ww = $(window).width();
		if (ind>12 && el.is('[data-ww="'+ww+'"]')) {
			return;
		}
		var h5 = $.json(el.attr('h5')||'{0:""}', 'simple');
		var width = el.attr('width');
		var space = el.attr('space');
		var w = 0;
		for (var i in h5) {
			if(i<ww && w<i){
				w = i;
				width = h5[i].width;
				space = h5[i].space;
			}
		}
		el.find('[class$="-grid-sizer"]').css({width: width});
		el.find('[class$="-gutter-sizer"]').css({width: space});
		el.attr({'data-ww':ww, 'data-ind':ind+1});
		el.o().masonry('layout');
	});
});

$.extend({
	/*
	 * 往瀑布流加入新元素
	 * 
	 */
	masonry_append: function (obj, html) {
		var $grid = $(obj).o();
		if (!$grid) {
			setTimeout(function(){
				$.masonry_append(obj, html);
			});
			return false;
		}
		html = $(html);
		this.find('img').addClass('.is-masonry-image');
		$grid.append(html).masonry('appended', html).imagesLoaded().progress(function(){
			$grid.masonry('layout');
		});
	}
});

$.fn.extend({
	masonry_append: function (html) {
		var $grid = this.o();
		if (!$grid) {
			setTimeout(()=>{
				this.masonry_append(html);
			});
			return false;
		}
		html = $(html);
		html.find('img').addClass('IsMasonryImage');
		$grid.append(html).masonry('appended', html).imagesLoaded().progress(function(){
			$grid.masonry('layout');
			setTimeout(()=>{
				$grid.masonry('layout');
			},1000);
		});
	},
	masonry_html: function (html) {
		var $grid = this.o();
		if (!$grid) {
			setTimeout(()=>{
				this.masonry_html(html);
			});
			return false;
		}
		html = $(html);
		html.find('img').addClass('IsMasonryImage');
		$grid.html(html).masonry('prepended', html).imagesLoaded().progress(function(){
			$grid.masonry('reloadItems');
			$grid.masonry('layout');
			setTimeout(()=>{
				$grid.masonry('layout');
			},1000);
		});
	},
	masonry_reload: function () {
		var $grid = this.o();
		$grid.imagesLoaded().progress(function(){
			$grid.masonry('reloadItems');
			$grid.masonry('layout');
			setTimeout(()=>{
				$grid.masonry('layout');
			},1000);
		});
	}
});
