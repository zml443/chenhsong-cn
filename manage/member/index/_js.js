

$(document).on('click', '.xiu_gai_huiyuan', function(){
	var id = $(this).attr('data-id');
	WP.$.alert_side({
		data: `
			<div class="flex-column maxh">
				<div class="maxw ly-h4 mt_45px mb_20px flex-middle2" cw="100%">
					<span>${$.lang.member.mod_account}</span>
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
			$.async('POST', '?ma=member/index&e=form&Id='+id, {}, result=>{
				var body = $.htmlbody(result, true)
				el.find('.body').html(body)
			})
			el.on('click', '.submit', function(){
				var form = el.find('form')
				var formdata = new FormData(form[0])
			    $.async('POST', '?ma=member/index&d=post', {newFormData:formdata}, result=>{
			        WP.$.alert(result.msg, 2000);
			        if (result.ret==1) {
			        	$.flush('info');
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
