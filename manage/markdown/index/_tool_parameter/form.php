<?php
// 已被使用的变量
// $name, $value, $row, $cfg
// $zip = db::result("select * from wb_markdown limit 0,1");

?>
<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit flex-max2 p_10_0px zIndex1' ly-sticky="center" bg="white">
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip flex-1'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
		<label class="ly_btn pointer" bg="main" file-upload="manage_default" accept="application/zip" fn="markdown_upload">
			<input class="wenjian" type="hidden" name="Files" value="<?=$row['Files']?>">选择文件
		</label>
		<div class="flex-middle2 inline-flex ml_10px">
			<a class="lianjie" color="text4" href="<?=$row['Files']?$row['Files']:'javascript:;'?>"><?=$row['Files']?$row['Files']:'未选择文件'?></a>
		</div>
		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>