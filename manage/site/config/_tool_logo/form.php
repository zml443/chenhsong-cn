<?php
// 已被使用的变量
// $name, $value, $row, $cfg

// d($row);
?>
<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit flex-max2 p_10_0px zIndex1' ly-sticky="center" bg="white">
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip flex-1'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
		<div class="ly_btn pointer2" bg="main" size="small" onclick="languageLogoEdit(this)">编辑LOGO</div>
		<script type="text" class="json"><?=str::json($row['languageLogo'])?></script>
		<div class="languageLogo hide">
		<?php 
			foreach ((array)$row['languageLogo'] as $k => $v) {
				echo "<input type='hidden' name='languageLogo[$k]' value='{$v}' />";
			}
		?>
		</div>
		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>