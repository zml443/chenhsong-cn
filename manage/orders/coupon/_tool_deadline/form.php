<?php
// 已被使用的变量
// $name, $value, $row, $cfg

$GetTimeMap = array('day'=>'天','hour'=>'小时');

?>
<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content flex-wrap'>
		<div class="tab_links mb_10px">
			<label class="ly_btn_radio pointer mr_10px">
				<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="FixedTime" <?=$row[$name.'Type']?($row[$name.'Type']=='FixedTime'?'checked':''):'checked'?> fn="_tool_deadline_"></i>
				<span>固定时间</span>
			</label>
			<label class="ly_btn_radio pointer mr_10px">
				<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="GetTime" <?=$row[$name.'Type']=='GetTime'?'checked':''?> fn="_tool_deadline_"></i>
				<span>领取时间</span>
			</label>
		</div>
		<div class="tab_content">
			<div class="width200" data-con="FixedTime">
				<?php
					if ($cfg['EditShow']) {
						echo $row[$name.'0'] ? (date('Y-m-d',$row[$name.'0']).' ~ '.date('Y-m-d',$row[$name.'1'])) : 'N/A';
					} else { 
				?>
					<span class='ly_input w360'>
						<input type='text' value='<?=(date('Y-m-d',$row[$name.'0']?:c('time')).' ~ '.date('Y-m-d',$row[$name.'1']?:c('time')))?>' ly-laydate='date' range="~" fn="_tool_deadline_" />
					</span>
					<input type="hidden" class="eftime0" name="<?=$name.'0'?>" value="<?=$row[$name.'0']?>" />
					<input type="hidden" class="eftime1" name="<?=$name.'1'?>" value="<?=$row[$name.'1']?>" />
				<?php } ?>
			</div>
			<div class="width200" data-con="GetTime">
				<label class="ly_input ly_not_border ">
					<input type="text" name="<?=$name.'Number'?>" value="<?=$row[$name.'Number']?>">
					<input type="hidden" name="<?=$name.'Unit'?>" value="<?=$row[$name.'Unit']?:'day'?>">
					<div class="overVis relative" bg="pane">
						<div class="tab_top mr_5px"><?=$row[$name.'Unit']?$GetTimeMap[$row[$name.'Unit']]:'天'?></div>
						<i class="lyicon-arrow-right-filling"></i>
						<div class="nowrap ml_10px">内有效</div>
						<div class='ly_drop_left width80'>
							<div>
								<a class='ly_drop_item <?=$row[$name.'Unit']?($row[$name.'Unit']=='day'?'cur':''):'cur'?>' onclick="_tool_deadline_.tab(this)" data-type="day" data-name="天">天</a>
								<a class='ly_drop_item <?=$row[$name.'Unit']=='hour'?'cur':''?>' onclick="_tool_deadline_.tab(this)" data-type="hour" data-name="小时">小时</a>
							</div>
						</div>
					</div>
				</label>
			</div>
		</div>
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>/form.js');</script>