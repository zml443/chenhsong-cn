// 切换事件 - 选择不同的优惠类型便切换不同的输入框
$(document).on('change', '[name="FreeType"]', function (e) {
	var i = parseInt($(this).val());
	var p = dbs.div(this);
	p.find('.inp').children().eq(i).show().siblings().hide();
});