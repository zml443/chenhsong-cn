<?php
// 已被使用的变量
// $name, $value, $row, $cfg

?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<?php if ($cfg['Lang']) { ?><span class='langselbox'></span><?php } ?>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
			
			<?php if ($cfg['EditShow']) { ?>
				<div style="font-size:20px">
					<div star-off-on='<?=$row[$name]?>'></div>
				</div>
			<?php } else { ?>
				<div style="font-size:20px">
					<div star-off-on=''><input type="hidden" name="<?=$name?>" value="<?=$this->is_mod?$value:10?>"></div>
				</div>
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>