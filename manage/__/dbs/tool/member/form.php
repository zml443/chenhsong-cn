<?php
// 已被使用的变量
// $name, $value, $row, $cfg


?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<?php
			// 展示模式
			if ($cfg['EditShow']) {
				$mids = explode(',', $row[$name]);
				$mid = '0';
				foreach ($mids as $v) {
					$mid .= ','.(int)$v;
				}
				$member = db::all("select * from wb_member where Id in ($mid)");
				foreach ($member as $v) {
			?>
				<div>
					<?=$v['UserName'] ? $v['UserName'] : ($v['Mobile'] ? $v['Mobile'] : $v['Phone']);?>
					<a hr-ef='<?=c('manage.url.email')?>&toEmail=<?=$v['Email']?>/<?=$v['UserName']?>'><?=$v['Email']?></a>
				</div>
			<?php
				}
			// 会员选择模式
			} else {
			?>
			 	<!-- lydbs-recommend data-href='?ma=member/index&l=recommend' -->
				<div class='ly_btn' lydbs-association-list data-ma='member/index' fn='WP._dbs_member_bind_' data-title='请选择，<?=$cfg['Name']?>'>
					绑定会员
					<span txt>(已选择数：<span data-qty><?=$value?substr_count($value, ',')+1:0?></span>)</span>
					<input type='hidden' name='<?=$name?>' value='<?=$value?>'>
				</div>
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>