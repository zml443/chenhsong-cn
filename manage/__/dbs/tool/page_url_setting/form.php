<?php
// 已被使用的变量
// $name, $value, $row, $cfg


$xxx = page_url::ext($name);

?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
	
			<div class="flex-wrap">
				<label class='ly_input width300 mr_30px'>
					<b>前缀</b>
					<textarea autoHeight notEnter name='<?=$name?>[prefix]'><?=$xxx['prefix']?></textarea>
				</label>
				<label class='ly_input width300'>
					<b>后缀</b>
					<textarea autoHeight notEnter name='<?=$name?>[suffix]'><?=$xxx['suffix']?></textarea>
				</label>
			</div>

		<!-- 结束 -->
	</div>
</div>
<!-- <script>$.include('<?=file::self_dir(__FILE__)?>/form.js');</script> -->