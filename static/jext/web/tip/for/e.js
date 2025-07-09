
$.__tip_for = {
	// 获取位置
	position: function (a, b) {
		var pyl = 10, pyt = 10;
		var w0 = $(window).width(),
			h0 = $(window).height();
		var w1 = a.outerWidth(),
			h1 = a.outerHeight();
		var l1 = a[0].getBoundingClientRect().left,
			t1 = a[0].getBoundingClientRect().top;
		var w2 = b.width(),
			h2 = b.height();
		var pos = {left:0, top:0, bottom:0, right:0};
		var json = $.json(a.attr('tip-for'), 'simple');
		var dat = {
			type: json.type||'',
			x: parseInt(json.x)||0,
			y: parseInt(json.y)||0,
		};
		var gy_top = t1<h2; // 高于a top 上面的屏幕高度
		var gy_bottom = h0-t1-h1<h2; // 高于a bottom 下面的屏幕高度

		switch (dat.type) {
			case 'radio': //选择框类型
			case 'checkbox': //选择框类型
			case 'select': //下拉类型
				pos.left = l1 + dat.x - 1;
				if (w1>w2) pos.minWidth = json['min-width']||w1;
				if ((gy_bottom&&t1>h0/2) || t1>h0/3*2) {
					pos.bottom = h0-t1 + 5 - dat.y;
					b.attr({p:'top'});
				}
				else {
					pos.top = t1 + h1 + 5 + dat.y;
					b.attr({p:'bottom'});
				}
				break;

			case 'center': //居中
				pos.left = l1 + dat.x - 1 - (w2-w1)/2;
				if ((gy_bottom&&t1>h0/2) || t1>h0/3*2) {
					pos.bottom = h0-t1 + pyl - dat.y;
					b.attr({p:'top', s:'center'});
				}
				else {
					pos.top = t1 + h1 + pyl + dat.y;
					b.attr({p:'bottom', s:'center'});
				}
				break;

			case 'bottom':
				pos.left = l1 + dat.x;
				pos.top = t1 + h1 + pyt + dat.y;
				b.attr({p:'bottom'});
				break;

			case 'right':
				pos.left = l1 + w1 + dat.x + pyl;
				pos.top = t1 + dat.y;
				b.attr({p:'right'});
				break;

			default:
				// 情况 1 left。     右边的空余位置小于屏幕的 1/6
				if (w0-l1<w0/6) {
					pos.right = w0 - l1 + pyl - dat.x;
					pos.top = (h2>(h0-t1)?h0-h2:t1) + dat.y;
					b.attr('p', 'left');

				// 情况 2 right。    左边的空余位置小于屏幕的 1/6
				} else if (l1<w0/6 || h1>80) {
					pos.left = l1 + w1 + dat.x + pyl;
					pos.top = t1 + dat.y;
					b.attr({p:'right'});

				// 默认
				} else {
					pos.left = l1 + dat.x;
					pos.top = t1 + h1 + pyt + dat.y;
					b.attr({p:'bottom'});
				}
				break;
		}

		var hh = h0 - pos.top - pos.bottom;
		var ww = w0 - pos.left - pos.right;
		pos.padding = 0;
		for (var i in pos) {
			if (pos[i]==0) pos[i] = 'auto';
		}
		return pos;
	},

	time: function (a, b) {
		var thi = this;
		var p = thi.position(a, b);
		b.css(p);
		// 定时更新位置
		clearTimeout(thi.timestart);
		thi.timestart = setTimeout(function () {
			thi.time(a, b);
		}, 10);
		// 判断位置发生改变就隐藏
		/*thi.timestart2 = setInterval(function () {
			var p2 = thi.position(a, b);
			for (var i in p) if (p[i]!=p2[i]) {
				thi.hide(b);
				clearInterval(thi.timestart2);
			}
			if (!a.is('.jxtipfornow')) clearInterval(thi.timestart2);
		}, 10);*/

	},

	triggerParents: function (o, t) {
		t = (t||'addClass.tip_for_hover').split('.');
		o.each(function () {
			var a = $(this);
			var json = $.json(a.attr('tip-for'), 'simple');
			var k = json['trigger-parents']||json.parents;
			if (k) {
				var kk='-'+k+'-', ap=a;
				for (var j=1;j<20;j++) {
					ap=ap.parent();
					if (kk.indexOf('-'+j+'-')>=0) {
						if (t[0]=='removeClass') ap.removeClass(t[1]);
						else ap.addClass(t[1]);
					}
				}
			}
		});
	},

	// 
	show: function (a) {
		var json = $.json(a.attr('tip-for'), 'simple');
		var to = json.to||a.attr('to');
		var b = $(to), r = $.rand('tipfor');
		// 当重复出现，那就去掉原先的
		// 以最新的为准
		if (b.size()>1) {
			$(to+'.jxtipfor').remove();
			b = $(to);
		}
		if (b.find('.arrow').size()==0) {
			if (!json.inline) {
				var c = b.clone();
				b.remove();
				b = c;
				$('body').append(b);
				b.find('[exec]').removeAttr('exec');
				b.css({left:-9999,top:-9999,bottom:'auto',right:'auto'});
			}
			else {
				b.addClass('is-inline');
			}
			b.addClass('jxtipfor break');
			b.wrapInner('<div class="tipbox"></div>');
			b.prepend('<div class="arrow"></div>');
			a.attr('data-r',r);
			b.attr('data-r',r);
			$.eval(a.attr('init'), a, a, b);
		}
		a.addClass('jxtipfornow');
		b.addClass('cur').show().css({zIndex:json.zIndex||60});
		if (json.keep) {
			b.addClass('show keep');
		}
		if (json.click) {
			$('.jxtipforbg').show().css({zIndex:json.zIndex||60});
			b.addClass('click');
		}
		if (a.is('input')) {
			b.addClass('focus show keep');
		}
		if (json.type=='select') {
			a.trigger('paste');
		}
		b.addClass(json.type);
		// 改变父级状态
		this.triggerParents(a, 'addClass.tip_for_hover');
		// 定位
		if (!json.inline) {
			this.time(a, b);
			b.css({visibility:'visible'});
		}
		b.siblings('.jxtipfor').removeClass('show cur keep click');
	},

	// 
	hide: function (b, t) {
		var thi = this;
		var a = $('.jxtipfornow');
		$('.jxtipforbg').hide();
		b.removeClass('show');
		setTimeout(function () {
			if (!b.is('.show') && !b.is('.focus')) {
				// 改变父级状态
				thi.triggerParents(a, 'removeClass.tip_for_hover');
				a.removeClass('jxtipfornow');
				b.removeClass('keep click cur').not('.is-inline').css({left:-9999,top:-9999,bottom:'auto',right:'auto',height:'auto',width:'auto'});
				clearTimeout(thi.timestart);
			}
		}, t||100);
	}
};


// 点击事件 - 展开下拉框
$(document).on('click', '[tip-for*="click:1"], input[tip-for]', function () {
	$.__tip_for.show($(this));
});
// 获取焦点 - 展开下拉框
$(document).on('focus', 'input[tip-for]', function () {
	$.__tip_for.show($(this));
});
// 失去焦点 - 关闭下拉框
$(document).on('blur', 'input[tip-for]', function () {
	var a = $(this);
	var b = $('.jxtipfor[data-r="'+a.attr('data-r')+'"]');
	a.attr('data-focus-times', 0);
	b.removeClass('focus');
	$.__tip_for.hide(b);
});
// 鼠标按下 - 防止点击下拉框后目标会失去焦点而导致下拉框关闭
$(document).on('mousedown', function (e) {
	if ($(e.target).is('.jxtipfor') || $(e.target).parents('.jxtipfor').size()) {
		e.preventDefault();
	}
});
// 鼠标移入事件 - 展开下拉框，但是是需要点击展开的话就不需要此事件了
$(document).on('mouseenter', '[tip-for]:not([tip-for*="click:1"], input)', function () {
	$.__tip_for.show($(this));
});
// 鼠标离开事件 - 关闭下拉框，但是是需要点击展开的话就不需要此事件了
$(document).on('mouseleave', '[tip-for]:not([tip-for*="click:1"], input)', function () {
	$.__tip_for.hide($('.jxtipfor.cur'));
});
// 点击事件 - 如果点击的是背景区，直接把展开的下拉框关闭掉
$(document).on('click', '.jxtipforbg', function () {
	$.__tip_for.hide($('.jxtipfor.cur'), 1);
});
// 鼠标移入事件 - 如果鼠标离开目标，又移入下拉框，应当保持下拉框展开状态
$(document).on('mouseenter', '.jxtipfor', function () {
	if ($(this).is('.keep')) $(this).addClass('show');
});
// 鼠标离开事件 - 关闭下拉框
$(document).on('mouseleave', '.jxtipfor:not(.click)', function () {
	$.__tip_for.hide($(this));
});
// 自定义关闭事件 - 关闭下拉框，需要手动触发
$(document).on('close', '.jxtipfor', function () {
	$.__tip_for.hide($(this));
});
// 预先把背景区加载到body里面
$('body').append('<div class="jxtipforbg hide fixed max"></div>');





// 点击事件 - 
// 将 dd 标签作为 option ，选中之后改变与目标有关系的隐藏域，同时触发目标与隐藏域的chang事件
$(document).on('click', '.jxtipfor.select dd:not([disabled])', function (e) {
	var dd = $(this);
	var b = dd.parents('.jxtipfor');
	var a = $('[tip-for][data-r="'+b.attr('data-r')+'"]');
	// c 与目标有关系的隐藏域
	var c = a.find('[type="hidden"]');
	if (c.size()==0) {
		c = a.next('[type="hidden"]');
	}
	var t = (dd.text()||'').replace(/^\s+|\s+$/g,'');
	var v = dd.is('[value]')?(dd.attr('value')||''):t;
	b.find('dd[selected]').removeAttr('selected');
	dd.attr('selected','');
	b.removeClass('focus').css({visibility:'hidden'}).trigger('close');//.hide();
	// $.__tip_for.hide(b);
	if (c.size()) {
		c.val(v);
		$.eval(c.attr('end'), c, c);
		c.trigger('change');
		if (a.is('input')) a.val(t);
		else if (a.children().size()) a.children().eq(0).html(t);
		else a.html(t);
		a.trigger('change');
	}
	else {
		a.val(v);
		$.eval(a.attr('end'), a, a);
		a.trigger('change');
	}
});
// 切换，键盘，粘贴，点击事件 
// 当目标被点击或者粘贴内容的时候发生数据变化，下拉框的选中状态也同步改变，
$(document).on('change keyup paste click', '[tip-for*="type:select"]', function (e) {
	var a = $(this);
	var b = $('.jxtipfor[data-r="'+a.attr('data-r')+'"]');
	var c = a.find('[type="hidden"]');
	if (c.size()==0) {
		c = a.next('[type="hidden"]');
	}
	var v = (c.val()||a.val()||a.children().eq(0).text()||'').replace(/^\s+|\s+$/g,''), l, d;
	var av = (a.val()||'').replace(/^\s+|\s+$/g,'');
	// 逐个匹配
	if (av) b.find('dd').each(function () {
		if (l) return false;
		d = $(this);
		var vv = d.attr('value')||'';
		var tt = d.text().replace(/^\s+|\s+$/g,'');
		if (av==vv || av==tt) {
			v = vv ? vv : tt;
			l = 1;
		}
	});
	if (!l && v) b.find('dd').each(function () {
		if (l) return false;
		d = $(this);
		var vv = d.attr('value')||'';
		var tt = d.text().replace(/^\s+|\s+$/g,'');
		if (v==vv || v==tt) {
			v = vv ? vv : tt;
			l = 1;
		}
	});
	if (l) {
		b.find('dd').removeAttr('selected');
		d.attr('selected','');
	}
	if (e.type.search(/change|keyup/)>=0) {
		c.val(v);
	}
	if (e.type=='change') {
		$.eval(c.attr('end'), c, c);
		c.trigger('change');
	}
});
$(document).on('change','[tip-for*="type:select"] input',function(e){e.stopPropagation()});




// 点击事件 - 单选，多选的时候，将全部选中的val值都赋值给目标的隐藏域
$(document).on('click', '.jxtipfor.checkbox, .jxtipfor.radio', function () {
	var b = $(this);
	var a = $('[tip-for][data-r="'+b.attr('data-r')+'"]');
	var c = a.find('[type="hidden"]');
	if (c.size()==0) {
		c = a.next('[type="hidden"]');
	}
	var v = '';
	b.find('input:checked').each(function(){
		v += ','+$(this).val();
	});
	c.val(v.replace(/^,+/g,''));
	$.eval(c.attr('end'), c, c);
	c.trigger('change');
});
// 点击，粘贴事件 - 
// 当目标被点击或者粘贴内容的时候发生数据变化，下拉框的单选，或者多选也同步改变，
$(document).on('click paste', '[tip-for*="type:checkbox"], [tip-for*="type:radio"]', function (e) {
	var a = $(this);
	var b = $('.jxtipfor[data-r="'+a.attr('data-r')+'"]');
	var c = a.find('[type="hidden"]');
	if (c.size()==0) {
		c = a.next('[type="hidden"]');
	}
	var v = ','+c.val()+',';
	b.find('input[type="checkbox"], input[type="radio"]').each(function () {
		var o = $(this);
		if (v.indexOf(','+o.val()+',')>=0) {
			o.attr('checked', 'checked').parents('label').addClass('cur');
		}
		else {
			o.removeAttr('checked').parents('label').removeClass('cur');
		}
	});
});



// jq 扩展
$.fn.extend({
	tip_for: function () {
		return $('[tip-for][data-r="'+this.attr('data-r')+'"]');
	},
	tip_for_alert: function () {
		return $('.jxtipfor[data-r="'+this.attr('data-r')+'"]');
	}
});


// 初始函数调用
$.task.push(function () {
	_('[tip-for]').each(function () {
		var a = $(this);
		var t = a.attr('tip-for');
		// 内嵌样式
		if (t.search(/inline:/)>0) {
			$.__tip_for.show(a);
			a.trigger('paste');
		}
		// 初始函数
		$.eval(a.attr('init'), a, a);
		// c 与目标有关系的隐藏域
		if (t.search(/type:(checkbox|radio|select)/)>0) {
			var c = a.find('[type="hidden"]');
			if (c.size()==0) {
				c = a.next('[type="hidden"]');
			}
			$.eval(c.attr('init'), c, c);
		}
	});
});