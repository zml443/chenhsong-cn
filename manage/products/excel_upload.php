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


	<div class="wrap_for_edit" data-width='900'>
		<div class='wbox_top' sticky="{}">
			<div class="ly_zindex21">
				<section id='dbs_top' class="clean">
					<h1 class='h1 fl'>
						<?=\system\manage::title();?>
					</h1>
					<!-- 二级菜单 结束 -->
				</section>
			</div>
		</div>
		<!--  -->
		<form class='wbox_body submit_batch_files'>
			<!-- 开始 -->
			<table class='ly_table_edit'>
				<tbody>
					<tr>
						<td><?=language('{/import.excel_format/}')?></td>
						<td><a class='down' href="?ma=products/excel_upload/_export" target="_blank"><?=language('{/global.download/}')?></a></td>
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
				</tbody>
			</table>
			<script>
				// 提交事件
				$(document).on('submit', '.submit_batch_files', function () {
					var f = $(this);
					var page = f.find('[name="page"]');
					if (f.is('.submiting')) {
						return false;
					}
					f.addClass('submiting');
					$.async('POST', '?ma=products/excel_upload/_upload', f.serialize(), function (data) {
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
								if (f.result.ret==1) {
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
		</form>
	</div>



</body>
</html>