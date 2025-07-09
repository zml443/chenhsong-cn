var __tree_menu = function (el, opt) {
	var thi = this;
	thi.opt = $.extend({
		li_style: [
			'.',
			'1',
			'-',
			'-',
			'-'
		],
		svg: {
			arrow:'<svg class="el-svg" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" height="20"><path d="M373.412318 205.422751 334.856478 242.886344l277.618102 269.744922L334.856478 782.385917l38.55584 37.458727 316.165428-307.213379L373.412318 205.422751 373.412318 205.422751zM373.412318 205.422751"></path></svg>',
			arrow2:'<svg class="el-svg" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" height="16"><path d="M755.974268 512 268.025732 146.975708l0 730.048584L755.974268 512"></path></svg>',
		},
	}, opt);
	thi.opt.el = $(el);
	thi.opt.fn = $.callbackfn(thi.opt.el.attr('fn'),['init']);
	function each_el (el, index) {
		var i = 0;
		el.children('.el-name').each(function () {
			i++;
			var a = $(this),
				next = a.next();
			if (thi.opt.after=='>') {
				a.append('<div class="el-arrow el-arrow-after trans m-pic">' + thi.opt.svg.arrow + '</div>');
			}
			else if (thi.opt.after=='>>') {
				a.append('<div class="el-arrow el-arrow-after trans m-pic">' + thi.opt.svg.arrow2 + '</div>');
			}
			else if (thi.opt.after=='+') {
				a.append('<div class="el-arrow el-add el-arrow-after trans m-pic"></div>');
			}
			else if (thi.opt.before=='>') {
				a.prepend('<div class="el-arrow el-arrow-before trans m-pic">' + thi.opt.svg.arrow + '</div>');
			}
			else if (thi.opt.before=='>>') {
				a.prepend('<div class="el-arrow el-arrow-before trans m-pic">' + thi.opt.svg.arrow2 + '</div>');
			}
			else if (thi.opt.before=='+') {
				a.prepend('<div class="el-arrow el-add el-arrow-before trans m-pic"></div>');
			}
			if (next.is('.el-children')) {
				a.addClass('has');
				if (next.is(':visible')) {
					a.addClass('cur');
					next.addClass('cur');
				}
				else {
					a.removeClass('cur');
					next.removeClass('cur').hide();
				}
				each_el(next, (index?(index+'.'):'')+i);
			}
			else {
				a.removeClass('cur');
			}
		});
	}
	each_el($(thi.opt.el));
	$.eval(thi.opt.fn.init, thi.opt.el);
};
// 点击展开
$(document).on("click", "[tree-menu] .el-name", function () {
	var a = $(this),
		next = a.next(),
		parent = a.parents('[tree-menu]:eq(0)'),
		menu = parent.o('tree-menu');
	if (next.is('.el-children')) {
		if (a.is('.cur')) {
			next.slideUp(function () {
				a.removeClass("cur");
				next.removeClass("cur");
				$.eval(menu.opt.fn.hide, parent, a, next);
			});
		}
		else {
			a.toggleClass("cur");
			next.toggleClass("cur");
			next.slideDown(function () {
				$.eval(menu.opt.fn.show, parent, a, next);
			});
		}
	}
});
// 识别页面的树状数据
$.task.push(function () {
	_('[tree-menu]').each(function () {
		var a = $(this),
			menu = new __tree_menu(a, $.json(a.attr('tree-menu'),'simple'));
		a.o('tree-menu', menu);
	});
});