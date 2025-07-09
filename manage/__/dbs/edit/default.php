<?php

// 防止胡乱进入
function_exists('c')||exit;

if ($this->dbg) {
	$row = $this->row = g($this->table);
} else {
	$Id = (int)$_GET['Id'];
	if ($this->table_copy && !$_GET['_original_']) {
		$row = $this->row = str::code(db::result("select * from {$this->table_copy} where ".$this->where));
		if (!$row) {
			$row = $this->row = db::result("select * from {$this->table} where ".$this->where);
			// 复制+草稿
			$this->copy__copy(array(
				'table' => $this->table,
				'table_copy' => $this->table_copy,
				'before_row' => $this->row,
				'fields' => $this->fields,
				'dbc' => $this->dbc,
			));
			$row = $this->row = str::code($this->row);
		}
	} else {
		$row = $this->row = str::code(db::result("select * from {$this->table} where ".$this->where));
	}
}

if ($_GET['_w_']) {
	$cw = $_GET['_w_'];
} else {
	$cw = $this->layout['right']?'1300':'800';
}

?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body bg="default">


	<form class='maxvh2 flex-column <?=$this->is_mod?'_do_not_go_to_back':''?>' lydbs-detail="" <?=$this->dbg?'is-not-list':''?> action='<?=$this->query_string['post'];?>'>

		<!-- 头部 开始 -->
		<ul cw="<?=$cw?>" class="p_20_0px">
			<li class="mt_20px flex-middle2" bg="default">
				<?php $lyCssConf=[]; include c('dbs.inc').'title-edit.php'; ?>
				<div class="flex-1"></div>
				<?php $lyCssConf=[]; include c('dbs.inc').'lang.php'; ?>
			</li>
			<?php $lyCssConf=['class'=>'pt_20px ml_5px']; include c('dbs.inc').'edit-head.php'; ?>
		</ul>
		<!-- 头部 结束 -->


		<div class="flex-between flex-wrap flex-1 mb_20px" cw="<?=$cw?>">
			<!-- 左边 开始 -->
			<div class='content_left'>
				<?php 
					foreach ($this->layout['field'] as $k => $v) {
						echo '<div class="_dbs_box" data-group="'.$k.'">';
						if ($v['name']) {
							echo '
								<div class="_dbs_h4">
									<span class="ly-h4 mr_15px">'.$v['name'].'</span>
									<span color="text3">'.($v['tip']?'( '.$v['tip'].' )':'').'</span>
								</div>
							';
						}
						foreach ($v['field'] as $k1 => $v1) {
							echo $this->ed($k1, $row);
						}
						echo "</div>";
					}
				?>
			</div>
			<!-- 左边 结束 -->
			<!-- 右边 开始 -->
			<?php if ($this->layout['right']) { ?>
				<div class='content_right' ly-sticky="center">
					<?php 
					foreach ($this->layout['right'] as $k => $v) {
						echo '<div class="_dbs_box" data-group="'.$k.'">';
						if ($v['name']) {
							echo '
								<div class="_dbs_h4">
									<span class="ly-h4 mr_15px">'.$v['name'].'</span>
									<span color="text3">'.($v['tip']?'( '.$v['tip'].' )':'').'</span>
								</div>
							';
						}
						foreach ($v['field'] as $k1 => $v1) {
							echo $this->ed($k1, $row);
						}
						echo "</div>";
					}
					?>
				</div>
			<?php } ?>
			<!-- 右边 结束 -->
		</div>

		<!--  -->
		<div class='_dbs_submit' ly-sticky="bottom">
			<div class=" flex-max2 _dbs_submit_chilren">
				<?php if (!$_GET['notback']) { ?>
					<label class='ly_btn min-width90 pointer' hr-ef='back()'><?=language('{/global.back/}')?></label>
				<?php } ?>
				<?php if (!$this->not_save && !$this->table_copy) { ?>
					<label class='ly_btn min-width90 pointer' bg="main"><input type='submit'><?=language('{/global.submit/}')?></label>
				<?php } ?>
				<?php if ($this->table_copy) { ?>
					<a class='ly_btn min-width90 pointer' bg="main" onclick="dbs_submit.submit_before(this)" data-status="_save_copy_"><?=language('{/global.save_draft/}')?></a>
					<a class='ly_btn min-width90 pointer' bg="success" onclick="dbs_submit.submit_before(this)" data-status="_release_copy_"><?=language('{/global.save_release/}')?></a>
					<?php if ($_GET['_original_']) { ?>
						<a class='ly_btn min-width90 pointer' hr-ef="?<?=url::query_string('_original_')?>"><?=language('{/global.draft/}')?></a>
					<?php } else { ?>
						<a class='ly_btn min-width90 pointer' hr-ef="?<?=url::query_string()?>&_original_=1"><?=language('{/global.reset/}')?></a>
					<?php } ?>
					<a class='ly_btn min-width90 pointer' onclick="dbs_submit.submit_before(this)" data-status="_save_copy_view_"><?=language('{/global.save_draft_view/}')?></a>
				<?php } ?>
			</div>
		</div>
		<!--  -->
		<input type='hidden' name='Id' value='<?=$row['Id']?>'>
		<!-- 以下是草稿专用字段 -->
		<input type='hidden' name='_save_copy_' value=''>
		<input type='hidden' name='_release_copy_' value=''>

	</form>

</body>
</html>