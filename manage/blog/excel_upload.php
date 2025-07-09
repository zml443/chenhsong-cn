<?php


// 当前用户的权限
if (!p($_GET['ma'].'.add')) {
    echo lang('notes.no_permit');
    return;
}



?>
<!DOCTYPE HTML>
<html>
<head>
	<meta loading>
	<?php include '__/inc/style_script.php'; ?>
</head>
<style>
	html{background:var(--beijing);}
</style>
<body>
<div body>



<div class='cw850 cw30'>
	<section id='head' sticky="{}">
		<div clean>
			<h1 class='tit fl' pointer hr-ef='back()'>
				<?=img::svg('/static/images/ico/zuo.svg', 'ico v-middle');?>
				<?=\system\manage::title();?>
			</h1>
		</div>
	</section>
	<!--  -->
	<form id='excel-upload' class='excel-upload-form' clean>
		<div class='box'>
			<!-- 开始 -->
			<table class='table'>
				<tr>
					<td><?=language('{/import.excel_format/}')?></td>
					<td><a class='down' href="?ma=news/excel_upload.export" target="_blank"><?=language('{/global.download/}')?></a></td>
				</tr>
				<tr>
					<td nowrap><?=language('{/import.upload_file/}')?></h3>
					<td>
						<label class='xls fl' file-upload='default' ext='xlsx?' fn='excel_upload'>
							<?=img::svg('/static/images/ico/upload.svg', 'v-middle')?> <span v-middle><?=language('{/import.upload_file/}')?></span>
						</label>
						<input type='hidden' name='xls' value=''>
						<div class='xls-file fl hide'><span>/static/images/ico/upload.svg</span><span class='c'><?=language('{/global.cancel/}')?></span></div>
						<div class='xls-submit fl hide'><span class='file-upload-progress'></span><span hide><?=language('{/import.start/}')?></span></div>
						<input type="hidden" name="page" value="0" />
					</td>
				</tr>
				<tr>
					<td>{/import.progress/}</td>
					<td><span data-xls-progress>0%</span><span data-xls-tip></span></td>
				</tr>
				<tr>
					<td style='line-height:1.6;' v-top><?=language('{/import.explanation/}')?></td>
					<td style='line-height:1.6; color:#666;'><?=language('{/import.explanation_tips/}')?></td>
				</tr>
			</table>
			<script>
				// 提交事件
				$(document).on('submit', '.excel-upload-form', function () {
					var f = $(this);
					var page = f.find('[name="page"]');
					if (f.is('.submiting')) {
						return false;
					}
					f.addClass('submiting');
					$.async('POST', '?ma=news/excel_upload.post', f.serialize(), function (data) {
						f.removeClass('submiting');
						if (data.ret==-100 || data.ret==1) {
							f.find('[data-xls-progress]').html(data.msg.progress);
							f.find('[data-xls-tip]').html(data.msg.txt);
							if (data.ret==1) {
								page.val(0);
								WP.$.alert(data.msg.txt);
							} else {
								page.val(parseInt(page.val()||0)+1);
								setTimeout(function(){
									f.submit();
								}, 200);
							}
						} else {
							page.val(0);
							WP.$.alert(data.msg);
						}
					}, function (error) {
						f.removeClass('submiting');
					}, 'json');
					return false;
				});
				// 取消
				$(document).on('click', '.excel-upload-form .xls-file .c', function () {
					$('[name="xls"]').val('');
					$('.xls-submit, .xls-file').hide();
					$('.xls').show();
				});
				// 提交
				$(document).on('click', '.excel-upload-form .xls-submit', function () {
					$(this).parents('form').submit();
				});
				var excel_upload = {
					after: function (obj, file) {
						$('.xls-submit').show();
						for (var i in file) {
							var f = file[i];
							if (f.data) {
								if (f.data.ret==1) {
									$('.xls-submit span').hide().eq(1).show();
									$('.xls-file').show().find('span').eq(0).html(f.name);
									$('[name="xls"]').val(f.data.msg.Path);
									$('.xls').hide();
								} else {
									$('.xls-submit span').hide().eq(0).show().html('上传excel文件失败');
								}
							} else {
								$('.xls-submit span').hide().eq(0).show().html(f.progress+'%');
							}
							break;
						}
					}
				};
			</script>
			<!-- 结束 -->
		</div>
	</form>
</div>





</div>
</body>
</html>