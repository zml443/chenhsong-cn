<?php
// 已被使用的变量
// $name, $value, $row, $cfg



$attr = $cfg['Null'] ? 'notnull' : '';

?>


<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
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
					foreach (c('language') as $v) {
						$n = $this->lang($name, $v);
						$val = $this->table_copy ? db::editor($this->table_copy, $row['Id'], $n) : db::editor($this->table, $row['Id'], $n);
						// $val = db::editor($this->table, $row['Id'], $n);
						$tab .= "<li>{$v}</li>";
						if ($cfg['EditShow']) $edt .= "<li>{$val}</li>";
						else $edt .= "<li><textarea ueditor='3' file-selector='manage' top='#dbs-top' style='height:500px' name='{$n}'>{$val}</textarea></li>";
					}
			?>
				<ul mLanguage class="relative"><?=$edt?></ul>
			<?php 
				} else { 
					$editor = $this->table_copy ? db::editor($this->table_copy, $row['Id'], $name) : db::editor($this->table, $row['Id'], $name);
			?>
				<?php if ($cfg['EditShow']) { ?>
					<?=$editor?>
				<?php } else { ?>
					<textarea ueditor='3' file-selector='manage' top='#dbs-top' style='height:500px' name='<?=$name?>'><?=$editor?></textarea>
					<div class="hide ueditordiv"><?=$editor?></div>
				<?php } ?>
			<?php 
				} 
			?>

		<!-- 结束 -->
	</div>
</div>