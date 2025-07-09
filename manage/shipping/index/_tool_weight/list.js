// 列表展示属性，可以直接提交，如：首页显示
$(document).on('click', ".wb_shipping_price_set", function (e) {
	var el = $(this)
	WP.$.alert_side({
		data: el.find('script').json(),
		css: {width:1000, right:0},
	});
});