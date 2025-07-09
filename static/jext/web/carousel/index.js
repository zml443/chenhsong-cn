/**
 * 轮播特效
 * @param {DOM} obj 轮播节点
 * @return {void}
 */
$.__carousel = function (obj, potion) {
	this.obj = obj;
	this.potion = $.extend({
		effect: 'default',
		play: 1,
		time: 3000,
		speed: 2,
		contrary: -1,
		wrapper: {},
	}, potion);
	this.init();
	this.run();
};
// 克隆
$.__carousel.prototype.clone = function () {
	var a = this.obj.find('.wrapper'),
		clone = a.clone();
	a.wrap('<div class="bigwrapper flex-nowrap maxw"></div>');
	this.potion.bigwrapper = this.obj.find('.bigwrapper');
	this.potion.bigwrapper.append(clone);
	clone = a.clone();
	this.potion.bigwrapper.append(clone);
	this.potion.wrapper.$el = this.potion.bigwrapper.children();
}
// 初始化定位
$.__carousel.prototype.init = function () {
	this.clone();
	this.resize();
	this.potion.bigwrapper.matrix([1,0,0,1,-this.potion.wrapper.width,0]);
	if (this.potion.init) {
		this.potion.init.call(this);
	}
}
// 改变尺寸
$.__carousel.prototype.resize = function () {
	this.potion.wrapper.width = this.potion.wrapper.$el[0].width();
}
// 运动
$.__carousel.prototype.run = function () {
	var thi = this,
		matrix = this.potion.bigwrapper.matrix();
	if (this.potion.effect=='seamless') {
		matrix[4] += this.potion.contrary*this.potion.speed;
		if (this.potion.play) {
			this.potion.bigwrapper.matrix(this.matrix(matrix));
		}
		$.settime(function(){thi.run()},2);
	}
	else {
		// 
	}
}
// 矩阵数据整理
$.__carousel.prototype.matrix = function (matrix) {
	var a = Math.abs(matrix[4]),
		b = Math.abs(this.potion.wrapper.width);
	if (a>=2*b) {
		matrix[4] = -(b + a%b);
	}
	return matrix;
}
// 停止滚动
$.__carousel.prototype.stop = function (matrix) {
	this.potion.play = 0;
}
// 开始滚动
$.__carousel.prototype.play = function (matrix) {
	this.potion.play = 1;
}
// 
$.task.push(function () {
	_('.carousel').each(function () {
		var a = $(this);
		var ro = new $.__carousel($(this), {
			effect: a.attr('effect'),
			contrary: parseInt(a.attr('contrary'))||-1,
		});
		$(this).o('carousel', ro);
	});
});

