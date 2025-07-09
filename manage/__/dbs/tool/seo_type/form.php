<?php
// 已被使用的变量
// $name, $value, $row, $cfg


$seo = db::seo($this->table, $row['Id']);
/*d(123);
d($this->table);
d($seo);*/

?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content clean'>
		<!-- 开始 -->
			
			<label class='ly_input'><input type='text' name='<?=$name?>' value="<?=$seo['Type']?>" notnull></label>

		<!-- 结束 -->
	</div>
</div>