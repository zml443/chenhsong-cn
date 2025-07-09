/*
 * 需要支持 FormData 函数
 * ERROR_STATUS
 * -300 格式，后缀。错误
 * -400 上传失败
 * -500 尺寸超出限制
**/
$.__file_upload = {
	/*
	 * 每个文件切片大小定为 2MB
	 * 
	**/
	SIZE: 1024 * 1024 * 1.5,
	URL: $.path + 'web/file/upload/inc/save.php',
	/*
	 * 执行
	 * 
	**/
	FILES: {},
	// COUNT: {},
	FILESLOGS: {},
	init: function(el) {
		var thi = this;
		if (typeof(FileReader)=='undefined') {
			WP.$.alert({
				str: $.lang.notes.low_browser_upload,
				style: 'B',
				confirm: 1
			});
			return false;
		}
		thi.el = el;
		thi.parent_el = thi.el.parents('[file-upload]');
		thi.fn = $.callbackfn(thi.parent_el.attr('fn'), 'before,after');
		thi.TYPE = thi.parent_el.attr('file-upload');
		thi.R = thi.el.attr('random') || '';
		if (!thi.R) {
			thi.R = Math.random();
			thi.el.attr('random', thi.R);
		}
		var r = thi.R;
		thi.DIR = thi.el.val().replace(/\\/g, '/');
		thi.DIR = thi.DIR.substring(0, thi.DIR.lastIndexOf('/') + 1);
		thi.READIMG = [0, 0];
		thi.FILES[r] = thi.FILES[r] || {};
		thi.FILESLOGS[r] = thi.FILESLOGS[r] || [];
		var filesary = [];
		for (var i in el[0].files) {
			if (typeof(el[0].files[i]) != 'object') {
				continue;
			}
			filesary.push(el[0].files[i]);
		}
		filesary = filesary.reverse();
		$.eval(thi.fn.before, thi.el, filesary);
		if (thi.el.is('[disabled],is-uploading,.stop-upload')) {
			return false;
		}
		for (var i in filesary) {
			var n = Math.random();
			if (thi.FILES[r][n]) {
				continue;
			}
			thi.FILES[r][n] = filesary[i];
			thi.FILES[r][n].path = (thi.DIR + filesary[i].name + ' ' + filesary[i].size).replace(/[^a-zA-Z0-9_]/g,'_');
			thi.FILES[r][n].move = 0;
			thi.FILES[r][n].progress = 0;
			thi.FILESLOGS[r].push(n);
			thi.src(n);
		}
		thi.OVER = 0;
		var iv = setInterval(function() {
			if (thi.READIMG[0]==0 || thi.READIMG[0]==thi.READIMG[1]) {
				clearInterval(iv);
				thi.callback();
				thi.ajax();
			}
		}, 300);
	},
	src: function(n) {
		var thi = this;
		var r = thi.R;
		if (thi.FILES[r][n].name.search(/\.(png|jpe?g|svg|ico|webp)$/i) > -1) {
			thi.READIMG[0]++;
			var x = new FileReader();
			x.readAsDataURL(thi.FILES[r][n]);
			x.onloadend = function(e) {
				thi.READIMG[1]++;
				if (thi.FILES[r][n]) thi.FILES[r][n].src = this.result;
			}
		} else {
			thi.FILES[r][n].src = thi.FILES[r][n].name;
		}
	},
	/*
	 * 文件分段
	 * 
	**/
	I: {},
	deal: function() {
		var thi = this;
		var r = thi.R;
		thi.I[r] = thi.I[r] || 0;
		var i = thi.I[r];
		var n = thi.FILESLOGS[r][i];
		if (!n) {
			thi.OVER = 1;
			return;
		}
		thi.N = n;
		if (!thi.FILES[r][n] || parseFloat(thi.FILES[r][n].progress) >= 100) {
			thi.I[r] += 1;
			thi.deal();
			return;
		}
		var s = thi.FILES[r][n].move;
		var e = s + thi.SIZE;
		if (e > thi.FILES[r][n].size) {
			e = thi.FILES[r][n].size;
		}
		var form = thi.el.parents('form');
		if (form.size()) {
			thi.DATA = new FormData(form[0]);
		} else {
			thi.DATA = new FormData();
		}
		thi.DATA.append('--file', thi.FILES[r][n].slice(s, e));
		thi.DATA.append('--size', thi.FILES[r][n].size);
		thi.DATA.append('--path', thi.FILES[r][n].path);
		thi.DATA.append('--name', thi.FILES[r][n].name);
		thi.DATA.append('--move', e);
		thi.DATA.append('--type', thi.TYPE);
		thi.FILES[r][n].move = e;
		thi.FILES[r][n].progress = parseFloat(((e / thi.FILES[r][n].size) * 100).toFixed(2));
		if (e == thi.FILES[r][n].size) {
			thi.I[r] += 1;
		}
	},
	/*
	 * 文件上传
	 * 
	**/
	ajax: function(s) {
		var thi = this;
		if (!s) {
			thi.deal();
		}
		if (thi.OVER == 1) {
			return ;
		}
		var n = thi.N;
		var r = thi.R;
		if (thi.FILES[r][n].move <= thi.SIZE) {
			if (thi.tokenisgo) {
				setTimeout(function(){
					thi.ajax(s);	
				},300);
				return 0;
			}
			thi.tokenisgo = 1;
			$.token('fileupload', function(code){
				thi.DATA.append('VCodeID', code);
				thi.xhr();
			});
		} else {
			thi.xhr();
		}
	},
	xhr: function() {
		var thi = this;
		if(thi.xisgo){return false;}
		else thi.xisgo=1;
		
		var n = thi.N;
		var r = thi.R;
		var xhr = new XMLHttpRequest();
		var TimeOut;
		xhr.open('POST', thi.URL, true);
		xhr.onreadystatechange = function() {
			clearTimeout(TimeOut);
			TimeOut = setTimeout(function() {
				thi.tokenisgo = 0;
				thi.xisgo = 0;
				if (xhr.readyState == 4 && xhr.status == 200) {
					result = $.json(xhr.responseText);
					if (result.ret == -1) {
						thi.FILES[r][n].move -= thi.SIZE;
						thi.ajax();
					} else {
						if (result.ret == 0) thi.FILES[r][n].progress = 100;
						thi.FILES[r][n].data = result;
						thi.FILES[r][n].result = result;
						thi.callback();
						thi.ajax();
					}
				} else {
					thi.ajax(1);
				}
			}, 100);
		};
		xhr.send(thi.DATA);
	},
	// 回调函数
	callback: function () {
		var thi = this,
			r = thi.R,
			clear = 1;
		thi.el.addClass('is-uploading');
		for(var i in thi.FILES[r]){
			if(parseInt(thi.FILES[r][i].progress)<100){
				clear = 0;
				break;
			}
		}
		$.eval(thi.fn.after, thi.el, thi.FILES[r]);
		if (clear) {
			thi.unset();
		}
	},
	// 释放执行完成的步骤
	unset: function () {
		var thi = this;
		var r = thi.R;
		thi.FILES[r] = {};
		thi.FILESLOGS[r] = [];
		thi.I[r] = 0;
		thi.el.removeClass('is-uploading').val('');
	} 
};