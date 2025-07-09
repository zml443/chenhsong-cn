ly2.cart.checkout = {
	url: {
		checkout: '/api/cart/checkout',
		orders: '/api/cart/checkout/type-orders',
	},
	/**
	 * 将 ly2-cart 进行字符拆分
	 * @param {DOM} obj 对象节点
	 * @return {array}
	 */
	get_attr: function (obj) {
		var data = (obj.attr('ly2-cart')||'').match(/^([^,]*),?(.*)$/);
		var ary = [];
		if (data && data[1]) {
			ary.push(data[1]);
			ary.push(data[2][0]=='{'?$.json(data[2],'simple'):data[2]);
		}
		return ary;
	},
	/**
	 * 修改订单
	 * @param {DOM} obj 数量对象节点
	 * @return {void}
	 */
	checkout: function () {
		var thi = this;
		$.async('POST', thi.url.checkout, $('[ly2-cart^="form,"]').serialize(), function (d) {
			if (d.ret==1) {
				thi.change(d.msg);
			}
			else {
				$.alert(d.msg, 3000);
			}
		}, 'json');
	},
	/**
	 * 提交订单
	 * @param {DOM} obj 数量对象节点
	 * @return {void}
	 */
	orders: function () {
		var thi = this;
		$.async('POST', thi.url.orders, $('[ly2-cart^="form,"]').serialize(), function (d) {
			if (d.ret==1) {
				location.href = '/cart/pay/n-'+d.msg.OrderNumber+'.html';
			}
			else {
				$.alert(d.msg, 3000);
			}
		}, 'json');
	},
	/**
	 * 更换前端的数据
	 * @return {viod}
	 */
	change: function (data) {
		for (var i in data) {
			$('[ly2-cart="str,'+i+'"]').html(data[i]);
		}
	}
};
// 加载后请求一次
$(document).ready(function () {
	ly2.cart.checkout.checkout();
});