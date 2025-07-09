ly2.cart.list = {
	url: {
		delete: '/api/cart/delete',
		checkbox: '/api/cart/checkbox',
		parameter: '/api/cart/parameter',
		qty: '/api/cart/qty',
	},
	/**
	 * 将 ly2-cart 进行字符拆分
	 * @param {DOM} el 对象节点
	 * @return {array}
	 */
	get_attr: function (el) {
		var data = (el.attr('ly2-cart')||'').match(/^([^,]*),?(.*)$/);
		var ary = [];
		if (data && data[1]) {
			ary.push(data[1]);
			ary.push(data[2][0]=='{'?$.json(data[2],'simple'):data[2]);
		}
		return ary;
	},
	/**
	 * 绑定数量输入框，更改数量后，改变购物车列表的价格
	 * @param {DOM} el 数量对象节点
	 */
	qty_data: {},
	qty: function (el) {
		var thi = this,
			p = el.parents('[ly2-cart^="li,"]'),
			id = p.find('[name^="Id"]').val()||el.dat('id'),
			val = el.val(),
			ids = '',
			qty = '';
		thi.qty_data[id] = val;
		for (var i in thi.qty_data) {
			ids += i+',';
			qty += thi.qty_data[i]+',';
		}
		clearTimeout(thi.qty_price_timeout);
		thi.qty_price_timeout = setTimeout(function () {
			thi.qty_data = {};
			$.async('POST', thi.url.qty, {Id:ids, Qty:qty}, function (d) {
				if (d.ret==1) {
					thi.change(d.msg);
				}
				else {
					$.alert(d.msg, 1);
				}
			}, 'json');
		}, 300);
	},
	/**
	 * 更改数量后，购物车列表的价格
	 * @param {DOM} el 数量对象节点
	 */
	param_data: {},
	parameter: function (el) {
		var thi = this,
			p = el.parents('[ly2-cart^="li,"]'),
			id = p.find('[name^="Id"]').val()||el.dat('id'),
			val = el.val();
		$.async('POST', thi.url.parameter, {Id:id, ParamId:val}, function (d) {
			if (d.ret==1) {
				thi.change(d.msg);
			}
			else {
				$.alert(d.msg, 1);
			}
		}, 'json');
	},
	/**
	 * 选中购物
	 * @param {DOM} el 数量对象节点
	 */
	checkbox: function (el) {
		var thi = this,
			ids = '',
			chk = '';
		$('[ly2-cart^="form,"] [name^="Id"]').each(function () {
			ids += $(this).val()+',';
			chk += ($(this).is(':checked')?1:0)+',';
		});
		clearTimeout(thi.checkbox_timeout);
		thi.checkbox_timeout = setTimeout(function () {
			$.async('POST', thi.url.checkbox, {Id:ids, Chk:chk}, function (d) {
				if (d.ret==1) {
					thi.change(d.msg);
				}
			}, 'json');
		}, 300);
	},
	/**
	 * 加入购物车
	 * @param {DOM} el form对象节点
	 */
	add: function (el) {
		var thi = this;
	    $.async('POST', '/api/cart/add', el.serialize(), function (d) {
	        if (d.ret==1) {
	            if (el.find('[name="BuyType"]').val()=='1') {
	                location.href='/cart/checkout/BuyType-1.html';
	            }
	            else {
	                $.alert({str:'Added to shopping cart', btn:1});
	            }
	            thi.change(d.msg);
	        }
	        //弹出登录窗口
	        else if (d.ret==-2) {
				ly2.member.login.popup();
	        }
	        else {
	            $.alert({str:d.msg});
	        }
	    },'json');
	},
	/**
	 * 删除
	 * @param {DOM} el 数量对象节点
	 */
	delete: function (el) {
		var thi = this,
			atr = thi.get_attr(el),
			ids = [];
		if (atr[0]=='del') {
			ids.push(atr[1]);
		}
		else {
			$('[ly2-cart^="form,"] [name^="Id"]:checked').each(function () {
				ids.push($(this).val());
			});
		}
		var tip_str = {null:'请选择删除项！', del:'您正要删除 '+ids.length+' 个选项，将无法复原，是否继续？'};
		if (ids.length==0) {
			$.alert({
				str: tip_str.null,
				btn: 1,
			});
			return false;
		}
		$.alert({
			str: tip_str.del,
			close: 0,
			btn: function () {
				$.async('POST', thi.url.delete, {Id:ids.join(',')}, function (d) {
					if (d.ret==1) {
						for (var i in ids) {
							$('[name^="Id"][value="'+ids[i]+'"]').parents('[ly2-cart^="li,"]').remove();
						}
						thi.change(d.msg);
					}
					else {
						$.alert(d.msg, 1);
					}
				}, 'json');
			}
		});
	},
	/**
	 * 更换前端的数据
	 */
	change: function (data) {
		for (var i in data) {
			$('[ly2-cart="str,'+i+'"]').html(data[i]);
		}
	}
};
// 清空购物车
$(document).on('click', '[ly2-cart^="del_all,"]', function () {
	// 
});
// 删除
$(document).on('click', '[ly2-cart^="del,"],[ly2-cart^="del_bat,"]', function () {
	ly2.cart.list.delete($(this));
});

// 加入购物车和立即购买共用
$(document).on('click', '[ly2-cart^="add,"]', function() {
    var a = $(this),
    	form = a.parents('form:eq(0)');
    if (a.is('[ly2-cart*=",cart"]')) {
    	form.find('[name="BuyType"]').val('0');
    }
    else {
    	form.find('[name="BuyType"]').val('1');
    }
    ly2.cart.list.add(form);
});