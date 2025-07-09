<?php
// 已被使用的变量
// $name, $value, $row, $cfg

$field_key = array();
foreach ($cfg['Field'] as $k => $v) $field_key[] = $k;
$eftime0 = $field_key[0];
$eftime1 = $field_key[1];

?>
<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
			<?php
				if ($cfg['EditShow']) {
					echo $row[$eftime0] ? (date('Y-m-d',$row[$eftime0]).' ~ '.date('Y-m-d',$row[$eftime1])) : 'N/A';
				} else { 
			?>
				<span class='ly_input w360'>
					<input type='text' name='<?=$name?>' value='<?=(date('Y-m-d',$row[$eftime0]?:c('time')).' ~ '.date('Y-m-d',$row[$eftime1]?:c('time')))?>' ly-laydate='date' range="~" fn="__deadline_" />
				</span>
				<input type="hidden" class="eftime0" name="<?=$eftime0?>" value="<?=$row[$eftime0]?>" />
				<input type="hidden" class="eftime1" name="<?=$eftime1?>" value="<?=$row[$eftime1]?>" />
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>/form.js');</script>