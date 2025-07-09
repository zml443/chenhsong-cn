<?php
// 已被使用的变量
// $name, $value, $row, $cfg


?>

<?php if (manage('Id')==$row['Id'] || $row['IsLock']) { ?>


<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
			<?=language('{/member.permit_'.(int)$row['Level'].'/}')?>
		<!-- 结束 -->
	</div>
</div>

<?php } else { ?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content flex-middle2'>
		<!-- 开始 -->

			<select class='ly_input width200' name='Level' dbsPermit>
				<?php if (manage('Level')==1) { ?>
					<option value='1' <?=$row['Level']==1?'selected':''?>><?=language('{/member.permit_1/}')?></option>
				<?php } ?>
				<option value='2' <?=$row['Level']==2?'selected':''?>><?=language('{/member.permit_2/}')?></option>
			</select>
			<div class='ly_btn pointer min-width90 hide2 ml_25px' bg="main" dbsPermitBtn data-name='<?=$name?>'>
				<?=language('{/member.permit/}')?>
				<span class="hide" data-input><?=str::ary_input(str::json(htmlspecialchars_decode($value), 'decode'), $name);?></span>
			</div>

		<!-- 结束 -->
	</div>
</div>

<script>$.include('<?=file::self_dir(__FILE__)?>/form.js');</script>

<?php } ?>