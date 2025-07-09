<?php
// 已被使用的变量
// $name, $value, $row, $cfg

// d($cfg);
?>
<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<div class="ly_btn pointer width150" bg="main" onclick="tool_where_extid(this)" data-ma="<?=$this->ma?>" data-exId="<?=$row['Id']?>">
				<?=language('{/global.set/}')?>
				<input type="hidden" name="_where_extid_add" value="">
				<input type="hidden" name="_where_extid_del" value="">
			</div>

		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>