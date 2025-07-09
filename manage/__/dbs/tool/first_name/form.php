<?php
// 已被使用的变量
// $name, $value, $row, $cfg

// d($name, $value, $row, $cfg);

?>



<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<?php if ($cfg['EditShow']) { ?>
				<?=l($row['LastName'].' '.$row['FirstName'], $row['FirstName'].' '.$row['LastName'])?>
			<?php } else { ?>
				<div class="flex">
					<div class='ly_input width250'>
						<b><?=language('{/form.firstname/}')?></b>
						<input type='text' name='FirstName' value="<?=$row['FirstName']?>" />
					</div>
					<div class='ly_input width250 ml_10px'>
						<b><?=language('{/form.lastname/}')?></b>
						<input type='text' name='LastName' value="<?=$row['LastName']?>" />
					</div>
				</div>
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>