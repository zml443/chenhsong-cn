
var wb_orders_address_info = {
	change(){
		$.async('POST', '', {}, result=>{
			var body = $.htmlbody(result)
			$('.gai_bian_ding_da_di_zhi').html(body.find('.gai_bian_ding_da_di_zhi').html())
		})
	}
}
$(document).on('click', '.xiu_gai_ding_da_di_zhi', function(){
	var id = $(this).attr('data-id');
	WP.$.alert_side({
		data: `
			<div class="flex-column maxh">
				<div class="maxw ly-h4 mt_45px mb_20px flex-middle2" cw="100%">
					<span>${$.lang.orders.shipping_address}</span>
					<i class="lyicon-close ly-h3 ml_50px return pointer"></i>
				</div>
				<div class="maxw flex-1 body p_0_20px" style="height:1px;overflow:auto;"></div>
				<div class="alert_side_btn_box maxw" bg="default">
					<div cw="100%">
						<div class="ly_btn_radius width100 mr_25px submit pointer" bg="main" size="small">${$.lang.global.save}</div>
						<div class="ly_btn_radius width100 return pointer" border="default" bg="white" size="small">${$.lang.global.back}</div>
					</div>
				</div>
			</div>
		`,
		css: {right:0, width:460},
		init(el){
			$.async('POST', '?ma=orders/address&e=form&Id='+id, {}, result=>{
				var body = $.htmlbody(result, true)
				el.find('.body').html(body)
			})
			el.on('click', '.submit', function(){
				var form = el.find('form')
				var formdata = new FormData(form[0])
			    $.async('POST', '?ma=orders/address&d=post', {newFormData:formdata}, result=>{
			        WP.$.alert(result.msg, 2000);
			        if (result.ret==1) {
			        	wb_orders_address_info.change()
			        	el.popup_remove()
			        }
			    }, 'json')
			})
			el.on('click', '.return', function(){
				el.popup_remove()
			})
		},
	})
})



$(document).on('click', '.orders_to_pay_status', function(){
	var id = $(this).attr('data-id')
	WP.$.alert({
		str: `
			<div class="lh_1_8">
				<div class="fz14">${$.lang.orders.pay_or_not}</div>
				<div color="text3">${$.lang.orders.pay_ps}</div>
			</div>
		`,
		cancel: 1,
		confirm(el){
			$.async('POST', '?ma=orders/index/_pay_status&', {Id:id}, result=>{
				WP.$.alert(result.msg, 2000)
				el.popup_remove()
			}, 'json')
			return false
		}
	})
})