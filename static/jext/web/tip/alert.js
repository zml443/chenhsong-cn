$.extend({
	// 弹窗
	alert: function(str, opt) {
		if (typeof str=='object') {
			opt = str;
			str = '';
		} else {
			if (typeof opt=='number') {
				if (opt>300) {
					opt = {time:opt,class:'notbg'};
				} else {
					opt = {confirm:1, style:'B'};
				}
			} else if (typeof opt!='object') {
				opt = {};
			}
			opt.str = str;
		}
		opt.str = opt.str||'';
		if (!opt.type) {
			if (opt.str.indexOf('loading')==0||opt.time) {
				opt.type = 'simple loading';
				// opt.locking = 1;
				opt.position = opt.position ? opt.position : 2;
			}
		}
		var opt = $.extend({
				title: '',
				str: str,
				close: 1,
				zIndex: opt.zIndex||1001,
				wh: [0,0],
				class: '',
				type: '',
				position: 5,
				_hide_popup: function(){
					if (this.keep) el.popup_hide();
					else el.popup_remove();
				}
			}, opt);
		if (!opt.id) opt.id = ('alert'+Math.random()).replace(/\./,'');
		var el = $('[alert="'+opt.id+'"]');
		if (el.size()==0) {
			if (opt.type=='custom') {
				el = $(`<div class='popup hidden ${opt.class}'>${opt.str}</div>`);
			} else {
				el = $(`
					<div class='popup hidden ${opt.class} ${opt.type}' alert='${opt.id}' s='${opt.style}'>
						<div class='relative flex-column'>
					    	<div class='at-move absolute max el-popup-moving'></div>
					    	<div class='at-close absolute el-popup-close flex-max2'><i class="lyicon-guanbi"></i></div>
					    	<div class='at-title clean relative'>${opt.title}</div>
							<div class='at-contents relative'>
								${opt.iframe?`<iframe class="maxh maxw" frameborder="0" src="${opt.iframe}" scroll="no" allowfullscreen></iframe>`:opt.str}
							</div>
						    <div class='at-bottom flex-right'>
						        <div class='at-cancel el-popup-close notcopy'>${$.lang.global.cancel}</div>
						        <div class='at-confirm notcopy'>${$.lang.global.confirm}</div>
						    </div>
						</div>
					</div>
				`);
			}
			el.css({zIndex:opt.zIndex});
			if (opt.wh[0]>0) el.children().width(opt.wh[0]);
			if (opt.wh[1]>0) {
				var max_height = $(window).height()-60;
				el.children().height(opt.wh[1]<max_height?opt.wh[1]:max_height);
			}
			if (!opt.close) {
				el.find('.at-close').hide();
			}
			if (!opt.cancel) {
				el.find('.at-cancel').hide();
			}
			if (!opt.confirm) {
				el.find('.at-confirm').hide();
			}
			if (!opt.cancel && !opt.confirm) {
				el.find('.at-bottom').hide();
			}
			if (!opt.title) {
				el.find('.at-title').addClass('null');
			}
			$('body').before(el);
			if (!opt.locking) el.on('click', '.el-popup-bg, .el-popup-close', function () {
				// $(this).popup_remove();
				opt._hide_popup();
				if (opt.end) opt.end(el);
			});
			el.on('click', '.at-cancel', function () {
				if (opt.end) opt.end(el);
				if (typeof opt.cancel=='function') opt.cancel(el);
			});
			el.on('click', '.at-confirm', function () {
				var ret = 1;
				if (typeof opt.confirm=='function') ret=opt.confirm(el);
				// if (ret||typeof ret=='undefined') el.popup_remove();
				if (ret||typeof ret=='undefined') opt._hide_popup();
			});
		}
		if (opt.xy) {
			el.popup({position:1});
			if (opt.xy[0]<0) {
				opt.xy[0] = 10;
			}
			if (opt.xy[1]<0) {
				opt.xy[1] = 10;
			}
			var last_x = el.width() - el.find('.el-popup-content').outerWidth();
			if (opt.xy[0]>last_x) {
				opt.xy[0] = last_x - 10;
			}
			var last_y = el.height() - el.find('.el-popup-content').outerHeight();
			if (opt.xy[1]>last_y) {
				opt.xy[1] = last_y - 10;
			}
			el.find('.el-popup-content').css({left:opt.xy[0], top:opt.xy[1], margin:0});
		} else {
			el.popup({position:opt.position});
		}
		if (opt.init) opt.init(el);
		var length = [el.find('iframe').size(), 0];
		if (length[0]) {
			el.find('iframe').iframe(function () {
				length[1]++;
				if (length[0]==length[1]) {
					if (opt.complete) opt.complete(el);
				}
			});
		} else if (opt.complete) {
			opt.complete(el);
		}
		// 定时关闭
		if (opt.time) {
			setTimeout(function(){el.popup_remove()}, opt.time);
		}
		return el;
	},
	// 侧边栏展开
	alert_side: function (opt) {
		var opt = $.extend({
				data: opt.url||opt.str,
				id: ''
			}, opt);
		if (!opt.id) opt.id = ('alert_side'+Math.random()).replace(/\./,'');
		if (!Array.isArray(opt.data)) opt.data = [opt.data];
		// console.log(opt.data);
		// 开始编辑弹窗代码
		var el = $('#'+opt.id);
		if (el.size()==0) {
			el = $(`
				<div class="popup hidden ${(opt.data.length>1||opt.is_array)?'is-array':''}" id='${opt.id}' alertside='${opt.id}'>
					<div class='flex'>
						<div class='_nav_ absolute max over notcopy' tab='{}' to='[alertside="${opt.id}"] ._ifr_'>
							${opt.data.map(v=>{
								return `<div title='${v.name}'>${v.name}</div>`
							}).join('')}
						</div>
						<div class='_ifr_ absolute max'>
							${opt.data.map((v,k)=>{
								if (typeof(v)=='string') v = {str:v};
								return `
									<div class='maxw maxh'>
										${v.url?`<iframe id="${v.id}" class='maxh maxw' src='${v.url}' name="${opt.id+k}" frameborder='0'></iframe>`:v.str}
									</div>
								`
							}).join('')}
						</div>
					</div>
				</div>
			`);
			$('body').append(el);
			el.children().css({width:opt.css.width});
			if (opt.init) opt.init(el);
			el.on('click', '.el-popup-bg, .el-popup-close', function () {
				if (opt.keep) {
					$(this).popup_hide();
				} else {
					$(this).popup_remove();
				}
				if (opt.end) opt.end(el);
			});
		}
		if (opt.css.left===0) {
			el.popup_left();
		} else if (opt.css.right===0) {
			el.popup_right();
		} else if (opt.css.top===0) {
			el.popup_top();
		} else if (opt.css.bottom===0) {
			el.popup_bottom();
		}
		return el;
	}
});