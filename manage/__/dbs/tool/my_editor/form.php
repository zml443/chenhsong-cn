<?php
// 已被使用的变量
// $name, $value, $row, $cfg



$attr = $cfg['Null'] ? 'notnull' : '';

?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<?php if ($cfg['Lang']) { ?><span class='langselbox'></span><?php } ?>
		<span class='tip'><?=$tip?'('.$tip.')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<?php
				if ($cfg['Lang']) {
					$tab = '';
					$edt = '';
					foreach (c('language') as $k => $v) {
						$n = $this->lang($name, $v);
						$val = $value[$v];
						// $val = db::editor($this->table, $row['Id'], $n);
						$tab .= "<li>{$v}</li>";
						$edt .= "<li ".($k?'hide':'')."><textarea ueditor='3' top='#dbs-top' fileSelector='manage' style='height:500px' name='{$n}'>{$val}</textarea></li>";
					}
				?>
				<!-- <ul class='tab clean' tab='[editor-contents]'><?=$tab?></ul> -->
				<ul mLanguage class="relative"><?=$edt?></ul>
			<?php
				}
				else {
			?>
				<div><textarea ueditor='3' top='#liTop' fileSelector='manage' style='height:500px' name='<?=$name?>'><?=$value?></textarea></div>
			<?php
				}
			?>

		<!-- 结束 -->
	</div>
</div>