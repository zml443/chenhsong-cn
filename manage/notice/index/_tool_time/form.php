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
		<div class="flex-middle2">
			<div color="text3">进入店铺</div>
			<label class="ly_input ml_10px mr_10px">
				<input type="text" name="<?=$name?>" value="<?=$row[$name]?:''?>">
				<div class="bg_pane">秒</div>
			</label>
			<div color="text3">后显示</div>
		</div>
		<!-- 结束 -->
	</div>
</div>

<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>