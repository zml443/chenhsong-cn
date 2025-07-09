var subnav_type = {
	li(data){
		return `
			<div class="zml_pic_url">
				<table class="maxw">
					<tr>
						<td>${$.lang.global.picture}</td>
						<td>${$.lang.global.url}</td>
						<td></td>
					</tr>
					<tr>
						<td class="w_1">
							<div class="pic flex-max2 mr_10px" file-selector='manage' fn='WP.subnav_file_selector'>
								${data.path?'<img class="maxwh1" src="'+data.path+'" alt="">':'<i class="lyicon-add-bold"></i>'}
								<input type="hidden" name="Pictures[][path]" value="${data.path||''}">
							</div>
						</td>
						<td>
							<label class="ly_input"><input type="text" name="Pictures[][url]" value="${data.url||''}"></label>
						</td>
						<td class="w_1"><a class="del flex-max2 lyicon-ashbin"></a></td>
					</tr>
				</table>
			</div>
		`
	},
	index(el){
		el.children().each(function (i) {
			var b = $(this).children().eq(0);
				b.find('span').html('组'+(i+1));
			$(this).find('[name]').each(function () {
				var n = $(this).attr('name') || '';
				if (!n) return;
				$(this).attr({name: n.replace(/^([^\[]*)\[[0-9]*\]/, '$1['+i+']')});
			});
		});
	}
}

$(document).ready(()=>{
	var el = $('.subnav_pic_data')
	var pic_data = el.find('script').json()
	var html = ''
	for (var v of pic_data) {
		html += subnav_type.li(v)
	}
	if (!html) {
		html = subnav_type.li({})
	}
	el.html(`
		<div class="list">${html}</div>
		<a class="add flex-middle2 mt_20px">
			<i class="zml_subnav_pic_data_add mr_10px flex-max2 lyicon-add-bold"></i>
			<span>${$.lang.global.add}</span>
		</a>
	`)
	var list = el.find('.list')
	subnav_type.index(list)

	// 删除
	el.on('click', '.zml_pic_url .del', function(){
		$(this).parents('.zml_pic_url').remove()
		subnav_type.index(list)
	})

	// 添加
	el.on('click', '.add', function(){
		list.append(subnav_type.li({}))
		subnav_type.index(list)
	})
})



// 切换风格
var zml_subnav_type_open = {
	init(el, checked){
		this.click(el, checked)
	},
	click(el, checked){
		var val = el.val()
		if (checked && val=='picture') {
			$('.picture_box').removeClass('hide2')
		} else {
			$('.picture_box').addClass('hide2')
		}
	}
}


// 选择文件
WP.subnav_file_selector = {
    change(el, files) {
        el.find('input').val(files[0].path);
        el.append('<img class="maxwh1" src="'+files[0].path+'" alt="">');
        el.find('i').remove();
    }
}