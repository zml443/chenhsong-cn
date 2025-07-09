<?php
// 当前用户的权限
if (!p('language.index.edit')) {
    echo language('notes.no_permit');
    return;
}
?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include '__/inc/style_script.php'; ?>
</head>


<body bg="default" class="pb_30px">

	<div class='p_30_0px mt_10px' cw="750">
		<?php $lyCssConf=[]; include c('dbs.inc').'title-edit.php'; ?>
	</div>
	
	<form class="yuyanbaopeizhi _dbs_box" cw="750">
		<div class="_dbs_item ly-h4"><?=language('{/panel.language/}')?></div>
		<div class="_dbs_item">
			<?php
				$language_name = c('language_name');
				$language_default = g('wb_language.default');
				$language_used = c('language');
				foreach ($language_name as $k => $v) {
			?>
				<div class="wcb_module_table flex-middle2">
					<div class="flex-1"><?=language('{/language.'.$k.'/}')?></div>
					<span class="mr_5px"><?=language('{/global.default/}')?></span>
					<label class="ly_switchery mr_20px">
						<input type="radio" name="default" value="<?=$k?>" <?=$language_default==$k?'checked':''?> fn="language_used">
					</label>
					<span class="mr_5px"><?=language('{/global.used/}')?></span>
					<label class="ly_switchery">
						<input type="checkbox" name="used[]" value="<?=$k?>" <?=in_array($k, $language_used)?'checked':''?> fn="language_used">
					</label>
				</div>
			<?php } ?>
		</div>
	</form>
	<script>
		var language_used = {
			click(el, checked){
				var formdata = new FormData($('.yuyanbaopeizhi')[0])
				$.async('POST', "/manage/?ma=language/index&d=post", {newFormData:formdata}, result=>{
					console.log(result)
				});
			}
		}
	</script>


</body>
</html>