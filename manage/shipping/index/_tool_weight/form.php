<?php
// 已被使用的变量
// $name, $value, $row, $cfg

$field_key = array();
foreach ($cfg['Field'] as $k => $v) $field_key[] = $k;
$first_price_name = $field_key[0];
$first_weight_name = $field_key[1];
$ext_price_name = $field_key[2];
$ext_weight_name = $field_key[3];

?>


<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<div class="flex-middle2 mb_10px">
				<span class=""><?=language('orders.shipping_first_price')?>：</span>
				<span class='ly_input'>
					<b><?=price::rate(0,1)?></b>
					<input type='number' name='<?=$first_price_name?>' value="<?=$row[$first_price_name]?>" step='0.01' />
				</span>
			</div>
			<!-- end -->
			<div class="flex-middle2 mb_10px">
				<div class=""><?=language('orders.shipping_first_weight')?>：</div>
				<label class='ly_input'>
					<b>Kg</b>
					<input type='number' name='<?=$first_weight_name?>' value="<?=$row[$first_weight_name]?>" step='0.001' />
				</label>
			</div>
			<!-- end -->
			<div class="flex-middle2">
				<span class=""><?=language('orders.shipping_ext_weight')?>：</span>
				<label class='ly_input'>
					<b>Kg</b>
					<input type='number' name='<?=$ext_weight_name?>' value="<?=$row[$ext_weight_name]?>" step='0.001' />
				</label>
				<span class="">　/　</span>
				<label class='ly_input'>
					<b><?=price::rate(0,1)?></b>
					<input type='number' name='<?=$ext_price_name?>' value="<?=$row[$ext_price_name]?>" step='0.01' />
				</label>
			</div>

		<!-- 结束 -->
	</div>
</div>