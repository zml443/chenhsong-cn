<?php
// 已被使用的变量
// $name, $value, $row, $cfg




$json = $cfg['Cfg'];
// if ($json[0]) $tip = sprintf(language('{/notes.pic_size_tips/}'), "{$json[0][0]}*{$json[0][1]}");
unset($json[0]);
$json = str::json($json);


?>







<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<?php if ($cfg['Lang']) { ?><span class='langselbox'></span><?php } ?>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<?php 
				if ($cfg['Lang']) { 
			?>
				<div mLanguage>
					<?php
						foreach ($this->language as $v) {
							$n = $this->lang($name, $v);
					?>
						<div>
							<div file-selector='manage' list='1' name='<?=$n?>' json='<?=$json?>'><textarea><?=$value[$v]?></textarea></div>
						</div>
					<?php } ?>
				</div>
			<?php
				} 
				else {
			?>
				<div file-selector='manage' list='1' name='<?=$name?>' json='<?=$json?>'><textarea><?=$value?></textarea></div>
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>