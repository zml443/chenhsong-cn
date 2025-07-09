<?php
// 已被使用的变量
// $name, $row, $cfg





?>

<?php if ($cfg['Lang']) { ?>
	<div mLanguage>
		<?php
			foreach ($this->language as $k => $v) {
				$n = $this->lang($name, $v);
		?>
			<span <?=$k!=c('lang')?'hide':''?>>
				<label class='ly_input'><textarea border="transparent" name='<?=$n?>' placeholder='<?=language('{/notes.need_content/}')?>' readonly autoheight><?=$row[$n]?></textarea></label>
			</span>
		<?php } ?>
	</div>
<?php } else { ?>
	<label class='ly_input'><textarea border="transparent" name='<?=$name?>' placeholder='<?=language('{/notes.need_content/}')?>' readonly autoheight><?=$row[$name]?></textarea></label>
<?php } ?>