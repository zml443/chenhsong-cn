<?php
// 防止胡乱进入
function_exists('c')||exit;
// 
$orderby = db::get_order_by($this->orderby);
$this->row = db::all("select * from ".$this->table." where IsLock=0 order by {$orderby}");

?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body bg="default">

	<?php $lyCssConf=['class'=>'p_30_0px', 'cw'=>'100%']; include c('dbs.inc').'title.php'; ?>

	<div bg="white" cw="100%">
		<div class="" ly-sticky="top">
			<div class="flex-middle2 flex-between p_20px" bg="white">
				<?php $lyCssConf=[]; include c('dbs.inc').'tool.php'; ?>
				<div class='paging'></div>
			</div>
		</div>
		<!--  -->
		<section>
			<table class='ly_table_list maxw'>
				<thead>
					<tr>
						<td class="w_1 relative"><?php $lyCssConf=[]; include c('dbs.inc').'id-all.php';?></td>
						<td><?=language('site.edit_custom')?></td>
						<td class='w_1'></td>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($this->row as $k => $v) {
							$v = str::code($v);
					?>
						<tr>
							<td class="w_1"><label class="ly_checkbox lyicon-select-bold ly_table_strip_ml" size="big"><input type='checkbox' name='Id' value='<?=$v['Id']?>'></label></td>
							<td><?=$this->li('Name', $v)?></td>
							<td class='w_1 width100'>
								<div class="ly_gap_10px">
									<?php 
									if ($this->permit['edit']) {
										$editurl = $this->query_string['edit']."&Id={$v['Id']}";
										echo "<a class='ly_btn_round lyicon-bianji' bg='light' dbs='edit' hr-ef='{$editurl}' ly-tip-bubble='{direction:top_center}' data-tip-contents='".language('{/global.edit/}')."'></a>";
									}
									echo '<a class="ly_btn_radius" bg="light" href="/manage/?ma=website/index&Id='.$v['Id'].'" target="_blank">'.language('panel.edit_custom_page').'</a>';
									if ($this->permit['del'] && !$v['Lock']) {
										echo "<a class='ly_btn_round lyicon-close' bg='light' dbs='del' data-id='{$v['Id']}' data-check='{$delete_check}' ly-tip-bubble='{direction:top_center}' data-tip-contents='".language('{/global.del/}')."'></a>";
									}
									?>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</section>
		<!--  -->
	</div>
	
</body>
</html>