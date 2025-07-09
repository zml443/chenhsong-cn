<?php
function_exists('c') || exit();


?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body bg="default">

	<div class="p_30_0px ly-h3 flex-middle2" cw="1400">
		<i class="ly-h3 mr_5px lyicon-arrow-left-bold" hr-ef='back()'></i>
		<span hr-ef='back()'><?=language('global.back')?></span>
	</div>

	<form class="ly_table_box" bg="white" cw="1400">
		<table class="ly_table_line maxw">
			<tr>
				<?php
					$type = array('01','02','03','04','05','06');
					$type_id = g('wb_service.type');
					foreach ($type as $k => $v) {
				?>
					<td>
						<div class="flex-max">
							<label class="ly_btn_radio pointer" size="small">
								<i class="mr_5px"></i>
								<span><?=language('global.select')?></span>
								<input type="checkbox" data-number="1" value="<?=$v?>" name="type" <?=$type_id==$v?'checked':''?> fn="change_service_type" />
							</label>
						</div>
					</td>
				<?php } ?>
			</tr>
			<tr>
				<?php foreach ($type as $k => $v) { ?>
					<td>
						<div class="flex-center">
							<iframe src="?ma=service/index/iframe&number=<?=$v?>" frameborder="0" width="100" height="660"></iframe>
						</div>
					</td>
				<?php } ?>
			</tr>
		</table>
	</form>

	<script>
		var change_service_type = {
			click(){
				var formdata = new FormData($('form')[0])
				$.async('POST', '?ma=service/index/_change_type', {newFormData: formdata}, result=>{
					// 
				}, 'json')
			}
		}
	</script>
	
</body>
</html>