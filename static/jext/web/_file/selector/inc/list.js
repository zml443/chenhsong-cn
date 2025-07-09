var returnResult = [];
// 本地文件库
// =================================================================================
var bendi = {
	// 隐藏标题,因为当天没有上传文件的时候时间标题反而有点碍眼
	set: function () {
		if ($('.wenjianjiahezi >*').size()) {
			$('.wenjbiaoti').removeClass('hide2');
		} else {
			$('.wenjbiaoti').addClass('hide2');
		}
		returnResult = [];
	},
	_search_k: 'Ext,Name', //搜索的字段
	_html(h){
		this.files = [];
		$('.wcb_alert_box').html($($.htmlbody(h)).find('.wcb_alert_box').html());
		this.set();
	},
	uid(el){
		var qs = $.query_string(this._search_k+',UId');
		qs['UId'] = $(el).attr('data-uid');
		$.async('GET', '?', qs, result=>{
			this._html(result);
		});
	},
	form(el){
		$.async('GET', '?', $(el).serializeArray(), result=>{
			this._html(result);
		});
		return false;
	},
	lis(){}, //插入文件
	filesChange:'', // files的拦截器
	upload(){}, //上传函数
	isImage:0, // 1：files有图片文件，0：files没有图片文件
	isVideo:0,
};


// 插入新文件
bendi.lis = (da)=>{
	return `
		<label class="wcb_fileitem file cur" fn="paixu">
			<input type="checkbox" name="Id[]" class="hide" value="${da.Id}" checked />
			<div class="img notcopy choice">
				<div class="absolute max m-pic"><img file-ext="${da.Path}" big-img="${da.Path}" /></div>
				<div class="tool" stopPropagation>
					<a class="lyicon-ashbin wj_delete" title="${$.lang.global.del}"></a>
					<a href="${da.Path}" class="lyicon-browse" title="${$.lang.global.view}" target="_blank"></a>
				</div>
				<div class="bianji" stopPropagation>
					<a class="lyicon-link" title="${$.lang.global.copy}" ly-text-copy="${da.Path}"></a>
				</div>
				<div class="move lyicon-export" title="${$.lang.form.move_file_to}" stopPropagation></div>
				<div class="is_check lyicon-select-bold" color="main"></div>
			</div>
			<div class="filename" stopPropagation data-id="${da.Id}">${da.Name}</div>
		</label>
	`;
};


// 绑定分段上传
bendi.upload = {
	before(){
		this.ul = $('.bd_jd_tishi');
		this.ul.show();
	},
	after(el, files){
		var ul = this.ul;
		var ei=0, ej=0;
		for (var i in files) {
			ei++;
			var v = files[i];
			var li = ul.find('[file="' + i + '"]');
			if (li.size()) {
				if (v.data && v.data.ret == 0) {
					li.find('.jd span').html($.lang.global.fail);
				} else {
					li.find('.jd span').html(v.progress + ' %');
				}
				li.find('.jd div').css({width: v.progress + '%'});
			} else {
				ul.find('ul').append(
					'<li file="' + i + '" class="file relative fl over">' +
						'<div class="absolute max m-pic">' +
							'<img file-ext="' + v.src + '" alt="" />' +
						'</div>' +
						'<div class="jd absolute max">' +
							'<div class="absolute max trans" style="width:' + v.progress + '%;"></div>' +
							'<span class="relative">' + v.progress + ' %</span>' +
						'</div>' +
					'</li>'
				);
			}
			if (parseFloat(v.progress)>=100 && v.data && v.data.ret==1) {
				ej++;
				$('.HostStorageSizeN').html(v.data.jext_files_size+' / '+v.data.HostStorageSize);
				$('.HostStorageSizeP>div').css({width:v.data.storage_percentage});
			}
		}
	},
	// 上传完毕
	end(el, files){
		var $this = this;
		var htmlfn = (da)=>{
			$('.bendi_file_span_box').prepend(bendi.lis(da));
			bendi.set();
			bendi.filesChange({id:da.Id, path:da.Path});
			$('.quanbuwenj').animate({scrollTop:$('.quanbuwenj').offset().top-$('.bendi_file_span_box').offset().top-200}, 300);
		};
		var compress = (files,i=0) =>{
			var v = files[i];
			if(!v) {
				setTimeout(()=>{$this.ul.fadeOut().find('.mask').remove()}, 500);
				return
			}
			i++;
			if (v.data.ret==1) {
				var da = v.data.msg;
				// 图片文件
				if(da.Path.match(/.*\.(jpe?g|png)$/g)){
					// 遮罩
					if(!$('.bd_jd_tishi').find('.mask').size()) $this.ul.append('<div class="mask flex-max maxw maxh" style="background:rgba(0,0,0,.3);position:absolute;left:0;top:0;"><i class="lyicon-loading" style="color:#fff;font-size:40px;"></i><div style="font-size:18px;color:#fff;margin-top:10px;">有图片正在压缩中...</div></div>');
					$.async('GET', $.path+'web/file/selector/inc/compress.php', {id:da.Id}, res=>{
						// bendi.createFilesItem(da);
						htmlfn(da);
						compress(files,i);
					},'json');
				}else{
					// bendi.createFilesItem(da);
					htmlfn(da);
					compress(files,i);
				}
			}
		}
		compress(files);
		/*for (var i in files) {
			var v = files[i];
			if (v.data.ret==1) {
				var da = v.data.msg;
				$('.bendi_file_span_box').prepend(bendi.lis(da));
				bendi.set();
				bendi.filesChange({id:da.Id, path:da.Path});
				$('.quanbuwenj').animate({scrollTop:$('.quanbuwenj').offset().top-$('.bendi_file_span_box').offset().top-200}, 300);
			}
		}
		setTimeout(()=>{this.ul.fadeOut()}, 500);*/
	}
};

// 用于压缩图片
/*bendi.compress = (files,i=0) =>{
	var v = files[i];
	if(!v) {
		setTimeout(()=>{$('.bd_jd_tishi').fadeOut().find('.mask').remove()}, 500);
		return
	}
	i++;
	if (v.data.ret==1) {
		var da = v.data.msg;
		// 图片文件
		if(da.Path.match(/.*\.(jpe?g|png)$/g)){
			// 遮罩
			if(!$('.bd_jd_tishi').find('.mask').size()) $('.bd_jd_tishi .box').append('<div class="mask flex-max maxw maxh" style="background:rgba(0,0,0,.3);position:absolute;left:0;top:0;"><i class="lyicon-loading" style="color:#fff;font-size:40px;"></i><div style="font-size:18px;color:#fff;margin-top:10px;">有图片正在压缩中...</div></div>');
			$.async('GET', $.path+'web/file/selector/inc/compress.php', {id:da.Id}, res=>{
				bendi.createFilesItem(da);
				bendi.compress(files,i);
			},'json');
		}else{
			bendi.createFilesItem(da);
			bendi.compress(files,i);
		}
	}
}*/


// bendi.files 数据拦截
// ==============================================================================
// 通过id删除文件
bendi.filesDeleteId = (ids)=>{
	for (var i=0; i<returnResult.length;i++) if (ids.indexOf(returnResult[i].id)>=0) {
		returnResult.splice(i,1);
		i--;
	}
	bendi.filesChange();
};
// 更换添加文件
bendi.filesChange = (data, x, y)=>{
	if (y) {
		returnResult.splice(x[0], 1);
	} 
	if (data) if (x) {
		returnResult.splice(x[0], 0, data);
	} else {
		returnResult.push(data);
	}
	// 之前的id
	var $id = [];
	$('.wcb_fileitem.file.cur input').each(function(){
		$id.push(parseInt($(this).val()));
	});
	// 是图片
	bendi.isImage = 0;
	returnResult.forEach(v => {
		var ind = $id.indexOf(parseInt(v.id));
		if (ind>=0) $id.splice(ind, 1);
		if((v.path).search(/\.(png|jpe?g)$/i) > -1){
			bendi.isImage = 1;
		}
		var p = $('.wcb_fileitem.file [data-uid="'+v.uid+'"]')
		if (v.uid && p.size()) {
			p.parents('.wcb_fileitem:eq(0)').addClass('child_select');
		}
	});
	for (var v of $id) {
		$('.wcb_fileitem [value="'+v+'"]').removeAttr('checked').parents('.wcb_fileitem:eq(0)').removeClass('cur');
	}
	/*if (xxxx) {
		// 
	}*/
	// 显示按钮
	bendi.btnShow();
	// 改变勾选的数目
	$('.wcb_alert_btn .number span').html(returnResult.length);
};
// ==============================================================================



// wcb_fileitem.file 勾选回调
bendi.choice = {
	click(el, checked){
		var val = el.val();
		var path = el.attr('data-file');
		var uid = el.attr('data-uid');
		if(checked) {
			bendi.filesChange({id:val,path:path,UId:uid});
		} else {
			bendi.filesDeleteId([val]);
		}
	}
};



// 删除文件
bendi.delete = function(opt){
	var event = opt.event;
	var id = opt.id;
	var url = $('.xxxxxxxxxxxx').json();
	var ids = id.split(',');
	if(id){
		var num = ids.length;
	}else{
		var num = 0;
	}
	if(!num) return
	WP.$.alert({
		str: $.lang.notes.del_tip.replace('{{qty}}', num),
        xy: $.xy(event, function (x, y){return [x - 200, y > 120 ? y - 120 : y + 30]}),
        style: 'B',
        zIndex:1005,
        cancel: 1,
		confirm: function () {
			var l = WP.$.alert('loading');
			$.async('POST', $.path + 'web/file/selector/inc/do.it.php', {Id:id, do:'del', GroupId:url.GroupId, ExtId2:url.ExtId2}, function(result){
				l.popup_remove(function(){
					if (result.ret==1) {
						if(opt.end) opt.end();
						$('.HostStorageSizeN').html(result.jext_files_size+' / '+result.HostStorageSize);
						$('.HostStorageSizeP>div').css({width:result.storage_percentage});
					} else {
						WP.$.alert($.lang.file.del_error, 3000);
					}
					bendi.set();
					// 删除选中的文件
					bendi.filesDeleteId(ids);
				});
			}, 'json');
		}
	});
}



// 删除
$(document).on('click', '.wj_delete', function (event) {
	var id = [];
	var parent = $(this).parents('.wcb_fileitem');
	if (parent.is('.cur')) {
		var delEl = $('.wcb_fileitem.cur');
		delEl.each(function (){
			id.push($(this).find('[name="Id[]"]').val());
		});
	}else{
		var delEl = parent;
		id.push(parent.find('[name="Id[]"]').val());
	}
	bendi.delete({
		event: event,
		id: id.join(','),
		end(){
			delEl.remove();
		}
	});
});
// 转移文件到
$(document).on('click', '.wcb_fileitem .move', function (e) {
	var url = $('.xxxxxxxxxxxx').json()
	var p = $(this).parents('.wcb_fileitem');
	var i = p.find('[name="Id[]"]').val();
	var s = 0;
	var ids = [];
	if (p.is('.cur')) {
		i = '';
		$('.wcb_fileitem.cur').each(function (){
			s++;
			var val = $(this).find('[name="Id[]"]').val();
			i += val + ',';
			ids.push(val);
		});
	}
	WP.$.alert({
		str:
			(s ? $.lang.notes.move_file_bat.replace(/{{qty}}/, s) : $.lang.form.move_file_to) +
			`<div select-dir style="height:30px;margin:30px 0 20px;"></div>`
		,
        xy: $.xy(e, function (x, y){return [x - 200, y > 120 ? y - 120 : y + 30]}),
        init: function (alert_el) {
        	$.async('POST', $.path + 'web/file/selector/inc/do.it.php', {do:'move_html', GroupId:url.GroupId}, result=>{
        		alert_el.find('[select-dir]').html(`
					<label class="ly_input_suffix" ly-drop-select="" data-type="radio" data-split-value="|">
						<input type="text" placeholder="${$.lang.form.root}" />
						<input type="hidden" name="UId" value="0," />
						<script type="text">${$.json(result)}</script>
						<i class="lyicon-arrow-down-bold"></i>
					</label>
        		`);
        	},'json');
		},
        zIndex:1005,
		cancel: 1,
		confirm: function (alert_el) {
			var l = WP.$.alert('loading');
			var UId = alert_el.find('[name="UId"]').val();
			if (!UId) {
				return false
			}
			$.async('POST', $.path + 'web/file/selector/inc/do.it.php', {Id:i, do:'move', UId:UId, GroupId:url.GroupId}, function(result){
				l.popup_remove(function(){
					if (result.ret == 1 && url.UId != UId) {
						p.remove();
						$('.wcb_fileitem.cur').remove();
					} else {
						WP.$.alert($.lang.file.move_error, 3000);
					}
					alert_el.popup_remove();
					bendi.set();
					// 删除选中的文件
					bendi.filesDeleteId(ids);
				});
			}, 'json');
			return 0;
		}
	});
});
// 添加文件夹
$(document).on('click', '.addnewdir', function (event) {
	var url = $('.xxxxxxxxxxxx').json()
	WP.$.alert({
		title: $.lang.form.new_dir,
		str:
			'<form>' +
				'<table class="maxw" style="margin-top:20px;">' +
					'<tr>' +
						'<td width=1 class="nowrap">' + $.lang.form.dir + '</td>' +
						'<td height=36 style="padding:0 3px 0 15px;">' +
							'<div class="relative maxh">' +
								'<input class="absolute max maxw" name="Name" style="border:1px solid #ddd; border-radius:3px; text-indent:9px; height:34px;">' +
								'<input class="hide" type="submit">' +
								'<input type="hidden" name="UId" value="' + url.UId + '">' +
								'<input type="hidden" name="GroupId" value="' + url.GroupId + '">' +
								'<input type="hidden" name="ExtId2" value="' + url.ExtId2 + '">' +
								'<input type="hidden" name="type" value="' + url.GroupId + '">' +
								'<input type="hidden" name="do" value="add">' +
							'</div>' +
						'</td>' +
					'</tr>' +
				'</table>' +
			'</form>'
		,
		xy: $.xy(event, function (x, y) {return [x - 60, y + 20]}),
		wh: [460, 0],
        zIndex:1005,
		init: function (alert_el) {
			alert_el.find('form').submit(function () {
			    $.async('POST', WP.$.path+'web/file/selector/inc/do.it.php', $(this).serializeArray(), function (result) {
					if (result.ret == 1) {
						alert_el.popup_remove();
						var v = result.msg;
						$('.wenjianjiahezi').append(`
							<div class="wcb_fileitem dir">
								<input type="checkbox" name="Id[]" class="hide" value="${v.Id}" />
								<div class="img notcopy">
									<div class="wenjianjia absolute max m-pic" onclick="bendi.uid(this)" data-uid="${v.UId}">
										<img file-ext />
									</div>
									<div class="tool" stopPropagation>
										<a class="wj_delete lyicon-ashbin"></a>
									</div>
								</div>
								<div class="filename" stopPropagation data-id="${v.Id}">${v.Name}</div>
							</div>
						`);
						$('.quanbuwenj').animate({scrollTop:$('.quanbuwenj').offset().top-$('.wenjianjiahezi .dir:last').offset().top-120}, 300);
						bendi.set();
					 } else {
						WP.$.alert(result.msg, 2500);
					}
			    }, 'json');
			    return false;
			});
		},
		cancel: 1,
		confirm: function (alert_el) {
			alert_el.find('form').submit();
			return false;
		}
	});
});




// 修改名称
// =================================================================================
!function () {
	function selectText(obj) {
        if (document.selection) {
            var range = document.body.createTextRange();
            range.moveToElementText(obj[0]);
            range.select();
        } else if (window.getSelection) {
            var range = document.createRange();
            range.selectNodeContents(obj[0]);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
        }
    }
	$(document).on('dblclick', '.filename', function (event) {
		$(this).attr('contenteditable', true).focus();
		selectText($(this));
	});
	$(document).on('blur', '.filename', function (event) {
		var url = $('.xxxxxxxxxxxx').json()
		var id = $(this).attr('data-id');
		var name = $(this).text();
		$(this).removeAttr('contenteditable');
		$.async('POST', $.path+"web/file/selector/inc/do.it.php", {id:id, name:name, GroupId:url.GroupId, ExtId2:url.ExtId2, do:'mod_name'}, function (data) {
			if (data.ret==1) {
				// 
			} else {
				WP.$.alert(data.msg, 1500);
			}
		}, 'json');
	});
}();
// =================================================================================










// 裁剪
// =================================================================================
bendi.image_cropper_cb = {
	confirm(){
		$('.wcb_alert_btn .submit').trigger('click');
	}
}

// 控制底部按钮的显示隐藏
bendi.btnShow = function(){
	var len = $('.ly_cropper > *').length;
	var cur = $('.ly_cropper > .cur');
	var first = $('.ly_cropper > *').first();
	var last = $('.ly_cropper > *').last();
	var prev = $('.wcb_alert_btn .prev');
	var next = $('.wcb_alert_btn .next');
	var submit = $('.wcb_alert_btn .submit');
	var cancel = $('.wcb_alert_btn .cancel');
	var cropper = $('.wcb_alert_btn .tocrop');
	var confirm = $('.wcb_alert_btn .at-confirm');
	// 有选中图片时
	if(bendi.isImage){
		if (!first.is('.cur') && len>1) prev.removeClass('hide2'); else prev.addClass('hide2');
		if (!last.is('.cur') && len>1) next.removeClass('hide2'); else next.addClass('hide2');
		if (len) cropper.addClass('hide2'); else cropper.removeClass('hide2');
		if (len) confirm.addClass('hide2'); else confirm.removeClass('hide2');
		if (len) submit.removeClass('hide2'); else submit.addClass('hide2');
		if (cur.is('.success')) submit.addClass('success'); else submit.removeClass('success');
		if (len) cancel.removeClass('hide2'); else cancel.addClass('hide2');
	}else{
		cancel.addClass('hide2');
		cropper.addClass('hide2');
	}
};

// 用于裁剪图片的上下张操作，此函数需在 btnShow 之前调用，
bendi.cropMove = function(type){
	var el = $('.ly_cropper > *.cur');
	var len = $('.ly_cropper > *').length;
	var first = $('.ly_cropper > *').first();
	var last = $('.ly_cropper > *').last();
	// 上下步操作
	if(len > 1){
		if(type=='prev' && !first.is('.cur')){
			el.removeClass('cur').prev().addClass('cur').removeClass('prev');
		}else if(type=='next' && !last.is('.cur')){
			el.removeClass('cur').next().addClass('cur').prevAll().addClass('prev');
		} else {
			if (_NotChoice_) {
				$(".wcb_alert_cropper").removeClass('cur');
				$(".wcb_alert_cropper .ly_cropper").html('');
			} else {
				$('.at-confirm').trigger('click');
			}
		}
	} else {
		if (_NotChoice_) {
			$(".wcb_alert_cropper").removeClass('cur');
			$(".wcb_alert_cropper .ly_cropper").html('');
		} else {
			$('.at-confirm').trigger('click');
		}
	}
};

// 去裁剪
$(document).on('click', '.wcb_alert_btn .tocrop', function () {
	if(bendi.isImage){
		var url = $('.xxxxxxxxxxxx').json();
		var html = ``;
		// 遍历选中文件，是图片,并且有UId的则生成 <div ly-image-cropper></div> 结构
		var first = 0;
		returnResult.forEach((v,i) => {
			if((v.path).search(/\.(png|jpe?g)$/i) > -1 && !v.IsCut){
				html += `
					<div class="${first?'':'cur'}" 
						ly-image-cropper 
						data-index="${i}" 
						data-file="${v.path}" 
						data-size="${url.size}" 
						fn="bendi.image_cropper_cb"
					>
						<div class="maxw maxh flex-max2"><i class="fz40 lyicon-loading"></i></div>
					</div>`;
				if (!first) first = 1;
			}
		});
		$(".ly_cropper").html(html);
		$(".wcb_alert_cropper").addClass('cur');
		bendi.btnShow();
	}
});
// 上传裁剪图片
$(document).on('click', '.wcb_alert_btn .submit', function () {
	var el = $(this);
	if (el.is('.success')) {
		bendi.cropMove('next');
		bendi.btnShow();
		return true;
	}
	var url = $('.xxxxxxxxxxxx').json();
	var curEl = $('.ly_cropper > .cur');
	// var html = el.text();
	var res = curEl.o().get();
	res.file.index = parseInt(curEl.attr('data-index'));
	var form = {
		ExtId: url.ExtId,
		GroupId: url.GroupId,
		UId: url.UId,
		IsCut: 1,
	};
	$.alert({
		str: `
			<div class="zml_cropper_popup flex">
				<div class="img m-pic"><img class="i" src="${res.base64}" alt="" /></div>
				<div class="">
					<div class="dir"><i class="lyicon-loading"></i></div>
					<div class="size" color="text3">${$.lang.panel.file.image_size.replace('{wh}', res.width+' × '+res.height)}</div>
					<div class="save ly_btn_radius pointer2" bg="main"><span class="l lyicon-loading hide2 mr_5px"></span>${$.lang.panel.cropper.save}</div>
				</div>
			</div>
		`,
		init(alert_el){
        	$.async('POST', $.path + 'web/file/selector/inc/do.it.php', {do:'move_html', GroupId:url.GroupId}, result=>{
        		alert_el.find('.dir').html(`
        			<div class="flex-middle2">
	        			<div class="mr_10px">${$.lang.panel.file.dir}</div>
						<label class="ly_input_suffix flex-1" ly-drop-select="" data-type="radio" data-split-value="|">
							<input type="text" placeholder="${$.lang.form.root}" />
							<input class="a" type="hidden" name="UId" value="${url.UId}" />
							<script type="text">${$.json(result)}</script>
							<i class="lyicon-arrow-down-bold"></i>
						</label>
					</div>
        		`);
        	},'json');
        	alert_el.on('change', '.dir label', function(){
        		form.UId = $(this).find('.a').val();
        	});
			alert_el.on('click', '.save', function(){
				$(this).find('.l').removeClass('hide2');
				$.upload({
					files: [res.file],
					url: $.path + 'web/file/upload/inc/save.php',
					type: 'manage', //类型
					form: form,
					// 上传完成后调用
					end(opt){
						curEl.addClass('success');
						// $(".wcb_alert_cropper").removeClass('cur');
						// $(".wcb_alert_cropper .ly_cropper").html('');
						// bendi.btnShow();
						// @！ 上传成功应刷新 预览区
						opt.files.forEach(v => {
							if(v.result.ret == 1){
								if (form.UId==url.UId) $('.bendi_file_span_box').prepend(bendi.lis(v.result.msg));
								returnResult[v.index].id = v.result.msg.Id;
								returnResult[v.index].path = v.result.msg.Path;
								returnResult[v.index].IsCut = 1;
							}
						});
						bendi.filesChange();
						alert_el.popup_remove();
						bendi.cropMove('next');
						bendi.btnShow();
					},
				});
			});
			// 点击保存结束
		},
	});
});
// 上一步
$(document).on('click', '.wcb_alert_btn .prev', function () {
	bendi.cropMove('prev');
	bendi.btnShow();
});
// 下一步
$(document).on('click', '.wcb_alert_btn .next,.wcb_alert_btn .cancel', function () {
	bendi.cropMove('next');
	bendi.btnShow();
});
// =================================================================================