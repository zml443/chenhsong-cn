<?php
// 已被使用的变量
// $name, $value, $row, $cfg


$bindTable = t($cfg['Table'][0]);
$one = db::result("select * from {$bindTable} where Id='".$row[$name]."'");

?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content flex-middle2'>
		<!-- 开始 -->

			<div class="not-event" hr-ef="?ma=<?=$cfg['Cfg']['ma']?>&l=selector-side&_popup_right_=1&_radio_=1" fn="lydbsHrefIframeBoxRadioFn">
				<div class="ly_btn pointer width150" bg="main">
					<?=language('{/global.set/}')?>
					<input type="hidden" name="<?=$name?>" value="<?=$row[$name]?>">
				</div>

				<div class="ml_20px" data-name=""><?=$one[$cfg['Cfg']['name']]?></div>
			</div>

		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script> 