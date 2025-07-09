<?php
// 已被使用的变量
// $name, $value, $row, $cfg


$field_key = array();
foreach ($cfg['Field'] as $k => $v) $field_key[] = $k;
$open_name = $field_key[0];
$price_name = $field_key[1];

?>


<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<label class="ly_switchery ml_5px" size="small">
			<input type='checkbox' value='1' <?=$row[$open_name]?'checked':''?> fn="__free2_open_" />
			<input type='hidden' name='<?=$open_name?>' value='<?=$row[$open_name]?'1':'0'?>' />
		</label>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content flex-middle2'>
		<!-- 开始 -->

			<label class='ly_input'>
				<b><?=price::rate(0,1)?></b>
				<input type='number' name='<?=$price_name?>' value="<?=$row[$price_name]?>" step="0.01" />
			</label>
			<div class="ml_15px"><?=language('orders.shipping_free_tip')?></div>

		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>