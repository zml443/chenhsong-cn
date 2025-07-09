<?php
// 已被使用的变量
// $name, $value, $row, $cfg



// 随机数，防止多个邮箱选择js冲突
$rand = str::rand(12);
?>



<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content clean'>
		<!-- 开始 -->
			
			<script class="json" type="text/json">
				<?php
					str::json($cfg['Cfg']);
				?>
			</script>
			<div class="flex">
				<label class='ly_input width300'><textarea class='email-<?=$rand?>' name='<?=$name?>'><?=$_GET['toEmail']?></textarea></label>
				<div class='pl_20px'>
					<div class='get_email ly_btn_min' lydbs-get-email="" style='margin-bottom:9px'>{/email.to/}</div>
					<div style='color:#999; line-height:1.7; font-size:13px;'>{/email.remark/}</div>
				</div>
			</div>

		<!-- 结束 -->
	</div>
</div>

<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>