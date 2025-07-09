var languageLogoEdit = (el)=>{
	el = $(el);
	var parent = el.parents('._dbs_content:eq(0)');
	var data = parent.find('.json').json();
	var inpBox = parent.find('.languageLogo');
	var aid = el.attr('data-alert-id')||$.rand('x');
	el.attr('data-alert-id', aid);
	WP.$.alert_side({
		id: aid,
		data: `
			<div class="flex-column maxh">
				<div class="maxw ly-h4 mt_45px mb_20px flex-middle2" cw="100%">
					<span>${$.lang.panel.languageLogo}</span>
					<i class="lyicon-close ly-h3 ml_50px return pointer"></i>
				</div>
				<div class="maxw flex-1 body p_20px" style="height:1px;overflow:auto;">
					<form>
						<table class="maxw">
							${$.language.all.map(v=>{
								var lo1 = data['logo_'+v]||'';
								var lo2 = data['logo-white_'+v]||'';
								return `
									<tr>
										<td class="pr_20px">${$.lang.language[v]}</div>
										<td class="pr_20px">
											<div class="mb_5px">${$.lang.panel.logo}</div>
											<label class='ly_file mr_20px ${lo1?'cur':''}' file-selector='manage' fn='WP.lyma_upload_img'>
												<img class="img" file-ext='${lo1}' />
												<i class="add"></i>
												<input type='hidden' name='languageLogo[logo_${v}]' value='${lo1}'>
											</label>
										</td>
										<td>
											<div class="mb_5px">${$.lang.panel.logo_white}</div>
											<label class='ly_file mr_20px ${lo2?'cur':''}' file-selector='manage' fn='WP.lyma_upload_img'>
												<img class="img" file-ext='${lo2}' />
												<i class="add"></i>
												<input type='hidden' name='languageLogo[logo-white_${v}]' value='${lo2}'>
											</label>
										</td>
									</tr>
								`
							}).join('<tr><td colspan="3"><div class="mt_20px mb_20px b-top"></div></td></tr>')}
						</table>
					</form>
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
		init(alert_el){
			var _this = this;
			alert_el.on('click', '.submit', function(){
				_this.end(alert_el);
				alert_el.popup_hide();
			})
			alert_el.on('click', '.return', function(){
				alert_el.popup_hide();
			})
		},
		end(alert_el){
			var logo = alert_el.find('form').serializeArray();
			var inp = '';
			for (var v of logo) {
				inp += `<input type='hidden' name='${v.name}' value='${v.value}' />`;
			}
			inpBox.html(inp);
		}
	});
	// 
}