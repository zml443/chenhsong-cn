<?php
// 已被使用的变量
// $name, $value, $row, $cfg

$json_arr = array();
foreach ($cfg['Args'] as $k => $v) {
	$json_arr[] = array(
		'label' => $v,
		'value' => $k,
	);
}


?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<?php 
			if ($cfg['EditShow']) { 
				$arr = explode(',', $row[$name]);
				foreach ($arr as $k => $v) {
					echo $cfg['Args'][$v].", ";
				}
			} else { 
			?>
				<?php if ($cfg['Add']) { ?>
					<label class="ly_select_checkbox" ly-drop-select="" data-type="checkbox">
						<div class=""><input type="text" placeholder="<?=language('{/global.select_index/}')?>" /></div>
						<input type="hidden" name='<?=$name?>' value="<?=$value?>" />
						<i class="lyicon-arrow-down-bold"></i>
						<script type="text"><?=str::json($json_arr)?></script>
					</label>
				<?php } else { ?>
					<label class="ly_input_suffix" ly-drop-select="">
						<input type="text" placeholder="<?=language('{/global.select_index/}')?>" />
						<input type="hidden" name='<?=$name?>' value="<?=$value?>" />
						<i class="lyicon-arrow-down-bold"></i>
						<script type="text"><?=str::json($json_arr)?></script>
					</label>
				<?php } ?>
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>