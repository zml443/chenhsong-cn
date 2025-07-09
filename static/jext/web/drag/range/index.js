class drag_range{
	constructor(a, option={}){
		a.addClass('relative').append('<div class="d1"></div><div class="d2"></div><div class="l0"></div>');
		this.a = a;
		this.d1 = a.find('.d1');
		this.d2 = a.find('.d2');
		this.l0 = a.find('.l0');
		this.data = (a.attr('data')||'').split(',');
		this.option = option||{};
		this.option.min = option.min||(parseInt(a.attr('min'))||0);
		this.option.max = option.max||(parseInt(a.attr('max'))||0);
		this.option.minel = option.minel||a.find('input[min]').length?a.find('input[min]'):$(a.attr('min-to'));
		this.option.maxel = option.maxel||a.find('input[max]').length?a.find('input[max]'):$(a.attr('max-to'));
		this.option.val = option.val||a.find('input').val();
		this.option.vertical = option.vertical||a.attr('drag-range')=='vertical';
		this.get_val();
		this.range = a.is('[max]')&&a.is('[min]');
		this.fn = $.callbackfn(a.attr('fn'),'init,change,move,down');

		this.ary=[];
		this.len=0;

		this.get_len();
		this.drag();
		$.eval(this.fn.init, a, this);
		this.events();
		this.reset();
	}
	get_len(){
		if (this.range) {
			this.len = this.option.max - this.option.min;
		}else {
			var li = '';
			for (var i in this.data) {
				if (this.data[i]) {
					li += '<div>'+this.data[i]+'</div>';
					this.ary.push(this.data[i]);
					this.len++;
				}
			}
			li = $('<div class="tip">'+li+'</div>');
			this.a.append(li);
		}
	}
	drag(){
		var thi = this;
		this.d1_ = this.d1.move(this.d1, {
			x: !this.option.vertical,
			y: this.option.vertical,
			box: this.a,
			down: function () {
				thi.l0.removeClass('trans5');
				$.eval(thi.fn.down, thi.a, thi);
			},
			move: function (d) {
				if (thi.option.vertical) {
					var num = Math.round(d.ratio.top * thi.len);
					thi.l0.css({top: d.ratio.top*100 + '%'});
				}
				else {
					var num = Math.round(d.ratio.left * thi.len);
					thi.l0.css({left: d.ratio.left*100 + '%'});
				}
				if (thi.range) thi.option.min = num;
				$.eval(thi.fn.move, thi.a, thi);
			},
			up: function (d) {
				thi.l0.addClass('trans5');
				// if (thi.option.vertical && thi.len) {
				// 	var num = Math.round(d.ratio.top * thi.len);
				// 	thi.reset({t:num / thi.len});
				// }
				// else if (thi.len) {
				// 	var num = Math.round(d.ratio.left * thi.len);
				// 	thi.reset({l:num / thi.len});
				// }
				thi.option.minel.val(thi.option.min);
				// console.log('min',thi.option.min);
				$.eval(thi.fn.change, thi.a, thi);
			}
		});
		this.d2_ = this.d2.move(this.d2, {
			x: !this.option.vertical,
			y: this.option.vertical,
			box: this.a,
			down: function () {
				thi.l0.removeClass('trans5');
				$.eval(thi.fn.down, thi.a, thi);
			},
			move: function (d) {
				if (thi.option.vertical) {
					var num = Math.round(d.ratio.top * thi.len);
					thi.l0.css({bottom: (1-d.ratio.top)*100 + '%'});
				}
				else {
					var num = Math.round(d.ratio.left * thi.len);
					thi.l0.css({right: (1-d.ratio.left)*100 + '%'});
				}
				if (thi.range) thi.option.max = num;
				else thi.option.data = thi.ary[num];
				$.eval(thi.fn.move, thi.a, thi);
			},
			up: function (d) {
				thi.l0.addClass('trans5');
				// if (thi.option.vertical && thi.len) {
				// 	var num = Math.round(d.ratio.top * thi.len);
				// 	thi.reset({t:num / thi.len});
				// }
				// else if (thi.len) {
				// 	var num = Math.round(d.ratio.left * thi.len);
				// 	thi.reset({l:num / thi.len});
				// }
				thi.option.maxel.val(thi.option.max);
				// console.log('max',thi.option.max);
				$.eval(thi.fn.change, thi.a, thi);
			}
		});
	}
	get_val(){
		let len = this.option.max - this.option.min;
		this.minv = parseFloat(this.option.minel.val());
		this.maxv = parseFloat(this.option.maxel.val());

		if(this.minv<this.option.min){
			this.minv = this.option.min;
		}else if(this.minv>this.option.max){
			this.minv = this.option.max;
		}
		if(this.maxv<this.option.min){
			this.maxv = this.option.min;
		}else if(this.maxv>len){
			this.maxv = len;
		}

		this.option.minel.val(this.minv);
		this.option.maxel.val(this.maxv);
	}
	reset(){
		this.get_val();
		var minv = this.minv;
		var maxv = this.maxv;
		var lt = (minv / this.len)*100;
		var rb = (1-(maxv / this.len))*100;
		// console.log('reset',minv,maxv,this.option.min,this.option.max);
		if(this.option.vertical){
			this.d1.css({transform:'translate(0)',top: lt + '%'})
			this.d2.css({transform:'translate(0)',top: (maxv / this.len)*100 + '%'});
			this.l0.css({top: lt + '%',bottom: rb + '%'});
		}else{
			this.d1.css({transform:'translate(0)',left: lt + '%'})
			this.d2.css({transform:'translate(0)',right: rb + '%'});
			this.l0.css({left: lt + '%',right: rb + '%'});
		}
	}
	events(){
		var thi = this;
		this.option.minel.on('change',function(){
			thi.reset();
		})
		this.option.maxel.on('change',function(){
			thi.reset();
		})
	}

}


$.task.push(function () {
	_('[drag-range]').each(function() {
		var xxx = new drag_range($(this));
		$(this).o('drag-range',xxx);
	});
});

$(document).on('click', '[drag-range] .reset', function () {
	$(this).parents('[drag-range]').o().reset();
});














// $.__drag_range = {
// 	go: function (a) {
// 		var thi = this;
// 		a.addClass('relative').append('<div class="d1"></div><div class="d2"></div><div class="l0"></div>');
// 		var d1 = a.find('.d1');
// 		var d2 = a.find('.d2');
// 		var l0 = a.find('.l0');
// 		var min = parseInt(a.attr('min'))||0;
// 		var max = parseInt(a.attr('max'))||0;
// 		var data = (a.attr('data')||'').split(',');
// 		var maxv = a.find('input[max]');
// 		var minv = a.find('input[min]');
// 		var val = a.find('input').val();
// 		var vertical = a.attr('drag-range')=='vertical';
// 		var range = a.is('[max]')&&a.is('[min]');
// 		var fn = $.callbackfn(a.attr('fn'),'up');
// 		thi.option = $.extend({
// 			max:max,
// 			min:min,
// 		}, $.json(a.attr('option'), 'simple'));
// 		if (range) {
// 			var len = max - min;
// 		}
// 		else {
// 			var li = '', len=0, ary=[];
// 			for (var i in data) {
// 				if (data[i]) {
// 					li += '<div>'+data[i]+'</div>';
// 					ary.push(data[i]);
// 					len++;
// 				}
// 			}
// 			li = $('<div class="tip">'+li+'</div>');
// 			a.append(li);
// 		}
// 		thi.option.d1 = d1.move(d1, {
// 			x: !vertical,
// 			y: vertical,
// 			box: a,
// 			down: function () {
// 				l0.removeClass('trans5');
// 			},
// 			move: function (d) {
// 				if (vertical) {
// 					var num = Math.round(d.ratio.top * len);
// 					l0.css({top: d.ratio.top*100 + '%'});
// 				}
// 				else {
// 					var num = Math.round(d.ratio.left * len);
// 					l0.css({left: d.ratio.left*100 + '%'});
// 				}
// 				if (range) thi.option.min = num;
// 				$.eval(a.attr('move'), a, thi.option);
// 			},
// 			up: function (d) {
// 				l0.addClass('trans5');
// 				if (vertical && len) {
// 					var num = Math.round(d.ratio.top * len);
// 					thi.reset({t:num / len});
// 				}
// 				else if (len) {
// 					var num = Math.round(d.ratio.left * len);
// 					thi.reset({l:num / len});
// 				}
// 				minv.val(thi.option.min);
// 				console.log('min',thi.option.min);
// 				$.eval(fn.up, a, thi.option);
// 			}
// 		});
// 		thi.option.d2 = d2.move(d2, {
// 			x: !vertical,
// 			y: vertical,
// 			box: a,
// 			down: function () {
// 				l0.removeClass('trans5');
// 			},
// 			move: function (d) {
// 				if (vertical) {
// 					var num = Math.round(d.ratio.top * len);
// 					l0.css({bottom: (1-d.ratio.top)*100 + '%'});
// 				}
// 				else {
// 					var num = Math.round(d.ratio.left * len);
// 					l0.css({right: (1-d.ratio.left)*100 + '%'});
// 				}
// 				if (range) thi.option.max = num;
// 				else thi.option.data = ary[num];
// 				$.eval(a.attr('move'), a, thi.option);
// 			},
// 			up: function (d) {
// 				l0.addClass('trans5');
// 				if (vertical && len) {
// 					var num = Math.round(d.ratio.top * len);
// 					thi.reset({t:num / len});
// 				}
// 				else if (len) {
// 					var num = Math.round(d.ratio.left * len);
// 					thi.reset({l:num / len});
// 				}
// 				maxv.val(thi.option.max);
// 				console.log('max',thi.option.max,maxv,maxv.val());
// 				$.eval(fn.up, a, thi.option);
// 			}
// 		});
// 		$.eval(a.attr('init'), a, thi.option);
// 	},
// 	reset: function (a) {
// 		console.log(this.option);
// 		this.option.d1.init();
// 		this.option.d2.init();
// 	},
// };


// $.task.push(function () {
// 	_('[drag-range]').each(function() {
// 		$.__drag_range.go($(this));
// 	});
// });

// $(document).on('reset', '[drag-range]', function () {
// 	$.__drag_range.reset($(this));
// });


