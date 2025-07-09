
var _all_checkbox_ = {
	check: function(el, opt){
		var bind = $(el.attr('all'));
		var pl = el.parents('label');
		var n = 0;
		var opt = {
			init:0,
			...opt
		};
		var result = {
			size: bind.size(),
			choice: 0
		};
		bind.each(function() {
			if ($(this).is(':checked')) {
				result.choice++
			}
		});
		if (result.size && result.size==result.choice) {
			el.attr('checked', true);
			pl.addClass('cur').removeClass('cur2');
		} else {
			el.attr('checked', false);
			pl.removeClass('cur');
			if (result.choice) {
				pl.addClass('cur2');
			} else {
				pl.removeClass('cur2');
			}
		}
		if (!opt.init) {
			var allfn = $.callbackfn(el.attr('fn'),'click');
			$.eval(allfn.click, el, el.is(':checked'), result);
		}
	}
}

$.task.push(function() {
	_('label [type=checkbox],label [type=radio]').each(function() {
		var el = $(this),
			parent = el.parents('label').eq(0),
			fn = $.callbackfn(el.attr('fn'),'init'),
			id = el.attr('id')||('rc'+Math.random()).replace('.','');
		if (el.is(':checked')) {
			parent.addClass('cur');
			var r = el.attr('name');
			$.__chk_rio = $.__chk_rio || {};
			$.__chk_rio[r] = el;
		} else {
			parent.removeClass('cur');
		}
		if (el.is(':disabled')) {
			parent.addClass('disabled');
		}
		parent.attr('for', id);
		el.attr('id', id);
		parent.find('[stopPropagation]').click(function(e) {
			$(this).parents('label:eq(0)').find('input[type=checkbox],input[type=radio]').addClass('stopClick');
		});
		if (el.is('[all]')) {
			_all_checkbox_.check(el,{init:1});
		}
		$.eval(fn.init, el, el.is(':checked'));
	})
});

$(document).on('click', 'label input[type=checkbox],label input[type=radio]', function () {
	var el = $(this);
	var parent = el.parents('label').eq(0);
	var fn = $.callbackfn(el.attr('fn'),'click');
	if (el.is('[all]')) {
		var all = $(el.attr('all'));
		var qty = 0;
		all.each(function() {
			if ($(this).is(':checked')) {
				qty++;
			}
		});
		if (all.size()==qty) {
			all.attr('checked', false).parent('label').removeClass('cur');
			el.attr('checked', false).parent('label').removeClass('cur');
		} else {
			all.attr('checked', true).parent('label').addClass('cur');
			el.attr('checked', true).parent('label').addClass('cur');
		}
		_all_checkbox_.check(el);
		// $.eval(fn.click, el, el.is(':checked'));
	} else {
		if (el.is('.stopClick')||el.is(':disabled')) {
			el.removeClass('stopClick');
			if (parent.is('.cur')) el.attr('checked', true);
			else el.removeAttr('checked');
			return false;
		}
		var r = el.attr('name');
		var n = parseInt($('[name="' + r + '"][data-number]').attr('data-number') || $('[name="' + r + '"][number]').attr('number')) || 0;
		var s = $('[name="' + r + '"]:checked').size();
		$.__chk_rio = $.__chk_rio || {};
		if (n!=0 && s>n && $.__chk_rio[r]) {
			$.__chk_rio[r].attr('checked', false).parents('label').removeClass('cur');
		}
		$.__chk_rio[r] = el;
		if (el.is('[type="radio"]')) {
			$('[name="' + r + '"]').parents('label').removeClass('cur');
		}
		$('[type=checkbox][all]').each(function() {
			var allel = $(this);
			_all_checkbox_.check(allel);
		});
		// 偶尔会出现，点击获取不到选中的状态
		// 所以这里使用定时器
		setTimeout(function(){
			if (el.is(':checked')) {
				parent.addClass('cur');
				parent.find('input[type=hidden]').val(el.val());
			} else {
				parent.removeClass('cur');
				parent.find('input[type=hidden]').val('');
			}
			$.eval(fn.click, el, el.is(':checked'));
		});
	}
});