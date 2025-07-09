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
	<script src="/manage/site/nav/_list.js"></script>
</head>

<body class="flex-column maxvh2" bg="default">

	<div class="flex-middle2 mt_50px mb_20px" cw="800">
		<div class="ly-h3 flex-1"><?=permit::name()?></div>
		<a class="tian_jia_cai_dan ly_btn_radius" size="small" bg="main">添加一级菜单</a>
	</div>

	<ul class="zml_nav mb_30px flex-1 relative" cw="800" drag-sort="" fn="dbs_category_myorder_list">
		<?php
			// 分类列表
			function each_category ($dbs, $row, $PreChars='', $uid='0,') {
				if (!$row[$uid]) {
					return '';
				}
				$html = '';
				foreach ($row[$uid] as $k => $v) {
					$my_uid = $v['UId'].$v['Id'].',';
					$li = each_category($dbs, $row, '<u class="prefix"></u>', $my_uid);
					$count = 0;
					if ($li) {
						$count = 1;
						$li = "<ul class='subnav hide2' drag-sort='' fn='dbs_category_myorder_list'>{$li}</ul>";
					}
					$html .= "
						<li class='li' i='".$v['Id']."'>
							<div class='flex-middle2'>
								{$PreChars}
								<div class='nav_name flex-1 flex-middle2'>
									".($count?"<div class='open stop-drag'><i></i></div>":'')."
									<i class='move lyicon-drag'></i>
									<span class='name flex-1'>".$v[ln('Name')]."</span>
									<a class='add tian_jia_cai_dan stop-drag' data-uid='{$v['UId']}{$v['Id']},'>添加子菜单</a>
									".($count?"<a class='type stop-drag' hr-ef='?ma=site/nav&E=subnav_type&Id={$v['Id']}'>风格</a>":'')."
									<a class='mod lyicon-bianji stop-drag' data-id='{$v['Id']}'></a>
									<a class='del lyicon-ashbin stop-drag' data-id='{$v['Id']}'></a>
								</div>
							</div>
							{$li}
						</li>
					";
				}
				return $html;
			}
			$row = db::get_category($this->table, $this->where);
			$html = each_category($this, $row, '', $row['uid']);
			if ($html) {
				echo $html;
			} else {
		?>
			<div class="flex-max2 pt_100px pb_90px">
				<div class="zmlnav_null flex-max2">
					<div class="flex-1">
						<div class="name"><?=language('{/menu.web.nav.module_null_title/}')?></div>
						<div class="brief"><?=language('{/menu.web.nav.module_brief/}')?></div>
						<div class="btn ly_btn_radius pointer tian_jia_cai_dan" bg="main"><?=language('{/menu.web.nav.module_null_add/}')?></div>
					</div>
					<div class="img"><img src="<?=language('{/menu.web.nav.module_null_pic/}')?>" /></div>
				</div>
			</div>
		<?php } ?>
	</ul>

</body>
</html>