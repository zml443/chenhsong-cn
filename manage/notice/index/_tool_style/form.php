<?php
// 已被使用的变量
// $name, $value, $row, $cfg


?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit flex-between'>
		<div>
			<span class="name"><?=$cfg['Name']?></span>
			<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
		</div>
		<div class="tab pointer" lydbs-association-list data-ma='member/index' data-title='请选择，<?=$cfg['Name']?>'>
			更换
			<input type="hidden" name="style" value="">
		</div>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
		<div class="flex-middle2">
			<img class="maxw" src="/static/images/1400.jpg">
		</div>
		<!-- 结束 -->
	</div>
</div>

<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>