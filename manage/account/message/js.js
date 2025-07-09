$(document).on('click', '.wcb_click_to_message', function(){
	WP.$.alert_side({
		data: `
			<div class="flex-column maxh">
				<div class="maxw ly-h4 mt_45px mb_20px flex-middle2" cw="100%">
					<span>${$.lang.member.mod_account}</span>
					<i class="lyicon-close ly-h3 ml_50px return pointer"></i>
				</div>
				<div class="maxw flex-1 body p_20px" bg="default" style="height:1px;overflow:auto;">
					<i class="lyicon-loading mt_20px" style="font-size:30px;margin-left:48%;"></i>
				</div>
			</div>
		`,
		css: {right:0, width:460},
		init(el){
			$.async('POST', '?ma=account/message/_list', {}, result=>{
				let othml = '';
				if(result.ret==1){
					othml = result.arr.map(v=>{
						return this.li(v)
					}).join('')
				}else{
					othml = '<div>无</div>'
				}
				el.find('.body').html(othml);
			}, 'json')

			el.on('click', '.return', function(){
				el.popup_remove()
			})
		},
		li(item){
			return `
				<div class="mb_20px p_20px pointer" bg="white" href="${item.Url}">
					<div class="fz16 flex-middle2 flex-between">${item.Name} <i class="lyicon-arrow-right"></i></div>
					<div class="mt_10px text-over" color="text3">${item.Message}</div>
					<div class="mt_20px" color="text3">${item.AddTime}</div>
				</div>
			`
		}
	})
})


$.async('POST', '?ma=account/message/_new_message', {}, result=>{
	if(result.ret==1){
		let othml = `
			<div class="pd_20px pb_60px">
				<div class="fz20">${result.arr.Name}</div>
				<div class="mt_10px">${result.arr.AddTime}</div>
				<div class="mt_20px lh_1_8">${result.arr.Message}</div>
			</div>`;
		$.alert({
			str: othml,
			wh:[600,0],
			style: 'B',
			close: 1,
			confirm: 1, //确认按钮
		});
	}else{
		// $.alert({
		// 	str: result.msg,
		// 	style: 'B',
		// 	confirm: 1, //确认按钮
		// });
	}
}, 'json')

