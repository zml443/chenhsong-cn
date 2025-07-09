<?php
// 防止胡乱进入
function_exists('c')||exit;
// 
$pg = $_GET['pg']-1;
$pg<0 && $pg = 0;
$this->row = db::get_limit($this->table, $this->where, '*', $this->orderby, $pg*$this->limit, $this->limit);
$this->total = db::get_row_count($this->table, $this->where);
// 获取草稿
/*if ($this->table_copy) {
	$ids = '0';
	foreach ($this->row as $k => $v) {
		$ids .= ','.$v['Id'];
	}
	$this->res_copy = db::query("select * from ".$this->table_copy." where Id in($ids)");
	$this->row_copy = array();
	while ($v = db::result($this->res_copy)) {
		$this->row_copy[$v['Id']] = $v;
	}	
}*/

$isnull = !$this->total && language('menu.'.implode('.', $this->u).'.module_null_title');



?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body class="flex-column maxvh2" bg="default">

	<div class="p_30_0px flex-middle2" cw="<?=$_GET['_w_']?>">
		<?php 
			if ($_GET['_inline_']) {
				$lyCssConf=[]; include c('dbs.inc').'/title2.php';
			} else if ($_GET['_is_popup_']) {
				$lyCssConf=[]; include c('dbs.inc').'/title-one.php';
			} else {
				$lyCssConf=[]; include c('dbs.inc').'/title.php';
			}
		?>
		<div class="flex-1"></div>
		<?php $lyCssConf=[]; include c('dbs.inc').'/lang3.php';?>
	</div>

	<div class="flex-1 mb_20px" bg="white" cw="<?=$_GET['_w_']?>" ajax-change="list">
		<div class="" ly-sticky="top">
			<div class="" bg="white">
				<div class="flex-middle2 p_20px b_bottom">
					<?php 
						if (!$_GET['_inline_'] && !$_GET['_is_popup_']) {
							$lyCssConf=[]; include c('dbs.inc').'nav.php';
						}
					?>
					<div class="flex-1"></div>
					<?php $lyCssConf=[]; include c('dbs.inc').'tool.php';?>
				</div>
				<div class="flex-middle2 p_20px <?=$isnull?'hide2':''?>">
					<?php $lyCssConf=[]; include c('dbs.inc').'search_xz.php';?>
					<div class="flex-1"></div>
					<?php $lyCssConf=[]; include c('dbs.inc').'search.php';?>
				</div>
			</div>
		</div>


		<?php if ($isnull) { ?>
			<div class="pt_150px pb_90px"><?php $lyCssConf=['cw'=>'900']; include c('dbs.inc').'null.php';?></div>
		<?php } ?>

		<!--  -->
		<section class="ly_table_box <?=$isnull?'hide2':''?>">

			<table class='ly_table_list maxw'>
				<thead>
					<tr>
						<td class="width70 sticky relative"><?php $lyCssConf=[]; include c('dbs.inc').'id-all.php';?></td>
						<?php if ($this->permit['myorder']) { ?><td d='myorder'><?=language('{/global.my_order/}')?></td><?php } ?>
						<?php foreach ($this->layout as $k => $v) { ?>
							<td class="nowrap <?=$v['class']?>" d="<?=strtolower($k)?>"><?=$v['name']?></td>
						<?php } ?>
						<?php if ($this->table_copy) { ?><td></td><?php } ?>
						<?php if ($this->permit['_ope']) { ?><td class="sticky"></td><?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($this->row as $k => $v) {
							$v = str::code($v);
							/*if ($this->table_copy) {
								$v_status = '<span color="success">'.language('{/global.release2/}').'</span>';
								$v_copy = $this->row_copy[$v['Id']];
								if ($v_copy && $v_copy['EditTime']!=$v['EditTime']) {
									$v_status = '<span color="main">'.language('{/global.update2/}').'</span>';
								}
							}*/
							if ($this->table_copy) {
								$v_status = '<span color="success">'.language('{/global.release2/}').'</span>';
								if ($v['IsUnpublished']) {
									$v_status = '<span color="main">'.language('{/global.update2/}').'</span>';
								}
							}
					?>
						<tr class="<?=($this->table=='wb_feedback'||$this->table=='wb_download_feedback') && $v['IsRead']==0?'notRead':'';?>">
							<td class="w_1 sticky"><label class="ly_checkbox lyicon-select-bold ly_table_strip_ml" size="big"><input type='checkbox' name='Id' value='<?=$v['Id']?>'></label></td>
							<?php if ($this->permit['myorder']) { ?><td class="w_1 sticky"><?=$this->li('_MyOrder', $v)?></td><?php } ?>
							<?php foreach ($this->layout as $k1 => $v1) { ?>
								<td class="<?=$v1['class']?>">
									<?php
										$ki = 0;
										foreach ($v1['field'] as $k2 => $v2) {
											echo "<div class='".($ki?'mt_10px':'')."'>".$this->li($k2, $v)."</div>";
											$ki++;
										}
									?>
								</td>
							<?php } ?>
							<?php if ($this->table_copy) { ?><td class="w_1"><?=$v_status;?></td><?php } ?>
							<?php if ($this->permit['_ope']) { ?><td class="w_1 width200 sticky"><?=$this->li('_Ope', $v)?></td><?php } ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</section>
		<!--  -->
		<div class="" ly-sticky="bottom">
			<?php $lyCssConf=['class'=>'flex-right p_20px','bg'=>'white']; include c('dbs.inc').'paging.php';?>
		</div>
		<!--  -->
	</div>

</body>
</html>