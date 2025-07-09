<?php
// 已被使用的变量
// $name, $value, $row, $cfg



?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content flex-middle2'>
		<!-- 开始 -->

			<div class="not-event" hr-ef="<?=str_replace('{{id}}', $row['Id'], $cfg['Cfg']['Href'])?>&_popup_right_=1&l=comment">
				<div class="ly_btn pointer width150" bg="main">
					<!-- <?=language('{/global.set/}')?> -->
					留言
				</div>
			</div>

		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script> 