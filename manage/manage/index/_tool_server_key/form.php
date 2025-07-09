<?php
// 已被使用的变量
// $name, $value, $row, $cfg

?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content clean'>
		<!-- 开始 -->
			
				<div class="flex-middle2">
					<label class='ly_switchery'>
						<input type="checkbox" value="1" <?=$row[$name.'Open']?'checked':''?> fn="manageServerKey" data-id="<?=$row['Id']?>">
						<input type='hidden' name="<?=$name?>Open" value='<?=$row[$name.'Open']?'1':'0'?>' />
					</label>
					<span class='ml_20px <?=$row[$name.'Open']?'':'hide2'?> manage-server-key-span' color="text3"><?=$row[$name]?></span>
					<span class='ml_20px hide manage-server-key-span  manage-server-key-span1'><?=$row[$name]?></span>
					<a class='ml_20px <?=$row[$name.'Open']?'':'hide2'?>' color="main" ly-text-copy="" to=".manage-server-key-span1"><?=language('{/global.copy/}')?></a>
				</div>

		<!-- 结束 -->
	</div>
</div>
<script>
	// $.include('<?=file::self_dir(__FILE__)?>form.js');
	var manageServerKey = {
		click(el, checked) {
			// el = $(el);
			let id = el.attr('data-id');
			let btn = el.parents('label').eq(0);
			$.async('POST', '/manage/?ma=manage/index/_.set_server_key', {Id:id, <?=$name?>Open:checked?1:0}, result=>{
				if (result.ret==1) {
					if (checked) {
						$('.manage-server-key-span').html(result.server_key);
						btn.siblings().removeClass('hide2');	
					} else {
						btn.siblings().addClass('hide2');
					}
				}
			}, 'json')
		}
	};
</script>