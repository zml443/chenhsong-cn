// 编辑器模板
$.include($.path + 'web/ueditor/dialogs/module/list.js');
$.task.push(function () {
	// 普通编辑器
	_('[ueditor="1"],[ueditor="simple"]').each(function () {
		var e = $(this);
		var u = 'Ueditor' + Math.random().toString().replace(/\./,'');
		e.attr({id:u,eu:u}).css({height:e.attr('height'), width:e.parent().width()});
		e.addClass('isok').parents('[jxloading]').addClass('isok');
		WP[u] = UE.getEditor(u,{
			height: e.attr('height')||500,
    		zIndex : 7,
		});
		var ud = WP[u];
		ud.addListener('selectionchange', function (type, event) {
			UeditorSelectionchangeColor(u);
		});
		ud.addListener('ready', function(){
			UeditorSelectionchangeColor(u);
		});
		ud.addListener('focus', function(e) {
		   	// 全部内容选中
		   	if (ud.CanSelectAll == 1) {
		   		setTimeout(function() {
		   			ud.CanSelectAll = 0;
		   		}, 300);
			   	var d = ud.iframe.contentDocument;
			   	var body = $(d).find('body')[0];
			 	d.getSelection().selectAllChildren(d.body.parentNode)
		   	}
		});
		// 绑定事件
		WP.$.__ueditor.on(u, e);
	});

	// 会员专用
	_('[ueditor="2"],[ueditor="member"]').each(function() {
		var e = $(this);
		/*var val = e.val();
		if (val.indexOf('　')<0) {
			e.val(val+'　');
		}*/
		var u = 'Ueditor' + Math.random().toString().replace(/\./, '');
		var top = e.attr('top')||'0';
		if (top.search(/[a-zA-Z]/)>=0) {
			top = $(top).outerHeight()||0;
		}
		e.attr({id:u,eu:u}).css({height:e.attr('height'), width:e.parent().width()});
		e.addClass('isok').parents('[jxloading]').addClass('isok');
		WP[u] = UE.getEditor(u, {
			serverUrl: $.path + "web/ueditor/managephp/controller.php",
			height: e.attr('height')||500,
    		offsetTop: parseInt(top),
    		zIndex : 1,
			toolbars: [[
				/*'fullscreen', 'source', '|',*/ 'undo', 'redo', '|',
				'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', /*'formatmatch',*/ 'autotypeset', /*'blockquote',*/ 'pasteplain', '|', 'forecolor', /*'backcolor',*/ 'insertorderedlist', 'insertunorderedlist', 'selectall', /*'cleardoc',*/ '|',
				'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
				/*'customstyle', 'paragraph', 'fontfamily',*/ 'fontsize', '|',
				/*'directionalityltr', 'directionalityrtl',*/ 'indent', '|',
				'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
				'link', 'unlink', 'anchor', '|', /*'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',*/
				/*'simpleupload',*/ 'insertimage', 'mypic', /*'insertvideo',*/ /*'attachment',*/ /*'insertframe',*/ 'pagebreak', /*'template',*/ '|',
				'horizontal', 'spechars', '|',
				'inserttable', /*'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts',*/ /*'|',
				'print', 'preview', 'searchreplace', 'help'*/
			]],
			labelMap:{'mypic': '站内图片'}
		});
		WP[u].addListener('ready', function() {
			$('#' + u + ' .edui-default .edui-for-insertimage .edui-icon').remove();
			$('#' + u + ' .edui-default .edui-for-mypic .edui-icon').attr({'file-selector':'member', fn:'WP.$.__ueditor.mypic('+u+')'});
		});
		// 绑定事件
		WP.$.__ueditor.on(u, e);
	});

	// 管理员专用
	_('[MUeditor],[ueditor="3"],[ueditor="manage"]').each(function() {
		var e = $(this);
		/*var val = e.val();
		if (val.indexOf('　')<0) {
			e.val(val+'　');
		}*/
		var u = 'Ueditor' + Math.random().toString().replace(/\./, '');
		var top = e.attr('top')||'0';
		if (top.search(/[a-zA-Z]/)>=0) {
			top = $(top).outerHeight()||0;
		}
		e.attr({id:u,eu:u}).css({height:e.attr('height'), width:e.parent().width()});
		e.addClass('isok').parents('[jxloading]').addClass('isok');
		WP[u] = UE.getEditor(u, {
			serverUrl: $.path + "web/ueditor/managephp/controller.php",
			height: e.attr('height')||500,
    		zIndex : 1,
    		offsetTop: parseInt(top),
			toolbars: [[
				'fullscreen', 'source', '|', 'undo', 'redo', '|',
				'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', /*'blockquote',*/ 'pasteplain', '|', 'forecolor', /*'backcolor',*/ 'insertorderedlist', 'insertunorderedlist', /*'selectall', 'cleardoc',*/ '|',
				'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
				/*'customstyle',*/ 'paragraph', 'fontfamily', 'fontsize', '|',
				/*'directionalityltr', 'directionalityrtl',*/ 'indent', /*'|',*/
				'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
				'link', 'unlink', 'anchor', 'code', '|', /*'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',*/
				/*'simpleupload',*/ 'insertimage', 'mypic', 'insertvideo', /*'attachment', 'insertframe',*/ 'pagebreak', /*'ueditormodule', 'template',*/ '|',
				'horizontal', 'spechars', '|',
				'inserttable', /*'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts',*/ '|',
				'print', /*'preview',*/ 'searchreplace', 'help'
			]],
			labelMap:{'mypic':'站内图片', 'ueditormodule':'模板', 'code':'代码'}
		});
		WP[u].addListener('ready', function () {
			$('#' + u + ' .edui-default .edui-for-insertimage .edui-icon').remove();
			$('#' + u + ' .edui-default .edui-for-mypic .edui-icon').attr({'file-selector':'manage', fn:'WP.$.__ueditor.mypic', 'data-u':u});
			$('#' + u + ' .edui-default .edui-for-code .edui-icon').attr({onclick:'WP.$.__ueditor.code("'+u+'")'});
			if (e.is('[ueditormodule]')) {
				$('#' + u + ' .edui-default .edui-for-ueditormodule .edui-icon').remove();
			} else {
				$('#' + u + ' .edui-default .edui-for-ueditormodule .edui-icon').attr({'ueditor-module':e.attr('ueditor-module')||'manage', fn:'WP.$.__ueditor.module', 'data-u':u});
			}
		});
		// 绑定事件
		WP.$.__ueditor.on(u, e);
	});

	// 模板专用
	_('[ueditor="jmdl"]').each(function() {
		var e = $(this);
		var u = 'Ueditor' + Math.random().toString().replace(/\./, '');
		e.attr({id:u,eu:u}).css({height:e.attr('height'), width:e.parent().width()});
		e.addClass('isok').parents('[jxloading]').addClass('isok');
		WP[u] = UE.getEditor(u, {
			serverUrl: $.path + "web/ueditor/managephp/controller.php",
			height: e.attr('height')||500,
    		zIndex : 9999,
    		offsetTop: e.attr('top')||0,
			toolbars: [[
				'source', '|', 'undo', 'redo', '|',
				'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
				'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
				'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
				'directionalityltr', 'directionalityrtl', 'indent', '|',
				'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
				'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
				/*'simpleupload',*/ 'insertimage', 'mypic', 'insertvideo', /*'attachment', 'insertframe',*/ 'pagebreak', 'ueditormodule', /*'template',*/ '|',
				'horizontal', 'spechars', '|',
				'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
				'print', /*'preview',*/ 'searchreplace', 'help'
			]],
			labelMap:{'mypic':'站内图片', 'ueditormodule':'模板'}
		});
		WP[u].addListener('ready', function () {
			$('#' + u + ' .edui-default .edui-for-insertimage .edui-icon').remove();
			$('#' + u + ' .edui-default .edui-for-mypic .edui-icon').attr({'file-selector':e.attr('file-selector')||'manage', fn:'WP.$.__ueditor.mypic', 'data-u':u});
			if (e.is('[ueditormodule]')) {
				$('#' + u + ' .edui-default .edui-for-ueditormodule .edui-icon').remove();
			} else {
				$('#' + u + ' .edui-default .edui-for-ueditormodule .edui-icon').attr({'ueditor-module':e.attr('ueditor-module')||'manage', fn:'WP.$.__ueditor.module('+u+')', ue:u});
			}
		});
		// 绑定事件
		WP.$.__ueditor.on(u, e);
	});
});

function UeditorSelectionchangeColor(u){
	var edi = UE.getEditor(u);
	var htm = edi.getContent();
	var txt = $(htm).find('body').html() || htm;
	if (txt && txt.search(/color: rgb\(2[0-9]{0,2}, 2[0-9]{0,2}, 2[0-9]{0,2}\)/) > 0) {
		$('#' + u).find('.edui-editor-iframeholder.edui-default').css({backgroundColor: '#59cbff'});
	} else {
		$('#' + u).find('.edui-editor-iframeholder.edui-default').css({backgroundColor: '#ffffff'});
	}
}

if (!WP.$.__ueditor) WP.$.__ueditor = {
	// 获取文件银行的文件链接
	mypic: {
		change: function (el, file) {
			var u = el.attr('data-u'),
				NotImg = 0;
			for (var i in file) {
				if (file[i].path.search(/.(mp4)$/)>0) {
					// WP[u].execCommand('insertHtml', "<video width='500' src='" + file[i].path + "' controls></video><p style='font-size:0'>　</p>");
					WP.$.alert({
						title: '设置视频宽高',
						str: 
							'<table>'+
								'<tr>' +
									'<td>宽度：</td>' +
									'<td><input w type="text" style="border:1px solid #ddd; border-radius:3px; height:30px; width:260px;; text-indent:6px" value="950" /></td>' +
								'</tr>' +
								'<tr><td style="height:12px"></td><td></td></tr>' +
								'<tr>' +
									'<td>高度：</td>' +
									'<td><input h type="text" style="border:1px solid #ddd; border-radius:3px; height:30px; width:260px; text-indent:6px" value="510" /></td>' +
								'</tr>' +
							'</table>'
						,
						cancel: 1,
						confirm: function (alert_el) {
							var w = parseInt(alert_el.find('[w]').val())||950;
							var h = parseInt(alert_el.find('[h]').val())||510;
							WP[u].execCommand('insertHtml', "<p><iframe class='ued-video' width='"+w+"' height='"+h+"' src='" + file[i].path + "' frameborder='0' scrolling='no' allowfullscreen='allowfullscreen'></iframe></p>");
						}
					});
				} else if (file[i].path.search(/.(png|jpe?g|gif|ico|webp)$/i)<0) {
					NotImg = 1;
					continue;
				} else {
					WP[u].execCommand('insertHtml', "<img src='" + file[i].path + "' />");
				}
			}
			if (NotImg) {
				$.alert({
					str: '此类型文件无法插入编辑器',
					style: 'B',
					confirm: 1,
				});
			}
		}
	},
	/**
	 * 编辑模板内容
	 * @param {string} u 编辑器的下标
	 * @param {string} con 插入代码
	 * @return {void}
	 */
	module: {
		change: function (el, con) {
			var u = el.attr('data-u');
			WP[u].execCommand('insertHtml', con);
		}
	},
	/**
	 * 编辑模板内容
	 * @param {string} u 编辑器的下标
	 * @return {void}
	 */
	code: function (u) {
		WP[u].execCommand('insertHtml', '<pre><br/></pre>');
	},

	// 绑定事件
	on_status:{},
	on: function (u, obj) {
		var thi = this;
		var a = ['selectionchange', 'keydown', 'ready', 'blur', 'focus'];
		for (var i in a) {
			go(a[i]);
		}
		function go (onk) {
			WP[u].addListener(onk, function () {
				if (onk=='selectionchange') onk = 'change';
				// 内容更新后触发
				clearTimeout(thi.on_status[u]);
				thi.on_status[u] = setTimeout(function () {
					if (obj.is('textarea')) obj.val(WP[u].getContent());
					obj.trigger(onk);
				}, 600);
				$.eval(obj.attr(onk), obj, WP[u]);
			});
		}
		WP[u].ready(function(){
			if (obj.next().is('.ueditordiv')) {
				WP[u].setContent(obj.next().html());
				obj.next().remove();
			}
			UE.dom.domUtils.on(WP[u].body, 'keydown', function (e) {
				var e = e||window.e;
				var code = e.keyCode||e.which||e.charCode;
				var ctrl = e.ctrlKey||e.metaKey;
				if (code==83 && ctrl) {
					$('[id="'+u+'"]').parents('form').submit();
					WP[u].blur();
					e.returnValue = false;
				}
			});
		});
	}
};

$(document).on('focus', '[ueditor]', function () {
	var u = $(this).attr('eu');
	WP[u].focus();
});