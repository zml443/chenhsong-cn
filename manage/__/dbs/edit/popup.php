<?php
// 防止胡乱进入
function_exists('c')||exit;

if ($this->dbg) {
	$row = $this->row = g($this->table);
} else {
	$Id = (int)$_GET['Id'];
	$row = $this->row = str::code(db::result("select * from {$this->table} where Id='{$Id}'"));	
}

if ($_GET['_w_']) {
	$cw = $_GET['_w_'];
} else {
	$cw = $this->layout['right']?'1300':'800';
}

?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<style>
html,body{background: none;}
</style>

<body class="maxvh flex-max">

	<div class="absolute max at-close"></div>

	<form class='wcb_alert_box flex-column _do_not_go_to_back' lydbs-detail="" is-not-list="" action='<?=$this->query_string['post'];?>'>

		<script class="wcb_alert_box_init_data" type="text"><?=str::json($current)?></script>
		<!-- 顶部标题 -->
		<div class="wcb_alert_title">
			<div class=""><?php $lyCssConf=[]; include c('dbs.inc').'title-one.php'; ?></div>
			<div class="at-close lyicon-guanbi pointer"></div>
		</div>
		<!-- 中间区域 -->
		<div class="flex relative flex-1 scrollbar p_30px" ajax-change="list" bg="default" style="height:0px">
			<!--  -->
			<div class="flex-between flex-wrap flex-1 mb_20px">
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
			<input type='hidden' name='Id' value='<?=$row['Id']?>'>
			<!--  -->
		</div>

		<!-- 底部按钮 -->
		<div class="wcb_alert_btn2 flex-middle2 flex-between">
			<div></div>
			<label class="wcb_alert_btn_submit at-confirm flex-btn" bg="main" color="white"><input class="hide" type='submit'><?=language('{/global.save/}')?></label>
		</div>

	</form>
</body>
</html>


<script>

</script>