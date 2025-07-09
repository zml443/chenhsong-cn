<?php
// 已被使用的变量
// $name, $value, $row, $cfg


?>
<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<label class='ly_file <?=$value?'cur':''?>' file-selector='manage' fn='WP.dbs_upload_img'>
				<img class="img" file-ext='<?=$value?>' />
				<i class="add"></i>
				<i class="close flex-max lyicon-close"></i>
				<input type='hidden' name='<?=$name?>' value='<?=$value?>'>
			</label>

		<!-- 结束 -->
	</div>
</div>

<script>$.include('<?=file::self_dir(__FILE__)?>/form.js');</script>