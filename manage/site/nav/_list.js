
// 添加
var add_nav = {
	popup(opt){
		WP.$.alert_side({
			data: `
				<div class="flex-column maxh">
					<div class="maxw ly-h4 mt_45px mb_20px flex-middle2" cw="100%">
						<span>${$.lang.menu.web.nav.module_name}</span>
						<i class="lyicon-close ly-h3 ml_50px return pointer"></i>
					</div>
					<div class="maxw flex-1 body p_0_20px" style="height:1px;overflow:auto;">
						<div class="flex-max2 mt_60px"><i class="lyicon-loading"></i></div>
					</div>
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
				$.async('POST', opt.url, {}, result=>{
					var body = $.htmlbody(result, true)
					el.find('.body').html(body);
					el.find('._dbs_content_language .absolute.goaway').addClass('mt_10px').removeClass('absolute goaway');
				})
				el.on('click', '.submit', function(){
					var form = el.find('form')
					var formdata = new FormData(form[0])
				    $.async('POST', '?ma=site/nav&d=post', {newFormData:formdata}, result=>{
				        WP.$.alert(result.msg, 2000);
				        if (result.ret==1) {
				        	el.popup_remove()
				        	location.reload()
				        }
				        if (typeof(opt.callback)=='function') {
				        	opt.callback(result)
				        }
				    }, 'json')
				})
				el.on('click', '.return', function(){
					el.popup_remove()
				})
			},
		});
	}
};

// 添加
$(document).on('click', '.tian_jia_cai_dan', function(){
	var uid = $(this).attr('data-uid');
	add_nav.popup({
		url: '?ma=site/nav&e=form&UId='+uid
	});
});
// 修改
$(document).on('click', '.zml_nav .mod', function(){
	var id = $(this).attr('data-id')
	add_nav.popup({
		url: '?ma=site/nav&e=form&Id='+id
	})
});


// 删除
$(document).on('click', '.zml_nav .del', function(){
	var el = $(this)
	var id = el.attr('data-id');
	WP.$.alert({
		str: $.lang.notes.del_tip.replace('{{qty}}', 1),
		style: 'B',
		cancel: 1,
		confirm: function () {
			var lo = WP.$.alert('loading...');
		    $.async('POST', '?ma=site/nav&d=del', {Id:id}, result=>{
				lo.popup_remove();
		        // el.parents('.li:eq(0)').remove()
		        location.reload()
		    }, 'json')
		}
	});
})
