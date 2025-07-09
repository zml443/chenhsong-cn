<?php
function_exists('c') || exit;
// 插入固定页的seo
if ($this->table=='wb_site_page_data') {
	$all_page = m('ZiDingYiYeMian');
	$in_where = "'".implode("','", $all_page)."'";
	$all_fix_page = db::query("select * from wb_site_page_data where Type in($in_where)");
	$fix_page_row = array();
	while ($v = db::result($all_fix_page)) {
		$fix_page_row[$v['Type']] = $v;
	}
	foreach ($all_page as $k => $v) {
		if (!$fix_page_row[$v]) {
			db::insert('wb_site_page_data', array(
				'Type' => $v,
				'IsLock' => 1
			));
		}
	}
}
// 
$pg = $_GET['pg']-1;
$pg<0 && $pg = 0;
if ($this->dbc['NotSeo']) {
	$this->where .= ' and NotSeo=0';
}
// $this->row = db::get_limit($this->table, $this->where, '*', $this->orderby, $pg*$this->limit, $this->limit);
$this->row = db::get_all($this->table, $this->where, '*', $this->orderby);
?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body bg="default">

	<?php //$lyCssConf=['class'=>'pt_30px pb_30px', 'cw'=>'100%']; include c('dbs.inc').'back.php';?>
	<div class="p_30_0px flex-middle2" cw="<?=$_GET['_w_']?>">
		<?php $lyCssConf=[]; include c('dbs.inc').'/title2.php';?>
		<div class="flex-1"></div>
		<?php $lyCssConf=[]; include c('dbs.inc').'/lang3.php';?>
	</div>

	<div class="mb_30px" bg="white" cw="100%">
		<div class="" ly-sticky="top">
			<div class="flex-between flex-middle2 p_20px" bg="white">
				<?php $lyCssConf=[]; include c('dbs.inc').'search.php';?>
				<div class="flex-middle2">
					<div class='seosubmit pointer ly_btn_radius' bg="main" size="small" dbs='seosubmit'><?=language('global.submit')?></div>
				</div>
			</div>
		</div>
		<!--  -->
		<section class="zml_seo_list">
			<table class='ly_table_list maxw'>
				<thead>
					<tr>
						<td class="w_1"><label class="ly_checkbox lyicon-select-bold" size="big"><input class="hide" type='checkbox' all='[name=Id]'></label></td>
						<td><?=language('global.name')?></td>
						<td><?=language('global.title')?></td>
						<td><?=language('global.keyword')?></td>
						<td><?=language('global.brief')?></td>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($this->row as $k => $v) {
							$v = str::code($v);
							$seo = str::code(db::seo($this->table, $v['Id']));
					?>
						<tr>
							<td class="w_1">
								<label class="ly_checkbox lyicon-select-bold" size="big"><input type='checkbox' name='Id' value='<?=$v['Id']?>'></label>
								<?php 
									if ($this->table=='wb_site_page_data') {
										echo '<input type="hidden" name="SeoType" value="'.$v['Type'].'">';
									}
								?>
							</td>
							<td class="width300"><div class='seoname'><?=$v['Name']?:($v[ln('Name')]?:lang('{/dbs.seo.'.$v['Type'].'/}'))?></div></td>
							<td>
								<?php
									echo $this->li('SeoTitle', $seo, array(
										'Type' => 'seo_title',
										'Lang' => $this->dbc['Language']?0:1,
										'NotSubmitLi' => 1
									));
								?>
							</td>
							<td>
								<?php
									echo $this->li('SeoKeyword', $seo, array(
										'Type' => 'seo_keyword',
										'Lang' => $this->dbc['Language']?0:1,
										'NotSubmitLi' => 1
									));
								?>
							</td>
							<td>
								<?php
									echo $this->li('SeoDescription', $seo, array(
										'Type' => 'seo_description',
										'Lang' => $this->dbc['Language']?0:1,
										'NotSubmitLi' => 1
									));
								?>
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