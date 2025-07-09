<?php
// 已被使用的变量
// $name, $value, $row, $cfg



?>

<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>' data-dbs-name="<?=$name?>">
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
			<div class="tab_links mb_15px">
				<label class="ly_btn_radio pointer mr_10px">
					<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="all" <?=$row[$name.'Type']?($row[$name.'Type']=='all'?'checked':''):'checked'?> fn="dbs_member_crowd"></i>
					<span><?=language('panel.select_member.check.all')?></span>
				</label>
				<label class="ly_btn_radio pointer mr_10px">
					<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="group" <?=$row[$name.'GroupType']?'checked':''?> fn="dbs_member_crowd"></i>
					<span><?=language('panel.select_member.check.group')?></span>
				</label>
				<label class="ly_btn_radio pointer mr_10px">
					<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="tag" <?=$row[$name.'Tag']?'checked':''?> fn="dbs_member_crowd"></i>
					<span><?=language('panel.select_member.check.tag')?></span>
				</label>
				<label class="ly_btn_radio pointer">
					<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="id" <?=$row[$name.'Id']?'checked':''?> fn="dbs_member_crowd"></i>
					<span><?=language('panel.select_member.check.id')?></span>
				</label>
			</div>
			<div class="tab_content">
				<label class="hide2 ly_select_checkbox" ly-drop-select data-type="checkbox" data-con="group">
					<div><input type="text" placeholder=""></div>
					<input type="hidden" name="<?=$name?>GroupType" value="<?=$row[$name.'GroupType']?>">
					<i class="lyicon-arrow-down-bold"></i>
					<script type="text">
						[
							{
								label: "会员",
								value: "member"
							},
							{
								label: "已购顾客",
								value: "purchased"
							},
							{
								label: "复购顾客",
								value: "repurchase"
							}
						]
					</script>
				</label>
				<label class="hide2 ly_select_checkbox" ly-drop-select data-type="checkbox" data-con="tag">
					<div><input type="text" placeholder=""></div>
					<input type="hidden" name="<?=$name?>Tag" value="<?=$row[$name.'Tag']?>">
					<i class="lyicon-arrow-down-bold"></i>
					<script type="text">
						[
							{
								label: "标签1",
								value: "1"
							},
						]
					</script>
				</label>
				<label class="hide2 ly_select_checkbox" data-type="checkbox" data-con="id" lydbs-association-list-drop="" data-ma="member/index">
					<input type="hidden" name="<?=$name?>Id" value="<?=$row[$name.'Id']?>">
					<i class="lyicon-arrow-down-bold"></i>
				</label>
			</div>
		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>
