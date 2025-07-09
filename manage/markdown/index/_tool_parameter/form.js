// 选择文件
// $(document).on('change','#md_upload_tool input',function(e){
// 	let file = e.target.files[0];
// 	if (file) {
// 		$('#md_upload_tool_res').html(`<span>${$(this).val()}</span><i class="del lyicon-error ml_10px"></i>`);
// 	}
// });

var markdown_upload = {
	before(el, files){
		var bl = el.parents('._dbs_content:eq(0)');
		var lj = bl.find('.lianjie');
		lj.html(`文件上传中...`);
	},
	after(el, files){
		var bl = el.parents('._dbs_content:eq(0)');
		var wj = bl.find('.wenjian');
		var lj = bl.find('.lianjie');
		if (files[0].result.ret==1) {
			var path = files[0].result.msg.Path;
			wj.val(path);
			lj.attr({href:path}).html(path);
		} else {
			lj.attr({href:'#'}).html($.lang.notes.fail);
		}
	}
}


// 删除文件
// $(document).on('click','#md_upload_tool_res .del',function(e){
// 	$(this).parent().html('<span color="text4">未选择文件</span>');
// 	$('#md_upload_tool input').val('');
// });