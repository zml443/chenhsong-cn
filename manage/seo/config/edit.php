<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body bg="default">


	<form class="maxvh2 flex-column _dbs_detail_form _do_not_go_to_back" dbs='detail' action="?ma=seo/config&d=post">
		<!--  -->
		<div class='' ly-sticky="top">
			<div class="p_30_0px" bg="default">
				<div class="flex-between" cw='800'>
					<?php $lyCssConf=[]; include c('dbs.inc').'title.php'; ?>
					<?php $lyCssConf=[]; include c('dbs.inc').'lang.php'; ?>
				</div>
			</div>
		</div>
		<!--  -->
		<div class="flex-1 maxw mb_20px" cw="800">
			<div class="_dbs_box">
				<div class="_dbs_item ly-h4"><?=language('panel.tdk_title')?></div>
				<?php
					// 从权限配置里面寻找 SEO 的模块
					$menu = p('manage.permit.allurl');
					$seo = array();
					foreach ($menu as $k => $v) {
						if ($k==='_') {
							continue;
						}
						$tmp_seo = array(
							'title' => language('menu.'.$k.'.s_module_name'),
							'array' => array()
						);
						foreach ($v as $k1 => $v1) {
							if ($k1==='_') {
								continue;
							}
							$na1 = language('menu.'.$k.'.'.$k1.'.module_name');
							if (count($v1)>1) {
								$tmp_seo = array(
									'title' => $na1,
									'array' => array()
								);
								foreach ($v1 as $k2 => $v2) {
									if ($k2==='_') {
										continue;
									}
									$na2 = language('menu.'.$k.'.'.$k1.'.'.$k2.'.module_name');
									if (c("manage.permit.config.$k.$k1.$k2.seo")) {
										$tmp_seo['array'][] = array(
											'title' => $na2,
											'url' => $v2['_']
										);
									}
								}
								if ($tmp_seo['array']) {
									$seo[] = $tmp_seo;
									$tmp_seo = array();
								}
							} else {
								if (c("manage.permit.config.$k.$k1.seo")) {
									$tmp_seo['array'][] = array(
										'title' => $na1,
										'url' => $v1['_']
									);
								}
							}
						}
						if ($tmp_seo['array']) {
							$seo[] = $tmp_seo;
						}
					}
				?>
				<div class='_dbs_item flex-middle2'>
					<table class="ly_table maxw">
						<?php foreach ($seo as $k => $v) { ?>
							<tr class=''>
								<td class='w_1 pr_30px'><?=$v['title']?></td>
								<td class=''>
									<?php
										foreach ($v['array'] as $k1 => $v1) {
											$ary = url::to_array($v1['url']);
											$url = '?u='.$_GET['u'].'&u2='.$ary['u'].'&ma='.$ary['m'].'/'.$ary['a'].'&l=seo';
									?>
										<a class='ly_btn_radius mr_30px' bg="light" size="small" href='<?=$url?>'><?=$v1['title']?></a>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
			<!--  -->
			<div class="_dbs_box">
				<div class="_dbs_item ly-h4"><?=language('panel.tdk_default')?></div>
				<?php 
					$row = g($this->table);
					foreach ($this->layout['field'] as $k => $v) {
						foreach ($v['field'] as $k1 => $v1) {
							echo $this->ed($k1, $row);
						}
					}
				?>
			</div>
			<!--  -->
			<div class="_dbs_box">
				<div class="_dbs_item ly-h4"><?=language('panel.sitemap')?></div>
				<div class='_dbs_item'>
					<div class='ly_btn pointer' bg="main" ly-sitemap><?=language('panel.create_sitemap')?></div>
					<div class="mt_20px">
						<?=language('panel.sitemap_time')?>：<?php
							$sitemap = c('root').'website/'.c('HostName').'/sitemap.xml';
							is_file($sitemap) || $sitemap = c('root').'/sitemap.xml';
							echo date("Y-m-d H:i:s", filemtime($sitemap));
						?>
					</div>
					<div class='mt_10px'>
						<?=language('panel.sitemap_file')?>：<a class="ly_color_a" href='/sitemap.xml' target='_blank'>/sitemap.xml</a>
					</div>
				</div>
			</div>
		</div>

		<div class='_dbs_submit' ly-sticky="bottom">
			<div class="flex-max2 _dbs_submit_chilren">
				<label class='ly_btn width100 pointer' bg="main"><input type='submit'><?=language('{/global.submit/}')?></label>
			</div>
		</div>
		<!--  -->

	</form>


</body>
</html>