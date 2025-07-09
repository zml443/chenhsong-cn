/**
 * 代码编辑器
 * <div acode='manage|text.php'></div>
 * autoheight 自定义高度
 * save = fn
 * change = fn 
 */
$.task.push(function() {
	// console.log(typeof(ace));
	if (typeof(ace)!='object') {
		return ;
	}
	_('[acode]:not([click])').each(function() {
		if ($(this).parents('[mcscroll]:not(.isok)').size()) {
			return 0;
		}
		$(this).acejscode();
	});
});

$(document).on('keydown', '[acode]', function(e) {
	if (e.which == 8) {
		return false;
	} else if (e.which == 83 && e.ctrlKey) {
		$(this).acejscode_save();
		e.preventDefault();
		return false;
	}
});

$(document).on('click', '[acode][click]', function(e) {
	var thi = $(this);
	WP.$.alert({
		title: '编辑器',
		str: '<div absolute max bianjiqi></div>',
		wh: [980, 800],
		style: 'C',
		type: 'over',
		init: function (a) {
			a.contents.removeAttr('mcscroll');
			a.bd.find('[bianjiqi]').attr({acode:thi.attr('acode'), save:thi.attr('save'), change:thi.attr('change')});
		}
	});
});


$.fn.extend({
	acejscode: function() {
		var obj = this;
		var xxx = {
			I: 0,
			init: function() {
				var w = (location.href.split(location.host)[1]||'').replace(/\?.*$/, '').replace(/[^\/]*$/, '') || '/';
				console.log(w);
				xxx.id = $.rand('acode');
				xxx.file = (obj.attr('acode') || '').split('|');
				xxx.type = xxx.file[0];
				xxx.file = !xxx.file[1] || xxx.file[1].search(/^\//)>=0 ? xxx.file[1]||'' : w+xxx.file[1];
				xxx.theme = obj.attr('theme') || '';
				textarea = obj.find('textarea');
				xxx.name = textarea.attr('name');
				obj.attr({id: xxx.id});
				if (textarea.size()) {
					xxx.value = textarea.val();
					xxx.ace(xxx.value);
				}
				else {
					xxx.ajax(); 
				}
			},
			mode: function() {
				if (obj.is('[mode]')) {
					return 'ace/mode/'+obj.attr('mode');
				}
				m = 'ace/mode/php';
				f = xxx.file;
				if (f.search(/\.js$/) > 0) {
					m = 'ace/mode/javascript';
				} else if (f.search(/\.css$/) > 0) {
					m = 'ace/mode/css';
				} else if (f.search(/\.html?$/) > 0) {
					m = 'ace/mode/html';
				}
				return m;
			},
			/**
			 * 生成编辑器
			 */
			ace: function(data) {
				data = {
					wrap: true,
					mode: xxx.mode(),
					value: data,
					// name: xxx.name,
					autoScrollEditorIntoView: true,
					enableBasicAutocompletion: true,
					enableSnippets: true,
					enableLiveAutocompletion: true,
					// setReadOnly: true,
				};
				if (xxx.theme) data.theme = 'ace/theme/' + xxx.theme;
				// console.log(data);
				window[xxx.id] = ace.edit(xxx.id, data);
				obj.o('ace', window[xxx.id]);
				if (xxx.name) {
					obj.append('<textarea class="hide" name="'+xxx.name+'"></textarea>');
					obj.find('textarea').val(xxx.value);
				}
				var change = function() {
					if (obj.is('[autoheight]')) {
						var h = window[xxx.id].getSession().getScreenLength() * window[xxx.id].renderer.lineHeight + 30;
						$('#' + xxx.id).height(h).find('.ace_fold-widget.ace_start').hide();
						window[xxx.id].resize();
					}
					obj.find('textarea.hide').val(window[xxx.id].getValue());
					$.eval(obj.attr('change'), obj);
				};
				change();
				window[xxx.id].getSession().on('change', change);
				// 不可编辑的状态
				if (obj.is('[acode^="default"]')) {
					window[xxx.id].setReadOnly(true);
				}
				obj.attr({'cansave':'1'}).click(function() {
					window[xxx.id].resize();
				});
			},	
			/**
			 * 获取文件内容
			 * DATA 记录文件内容
			 * SIZE 记录读取的文件数量，用于判断是否加载完成
			 */
			ajax: function() {
				if (!xxx.file) {
					xxx.ace('');
					return;
				}
				$.ajax({
					url: $.path + 'web/ace/do/inc/read.php',
					type: 'POST',
					dataType: 'text',
					contentType: 'application/x-www-form-urlencoded',
					data: {
						type: xxx.type,
						file: xxx.file
					},
					success: function(data) {
						if (data.search(/THE VCODEID ERROR/i)>=0 && xxx.I<20) {
							xxx.I++;
							setTimeout(function(){xxx.ajax()}, 300);
						} else if (data.search(/(THE file DOES NOT EXIST!|NEED TO LOGIN!|INSUFFICIENT PRIVILEGE!)/i)>=0) {
							xxx.error(data);
						} else {
							xxx.ace(data);
						}
					},
					error: function(xhr, status, err) {
						xxx.error('GET TIMEOUT!');
					}
				});
			},
			error: function(data) {
				console.log(data);
			}
		};
		xxx.init();
	},
	/**
	 * 保存
	 */
	acejscode_save: function() {
		var obj = this;
		var w = (location.href.split(location.host)[1]||'').replace(/\?.*$/, '').replace(/[^\/]*$/, '') || '/';
		var file = (obj.attr('acode') || '').split('|');
		if (obj.is('[isacesave]') || !obj.is('[cansave]')) {
			return 0;
		}
		if (!file[1]) {
			$.eval(obj.attr('save'), obj);
			return;
		}
		obj.attr({isacesave: ''});
		$.ajax({
			url: $.path + 'web/ace/do/inc/save.php',
			type: 'POST',
			dataType: 'text',
			contentType: 'application/x-www-form-urlencoded',
			data: {
				type: file[0],
				file: file[1].search(/^\//)>=0 ? file[1] : w + file[1],
				data: obj.aceData()
			},
			success: function(data) {
				obj.removeAttr('isacesave');
				$.eval(obj.attr('save'), obj);
			},
			error: function(xhr, status, err) {
				obj.removeAttr('isacesave');
				$.eval(obj.attr('save'), obj);
			}
		});
	},
	/**
	 * 获取编辑器的内容
	 */
	aceData: function() {
		var id = this.attr('id');
		return window[id].getValue();
	}
});