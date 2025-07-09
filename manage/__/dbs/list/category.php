<?php
function_exists('c')||exit();
if (!$this->dbc['UId']) {
	return;
}
?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body class="flex-column maxvh2" bg="default">

	<div class="p_30_0px flex-middle2" cw="<?=$_GET['_w_']?:''?>">
		<?php 
			if ($_GET['_inline_']) {
				$lyCssConf=[]; include c('dbs.inc').'/title2.php';
			} else {
				$lyCssConf=[]; include c('dbs.inc').'/title.php';
			}
		?>
		<div class="flex-1"></div>
		<?php $lyCssConf=[]; include c('dbs.inc').'/lang3.php';?>
	</div>

	<div class="flex-1 mb_30px" cw="<?=$_GET['_w_']?:''?>" bg="white" ajax-change="list">
		<div class="" ly-sticky="top">
			<div class="ly_zindex21" bg="white">
				<div class="flex-middle2 p_20px b_bottom">
					<?php 
						if (!$_GET['_inline_']) {
							$lyCssConf=[]; include c('dbs.inc').'nav.php';
						}
					?>
					<div class="flex-1"></div>
					<?php $lyCssConf=[]; include c('dbs.inc').'tool.php';?>
				</div>
			</div>
		</div>

		<table class='ly_table_list2 ml_30px'>
			<thead>
				<tr>
					<td class="w_1 sticky relative"><?php $lyCssConf=[]; include c('dbs.inc').'id-all.php';?></td>
					<td class="">&nbsp;</td>
				</tr>
			</thead>
		</table>

		<div class="p_20px pt_0px clean">
			

			<ul class="zml_nav zml_nav2" drag-sort="" fn="dbs_category_myorder_list" data-href="<?=$this->query_string['myorder']?>">
				<?php
					// 分类列表
					function each_category2 ($dbs, $row, $PreChars='', $uid='0,') {
						if (!$row[$uid]) {
							return '';
						}
						$html = '';
						foreach ($row[$uid] as $k => $v) {
							$my_uid = $v['UId'].$v['Id'].',';
							$li = each_category2($dbs, $row, '<u class="prefix"></u>', $my_uid);
							$count = 0;
							if ($li) {
								$count = 1;
								$li = "<ul class='subnav ".($v['Dept']==1?'':'hide2')."' drag-sort='' fn='dbs_category_myorder_list' data-href='{$dbs->query_string['myorder']}'>{$li}</ul>";
							}
							$div = '';
							foreach ($dbs->layout as $k1 => $v1) {
								foreach ($v1['field'] as $k2 => $v2) {
									if ($k2=='Name') {
										$div .= "<span class='name flex-1'>".$v[$v2['Lang']?ln('Name'):'Name']."</span>";
									} else {
										$div .= "<span class='mr_50px'>".$dbs->li($k2, $v)."</span>";
									}
								}
							}
							$_ope = '';
							if ($dbs->permit['_add'] && !$_GET['_UId']) {
								$_ope .= $dbs->li('_UId', $v);
							}
							if ($dbs->permit['_ope']) {
								$_ope .= $dbs->li('_Ope', $v);
							}
							$html .= "
								<li class='li ".($v['Dept']==1?'cur':'')."' i='".$v['Id']."'>
									<div class='flex-middle2'>
										{$PreChars}
										<div class='nav_name flex-1 flex-middle2'>
											".($count?"<div class='open' stopPropagation><i></i></div>":'')."
											<i class='move lyicon-drag'></i>
											<label class='ly_checkbox lyicon-select-bold mr_15px' size='big' stopPropagation><input type='checkbox' name='Id' value='{$v['Id']}'></label>
											{$div}
											<div stopPropagation>{$_ope}</div>
										</div>
									</div>
									{$li}
								</li>
							";
						}
						return $html;
					}
					$row = db::get_category($this->table, $this->where);
					echo each_category2($this, $row, '', $row['uid']);
				?>
			</ul>
			<!--  -->
		</div>
	</div>

</body>
</html>