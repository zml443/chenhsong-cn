var _dbs_parameter_ = {
	price: {
		data: [],
	},
	parameter: {
		data: [],
		init(){
			$('.wb_pro_parameter_type_list .ul').html(`
				${this.data&&this.data.length>0?this.data.map(v=>{
					return `
						<div class="li">
							<div class="title flex">
								<div class="a">
									${v.name}
									<input type="hidden" name="wb_products_parameter[0][name]" value="${v.name}" />
								</div>
								<div class="more flex-middle">
									<div class="edit">${$.lang.global.edit}</div>
									<div class="del">${$.lang.global.del}</div>
								</div>
								<input type="hidden" name="wb_products_parameter[0][id]" value="${v.id}" />
								<input type="hidden" name="wb_products_parameter[0][type]" value="${v.type}" />
							</div>
							<div class="value flex-wrap">
								${v.children?v.children.map(val=>{
									return `
										<div class="var ly_input">
											<div class="pic">
												<input type="hidden" name="wb_products_parameter[0][children][0][picture]" value="${val.picture}" />
											</div>
											<input type="text" name="wb_products_parameter[0][children][0][name]" value="${val.name}" placeholder="${$.lang.orders.products_inp_sp}">
											<input type="hidden" name="wb_products_parameter[0][children][0][id]" value="${val.id}" />
											<div class="del lyicon-ashbin"></div>
										</div>
									`
								}).join(''):''}
								<div class="add flex-max2"><i class="lyicon-add mr_3px"></i><span>${$.lang.orders.products_add_sp}</span></div>
							</div>
						</div>
					`
				}).join(''):''}
			`)
			this.orderby()
		},
		// set_data
		set_data(){
			let row = [];
			$('.wb_pro_parameter_type_list .ul .li').each((i, li)=>{
				let children = [];
				$(li).find('.var').each((j, va)=>{
					children.push({
						id: $(va).find('[name$="[id]"]').val(),
						name: $(va).find('[name$="[name]"]').val()||'',
						picture: $(va).find('[name$="[picture]"]').val()||'',
						color: $(va).find('[name$="[color]"]').val()||'',
					})
				})
				row.push({
					id: $(li).find('.title [name$="[id]"]').val(),
					name: $(li).find('.title [name$="[name]"]').val(),
					type: $(li).find('.title [name$="[type]"]').val(),
					children: children
				})
			})
			this.data = row
			_dbs_parameter_.combination.hebing(this.data)
			_dbs_parameter_.combination.init()
		},
		// 排序
		orderby(){
			$('.wb_pro_parameter_type_list .ul .li').each((i, li)=>{
				$(li).find('select,input,textarea').each(function(){
					let input = $(this)
					let name = input.attr('name')||''
					input.attr('name', name.replace(/^([^\[]*)\[([\d]*)\]([\s\S]*)$/, '$1['+i+']$3'))
				})
				$(li).find('.var').each((j, va)=>{
					$(va).find('select,input,textarea').each(function(){
						let input = $(this)
						let name = input.attr('name')||''
						input.attr('name', name.replace(/^([\s\S]*\[[\d]*\][\s\S]*)\[([\d]*)\]([\s\S]*)$/, '$1['+j+']$3'))
					})
				})
			})
		},
		// 获取id
		get_id(){
			var id = 1
			while (1) {
				if ($('.wb_pro_parameter_type_list .ul .li [name$="[id]"][value="'+id+'"]').size()==0) {
					break;
				}
				id++;
			}
			return id
		},
	},
	// 合并
	combination:{
		data: [],
		parameter: [],
		hebing(data){
			this.parameter = []
			this.data = []
			if (data && data.length>0) {
				for (var v of data) {
					if (v.children && v.children.length>0) {
						this.parameter.push(v)
					}
				}
				if (this.parameter.length>0) {
					let result = []
					let sd = (arr, len, temp) => {
						for (let v of arr[len].children) {
							let newtemp = temp.concat(v)
							if (arr.length-1==len) {
								result.push(newtemp)
							} else {
								sd(arr, len+1, newtemp)
							}
						}
					}
					sd(this.parameter, 0, [])
					this.data = result
				}
			}
		},
		// 展示列表
		input(key, data){
			var parameter_id = []
			for (var v of data) {
				parameter_id.push(v.id)
			}
			parameter_id = parameter_id.sort((x,y)=>x-y).join(',')
			var item = _dbs_parameter_.price.data[parameter_id] || {
				picture: '',
				price: '',
				stock: '',
				SKU: '',
			}
			return `
				<tr class="">
					${data.map((v, k)=>{
						return `
							<td data-id="${v.id}">
								${v.name}
								<input type='hidden' name='wb_products_parameter_price[0][parameter][${k}][title]' value='${this.parameter[k].name}'>
								<input type='hidden' name='wb_products_parameter_price[0][parameter][${k}][value]' value='${v.name}'>
							</td>
						`
					}).join('')}
					<td class="hide">
						<label class='ly_file ${item.picture?'cur':''}' size="mini" file-selector='manage' fn='WP.lyma_upload_img'>
							<img class="img" file-ext='${item.picture}' />
							<i class="add"></i>
							<input type='hidden' name='wb_products_parameter_price[0][picture]' size="mini" value='${item.picture}'>
						</label>
					</td>
					<td>
						<label class="ly_input width100" size="mini">
							<input type="number" name="wb_products_parameter_price[0][price]" size="mini" value='${item.price}' step='0.01' />
						</label>
					</td>
					<td>
						<label class="ly_input width100" size="mini">
							<input type="number" name="wb_products_parameter_price[0][original_price]" size="mini" value='${item.original_price}' step='0.01' />
						</label>
					</td>
					<td>
						<label class="ly_input width100" size="mini">
							<input type="number" name="wb_products_parameter_price[0][cost_price]" size="mini" value='${item.cost_price}' step='0.01' />
						</label>
					</td>
					<td>
						<label class="ly_input width100" size="mini">
							<input type="number" name="wb_products_parameter_price[0][stock]" size="mini" value='${item.stock}' step='0' />
						</label>
					</td>
					<td>
						<label class="ly_input width100" size="mini">
							<input type="type" name="wb_products_parameter_price[0][SKU]" size="mini" value='${item.SKU}' />
						</label>
						<input type="hidden" name="wb_products_parameter_price[0][parameter_id]" value="${parameter_id}" />
					</td>
				</tr>
			`
		},
		init(){
			let parameter = this.parameter
			let combination = this.data
			$('.wb_pro_parameter_type_table').html(`
				<thead>
					<tr>
						${parameter.map(v=>{
							return `<td>${v.name}</td>`
						}).join('')}
						<td class="hide">${$.lang.global.picture}</td>
						<td>
							<label class="ly_input width100" size="mini">
								<input type="number" name="wb_products_parameter_price_temp_price" size="mini" placeholder="${$.lang.orders.sale_price}" />
							</label>
						</td>
						<td>
							<label class="ly_input width100" size="mini">
								<input type="number" name="wb_products_parameter_price_temp_original_price" size="mini" placeholder="${$.lang.orders.original_price}" />
							</label>
						</td>
						<td>
							<label class="ly_input width100" size="mini">
								<input type="number" name="wb_products_parameter_price_temp_cost_price" size="mini" placeholder="${$.lang.orders.cost_price}" />
							</label>
						</td>
						<td>
							<label class="ly_input width100" size="mini">
								<input type="number" name="wb_products_parameter_price_temp_stock" size="mini" placeholder="${$.lang.orders.stock}" />
							</label>
						</td>
						<td>
							<label class="ly_input width100" size="mini">
								<input type="type" name="wb_products_parameter_price_temp_SKU" size="mini" placeholder="SKU" />
							</label>
						</td>
					</tr>
				</thead>
				<tbody>
					${combination.map((v,k)=>{
						return this.input(k, v)
					}).join('')}
				</tbody>
			`)
			$('.wb_pro_parameter_type_table tbody tr').each(function(i){
				$(this).find('select,input,textarea').each(function(){
					let input = $(this)
					let name = input.attr('name')||''
					input.attr('name', name.replace(/^([^\[]*)\[([\d]*)\]/, '$1['+i+']'))
				})
			})
			$('.wb_pro_parameter_type_table tbody tr').each((i0, e0)=>{
				var tbody = $(e0).parent()
				var length = combination.length
				$(e0).find('[data-id]').each((i1, e1)=>{
					var cur_len = parameter[i1].children.length
					length = length/cur_len
					if (length>1) {
						$(e1).attr({'rowspan':length})
						if (i0%length) {
							$(e1).hide()
						}
					}
				});
			})
		},
	},
	// 初始化
	init(){
		this.price.data = $.json($('script.wb_products_parameter_price_data').html())
		this.parameter.data = $.json($('script.wb_products_parameter_data').html())
		this.combination.hebing(this.parameter.data)
		this.parameter.init()
		this.combination.init()
		this.show()
	},
	// 判断显示内容
	show(){
		if ($('.wb_pro_parameter_type_list .ul .li').size()==0) {
			$('.wb_pro_parameter_type_null__1').removeClass('hide')
			$('.wb_pro_parameter_type_null__2').addClass('hide')
			$('.wb_pro_parameter_type_list').addClass('hide')
			$('.wb_pro_parameter_type_table__1').addClass('hide')
		} else if ($('.wb_pro_parameter_type_table tbody tr').size()==0) {
			$('.wb_pro_parameter_type_null__1').addClass('hide')
			$('.wb_pro_parameter_type_null__2').removeClass('hide')
			$('.wb_pro_parameter_type_list').removeClass('hide')
			$('.wb_pro_parameter_type_table__1').addClass('hide')
		} else {
			$('.wb_pro_parameter_type_null__1').addClass('hide')
			$('.wb_pro_parameter_type_null__2').addClass('hide')
			$('.wb_pro_parameter_type_list').removeClass('hide')
			$('.wb_pro_parameter_type_table__1').removeClass('hide')
		}
	}
}
$(document).ready(function(){
	_dbs_parameter_.init()
})




// 添加属性
$(document).on('click', '.lydbs_add_pro_parameter', function (e) {
	// var el = $(this)
	// var dbs_item = el.parents('._dbs_item')
	WP.$.alert_side({
		remove: 1,
		data: {
			str: `
				<div class="flex-column maxh">
					<div class="maxw ly-h4 mt_45px mb_20px flex-middle2" cw="100%">
						<span>${$.lang.orders.products_add_parameter}</span>
						<i class="lyicon-close ly-h3 ml_50px return pointer"></i>
					</div>
					<div class="maxw flex-1 body p_0_20px" style="height:1px;overflow:auto;">
						<div class="_dbs_item">
							<div class="ly-h5 mb_10px">名称</div>
							<div class="ly_input">
								<input type="text" name="name" value="" placeholder="${$.lang.orders.products_parameter_name}" />
							</div>
						</div>
						<div class="_dbs_item">
							<div class="ly-h5 mb_10px">${$.lang.orders.products_parameter_type}</div>
							<div class="flex">
								<label class="zml_parameter_type flex-1 flex-max p_20px mr_10px">
									<div class="pic"><img src="" alt="" /></div>
									<div class="fz14">文字</div>
									<input class="hide" type="radio" name="type" value="text" />
								</label>
								<label class="zml_parameter_type flex-1 flex-max p_20px mr_10px">
									<div class="pic"><img src="" alt="" /></div>
									<div class="fz14">颜色</div>
									<input class="hide" type="radio" name="type" value="color" />
								</label>
								<label class="zml_parameter_type flex-1 flex-max p_20px">
									<div class="pic"><img src="" alt="" /></div>
									<div class="fz14">图文</div>
									<input class="hide" type="radio" name="type" value="picture" />
								</label>
							</div>
						</div>
					</div>
					<div class="alert_side_btn_box maxw" bg="default">
						<div cw="100%">
							<div class="ly_btn_radius width100 mr_25px submit pointer" bg="main" size="small">${$.lang.global.save}</div>
							<div class="ly_btn_radius width100 return pointer" border="default" bg="white" size="small">${$.lang.global.back}</div>
						</div>
					</div>
				</div>
			`,
		},
		css: {width:460, right:0},
		init(alert_side) {
			alert_side.on('click', '.cancel, .return', function(){
				alert_side.popup_remove()
			})
			// 添加属性
			alert_side.on('click', '.submit', function(){
				var data = {
					id: _dbs_parameter_.parameter.get_id(),
					name: alert_side.find('[name="name"]').val(),
					type: alert_side.find('[name="type"]:checked').val()||'text',
				}
				$('.wb_pro_parameter_type_list .ul').append(`
					<div class="li">
						<div class="title flex">
							<div class="a">
								${data.name}
								<input type="hidden" name="wb_products_parameter[0][name]" value="${data.name}" />
							</div>
							<div class="more  flex-middle">
								<div class="edit">修改</div>
								<div class="del">删除</div>
							</div>
							<input type="hidden" name="wb_products_parameter[0][id]" value="${data.id}" />
							<input type="hidden" name="wb_products_parameter[0][type]" value="${data.type}" />
						</div>
						<div class="value flex-wrap">
							<div class="add flex-max2"><i class="lyicon-add"></i> 新增规格</div>
						</div>
					</div>
				`)
				_dbs_parameter_.parameter.orderby()
				_dbs_parameter_.show()
				alert_side.popup_remove()
			})
		}
	})
	return false
})
// 删除属性
$(document).on('click', '.wb_pro_parameter_type_list .title .del', function (e) {
	var el = $(this)
	var li = el.parents('.li').eq(0)
	WP.$.alert({
		str: `删除属性，是否继续？`,
		cancel: 1,
		confirm(){
			li.remove()
			_dbs_parameter_.parameter.set_data()
			_dbs_parameter_.parameter.orderby()
			_dbs_parameter_.show()
		}
	});
})

// 添加规格
$(document).on('click', '.wb_pro_parameter_type_list .value .add', function (e) {
	var id = _dbs_parameter_.parameter.get_id()
	// _dbs_parameter_.parameter.addguige()
	$(this).before(`
		<div class="var ly_input">
			<div class="pic">
				<input type="hidden" name="wb_products_parameter[0][children][0][picture]" value="" />
			</div>
			<input type="text" name="wb_products_parameter[0][children][0][name]" value="" placeholder="请填写规格">
			<input type="hidden" name="wb_products_parameter[0][children][0][id]" value="${id}" />
			<div class="del lyicon-ashbin"></div>
		</div>
	`)
	_dbs_parameter_.parameter.orderby()
})

// 删除规格
$(document).on('click', '.wb_pro_parameter_type_list .value .var .del', function (e) {
	var el = $(this)
	var va = el.parents('.var').eq(0)
	if (va.find('.name input').val()) {
		WP.$.alert({
			str: `删除规格，是否继续？`,
			cancel: 1,
			confirm(){
				va.remove()
				_dbs_parameter_.parameter.set_data()
				_dbs_parameter_.parameter.orderby()
				_dbs_parameter_.show()
			}
		});
	} else {
		va.remove()
		_dbs_parameter_.parameter.set_data()
		_dbs_parameter_.parameter.orderby()
		_dbs_parameter_.show()
	}
})
// 输入属性
$(document).on('change', '.wb_pro_parameter_type_list input', function (e) {
	_dbs_parameter_.parameter.set_data()
	_dbs_parameter_.show()
})
// 批量填充
$(document).on('click', '.wb_pro_parameter_type_table_bat .btn', function (e) {
	var price = $('[name="wb_products_parameter_price_temp_price"]')
	var cost_price = $('[name="wb_products_parameter_price_temp_cost_price"]')
	var original_price = $('[name="wb_products_parameter_price_temp_original_price"]')
	var stock = $('[name="wb_products_parameter_price_temp_stock"]')
	var SKU = $('[name="wb_products_parameter_price_temp_SKU"]')
	if (price.val()) {
		var has_kong_price = 0
		var all = $('.wb_pro_parameter_type_table [name$="[price]"]')
		all.each((i, input)=>{
			if (!$(input).val()) has_kong_price = 1
		})
		all.each((i, input)=>{
			if (!$(input).val() || has_kong_price==0) $(input).val(price.val())
		})
		price.val('')
	}
	if (original_price.val()) {
		var has_kong_original_price = 0
		var all = $('.wb_pro_parameter_type_table [name$="[original_price]"]')
		all.each((i, input)=>{
			if (!$(input).val()) has_kong_original_price = 1
		})
		all.each((i, input)=>{
			if (!$(input).val() || has_kong_original_price==0) $(input).val(original_price.val())
		})
		original_price.val('')
	}
	if (cost_price.val()) {
		var has_kong_cost_price = 0
		var all = $('.wb_pro_parameter_type_table [name$="[cost_price]"]')
		all.each((i, input)=>{
			if (!$(input).val()) has_kong_cost_price = 1
		})
		all.each((i, input)=>{
			if (!$(input).val() || has_kong_cost_price==0) $(input).val(cost_price.val())
		})
		cost_price.val('')
	}
	if (stock.val()) {
		var has_kong_stock = 0
		var all = $('.wb_pro_parameter_type_table [name$="[stock]"]')
		all.each((i, input)=>{
			if (!$(input).val()) has_kong_stock = 1
		})
		all.each((i, input)=>{
			if (!$(input).val() || has_kong_stock==0) $(input).val(stock.val())
		})
		stock.val('')
	}
	if (SKU.val()) {
		var has_kong_SKU = 0
		var all = $('.wb_pro_parameter_type_table [name$="[SKU]"]')
		all.each((i, input)=>{
			if (!$(input).val()) has_kong_SKU = 1
		})
		all.each((i, input)=>{
			if (!$(input).val() || has_kong_SKU==0) $(input).val(SKU.val())
		})
		SKU.val('')
	}
})

// 切换
$(document).on('click', ".wb_pro_price_type input", function(){
	var el = $(this)
	var li = el.parents('.li:eq(0)')
	var i = el.val()
	$('.wb_products_parameter_tab__box >*').eq(i).removeClass('absolute goaway').siblings().addClass('absolute goaway')
})