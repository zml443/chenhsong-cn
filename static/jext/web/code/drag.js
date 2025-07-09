$('[jextstyle]').append(
	'[code-drag]{height: 60px;border-radius: 5px;text-align: center;background: #efefef;}'+
	'[code-drag] .el-bg{height: 100%;position: absolute;left: 0;top: 0;background: #75CDF9;}'+
	'[code-drag][is="success"] .el-bg{background: lightgreen;}'+
	'[code-drag] .el-text{position: absolute;top: 0;left: 0;bottom: 0;right: 0;color: #333;visibility: hidden;display: flex;align-items: center;justify-content: center;}'+
	'[code-drag][is="moving"] .el-ready,'+
	'[code-drag][is="ready"] .el-ready,'+
	'[code-drag][is="load"] .el-load,'+
	'[code-drag][is="success"] .el-success,'+
	'[code-drag][is="fail"] .el-fail{visibility: visible;}'+
	'[code-drag] .el-btn{position: absolute;cursor: move;border-radius: 5px;top: 0;left: 0;bottom: 0;background: #fff;fill: #444;border: 2px solid #efefef;}'+
	'[code-drag][is="moving"] .el-btn,'+
	'[code-drag][is="load"] .el-btn,'+
	'[code-drag][is="success"] .el-btn{border-color: #75CDF9;}'+
	'[code-drag][is="success"] .el-btn{border-color: lightgreen;}'
);

$.__code_drag = function (el, opt) {
	var thi = this;
	thi.opt = $.extend({
		ico: '<svg class="svg" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" height="20"><path d="M516.266667 494.933333l-192 192-29.866667-29.866666 162.133333-162.133334-162.133333-162.133333 29.866667-29.866667 192 192z m256 0l-192 192-29.866667-29.866666 162.133333-162.133334-162.133333-162.133333 29.866667-29.866667 192 192z"></path></svg>',
		json: $.json(el.attr('code-drag'), 'simple'),
		fn: $.callbackfn(el.attr('fn'),'init,down,up,success,fail,move'),
		token_name: 'register'
	}, opt);

	el.addClass('relative over').append('<div class="el-bg"></div>');
	if (el.find('.el-ready').size()==0) el.append('<div class="el-text el-ready">'+$.lang.code.drag.ready+'</div>');
	if (el.find('.el-load').size()==0) el.append('<div class="el-text el-load">'+$.lang.code.drag.load+'</div>');
	if (el.find('.el-success').size()==0) el.append('<div class="el-text el-success">'+$.lang.code.drag.finish+'</div>');
	if (el.find('.el-fail').size()==0) el.append('<div class="el-text el-fail">'+$.lang.code.drag.fail+'</div>');
	if (el.find('input').size()==0) el.append('<input type="hidden" name="v_code" check="str" tip="'+$.lang.code.drag.tip+'" />');
	el.append('<div class="el-btn m-pic">'+thi.opt.ico+'</div>');
	el.attr({'is':'ready'});

	thi.opt.btn = el.find('.el-btn'),
	thi.opt.bg = el.find('.el-bg');
	thi.opt.btn.width(el.height());
	thi.move = thi.opt.btn.move(thi.opt.btn, {
		x: 1,
		y: 0,
		space: [1,0,2,0],
		box: 1,
		down: function () {
			// var themove = this;
			/*if (themove.not==1) {
				return;
			}*/
			el.attr({'is':'moving'});
			thi.opt.bg.removeClass('trans5');
			if (thi.opt.json.color1) {
				thi.opt.btn.css({borderColor:thi.opt.json.color1});
				thi.opt.bg.css({background:thi.opt.json.color1});
			}
			clearTimeout(thi.opt.move_token);
			clearTimeout(thi.opt.move_fail);
			// 回调函数
			$.eval(thi.opt.fn.down, el);
		},
		move: function (args) {
			thi.opt.bg.css({width: args.ratio.left*100 + '%'});
			if (args.ratio.left>=1) {
				el.attr({'is':'load'});
				clearTimeout(thi.opt.move_token);
				thi.opt.move_token = setTimeout(function () {
					$.token(thi.opt.token_name, function(vcode){
						if (vcode) {
							el.attr({'is':'success'});
							el.find('input').val(vcode);
							if (thi.opt.json.color2) {
								thi.opt.btn.css({borderColor:thi.opt.json.color2});
								thi.opt.bg.css({background:thi.opt.json.color2});
							}
							// 回调函数
							$.eval(thi.opt.fn.success, el);
						}
						else {
							el.attr({'is':'fail'});
							thi.opt.move_fail = setTimeout(function(){
								thi.reset();
							}, 1500);
							// 回调函数
							$.eval(thi.opt.fn.fail, el);
						}
					});
				}, 250);
			}
		},
		up: function(){
			if (el.is('[is="moving"]')) {
				thi.reset();
			}
			// 回调函数
			$.eval(thi.opt.fn.up, el);
		}
	});
	thi.reset = function () {
		var mx = thi.opt.btn.matrix();
		mx[4]=0;
		mx[5]=0;
		if (thi.opt.json.color1) {
			thi.opt.btn.css({borderColor:thi.opt.json.color1});
			thi.opt.bg.css({background:thi.opt.json.color1});
		}
		thi.opt.bg.addClass('trans5').css({width: 0});
		thi.opt.btn.css({borderColor:''}).addClass('trans5').matrix(mx);
		el.attr({'is':'ready'});
	};
	// 回调函数
	$.eval(thi.opt.fn.init, el);
	return thi;
};


$.task.push(function () {
	_('[code-drag]').each(function() {
		var el = $(this),
			code_drag = new $.__code_drag(el, {});
		el.on('reset', function () {code_drag.reset()});
	});
});