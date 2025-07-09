

// $.include($.path + 'web/file/selector/style/1.css', 1);

$.task.push(function() {
	_('[file-selector][list]').each(function() {
		$.__file_selector_style.init($(this));
	});
});

$.__file_selector_style = {
	svg: {
		del: '<svg class="svg" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" height="20"><path d="M202.666667 256h-42.666667a32 32 0 0 1 0-64h704a32 32 0 0 1 0 64H266.666667v565.333333a53.333333 53.333333 0 0 0 53.333333 53.333334h384a53.333333 53.333333 0 0 0 53.333333-53.333334V352a32 32 0 0 1 64 0v469.333333c0 64.8-52.533333 117.333333-117.333333 117.333334H320c-64.8 0-117.333333-52.533333-117.333333-117.333334V256z m224-106.666667a32 32 0 0 1 0-64h170.666666a32 32 0 0 1 0 64H426.666667z m-32 288a32 32 0 0 1 64 0v256a32 32 0 0 1-64 0V437.333333z m170.666666 0a32 32 0 0 1 64 0v256a32 32 0 0 1-64 0V437.333333z" fill="#fff"></path></svg>',
		edit: '<svg class="svg" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="7239" height="18"><path d="M870.093413 512c-16.481086 0-29.841118 13.360032-29.841118 29.841118l0 332.624224c0 14.004886-11.514379 25.46919-25.645988 25.46919l-664.89485 0c-14.124455 0-25.645988-11.53584-25.645988-25.645988l0-664.89485c0-14.203146 11.433645-25.645988 25.665405-25.645988L482.158882 183.747705c16.481086 0 29.841118-13.360032 29.841118-29.841118s-13.360032-29.841118-29.841118-29.841118L149.730874 124.065469C102.525701 124.065469 64.383234 162.240639 64.383234 209.393693l0 664.89485C64.383234 921.345533 102.610523 959.616766 149.711457 959.616766l664.89485 0c47.035529 0 85.328224-38.126116 85.328224-85.151425L899.934531 541.841118C899.934531 525.360032 886.574499 512 870.093413 512z" fill="#fff"></path><path d="M930.546204 93.428248c-38.721916-38.721916-101.637621-38.736224-140.391218 0.016351L290.569709 593.029876l-3.154778 3.154778-1.703601 4.122571-56.258683 136.124551c-16.928703 40.96 11.810747 70.758196 53.260263 55.097741l140.315593-53.013972 4.507848-1.703601 3.407202-3.407202 499.585277-499.585277C969.305932 195.042363 969.313086 132.194108 930.546204 93.428248zM402.699752 698.345517l-129.257006 48.836216 51.931721-125.654611 2.655042-2.655042 77.07184 77.07184L402.699752 698.345517zM436.753373 664.292918l-77.07184-77.07184 366.434619-366.434619 77.07184 77.07184L436.753373 664.292918zM898.877828 202.167441l-64.039856 64.039856-77.07184-77.07184 64.039856-64.039856c21.26895-21.26895 55.843768-21.261796 77.088192-0.016351C920.179481 146.363529 920.176415 180.869876 898.877828 202.167441z" fill="#fff"></path></svg>',
		show: '<svg class="svg" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" height="20"><path d="M512 832c-156.448 0-296.021333-98.730667-418.410667-291.605333a52.938667 52.938667 0 0 1 0-56.789334C215.978667 290.730667 355.552 192 512 192c156.448 0 296.021333 98.730667 418.410667 291.605333a52.938667 52.938667 0 0 1 0 56.789334C808.021333 733.269333 668.448 832 512 832z m0-576c-129.514667 0-249.461333 83.850667-360.117333 256C262.538667 684.149333 382.485333 768 512 768c129.514667 0 249.461333-83.850667 360.117333-256C761.461333 339.850667 641.514667 256 512 256z m0 405.333333c-83.210667 0-150.666667-66.858667-150.666667-149.333333S428.789333 362.666667 512 362.666667s150.666667 66.858667 150.666667 149.333333S595.210667 661.333333 512 661.333333z m0-64c47.552 0 86.101333-38.208 86.101333-85.333333S559.552 426.666667 512 426.666667c-47.552 0-86.101333 38.208-86.101333 85.333333s38.549333 85.333333 86.101333 85.333333z" fill="#fff"></path></svg>',
	},
	// 初始化
	init: function(a) {
		this.ui(a);
	},
	// 样式
	decode: function(htm) {
		htm = htm.replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
		return $.json(htm);
	},
	ui: function(a) {
		var thi = this;
		var s = thi.decode(a.find('textarea').val()||a.html());
		var n = a.attr('name');
		var k = a.attr('json');
		var h = '';
		var fs = a.attr('file-selector') || '';
		var g_type = a.attr('data-type') || '';
		var ul = $('<ul xczdwqewboxt1 dragsort fn="WP.$.__file_selector_style.dragsort" class="clean"></ul>');
		ul.attr({name:n+'[]', json:k});
		for (var i in s) {
			h += thi.uihtml(ul, s[i]);
		}
		h += `
			<div tli add class="pointer m-pic relative" file-selector="${fs}" data-type="${g_type}" fn="WP.$.__file_selector_style.use">
				<i class="inline-block v-middle"></i>
			</div>
		`;
		a.removeAttr('file-selector').html(ul.html(h)).find('[tli] [edit]').trigger('click');
		thi.dragsort.change(ul);
	},
	uihtml: function(a, v) {
		if (typeof(v)!='object' && typeof(v)!='array') return '';
		var p = '';
		var n = a.attr('name');
		for (var i in v) {
			p += '<textarea class="hide" name="' + n + '[' + i + ']">' + v[i] + '</textarea>';
		}
		var h = 
			'<li tli class="m-pic relative">' +
				'<img file-ext="' + v.path + '" />' +
				'<div num class="nowrap">0</div>' +
				'<div tool stop-drag>' +
					'<a class="m-pic" delete title="'+$.lang.global.delete+'">'+this.svg.del+'</a>' +
					'<a class="m-pic" edit title="'+$.lang.global.edit+'">'+this.svg.edit+'</a>' +
					'<a href="' + v.path + '" class="m-pic" target="_blank" title="'+$.lang.global.show+'">'+this.svg.show+'</a>' +
				'</div>' + p +
			'</li>'
		;
		return h;
	},
	// 拖拽-改变
	dragsort: {
		change: function(el) {
			var name = el.attr('name').replace(/\[\]$/, ''),
				r = new RegExp('^' + name.replace(/\[/g, '\\[').replace(/\]/g, '\\]') + '\\[[0-9]*\\]', '');
			el.children('li').each(function(i) {
				var cur = $(this);
				cur.find('[num]').html(i + 1);
				cur.find('input,textarea').each(function() {
					var n = $(this).attr('name');
						n = n.replace(r, name + '\[' + i + '\]');
					$(this).attr('name', n);
				});
			});
			if (el.children('li').size()) {
				el.find('._tmp_file_input').remove()
			} else {
				el.children('div').append('<input type="hidden" class="_tmp_file_input" name="'+name+'" value="" />')
			}
		}
	},
	// 改变
	use: {
		change: function(el, files) {
			var thi = $.__file_selector_style,
				a = el.parents('ul[dragsort]'),
				h = '';
			// console.log(el, files);
			for (var i in files) {
				h += thi.uihtml(a, {
					path: files[i].path
				});
			}
			a.children('[tli]:last').before(h);
			thi.dragsort.change(a);
			a.trigger('change');
			// a.find('input,textarea').trigger('change');
		}
	},

	// 图片上面加图片
	add_img: {
		change: function (el, file) {
			el.siblings('[ex]').val(file[0].path);
			el.siblings('[imgView]').find('img').attr('file-ext',file[0].path);
		}
	}
};

$(document).on('click', '[fn^="WP.$.__file_selector_style."] [delete]', function() {
	var el = $(this),
		ul = el.parents('[dragsort]');
	el.parents('li[tli]').remove();
	$.__file_selector_style.dragsort.change(ul);
});


//修改图片路径
$(document).on('mousedown click', '[fn^="WP.$.__file_selector_style."] [edit]', function(event) {
	var thi = $(this).parents('[tli]');
	var par = thi.parents('[dragsort]');
	var jso = $.json(par.attr('json')),
		pho = thi.find('[name$="[path]"]').val(),
		htm = 
			'<tr>' +
				'<td td1 class="nowrap">'+$.lang.form.path+'</td>' +
				'<td td2>' +
					// '<div input><b></b><input rows="4" ex="path" value="' + pho + '"></div>' +
					'<div input class="path-inp relative">' +
						'<input ex="path" value="' + pho + '" />' +
						'<div class="img-view m-pic" imgView><img file-ext="'+pho+'" /></div>' +
						'<div class="img-upload pointer" file-selector="manage" data-zindex="521" fn="WP.$.__file_selector_style.add_img">选择</div>' +
					'</div>' +
				'</td>' +
			'</tr>'
		,
		num = 1;
	var tip = tips = '', langhtml = '', tabrand = ('filelist'+Math.random()).replace(/\./, '');
	var narr = {};
	for (var i in $.language.all) {
		langhtml += '<div class="inline-block" lang="'+$.language.all[i]+'">'+$.language.all[i]+'</div>';
	}
	for (var i in jso) {
		inp = tip = '';
		if (typeof(jso[i])!='object' || jso[i]==null || !jso[i].Type) continue;
		if (jso[i].Lang) {
			var lang = $.language.all;
		}
		else {
			var lang = [''];
		}
		for (var k in lang) {
			num++;
			j = lang[k] ? '_'+lang[k] : '';
			v = thi.find('[name*="[' + i + j + ']"]').val() || '';
			inp += '<div class="'+(k>0?'hide':'')+'">';
			if (jso[i].Type.search(/textarea/i) >= 0) {
				inp +=
					'<div input>' +
						'<textarea  class="scrollbar" rows="4" ex="' + i + j + '">' + v + '</textarea>' +
					'</div>'
				;
			}
			else if (jso[i].Type.search(/color/i) >= 0) {
				inp +=
					'<div input>' +
						'<input ex="' + i + j + '" color-selector value="' + v + '" />' +
					'</div>'
				;
			}
			else if (jso[i].Type.search(/img|image|file/i) >= 0) {
				inp +=
					'<div input class="path-inp relative">' +
						'<input ex="' + i + j + '" value="' + v + '" />' +
						'<div class="img-view m-pic" imgView><img file-ext="'+v+'" /></div>' +
						'<div class="img-upload" file-selector="manage" data-zindex="521" pointer fn="WP.$.__file_selector_style.add_img">选择</div>' +
					'</div>'
				;
			}
			else if (jso[i].Type.search(/radio/i) >= 0) {
				for(var n in jso[i]['Args']){
					var chk = n==v?'checked':'';
					inp+='<label class="choice"><input type="radio" ex="'+i+'" name="'+i+'" value="'+n+'" '+chk+' >'+jso[i]['Args'][n]+'</label>'
				}
			}
			else if (jso[i].Type.search(/open/i) >= 0) {
				var chk = v?'checked':'';
				inp+='<label class="switchery"><input type="checkbox"  value="1" '+chk+' /><input type="hidden" ex="'+i+'" name="'+i+'" value="'+v+'" /></label>'
			}
			else if (jso[i].Type.search(/position/i) >= 0) {
				inp += '<div class="position flex-wrap">';
				for (var n=1; n<=9; n++) {
					var chk = n==v?'checked':'';
					inp += '<label><input class="hide" type="radio" name="'+i+j+'" ex="'+i+j+'" value="'+n+'" '+chk+' /></label>';
				}
				inp += '</div>';
			}
			else {
				inp +=
					'<div input>' +
						'<textarea ex="' + i + j + '" style="min-height:inherit;" autoheight notenter>' + v + '</textarea>' +
					'</div>'
				;
			}
			inp += '</div>';
			narr[i + j] = v;
			tip +=
				'<div input>' +
					'<b>' + j + '</b>：' + v +
				'</div>'
			;
		}
		htm += '<tr><td td1 class="nowrap">' + jso[i].Name + '</td><td td2 '+(jso[i].Lang?tabrand:'')+'>' + inp + '</td></tr>';
		tips += '<tr><td td1 class="nowrap v-top">' + jso[i].Name + '</td><td td2 v-top>' + tip + '</td></tr>'
	}
	if (tips) thi.attr({'tip-for':'<table style="max-width:600px">'+tips+'</table>', 'data-color':'#b89670, #fff'});
	if (event.type=='click') {
		return 0;
	}
	WP.$.alert({
		title: $.lang.global.edit,
		str:
			'<div zxcasdqwenk12>' +
				'<div class="language" tab="{}" to="['+tabrand+']">'+langhtml+'</div>'+
				'<table class="maxw">' + htm + '</table>' +
			'</div>'
		,
		class: 'file-selector-al',
		wh: [600, 0],
		xy: $.xy(event, function(x, y) {return [x - 100, y - 200]}),
		init: function(alert_el){
			// 当发现没有多语言的时候隐藏语言切换
			if (alert_el.find('['+tabrand+']>*').size()<2) {
				alert_el.find('.language').hide();
			}
		},
		zIndex: 501,
		cancel: 1,
		confirm: function(alert_el){
			thi.find('textarea.hide').remove();
			alert_el.find('textarea, input:not([type=radio],[type=checkbox]), input:checked, select').each(function(i, e) {
				x = $(this).attr('ex');
				v = $(this).val() || '';
				if (thi.find('[name$="[' + x + ']"]').size() == 0) {
					var name = par.attr('name');
					thi.append('<textarea class="hide" name="' + name + '[' + x + ']"></textarea>');
				}
				thi.find('[name$="[' + x + ']"]').val(v);
				if (x == 'path') {
					thi.find('img').attr('file-ext', v);
				}
			});
			$.__file_selector_style.dragsort.change(par);
			thi.find('[edit]').trigger('click');
		}
	});
});