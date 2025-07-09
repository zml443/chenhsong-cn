<?php
// 已被使用的变量
// $name, $value, $row, $cfg
// d($row);

?>
<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit flex-between'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div>
		<label class="ly_btn_radio pointer mr_10px">
			<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>" value="self" <?=$row[$name]?($row[$name]=='self'?'checked':''):'checked'?> fn="_tool_send_type"></i>
			<span>手动投放</span>
		</label>
		<label class="ly_btn_radio pointer mr_10px">
			<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>" value="system" <?=$row[$name]=='system'?'checked':''?> fn="_tool_send_type"></i>
			<span>自动投放</span>
		</label>
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>