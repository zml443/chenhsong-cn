<?php
// 已被使用的变量
// $name, $value, $row, $cfg



$attr = $cfg['Null'] ? 'notnull' : '';

$randCls = str::rand(15);

?>


<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit flex'>
		<span class="name"><?=$cfg['Name']?></span>
		<?php if ($cfg['Lang']) { ?><span class='langselbox'></span><?php } ?>
		<span class='tip flex-1'><?=$tip?'('.$tip.')':''?></span>
		<!-- <div></div> -->
		<dl class="flex-max2" ly-tab="" to=".<?=$randCls?>">
			<?php
				$cTab = language('dbs.editor_open.tab');
				$i=-1;
				foreach ($cTab as $k => $v) {
					$i++;
					echo '
						<label class="flex-max2 fz12 pointer '.($i?'ml_10px':'').' '.($k==$row[$name.'Type']?'cur':'').'">
							<i class="ly_radio mr_3px"><input type="radio" name="'.$name.'Type" value="'.$k.'" '.($k==$row[$name.'Type']?'checked':'').'></i>
							<span>'.$v.'</span>
						</label>
					';
				}
			?>
		</dl>
	</div>
	<dl class='_dbs_content relative <?=$randCls?>'>
		<!-- 开始 -->

		<dd class="">
			<?php 
				if ($cfg['Lang']) {
					$tab = '';
					$edt = '';
					foreach (c('language') as $v) {
						$n = $this->lang($name, $v);
						$val = $this->table_copy ? db::editor($this->table_copy, $row['Id'], $n) : db::editor($this->table, $row['Id'], $n);
						$tab .= "<li>{$v}</li>";
						if ($cfg['EditShow']) $edt .= "<li>{$val}</li>";
						else $edt .= "<li><textarea ueditor='3' file-selector='manage' top='#dbs-top' style='height:500px' name='{$n}'>{$val}</textarea></li>";
					}
			?>
				<ul class="relative" mLanguage><?=$edt?></ul>
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
		</dd>
		<dd>
			<label class='ly_input mt_20px mb_50px'>
				<span><?=language('{/dbs.editor_open.tab.url/}')?></span>
				<textarea autoHeight notEnter name='<?=$name?>Url'><?=$row[$name.'Url']?></textarea>
			</label>
		</dd>
		<dd>
			<div class="mt_50px mb_50px text-center fz16" color="text3"><?=language('{/dbs.editor_open.hide_tip/}')?></div>
		</dd>

		<!-- 结束 -->
	</dl>
</div>