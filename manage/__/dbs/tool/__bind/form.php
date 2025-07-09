<?php
// 已被使用的变量
// $name, $value, $row, $cfg

$ids = array();
if ($row[$name]) {
	$ids = explode(',', $row[$name]);
}


?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content flex-middle2'>
		<!-- 开始 -->

			<div class="ly_btn pointer width150" bg="main" onclick="tool_bind(this)" data-ma="<?=$cfg['Cfg']['ma']?>" data-name="<?=$cfg['Cfg']['name']?>" data-picture="<?=$cfg['Cfg']['picture']?>">
				<?=language('{/global.set/}')?> (<span class="a"><?=count($ids)?></span>)
				<input type="hidden" name="<?=$name?>" value="<?=$row[$name]?>">
			</div>

		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script> 