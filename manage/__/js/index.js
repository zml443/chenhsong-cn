
var $dbs = {
	is_add: 0,
	is_mod: 0,
	// 用于监控是否修改过内容
	lydbs_has_change_form: 0,
	ma(){
		var c = location.href.replace(/^([\s\S]*)\?[\s\S]*#?[\s\S]*?$/,'$1');
		var h = location.href.replace(/^[\s\S]*\?([\s\S]*)#?[\s\S]*?$/,'$1').split('&');
		var x = [];
		for(var i in h){
			if (h[i].search(/^m?a?=/)>=0) x.push(h[i]);
		}
		var r = c+'?'+x.join('&');
		return r;
	},

	// 获取完整的参数
	query_string(s){
		let q = $.query_string('',s);
		if (q.mg) {
			q.ma = q.mg;
		}
		if (q.ma) {
			let a = q.ma.split('/');
			q.m = a[0];
			q.a = ((a[1]||'')+'/'+(a[2]||'')).replace(/^\/|\/+$/,'');
			if (!q.mg) q._ifr_ = 1;
		}
		q.U = (q.u||'').split(',');
		q.ma = (q.m+'/'+q.a).replace(/^\/|\/+$/,'');
		return q;
	},

	// 弹窗的数组，按照后入栈先出栈的方式
	popup:[],
	popup_remove($type){
		for (let i=WP.$dbs.popup.length-1; i>=0; i--) {
			let v = WP.$dbs.popup[i]
			let nx = WP.$dbs.popup[i-1]
			if (v.el.size()) {
				if (!$type) {
					if (v.btnEl && v.btnEl.is('[is-end-flush]')) v.jq.flush();
					v.el.popup_remove();
				}
				if (nx) {
					// nx.el.find('iframe').attr('src', nx.el.find('iframe').attr('src'));
					nx.el.find('iframe')[0].contentWindow.$.flush();
				}
				WP.$dbs.popup.splice(i, 1);
				break;
			} else {
				WP.$dbs.popup.splice(i, 1);
			}
		}
	},

	// 页面跳转
	href(href, el){
		if (!href) {
			return false
		}
		let q = this.query_string();
		let qCur = this.query_string(href);
		let fn;
		if (el) {
			fn = $.callbackfn(el.attr('fn'), 'init,end,confirm,change');
		}
		if (href=='back()') {
			if ((q._popup_ || q._popup_top_ || q._popup_left_ || q._popup_right_ || q._popup_bottom_ || q._alert_ || q._alert_side_) && !q._popup_dept_) {
				$dbs.popup_remove()
			} else {
				history.back();
			}
		} else {
			// 获取 _choice_ids
			if (href.indexOf('_choice_ids')>0) {
				let _choice_ids = (el.is('[data-ids]')?el.attr('data-ids'):el.find('[type="hidden"]').val()) || '';
				href = href.replace(/(&)?_choice_ids([^&]*)?(&)?/, '$1_choice_ids='+_choice_ids+'$2$3');
			}
			// 弹窗
			if (qCur.pg && (q._popup_ || q._popup_top_ || q._popup_left_ || q._popup_right_ || q._popup_bottom_)) {
				location.href = href+'&_popup_=1';

			} else if (qCur._popup_ || qCur._popup_top_ || qCur._popup_left_ || qCur._popup_right_ || qCur._popup_bottom_) {
				let popup = WP.$.iframeBox({
					url: href,
					side: (qCur._popup_right_?'right':(qCur._popup_left_?'left':'')),
					zIndex: 500,
					confirm(a, b, c){
						if (fn) $.eval(fn.confirm, el, a, b, c);
					},
					change(a, b, c){
						if (fn) $.eval(fn.change, el, a, b, c);
					},
					end(a,b,c){
						if (fn) $.eval(fn.end, el, a, b, c);
						if (el && el.is('[is-end-flush]')) $.flush();
						$dbs.popup_remove(1);
					},
				});
				WP.$dbs.popup.push({
					el: popup,
					btnEl: el,
					jq: $,
					type: 'popup',
				});
			} else if (qCur._alert_) {
				let popup = WP.$.alert({
					id: qCur.ma+'-'+qCur.Id,
					url: href+'&_alert_=1',
					wh: [qCur._w_||780, qCur._h_],
					zIndex: 500,
					end(a, b, c){
						if (fn) $.eval(fn.end, el, a, b, c);
						if (el && el.is('[is-end-flush]')) $.flush();
						$dbs.popup_remove(1);
					}
				});
				WP.$dbs.popup.push({
					el: popup,
					btnEl: el,
					jq: $,
					type: 'alert',
				});
			} else if (qCur._alert_side_ || q._alert_side_ || q._popup_ || q._alert_ || q._popup_top_ || q._popup_left_ || q._popup_right_ || q._popup_bottom_) {
				let popup = WP.$.alert_side({
					id: qCur.ma+'-'+qCur.Id,
					data: {
						url: href+'&_alert_side_=1'
					},
					zIndex: 500,
					css: {width:qCur._w_||780, right:0},
					end(a, b, c){
						if (fn) $.eval(fn.end, el, a, b, c);
						if (el && el.is('[is-end-flush]')) $.flush();
						$dbs.popup_remove(1);
					}
				});
				WP.$dbs.popup.push({
					el: popup,
					btnEl: el,
					jq: $,
					type: 'alert_side',
				});
			} else {
				WP.manage.src(href)
			}
		}
		WP.$dbs.lydbs_has_change_form = 0;
	}
}

// 退出登录
//////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '[manage-logout]', function () {
	var language = $(this).attr('change-manage-language');
	$.async('POST', '?ma=account/logout', {}, function () {
		window.location.reload();
	});
});
//////////////////////////////////////////////////////////////////////////////////////////



// 语言切换
//////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '[manage-language]', function () {
	var language = $(this).attr('manage-language');
	$.async('POST', '?ma=language/_manage', {lang:language}, function () {
		window.location.reload();
	});
});
$(document).on('click', '[front-end-language]', function () {
	var language = $(this).attr('front-end-language');
	$.async('POST', '?ma=language/_front_end', {lang:language}, function () {
		window.location.reload();
	});
});
//////////////////////////////////////////////////////////////////////////////////////////



// AI 智能管家
//////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '.zml_click_to_ai', function(){
	WP.$.alert_side({
		id: 'ai-xxx',
		data: {
			url: '/tools/ai/dist'
		},
		// bg: 0,
		// close: 1,
		css: {width:700, right:0},
		end(alertside_el) {
			// 
		}
	});
});
//////////////////////////////////////////////////////////////////////////////////////////



// 弹窗
//////////////////////////////////////////////////////////////////////////////////////////
/*$(document).on('click', '[lydbs-popup]', function () {
	var url = $(this).attr('data-url');
	WP.$.iframeBox({
		url: url,
		init(alert_el, files, obj){
			// 
		},
		change(alert_el, files, obj){
			obj.alert_el = alert_el;
			$.eval(fn.change, el, files, obj);
		},
	});
});*/
//////////////////////////////////////////////////////////////////////////////////////////



// 筛选
//////////////////////////////////////////////////////////////////////////////////////////
$(document).on('submit', '[lydbs-search-form]', function(){
	var el = $(this);
	var fn = $.callbackfn(el.attr('fn'),'before,after,error');
	if ($.G.event.search.ajax_change) {
		$.eval(fn.before, el, '');
		if ($.G.event.search.before) $.G.event.search.before();
		$.async('GET', '', el.serializeArray(), result=>{
			var body = $($.htmlbody(result));
			$.G.event.search.ajax_change.map(v=>{
				$('[ajax-change="'+v+'"]').html(body.find('[ajax-change="'+v+'"]').html());
			});
			$.eval(fn.after, el, result);
			if ($.G.event.search.after) $.G.event.search.after(result);
		});
		return false;
	}
});
var lydbs_search_data = {
	init(form_el){
		this.form_el = form_el;
		this.data = $.json((this.form_el.find('[lydbs-search-json]').html()||'').replace(/<\\\/script>/g,'<\/script>').replace(/^\s+|\s+$/g,''));
		if (this.data.length==0) {
			this.form_el.find('[lydbs-search-btn]').hide();
		}
	},
	show(form_el, option){
		var _this = this;
		lydbs_search_data.init(form_el);
		WP.$.alert_side({
			data: `
				<div class="flex-column maxh">
					<div class="maxw ly-h4 mt_45px mb_20px flex-middle2" cw="100%">
						<span>${$.lang.global.sifting}</span>
						<i class="lyicon-close ly-h3 ml_50px return pointer"></i>
					</div>
					<div class="maxw flex-1 body p_0_20px" style="height:1px;overflow:auto;">
						<form>
						${_this.data.map((v, k)=>{
							return `
								<div class="p_20px ${k?'mt_20px':''}" bg="default">
									<div class="fz16">${v.name}</div>
									<div class="mt_10px">${v.value}</div>
								</div>
							`;
						}).join('')}
						</form>
					</div>
					<div class="alert_side_btn_box maxw" bg="default">
						<div cw="100%">
							<div class="ly_btn_radius width100 mr_25px submit pointer" bg="main" size="small">${$.lang.global.confirm}</div>
							<div class="ly_btn_radius width100 return pointer" border="default" bg="white" size="small">${$.lang.global.back}</div>
						</div>
					</div>
				</div>
			`,
			css: {right:0, width:460},
			init(el){
				var inputbox = _this.form_el.find('[lydbs-search-input]');
				el.on('click', '.return', function(){
					el.popup_remove();
				});
				el.on('click', '.submit', function(){
					var form = el.find('form').serializeArray();
					var inp = '';
					for (var v of form) {
						inputbox.parents('form:eq(0)').find('[name="'+v.name+'"]').remove();
						inp += `<textarea name="${v.name}">${v.value}</textarea>`;
					}
					inputbox.html(inp).parents('form').submit();
					el.popup_remove();
				});
			}
		});
	}
};
// 删除选择
lydbs_search_data.delete_xz=(el, option)=>{
	el = $(el);
	option = {...option}
	var $to = $(el.attr('to'));
	var $name = el.attr('data-name');
	console.log($to.find('[name="'+$name+'"]'))
	$to.find('[name="'+$name+'"]').remove();
	if (option.fn) option.fn();
	else $to.submit();
}
$.task.push(()=>{
	_('[lydbs-search-form]').each(function(){
		lydbs_search_data.init($(this));
	});
});
// 弹出筛选窗口
$(document).on('click', '[lydbs-search-btn]', function(){
	lydbs_search_data.show($(this).parents('[lydbs-search-form]'));
});
// 删除筛选项
// $(document).on('click', '[lydbs-search-xz]', function(){
// 	var get = $(this).attr('lydbs-search-xz').replace(/([\[\]])/g, '\\$1');
// 	var reg = new RegExp("&"+get+"=([^&]*)", 'g');
// 	var url = decodeURIComponent(location.href).replace(reg, '');
// 	WP.manage.src2(url);
// });
//////////////////////////////////////////////////////////////////////////////////////////




// 编辑页form提交
/////////////////////////////////////////////////////////////////////////////
var dbs_submit = {
	post(form, fn){
		if (!$('body').is('.is-loading-completed')) {
			$.alert($.lang.notes.not_ready, 3000);
			return false;
		}
		var url = form.attr('action')||'',
			check;
		if (check=form.check_form()) {
			$.alert(check[0].tip, 2500);
			return false;
		}
		var loading = WP.$.alert('loading...');
		$.async('POST', url, {newFormData:new FormData(form[0])}, function(result){
			WP.$dbs.lydbs_has_change_form = 0;
			form.find('[name="_save_copy_"]').val('');
			form.find('[name="_release_copy_"]').val('');
			loading.popup_remove(function(){
				var is_id = parseInt(form.find('[name="Id"]').val())
				if (result.ret==1) {
					if (!is_id) {
						form.find('[name="Id"]').val(result.id);
					}
				}
				if (typeof(fn)=='function') fn(result)
			});
		}, 'json');
	},
	submit_before(el){
		var el = $(el);
		var form = el.parents('form:eq(0)');
		var status = el.attr('data-status');
		if (status=='_save_copy_' || status=='_save_copy_view_') {
			form.find('[name="_save_copy_"]').val('1');
		} else if (status=='_release_copy_') {
			form.find('[name="_release_copy_"]').val('1');
		}
		form.attr('data-status', status).submit();
	}
}
$(document).on('submit', 'form[dbs="detail"], [lydbs-detail]', function () {
	var form = $(this);
	var q = $dbs.query_string();
	dbs_submit.post(form, result=>{
		var go_to_back = !form.is('._temp_do_not_go_to_back,._do_not_go_to_back');
		if (result.ret==1) {
			if (result.add_to_edit && result.is_add) {
				if (q._alert_side_ || q._popup_ || q._alert_ || q._popup_top_ || q._popup_left_ || q._popup_right_ || q._popup_bottom_) {
					location.href = result.query_string.edit+'&_alert_side_=1';
				} else {
					$dbs.href(result.query_string.edit);
				}
				WP.$.alert({
					str: result.msg,
					time: 2000
				});
			} else if (form.is('[data-status="_save_copy_view_"]')) { //预览跳转
				form.removeAttr('data-status');
				var query_string = (result.data.Href.indexOf('?')>=0?'&':'?')+'is_copy_module=1';
				window.open(result.data.Href+query_string, '_blank');
			} else if (form.is('[is-not-list]')) { //没有列表的提示方式
				WP.$.alert({
					str: `
						<div class="p_0_20px">
							<div class="mt_50px mb_50px text-center fz16" color="text2">信息添加已成功！</div>
							<div class="flex-max2 mb_30px">
								<a class="ly_btn width100 close" bg="main">${$.lang.global.confirm}</a>
							</div>
						</div>
					`,
					wh:[460,0],
					init(el){
						el.on('click', '.close', function(){
							el.popup_remove();
						});
					}
				});
			} else { //正常的提示方式
				WP.$.alert({
					str: `
						<div class="p_0_20px">
							<div class="mt_50px mb_50px text-center fz16" color="text2">信息添加已成功，是否继续？</div>
							<div class="flex-max2 mb_30px">
								<a class="ly_btn fanhuiliebiao close">返回列表</a>
								<a class="ly_btn ml_20px close">留在当前页</a>
								<a class="ly_btn ml_20px xinzengshuju close" bg="main">继续新增</a>
							</div>
						</div>
					`,
					wh:[460,0],
					init(el){
						el.on('click', '.fanhuiliebiao', function(){
							$dbs.href('back()');
							// history.back();
						});
						el.on('click', '.xinzengshuju', function(){
							// WP.manage.src2(result.query_string.add);
							if (q._alert_side_ || q._popup_ || q._alert_ || q._popup_top_ || q._popup_left_ || q._popup_right_ || q._popup_bottom_) {
								location.href = result.query_string.add+'&_alert_side_=1';
							} else {
								$dbs.href(result.query_string.add);
							}
						});
						el.on('click', '.close', function(){
							if (result.edit_to_flush) {
								if (result.is_mod) {
									$.flush();
								} else {
									$dbs.href(result.query_string.edit);
								}
							}
							el.popup_remove();
						});
					},
					end(){
						if (result.edit_to_flush) {
							if (result.is_mod) {
								$.flush();
							} else {
								$dbs.href(result.query_string.edit);
							}
						}
					}
				});
			}
			$('[name="Id"]').val(result.data.Id);
		} else {
			WP.$.alert(result.msg.tip||result.msg, 3000);
		}
	})
	return false;
});

$(document).on('input', '[lydbs-detail] input,[lydbs-detail] select,[lydbs-detail] textarea', function () {
	WP.$dbs.lydbs_has_change_form = 1;
});
/////////////////////////////////////////////////////////////////////////////



// ctrl + s 提交保存
/////////////////////////////////////////////////////////////////////////////
$(document).on('keydown',function (event) {
	if (event.keyCode==83 && event.ctrlKey) {
		$('form[dbs="detail"]').submit();
		return false;
	}
});
WP.$(WP.document).on('keydown',function (event) {
	if (event.keyCode==83 && event.ctrlKey) {
		$('form[dbs="detail"]').submit();
		return false;
	}
});
/////////////////////////////////////////////////////////////////////////////




// 预览
/////////////////////////////////////////////////////////////////////////////
$(document).on('click', '[lydbs-preview]', function (e) {
	var el = $(this),
		form = el.parents('[dbs="detail"]'),
		method = form.attr('method'),
		action = form.attr('action'),
		preview = el.attr('data-url');
	form.addClass('_do_not_submit_').attr({action:preview, method:'post', 'action-log':action, 'method-log':method, target:'_blank'});
	form.submit();
	setTimeout(function(){
		form.removeClass('_do_not_submit_').attr({action:action, method:method, target:''});
	}, 300);
});
/////////////////////////////////////////////////////////////////////////////




// 修改密码
/////////////////////////////////////////////////////////////////////////////
$(document).on('click', "[lydbs-password]", function (event) {
	var t = $(this);
	var u = t.attr('lydbs-password');
	WP.$.alert({
		title: $.lang.member.mod_password,
		str: 
			'<div style="color:#888; font-size:12px; margin-bottom:5px;">'+$.lang.member.password+'</div>'+
			'<input type="text" style="border-radius:3px; border:1px solid #ddd; height:34px; padding:6px; width:100%;" />'
		,
		cancel: 1,
		xy: $.xy(event, function(x, y) {return [x - 100, y - 60]}),
		confirm: function (alert_el) {
			var name = t.attr('name');
			var data = {
				Id: t.attr('data-id'),
				Password:alert_el.find('input').val()
			};
			$.async('POST', u, data, function(result){
				if (result.ret==1) {
					alert_el.popup_remove();
				}
				else {
					WP.$.alert(result.msg, 2000);
				}
			}, 'json');
			return false;
		}
	});
	event.stopPropagation();
});
/////////////////////////////////////////////////////////////////////////////





// 账号锁定
/////////////////////////////////////////////////////////////////////////////
$(document).on('click', "[dbs-edit-head-is-login-lock]", function (event) {
	var t = $(this);
	var u = t.attr('dbs-edit-head-is-login-lock');
	WP.$.alert({
		str: $.lang.member.is_login_lock_tip,
		cancel: 1,
		xy: $.xy(event, function(x, y) {return [x - 100, y + 30]}),
		confirm: function (alert_el) {
			var name = t.attr('name');
			var data = {
				Id: t.attr('data-id'),
				IsLoginLock: t.attr('data-lock')||'0'
			};
			$.async('POST', u, data, function(result){
				if (result.ret==1) {
					alert_el.popup_remove()
					location.reload()
				} else {
					WP.$.alert(result.msg, 2000);
				}
			}, 'json');
			return false;
		}
	});
	event.stopPropagation();
});
/////////////////////////////////////////////////////////////////////////////






// 在列表页就能编辑
//////////////////////////////////////////////////////////////////////////////////////////
var _dbs_list = {
	// 帮忙统一提交单个组件的数据，估计也就在查看列表里面才能用得到
	rand: {},
	post: function (el) {
		var form = el.parents('form:eq(0)')
		var r = form.attr('data-save-log-r') || Math.random()
		var data = [
				{name:'Id', value:form.attr('data-id')},
			]
		var href = location.href.replace(/([&\?])d=([^&#]+)(&?)/, '$1')+'&d=post&_ifr_=1'
		form.attr('data-save-log-r', r);
		clearTimeout(this.rand[r]);
		this.rand[r] = setTimeout(function(){
			data = data.concat(form.serializeArray());
			$.async('POST', href, data, function(result){
				WP.$.alert(result.msg, 1500);
			}, 'json');
		}, 380);
	},
};
$(document).on('click', "[lydbs-submit-list] [type='radio'], [lydbs-submit-list] [type='checkbox']", function (e) {
	_dbs_list.post($(this));
	e.stopPropagation();
});
$(document).on('change', "[lydbs-submit-list] textarea, [lydbs-submit-list] select, [lydbs-submit-list] input", function (e) {
	_dbs_list.post($(this));
	e.stopPropagation();
});
$(document).on('submit', "[lydbs-submit-list]", function (e) {
	return false;
});
//////////////////////////////////////////////////////////////////////////////////////////





// 编辑
//////////////////////////////////////////////////////////////////////////////////////////
// 弹出一个编辑框
function lydbs_edit_popup(data){
	WP.$.alert_side({
		data: {
			url: data.url
		},
		css: {width:data.width||700, right:0},
		end(alertside_el) {
			// 
		}
	});
}
$(document).on('click', '[lydbs-edit-popup]', function (e) {
	var t = $(this);
	var name = t.attr('data-name');
	var id = $('form[dbs="detail"] [name="Id"]').val();
	var ex_na = t.attr('data-ex-na');
	var ex_id = t.attr('data-ex-id')||id;
	var url = t.attr('data-url');
	var width = parseInt(t.attr('data-w'));
	if (ex_na) {
		if (!ex_id) {
			WP.$.alert({
				str: '添加关联，需要先保存当前数据，是否继续？',
				cancel: 1,
				confirm(alert_el){
					dbs_submit.post($('form[dbs="detail"]'), result=>{
						if (result.ret==1) {
							url += '&'+ex_na+'='+result.id;
							lydbs_edit_popup({
								url: url,
								width: width
							});
						} else {
							WP.$.alert(result.msg.tip||result.msg, 3000);
						}
					});
				}
			});
			return;
		}
		url += '&'+ex_na+'='+ex_id;
	}
	lydbs_edit_popup({
		url: url,
		width: width
	});
	return false;
});
//////////////////////////////////////////////////////////////////////////////////////////



// 批量选中
var $dbsChoiceAll = {
	click(el, checked, result){
		var pl = el.parents('.ly_table_strip');
		var label = el.parents('label');
		var thead = el.parents('thead');
		var names = pl.find('.n');
		var arrow = pl.find('.a i');
		if (result.choice) {
			names.removeClass('hide2');
			thead.addClass('hide_tr');
			arrow.addClass('hide2');
		} else {
			names.addClass('hide2');
			thead.removeClass('hide_tr');
			arrow.removeClass('hide2');
		}
		if (label.is('.cur2')) {
			label.removeClass('lyicon-select-bold').addClass('lyicon-minus-bold cur');
		} else {
			label.removeClass('lyicon-minus-bold').addClass('lyicon-select-bold');
		}
		pl.find('.num').html($.lang.notes.choice_tip.replace('{{qty}}', result.choice));
	}
};




// 导出
//////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '[lydbs-export]', function () {
	var el = $(this),
		href = el.attr('data-href'),
		where_url = el.attr('data-where')||'';
	if (where_url) {
		var loading = WP.$.alert('loading...');
		var data = (location.search||'').replace(/^\?/,'');
		$.async('POST', where_url, data, function(result){
			loading.popup_remove(function(){
				WP.$.alert({
					title: $.lang.global.export_where,
					str: '<form action="'+href+'" target="_blank" method="post">'+result+'</form>',
					cancel: 1,
					confirm: function(alert_el){
						alert_el.find('form').submit();
						return false;
					}
				});
			});
		},'html');
	} else {
		window.open(href, '_blank');
	}
});
//////////////////////////////////////////////////////////////////////////////////////////




// 复制
//////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '[lydbs-copy]', function () {
	var el = $(this),
		id = el.attr('data-id');
	WP.$.alert({
		str: $.lang.notes.copy_tip,
		style: 'B',
		confirm(alert_el){
			var lo = WP.$.alert('loading...');
			var s_data = {
				Id: id,
			};
			var href = $dbs.ma()+'&d=copy&_ifr_=1';
			$.async('POST', href, s_data, result=>{
				lo.popup_remove(function(){
					if (result.ret==1) {
						location.reload();
					}
				});
			}, 'json');
		}
	});
	return false;
});
//////////////////////////////////////////////////////////////////////////////////////////



// 排序
//////////////////////////////////////////////////////////////////////////////////////////
$(document).on('change', '[dbs="myorder"]', function () {
	var t = $(this);
	var data = {
		Id: t.attr('i'),
		MyOrder: t.val(),
	};
	var href = $dbs.ma()+'&d=myorder&_ifr_=1';
	$.async('POST', href, data, function(result){
		WP.$.alert(result.msg, 1500);
	}, 'json');
	return false;
});
//////////////////////////////////////////////////////////////////////////////////////////




// 删除，回收站，恢复
//////////////////////////////////////////////////////////////////////////////////////////
!(function(){
	$(document).on('click', '[dbs="del"],[dbs="recycle"],[dbs="restore"]', function(){
		var el = $(this),
			check_url = el.attr('data-check')||'';
		myfn.set(el);
		if (myfn.data.Id) {
			if (check_url) {
				var loading = WP.$.alert('loading...');
				$.async('POST', check_url, myfn.data, function(result){
					loading.popup_remove(function(){
						if (result.msg) {
							myfn.tips.del = '<div style="color:#999;margin-bottom:12px;font-size:12px;">'+result.msg+'</div>' + myfn.tips.del;
						}
						myfn.delete();
					});
				},'json');
			} else {
				myfn.delete();
			}
		} else {
			WP.$.alert(myfn.tips.null, 2000);
		}
		return false;
	});
	var myfn = {
		data: {},
		tips: {},
		reload: true, //判断是否重新加载
		href: '',
		delete: function(){
			WP.$.alert({
				str: myfn.tips.del,
				style: 'B',
				cancel: 1,
				confirm: function () {
					var lo = WP.$.alert('loading...');
					$.async('POST', myfn.href, myfn.data, function(result){
						lo.popup_remove(function(){
							if (result.ret==1) {
								if (myfn.reload) {
									location.reload();
								} else {
									var id = myfn.data.Id.split(',');
									for (var i in id) {
										$('[name=Id][value="'+id[i]+'"]').parents('tr').eq(0).remove();
									}
								}
							} else {
								WP.$.alert(result.msg);
							}
						});
					}, 'json');
				}
			});
		},
		// 搜集id和整理提示语
		set: function(el){
			var href = $dbs.ma(),
				id = [];
			if (el.is('[data-id]')) {
				id.push(el.attr('data-id'));
			} else {
				$('[name=Id]:checked').each(function () {
					id.push($(this).val());
				});
			}
			if (el.is('[dbs="recycle"]')) {
				this.href = href + '&d=recycle&_ifr_=1';
				this.tips.null = $.lang.notes.recycle_null;
				this.tips.del = $.lang.notes.recycle_tip.replace('{{qty}}', id.length);
			}
			else if (el.is('[dbs="restore"]')) {
				this.href = href + '&d=restore&_ifr_=1';
				this.tips.null = $.lang.notes.restore_null;
				this.tips.del = $.lang.notes.restore_tip.replace('{{qty}}', id.length);
			}
			else {
				this.href = href + '&d=del&_ifr_=1';
				this.tips.null = $.lang.notes.del_null;
				this.tips.del = $.lang.notes.del_tip.replace('{{qty}}', id.length);
			}
			this.data.Id = id.join(',');
			this.reload = !el.is('[data-reload="false"]');
		}
	};
})();
//////////////////////////////////////////////////////////////////////////////////////////


// 批量转移分类
//////////////////////////////////////////////////////////////////////////////////////////
(function () {
	var ajax_popup = 1;
	$(document).on('click', '[lydbs-move-category]', function (event) {
		var el = $(this);
		var ids = '';
		$('[name="Id"]:checked').each(function(){
			ids += $(this).val()+',';
		});
		if (!ids) {
			return false;
		}
		if (ajax_popup) {
			ajax_popup = 0;
			var u = $dbs.ma()+'&_ifr_=1&e=uid&Id='+ids;
			$.async('GET', u, {}, function (html) {
				ajax_popup = 1;
				WP.$.alert({
					title: $.lang.global.move_category,
					str: html,
					cancel: 1,
					confirm: function (alert_el) {
						var u = $dbs.ma()+'&_ifr_=1&d=save-uid';
						$.async('POST', u, alert_el.find('form').serializeArray(), function(result){
							location.reload();
							alert_el.popup_remove();
						}, 'json');
						return false;
					}
				});
			});
		}
	});
})();
//////////////////////////////////////////////////////////////////////////////////////////


// 语言版本切换
//////////////////////////////////////////////////////////////////////////////////////////
// 鼠标移过+点击事件 - 进行语言版本切换
$(document).on('mouseover', '.langselbox', function(event){
	$(this).addClass('cur now_ij');
});
$(document).on('mouseleave', '.langselbox', function(event){
	var el = $(this);
		el.removeClass('now_ij');
	setTimeout(function(){
		if(!el.is('.now_ij')) el.removeClass('cur');
	}, 100);
});
$(document).on('click', '.langselbox .changelang >*', function(event){
	$('[to="[mLanguage]"] >*').eq($(this).index()).trigger('click');
	$(this).parents('.langselbox').removeClass('cur');
});
// 点击事件 - 当光标在输入框里面，然后键盘tab切换，将顺序重新排一下
$(document).on('click', '#dbcss .-form input,#dbcss .-form textarea', function(){
	var i = 1;
	$('#form input,#form textarea').each(function () {
		var a = $(this);
		if (!a.is(':visible') || a.is('[readonly]') || a.is('[laydate]') || a.is('[disabled]') || a.parents('.goaway.absolute').size()) {
			a.removeAttr('tabindex');
			return ;
		}
		a.attr({tabindex:i});
		i++;
	});
});
// 第一次加载，将语言包插入组件的标题里面
$(document).ready(function () {
	_('._dbs_tit .langselbox').each(function () {
		var h = '', h1 = '';
		var l = $.language.all;
		for (var i in l) {
			h += "<font class='lang-na'> - "+$.lang.language[l[i]]+"</font>";
			h1 += "<font>"+$.lang.language[l[i]]+"</font>";
		}
		h = "<span mLanguage>"+h+"</span> <i class='ico lyicon-arrow-down'></i><span class='changelang hide'>"+h1+"</span>";
		$(this).html(h);
	});
});
//////////////////////////////////////////////////////////////////////////////////////////



// 导入关键文件
//////////////////////////////////////////////////////////////////////////////////////////
!(function(){
	// 分页
	$.include('/manage/__/js/paging.js');
	// seo
	$.include('/manage/__/js/seo.js');
	// 链接跳转
	$.include('/manage/__/js/href.js');
})();
//////////////////////////////////////////////////////////////////////////////////////////









// 分类
//////////////////////////////////////////////////////////////////////////////////////////
var dbs_category_myorder_list = {
	change(el){
		var id = [];
		var myorder = [];
		var href = el.attr('data-href') ||location.href.replace(/([&\?])d=([^&#]+)(&?)/, '$1')+'&d=myorder&_ifr_=1';
		el.children().each(function(i){
			id.push($(this).attr('i') || $(this).attr('data-id'));
			myorder.push(i+1);
		});
	    $.async('POST', href, {Id:id, MyOrder:myorder}, result=>{
	        if (result.ret==1) {
	        	// 
	        } else {
	        	WP.$.alert(result.msg, 2000);
	        }
	    }, 'json');
	}
};
// 展开
$(document).on('click', '.zml_nav .open', function(){
	var el = $(this)
	var li = el.parents('.li:eq(0)')
	li.toggleClass('cur');
	li.children('.subnav').toggleClass('hide2');
});
//////////////////////////////////////////////////////////////////////////////////////////







//关联
//////////////////////////////////////////////////////////////////////////////////////////
// iframebox 的弹窗回调
var lydbsHrefIframeBoxFn = {
	confirm(el, popupEl, result, option){
		let ids = [];
		for (let i in result) {
			ids.push(result[i].id);
		}
		el.find("input[type='hidden']").val(ids.join(','))
		el.find('[data-length]').html(ids.length);
	}
}
// 单选弹窗
var lydbsHrefIframeBoxRadioFn = {
	confirm(el, popupEl, result, option){
		let ids = [];
		for (let i in result) {
			ids.push(result[i].id);
		}
		el.find("input[type='hidden']").val(ids.join(','))
		el.find('[data-length]').html(ids.length);
	}
};
// 单选弹窗
$.task.push(()=>{
	_('[fn="lydbsHrefIframeBoxRadioFn"]').each(function(){
		let el = $(this);
		let href = el.attr('hr-ef');
		let q = $dbs.query_string(href);
		let _choice_ids = (el.is('[data-ids]')?el.attr('data-ids'):el.find('[type="hidden"]').val()) || '';
		$.async('POST', '?ma='+q.ma+'&l=selector-json&_choice_ids='+_choice_ids, {}, result=>{
			if (result.ret==1) {
				el.find('[data-name]').html(result.data[0].name);
			}
		}, 'json');
	});
});
//////////////////////////////////////////////////////////////////////////////////////////


//关联 下拉框产品选择
//////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '[lydbs-association-list-drop]', function(){
	if ($(this).is('[jx-o]')) {
		$(this).o('lydbsAssociationListDrop').drop();
	}
});
// jext的定时任务，会重复触发
$.task.push(()=>{
	_('[lydbs-association-list-drop]').each(function(){
		// 绑定的元素
		var el = $(this);
		var fn = $.callbackfn(el.attr('fn'),['init']);
		var p = el.attr('lydbs-association-list-drop');
		var data = {
			el: el,
			ma: el.attr('data-ma')||'',
			value: el.find('input[type="hidden"]').val(),
			type: el.attr('data-type')||'checkbox',
			init(){
				$.eval(fn.init, el, this);
			},
		};
		if (p) {
			p = $.json(p, 'simple');
			data.field = {
				name: p.name,
				picture: p.picture,
			};
		}
		let obj = new lydbsAssociationListDrop(data);
		el.o('lydbsAssociationListDrop', obj)
	});
});
// 类
class lydbsAssociationListDrop {
	constructor(option){
		this.option = {
			value: '',
			type: 'checkbox',
			field: {
				name: 'Name',
				picture: '',
			},
			...option
		};
		// 弹窗的标题
		this.table = 'wb_' + option.ma.replace(/\/index$/,'').replace(/\//g, '_');
		// 请求的地址
		this.url = '?ma=' + option.ma + '&l=json';
		// 提交的数据
		this.value = option.value=='' ? [] : option.value.split(',');
		// 首次调用
		// this.isfirst = 1;
		// 记录
		// this.log = {};
		this.cls = $.rand('x');
		// 触发对象
		this.el = option.el;
		// 勾选的数据包含value与label
		this.list = [];

		this.default();
		this.events();
	}
	default(){
		// 下拉dom
		this.dropEl = $(`
			<div class="ly_drop hidden" cw='700' data-drop="">
				<div class="ly_drop_content scrollbar">
					<div class="flex-column maxh scrollbar notcopy ${this.cls}">
						<div class="sticky" bg="white" style="top:0;z-index:5">
							<form class="searchform flex-right p_20px">
								<div class="hide" lydbs-search-input></div>
								<div class='ly_input_suffix flex-1'>
									<input type='text' name='keyword' value='' autocomplete='off' />
									<i class='submit lyicon-search pointer' bg="main"></i>
								</div>
							</form>
						</div>

						<div class="searchlist maxw flex-1 flex-wrap" bg="white">
							<i class="lyicon-loading mt_20px" style="font-size:30px;margin-left:48%;"></i>
						</div>
						
						<div class="maxw sticky" style="bottom:0;z-index:5">
							<div class="tPage flex-wrap p_20px" bg="white">分页</div>
						</div>

					</div>
				</div>
			</div>
		`);

		this.value.forEach(v => {
			this.list.push({value:v});
		});

		this.get({}, result=>{
			this.create_result();
			if (this.init) this.init();
		});

		$('html').append(this.dropEl);
	}

	drop(){
		this.el.drop({
			el: this.dropEl,
			placement: '',
		});
	}

	create_result(){
		// 更新label
		let html = '';
		this.list.forEach(v => {
			html += `<div class='flex-middle2 ml_10px'>
						<div>${v.label}</div>
						<i class='delete ml_5px pointer lyicon-error' data-id='${v.value}'></i>
					</div>`
		});
		if(this.el.find('.check_result').size()){
			this.el.find('.check_result').html(html);
		}else{
			this.el.prepend(`<div class='check_result flex-middle2'>${html}</div>`);
		}

		// 更新value
		this.el.find('input[type="hidden"]').val(this.list.map(i=>i.value).join(','))
	}

	events(){
		var _this = this;
		// 搜索
		this.dropEl.on('click', '.searchform .submit', function(e){
			_this.get($(this).parents('form').json());
		});

		// 勾选
		this.dropEl.on('change', '.searchlist input', function(){
			let val = $(this).val();
			let name = $(this).attr('data-name');
			let index = _this.list.findIndex(v=>v.value==val)
			if(_this.option.type=="checkbox"){
				if($(this).is(':checked')){
					if(index<0){
						_this.list.push({value:val,label:name})
					}
				}else{
					if(index>-1){
						_this.list.splice(index,1)
					}
				}
			}else{
				_this.list = [{value:val,label:name}];
			}
			_this.create_result();
		});

		//翻页
		this.dropEl.on('click', '.lyui_paging [data-i]', function(){
			let para = _this.dropEl.find('.searchform form').json()
			para.pg = $(this).attr('data-i');
			_this.get(para);
		});

		// 删除
		this.el.on('click', '.check_result .delete', function(){
			let id = $(this).attr('data-id');
			let index = _this.list.findIndex(v=>v.value==id)

			if(index>-1){
				_this.list.splice(index,1)
				_this.dropEl.find('.searchlist input[value="'+id+'"]').removeAttr('checked').parent().removeClass('cur');
			}
			_this.create_result();
		});
	}

	// 获取数据
	get(data, fn){
		$.async('GET', this.url, data, result=>{
			// 列表布局
			var listHtml = '';
			if(result.total){
				listHtml = result.children.map(v=>{
					// 会员，没有邮箱就显示电话
					if(this.option.ma == 'member/index'){
						if(v['Email']){
							this.option.field.name = 'Email';
						}else{
							this.option.field.name = 'Mobile';
						}
					}
					// 原数据里有的就勾选上
					let index = this.list.findIndex(item=>item.value == v.Id);
					if(index>-1 && !this.list[index].label) this.list[index].label = v[this.option.field.name];
					let path = $.json(v[this.option.field.picture]);
					if (path.length) path = path[0].path;
					else path = '';
					// this.log[v.Id] = v;
					return ` 
						<label class="flex-middle2 pointer p_10_20px" bg="white" style="flex:0 0 50%">
							<i class="ly_checkbox lyicon-select-bold mr_15px"></i>
							<input class="hide" type="${this.option.type}" name="Id" ${index>-1?'checked':''} value="${v.Id}" data-name="${v[this.option.field.name]}"/>
							${this.option.field.picture?`<div class="ly_img mr_15px"><img src="${path}"></div>`:''}
							<div class="fz16">${v[this.option.field.name]}</div>
						</label>
					`
				}).join('');
			} else {
				listHtml = `<div class="p_20px" color="text3" bg="white">暂无~</div>`;
			}
			this.dropEl.find('.searchlist').html(listHtml);
			// 分页
			this.dropEl.find('.tPage').addClass('p_20px').html($.page({total:result.total, limit:result.limit, page:result.pg}).html);
			// 结束操作
			// this.isfirst = 0;
			if (fn) fn(result);
		},'json');
	}
}
//////////////////////////////////////////////////////////////////////////////////////////


//关联
//////////////////////////////////////////////////////////////////////////////////////////
class lydbsWhereExtId {
	constructor(option){
		this.option = {
			value: '',
			delete_value: '',
			exName: 'wb_products_id',
			exId: 0,
			...option
		};
		// 弹窗的标题
		this.table = 'wb_' + option.ma.replace(/\/index$/,'').replace(/\//g, '_');
		this.option.exName = this.table+'_id';
		// 请求的地址
		this.url = '?ma=' + option.ma + '&e=where_extid';
		// 提交的数据
		this.value = option.value=='' ? [] : option.value.split(',');
		this.delete_value = [];
		this.before_value = [];
		// 首次调用
		this.isfirst = 1;
		this.cls = $.rand('x');
		// 弹窗
		this.popup();
	}

	// 弹窗
	popup(){
		var _this = this;
		WP.$.alert_side({
			// id: this.cls,
			data: `
				<div class="flex-column maxh scrollbar notcopy ${this.cls}">
					<div class="sticky" bg="white" style="top:0;z-index:5">
						<div class="maxw ly-h4 mt_45px flex-middle2" cw="100%">
							<span>${$.lang.dbs.relative.filter}</span>
							<i class="lyicon-close ly-h3 ml_50px return pointer"></i>
						</div>
						<div class="searchform"></div>
					</div>
					<div class="searchlist maxw flex-1" bg="white">
						<i class="lyicon-loading mt_20px" style="font-size:30px;margin-left:48%;"></i>
					</div>
					<div class="alert_side_btn_box maxw sticky" bg="default" style="bottom:0;z-index:5">
						<div cw="100%" class="flex-middle2">
							<label class="pointer mr_20px fz16">
								<i class="ly_checkbox lyicon-select-bold mr_5px"></i>
								<input class="hide" type="checkbox" name="checkbox" all=".${this.cls} [name='Id']" />
								${$.lang.global.all}
							</label>
							<div class="ly_btn_radius width100 mr_25px submit pointer" bg="main" size="small">${$.lang.global.confirm}</div>
						</div>
					</div>
				</div>
			`,
			css: {right:0, width:460},
			init(alert_el){
				_this.alert_el = alert_el;
				_this.get({}, result=>{
					if (_this.init) _this.init.call(_this);
				});
				// 关闭弹窗按钮
				alert_el.on('click', '.return', function(){
					alert_el.popup_remove();
					if (_this.option.close) _this.option.close.call(_this);
				});
				// 提交
				alert_el.on('click', '.submit:not(.disabled)', function(){
					_this.check();
					alert_el.popup_remove();
					if (_this.option.confirm) _this.option.confirm.call(_this);
				});
				// 弹窗中提交样式控制
				alert_el.on('click', 'input', function(){
					setTimeout(()=>{_this.check()},100);
				});
				// 绑定搜索提交事件
				alert_el.find('.searchform').on('submit', 'form', function(){
					_this.filter();
					return false;
				});
				// 搜索
				alert_el.on('change', '.wangzhanshousuoform12 .lang', function(){
					_this.filter();
				});
				alert_el.on('keyup', '.wangzhanshousuoform12 .search', function(){
					_this.filter();
				});
				_this.check();
			},
		})
	}

	// 获取数据
	get(data, fn){
		$.async('GET', this.url, data, result=>{
			let sh = '';
			let sh2 = '';
			if (result.ret==1) {
				var lan = [];
				for (var v of $.language.all) {
					lan.push({label:$.lang.language[v], value:v});
				}
				sh = `
					<form class="flex-right p_20px wangzhanshousuoform12">
						${$.language.all.length ? `
							<label class="lang ly_input_suffix inline-flex width120 mr_15px" ly-drop-select>
								<input type="text" placeholder="暂无数据">
								<input type="hidden" name="Language">
								<script type="text">${$.json(lan)}</script>
								<i class="lyicon-arrow-down-bold"></i>
							</label>
						` : ''}
						<div class='search ly_input_suffix flex-1'>
							<input type='text' name='Keyword' value='${data.keyword||''}' autocomplete='off' />
							<i class='lyicon-search pointer' bg="main"></i>
						</div>
					</form>
				`;
				sh2 = `
					${result.data.map((v,k)=>{
						return `
							<div class="li p_20px b-top" data-lang="${v.Language}">
								<div class="fz16 p_10_0px">${v.Name} <span class="fz12" color="text3">[${$.lang.language[v.Language]}]</span></div>
								${v.children.map(v2=>{
									let flag = false;
									let xid = v2[this.option.exName];
									let beID = (xid && xid.split(',').includes(this.option.exId));
									if (beID) {
										this.before_value.push(v2.Id);
									}
									if (this.option.value || this.option.delete_value) {
										flag = this.value.includes(v2.Id);
									} else {
										flag = beID;
									}
									return `
										<label class="flex-middle2 pointer p_10px" bg="white">
											<i class="ly_checkbox lyicon-select-bold mr_15px"></i>
											<input class="hide" type="checkbox" name="Id" ${flag?'checked':''} value="${v2.Id}"/>
											<div class="fz12" color="text2">${v2.Name}</div>
										</label>
									`
								}).join('')}
							</div>
						`;
					}).join('')}
				`;
			} else {
				sh2 = `<div class="p_20px" color="text3" bg="white">暂无~</div>`;
			}
			this.alert_el.find('.searchform').html(sh);
			this.alert_el.find('.searchlist').html(sh2);
			if (fn) fn(result);
		},'json');
	}

	// 篩選
	filter(){
		var lang = this.alert_el.find('[name="Language"]').val();
		var key = this.alert_el.find('[name="Keyword"]').val();
		this.alert_el.find('.li').each((i,el)=>{
			el = $(el);
			var l = el.attr('data-lang');
			var t = el.html();
			if (!lang || l==lang) {
				el.removeClass('hide2');
				if (!key || t.indexOf(key)>=0) {
					el.removeClass('hide2');
				} else {
					el.addClass('hide2');
				}
			} else {
				el.addClass('hide2');
			}
		});
	}

	// 拿原来的数据与勾选的数据对比，勾选了原数据没有的就添加，取消了原数据有的就删除
	check(){
		this.delete_value = [];
		this.alert_el.find("input[name='Id']").each((i,item)=>{
			let id = $(item).val();
			let index = this.value.indexOf(id);
			if ($(item).is(':checked')) {
				if (index<0) {
					this.value.push(id)
				}
			} else {
				if (index>-1) {
					this.value.splice(index,1)
				}
				if (this.before_value.indexOf(id)>=0) {
					this.delete_value.push(id);
				}
			}
		});
		// 检查是否可提交
		// if (this.value.length || this.delete_value.length) this.alert_el.find('.submit').removeClass('disabled').addClass('pointer');
		// else this.alert_el.find('.submit').addClass('disabled').removeClass('pointer');
	}

}
//////////////////////////////////////////////////////////////////////////////////////////