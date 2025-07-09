$.task.unshift(function(){
    _('[ly-image-cropper]').each(function(){
        var el = $(this);
        var flie = $(this).attr('data-file');
        var size = $(this).attr('data-size');
		if(size&&size!='undefined'){
			size = size.split(',');
		}else{
			size = [];
		} ;
		var fn = $.callbackfn(el.attr('fn'),['init','confirm']);
        var cropper = new ly_image_cropper({
			el: el,
			flie: flie,
			size: size,
			init(){
				$.eval(fn.init, el, this);
			},
			confirm(){
				$.eval(fn.confirm, el, this);
			}
		});
		el.o('cropper',cropper);
    });
});


class ly_image_cropper {
	constructor(option){
		this.option = option;
		this.el = option.el;
		this.file = option.flie;
		this.size = option.size;
		this.viewHtml = '';
		this.cropper = '';
		this.start();
	}
	start(){
		$.async('GET', $.path + 'web/image/cropper/view.html', {}, html=> {
			this.viewHtml = html;
			this.el.html(this.viewHtml);
			this.do();
		}, 'html');
	}
	do(){
		var _this = this;
		var URL = window.URL || window.webkitURL;
		var	img = this.el.find('.ly_cropper_right img');
		var	blobURL = typeof(this.file)=='string' ? (this.file.search(/https?:/)>=0&&this.file.indexOf(location.host)<0?$.path+'web/image/cropper/img-origin.php?url='+this.file:this.file) : URL.createObjectURL(this.file);
		// 通过随机数 来区
		var rand = 'ly_crop_' + Math.random();
		rand = rand.replace('.','');
		this.el.addClass(rand);
		// 插入裁剪图片路径
		img.attr('src', blobURL);
		this.cropper = new Cropper(img[0], {
			// aspectRatio: parseInt(this.size[0]) / parseInt(this.size[1]),
			minCropBoxWidth: this.size[0],
			minCropBoxHeight: this.size[1],
			viewMode: 1,//this.mode,
			dragMode:'move',//参数：move-可以移动图片和框，crop-拖拽新建框
			movable: false,
			zoomOnTouch: false,
			zoomOnWheel: false,
			preview: '.'+rand+' .ly_cropper_preview',
			// cropBoxResizable:false,
			// strict: true,
			crop: function (e) {
				_this.el.find('.ly_cropper_width').val(Math.round(e.detail.width));
				_this.el.find('.ly_cropper_height').val(Math.round(e.detail.height));
			},
			ready: function () {
				// console.log(img[0].naturalWidth,img[0].naturalHeight);
				_this.el.find('.ly_cropper_right').addClass('isshow');
				_this.el.find('.ly_cropper_width').val(Math.round(e.detail.width));
				_this.el.find('.ly_cropper_height').val(Math.round(e.detail.height));
				if (_this.option.init) _this.option.init.call(_this);
			}
		});
		// 关闭调整尺寸
		if (this.size[0]) {
			this.el.find('.ly_cropper_radio').addClass('cannot');
		}
		// 更换比例
		var timer;
		this.el.find('.ly_cropper_width,.ly_cropper_height').change(function () {
			var cD = _this.cropper.getCanvasData();
			// 宽、高输入框
			var width = parseFloat(_this.el.find('.ly_cropper_width').val())||1;
			var height = parseFloat(_this.el.find('.ly_cropper_height').val())||1;
			// 裁剪图片的最大尺寸
			var maxw = cD.naturalWidth;
			var maxh = cD.naturalHeight;
			var ratio = cD.height / cD.naturalHeight;
			if(width > maxw){
				width = maxw;
				_this.el.find('.ly_cropper_width').val(maxw);
			}
			if(height > maxh){
				height = maxh;
				_this.el.find('.ly_cropper_height').val(maxh);
			}
			_this.cropper.setCropBoxData({width:ratio*width,height:ratio*height, left:0, top:0});
		});
	    // 更换比例
	    this.el.find('.ly_cropper_bili dd').click(function () {
	    	var cD = _this.cropper.getCanvasData();
	    	var ratio = cD.naturalWidth / cD.naturalHeight;
			var ratio2 = cD.height / cD.naturalHeight;
	    	var e = $(this);
	    	if (e.is('.cur')) {
	    		e.removeClass('cur');
	    		var r0 = 0;
	    		var r1 = 1;
	    	} else {
	    		e.addClass('cur').siblings().removeClass('cur');
		    	var r = e.attr('value').split(':');
		    	var r0 = parseInt(r[0])||0;
		    	var r1 = parseInt(r[1])||1;
	    	}
	    	_this.cropper.setAspectRatio(r0/r1);
	    	if (ratio > r0/r1) {
	    		_this.cropper.setCropBoxData({height:cD.naturalHeight*ratio2});
	    	} else {
	    		_this.cropper.setCropBoxData({width:cD.naturalWidth*ratio2});
	    	}
	    });
		// 翻转
		this.el.find('.ly_cropper_scale').click(function () {
			var xy = $(this).attr('scale').toLowerCase();
			var op = parseInt($(this).data('option')||-1);
			$(this).data('option', -op);
			if (xy=='x') _this.cropper.scaleX(op);
			else _this.cropper.scaleY(op);
		});
		// 重置
		this.el.find('.ly_cropper_reset').click(function () {
			_this.cropper.reset();
		});
		// 预览
		this.el.find('.ly_cropper_view').click(function () {
			// var info = _this.get();
			// _this.el.find('.ly_cropper_views img').attr({src:info.base64, 'image-show':'123adsdxxz|'+info.base64}).trigger('click');
			if (_this.option.confirm) _this.option.confirm.call(_this);
		});
		// 旋转
		// this.el.find('.ly_cropper_rotate').click(function () {
		// 	_this.cropper.rotate(parseInt($(this).attr('rotate')));
		// });
		// // 缩放
		// this.el.find('.ly_cropper_zoom').click(function () {
		// 	_this.cropper.zoom(parseFloat($(this).attr('zoom')));
		// });
		// // 缩放
		// this.el.find('[zoomto]').click(function () {
		// 	_this.cropper.zoomTo(parseFloat($(this).attr('zoomto')));
		// });
		// 确认
		// this.el.find('.ly_cropper_confirm').click(function () {
		// 	if (typeof(this.end)=='function') {
		// 		var w = parseInt(this.size[0]) || _this.el.find('.iwidth input').val();
		// 		var h = parseInt(this.size[1]) || _this.el.find('.iheight input').val();
		// 		var canvas = this.cropper.getCroppedCanvas({'width':w, 'height':h});
		// 		var ly = typeof(this.file)=='string' ? this.file : '';
		// 		this.end.call(this.obj, canvas.toDataURL('image/png'), ly);
		// 	}
		// 	// this.el.popup_remove();
		// });
	}
	// 获取裁剪的内容
	get(){
		var w = parseInt(this.el.find('.ly_cropper_width').val());
		var h = parseInt(this.el.find('.ly_cropper_height').val());
		var width = parseInt(this.el.find('.ly_cropper_real_width').val()) || w;
		var height = parseInt(h*(width/w));
		var canvas = this.cropper.getCroppedCanvas({'width':width, 'height':height});
		var base64 = canvas.toDataURL('image/png');
		var arr = base64.split(','),
	    	mime = arr[0].match(/:(.*?);/)[1],
	    	bstr = atob(arr[1]),
	    	n = bstr.length,
	    	u8arr = new Uint8Array(n),
			filename = ('f' + Math.random()).replace('.','');
	    while (n--) {
	      	u8arr[n] = bstr.charCodeAt(n);
	    }
		return {width:width, height:height, base64:base64, file:new File([u8arr], filename + '.png', { type: mime })}
	}
}