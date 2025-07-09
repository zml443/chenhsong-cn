<?php
// 已被使用的变量
// $name, $value, $row, $cfg





$url = str::code(db::result("select * from page_url where ExtTable='".$this->table."' and ExtId='{$row['Id']}'"));
$xxx = page_url::ext($this->table);

// $prefix = g('wb_site_page_url_setting.'.$this->table)?:'/';
// $suffix = g('wb_site_page_url_setting.'.$this->table)?:'html';

?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<input type='hidden' name='<?=$name?>_Dir' value="<?=$xxx['prefix']?>" />
			<label class='ly_input'>
				<b><?=$xxx['prefix']?></b>
				<textarea class="tool_page_url_this" autoHeight notEnter name='<?=$name?>' -check='customUrl' tip='<?=language('{/notes.custom_url/}')?>' oninput="tool_page_url_(this)"><?=$url['Url']?></textarea>
			</label>
			<div class="flex mt_10px">
				<span color="text3">使用结果</span>
				<span class="mr_5px ml_5px">:</span>
				<span class="result" color="main" data-prefix="<?=$xxx['prefix']?>" data-suffix="<?=$xxx['suffix']?>">系统链接</span>
			</div>

		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>/form.js');</script>