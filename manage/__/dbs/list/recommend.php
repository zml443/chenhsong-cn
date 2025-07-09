<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body>

	<div class="" ly-sticky="top">
		<div class="p_20px" bg="white"><?php include c('dbs.inc').'search.php';?></div>
	</div>
	<!-- 列表 开始 -->
	<table class='ly_table_list maxw'>
		<thead>
			<tr>
				<td class='hide'><label><input type='checkbox' all='[name=Id]'></label></td>
				<?php foreach ($this->layout as $k => $v) { ?>
					<td class="nowrap"><?=$v['name']?></td>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<?php
				$pg = $_GET['pg']-1;
				$pg<0 && $pg = 0;
				$row = db::get_limit($this->table, $this->where, '*', $this->orderby, $pg*$this->limit, $this->limit);
				foreach ($row as $k => $v) {
					$v = str::code($v);
			?>
				<tr class="-tr pointer">
					<td class='hide'><label><input type='checkbox' name='Id' data-id value='<?=$v['Id']?>'></label></td>
					<?php foreach ($this->layout as $k1 => $v1) { ?>
						<td>
							<?php
								foreach ($v1['field'] as $k2 => $v2) {
									echo $this->li($k2, $v);
								}
							?>
						</td>
					<?php } ?>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<!-- 列表 结束 -->
	<!-- 分页 开始 -->
	<div ly-sticky="bottom">
		<div class="flex-right flex-middle2 p_20px" bg="white">
			<?php
				$page = page::html(array(
					'type' => 'search2',
					'page' => $_GET['pg'],
					'limit' => $this->limit,
					'total' => (int)db::get_row_count($this->table, $this->where)
				));
				echo str_replace('href=', 'hr-ef=', $page['html']);
			?>
		</div>
	</div>
	<!-- 分页 结束 -->


</body>
</html>