<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body class="flex-column maxvh2" bg="default">

	<div class="pb_30px pt_30px" cw="<?=$_GET['_w_']?>">
		<?php include c('dbs.inc').'/title.php';?>
	</div>
	<div class="flex-1 mb_20px" bg="white" cw="<?=$_GET['_w_']?>">
		<div class="" ly-sticky="top">
			<div class="flex-between p_20px" bg="white">
				<div class="tool"><?php include c('dbs.inc').'/tool.php';?></div>
				<div class="search"><?php include c('dbs.inc').'/search.php';?></div>
			</div>
		</div>
		<!--  -->
		<section class="ly_table_box">
			<table class='ly_table_list maxw'>
				<thead>
					<tr>
						<td class="w_1 sticky"><label class="ly_checkbox lyicon-select-bold" size="big"><input type='checkbox' all='[name=Id]'></label></td>
						<?php if ($this->permit['myorder']) { ?><td d='myorder'><?=language('{/global.my_order/}')?></td><?php } ?>
						<?php foreach ($this->layout as $k => $v) { ?>
							<td class="nowrap <?=$v['class']?>" d="<?=strtolower($k)?>"><?=$v['name']?></td>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php
						$pg = $_GET['pg']-1;
						$pg<0 && $pg = 0;
						$this->row = db::get_limit($this->table, $this->where, '*', $this->orderby, $pg*$this->limit, $this->limit);
						foreach ($this->row as $k => $v) {
							$v = str::code($v);
					?>
						<tr>
							<td class="w_1 sticky"><label class="ly_checkbox lyicon-select-bold" size="big"><input type='checkbox' name='Id' value='<?=$v['Id']?>'></label></td>
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
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</section>
		<!--  -->
		<div class="" ly-sticky="bottom">
			<div class="flex-right flex-middle2 p_20px" bg="white">
				<?php
					$page = page::html(array(
						'type' => 'search',
						'page' => $_GET['pg'],
						'limit' => $this->limit,
						'total' => (int)db::get_row_count($this->table, $this->where)
					));
					echo str_replace('href=', 'hr-ef=', $page['html']) . "<div class='ml_20px'>".str_replace('%u', $page['total'], language('global.page_total'))."</div>";
				?>
			</div>
		</div>
		<!--  -->
	</div>

</body>
</html>