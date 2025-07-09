
$(document).on('change', 'input[type=file][image-cropper]', function () {
	var el = $(this),
		files = el[0].files;
	if (files) for (var i in files) {
		if (typeof(files[i]) != 'object') {
			continue;
		}
		_image_cropper.init(el, files[i]);
		break;
	}
	// a.val('');
});
$(document).on('click', '[image-cropper]:not(input)', function () {
	_image_cropper.init($(this), $(this).attr('src'));
});

var _image_cropper = {
	// 初始化
	init: function (el, file) {
		var thi = this;
		if (typeof(Cropper)!='undefined' && thi.viewHtml) {
			thi.begin(el, file);
			return false;
		}
		$.include($.path + 'web/image/cropper/cropper.min.css');
		$.include($.path + 'web/image/cropper/cropper.min.js');
		$.async('GET', $.path + 'web/image/cropper/view.html', {}, function (html) {
			thi.viewHtml = html;
		}, 'html');
		thi.go(el, file);
		thi.loading = $.alert('loading...');
	},
	// 执行
	go: function (el, file) {
		var thi = this;
		if (typeof(Cropper)!='undefined' && thi.viewHtml) {
			thi.loading.popup_remove(function(){
				thi.begin(el, file);
			});
		} else {
			setTimeout(function(){thi.go(el,file)},300);
		}
	},
	// 开始
	begin: function (el, file) {
		var opt = $.json(el.attr('image-cropper'), 'simple');
		_image_cropper.do($.extend({
			file: file,
			obj: el,
			resizable: opt.resize||0,
			end: function (base64, canvas) {
				var fn = $.callbackfn(el.attr('fn'), 'confirm');
				$.eval(fn.confirm, el, base64, canvas);
			}
		}, opt));
	},
	// 真正执行
	do: function (v) {
		var v = $.extend({
			wh: [0, 0],
		}, v);
		WP.$.alert({
			title: $.lang.cropper.name,
			str: _image_cropper.viewHtml,
			class: 'cropperbox',
			type: 'border',
			wh: [1600, 900],
			init: function (alert_el) {
				alert_el.find('.at-centents').css({padding:0});
				var URL = window.URL || window.webkitURL,
					img = alert_el.find('.right img'),
					blobURL = typeof(v.file)=='string' ? (v.file.search(/https?:/)>=0&&v.file.indexOf(location.host)<0?$.path+'web/image/cropper/img-origin.php?url='+v.file:v.file) : URL.createObjectURL(v.file);
		        img.attr('src', blobURL);
				var cropper = new Cropper(img[0], {
			        aspectRatio: parseInt(v.wh[0]) / parseInt(v.wh[1]),
			        minCropBoxWidth: v.wh[0],
			        minCropBoxHeight: v.wh[1],
			        viewMode: v.mode,
			        dragMode:'move',//参数：move-可以移动图片和框，crop-拖拽新建框
			        resizable: v.resizable,
			        preview: '#igcropper .left .thumb .view',
			        // strict: true,
			        crop: function (e) {
			        	// console.log(e);
			        	$('#igcropper .left .iwidth input').val(Math.round(e.detail.width));
			        	$('#igcropper .left .iheight input').val(Math.round(e.detail.height));
			        },
			        ready: function () {
			        	$('#igcropper .right').addClass('isshow');
			        }
			    });
			    // 关闭调整尺寸
			    if (v.wh[0]) {
			    	alert_el.find('#igcropper .left .proportion').addClass('cannot');
			    }
			    // 更换比例
			    alert_el.find('[ratio]').change(function () {
			    	var r = $(this).val().split(':');
			    	var r0 = parseInt(r[0])||1;
			    	var r1 = parseInt(r[1])||1;
			    	cropper.setAspectRatio(r0/r1);
			    });
		        // 旋转
			    alert_el.find('[rotate]').click(function () {
			    	cropper.rotate(parseInt($(this).attr('rotate')));
			    });
		        // 翻转
			    alert_el.find('[scale]').click(function () {
			    	var xy = $(this).attr('scale').toLowerCase();
			    	var op = parseInt($(this).data('option')||-1);
			    	$(this).data('option', -op);
			    	if (xy=='x') cropper.scaleX(op);
			    	else cropper.scaleY(op);
			    });
		        // 缩放
			    alert_el.find('[zoom]').click(function () {
			    	cropper.zoom(parseFloat($(this).attr('zoom')));
			    });
		        // 缩放
			    alert_el.find('[zoomto]').click(function () {
			    	cropper.zoomTo(parseFloat($(this).attr('zoomto')));
			    });
		        // 重置
			    alert_el.find('[reset]').click(function () {
			    	cropper.reset();
			    });
			    // 预览
			    alert_el.find('[view]').click(function () {
			    	var w = parseInt(v.wh[0]) || $('#igcropper .left .iwidth input').val(),
			    		h = parseInt(v.wh[1]) || $('#igcropper .left .iheight input').val(),
			    		canvas = cropper.getCroppedCanvas({'width':w, 'height':h}),
			    		base64 = canvas.toDataURL('image/png');
		    		alert_el.find('.views img').attr({src:base64, 'image-show':'123adsdxxz|'+base64}).trigger('click');
			    });
			    // 确认
			    alert_el.find('[confirm]').click(function () {
			    	if (typeof(v.end)=='function') {
				    	var w = parseInt(v.wh[0]) || $('#igcropper .left .iwidth input').val();
				    	var h = parseInt(v.wh[1]) || $('#igcropper .left .iheight input').val();
			    		var canvas = cropper.getCroppedCanvas({'width':w, 'height':h});
						var ly = typeof(v.file)=='string' ? v.file : '';
			    		v.end.call(v.obj, canvas.toDataURL('image/png'), ly);
			    	}
			    	alert_el.popup_remove();
			    });
			    // 取消
			    alert_el.find('[cancel]').click(function () {
			    	alert_el.popup_remove();
			    });
			}
		});
	}
};

