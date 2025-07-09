<?php
include '../../../../php/init.php';
// 初始语言包，前后端区分
if ($_GET['GroupId']!='manage') {
	c('manage.lang', c('lang'));
}

$type1 = dirname(__FILE__).'/../cfg/'.($_GET['GroupId']?str_replace('../','',$_GET['GroupId']):'default').'.php';
if (is_file($type1)) {
	include $type1;
} else {
	str::msg('配置错误', 0);
}


$_GET['UId'] || $_GET['UId'] = '0,';
$where1 = " and UId='{$_GET['UId']}'";

if ($_GET['Name']) {
	$where1 .= " and Name like '%{$_GET['Name']}%'";
}

switch ($_GET['Ext']) {
	case 'img':
		$where1 .= " and Name REGEXP '\.(png|jpe?g|gif|ico|webp)'";
		break;
	case 'mp4':
		$where1 .= " and Name REGEXP '\.(mp4|avi|rmv?b?|mov|qt|asf|flv|mpe?g|dat)'";
		break;
	case 'doc':
		$where1 .= " and Name REGEXP '\.(docx?|xlsx?|pdf|ppt|webp)'";
		break;
	case 'mp3':
		$where1 .= " and Name REGEXP '\.(mp3)'";
		break;
	case 'other':
		$where1 .= " and Name REGEXP '\.?!(mp3|docx?|xlsx?|pdf|ppt|webp|mp4|avi|rmv?b?|mov|qt|asf|flv|mpe?g|dat|png|jpe?g|gif|ico|webp)'";
		break;
	default:
		break;
}


$dir = db::query("select * from jext_files where {$__WHERE} and Type=0 {$where1}");
$list = db::query("select * from jext_files where {$__WHERE} and Type=1 {$where1} order by AddTime desc limit ".((int)$_GET['pg']*30).", 30");

$number = db::result("select count(*) as a from jext_files where {$__WHERE} and Type=1", 'a');

// 当前文件夹
$dirs = explode(',', $_GET['UId']);
$DirX = '/ ';
foreach ($dirs as $k => $v) {
	$v = (int)$v;
	if (!$v) continue;
	$name = db::query("select Name from jext_files where Id=$v");
	$name = db::result($name);
	$DirX .= $name['Name'] . ' /';
}

?><!DOCTYPE html>
<html lang='zh-cn'>
<head>
	<meta charset='utf-8' language='<?=c('manage.lang');?>' website-language='<?=c('language');?>' />
	<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
	<link href='../../../../css/lyicon/iconfont.css' rel='stylesheet' type='text/css' />
	<link href='../../../../css/global.css' rel='stylesheet' type='text/css' />
	<link href='../../../../css/ly2ui.css' rel='stylesheet' type='text/css' />
	<script src='../../../../a.js'></script>
	<script src='../../../../b.js'></script>
	<script>
		$.language.cur = '<?=c('manage.lang')?>';
		// $.lang = <?//=str::json(include c('language_pack').c('manage.lang').'/0.php')?>;x
		$.lang = <?=str::json(include c('language_pack.manage').c('manage.lang').'/0.php')?>;
		var _NotChoice_ = <?=(int)$_GET['_NotChoice_']?>;
	</script>
	<script src='list.js'></script>
	<link href='list.css' rel='stylesheet' type='text/css' />
	<style>
		body,html{background:transparent;}
		.wcb_alert_box{width: 90vw;height: 90vh;position: relative;max-width: 1440px;max-height: 900px;overflow: hidden;border-radius: 5px;background: #fff;}
	</style>
</head>
<body class="maxvh flex-max">

	<div class="wcb_alert_box flex-column">
		<!-- <div class="absolute max flex-max" style="z-index: 9;background: rgba(255,255,255,.5)"><i class="lyicon-loading fz38"></i></div> -->
		<!-- 顶部标题 -->
		<div class="wcb_alert_title">
			<div class="">文件选择器</div>
			<div class="at-close lyicon-guanbi pointer"></div>
		</div>
		<!-- 中间区域 -->
		<div class="flex relative flex-1" style="height:0px">
			<!-- 左侧栏 -->
			<div class="wcb_alert_menu flex-column">
				<form class='text-center pt_30px pb_20px xxxxxxxxxxxx'>
					<label class="ly_btn_radius pointer" bg="main" file-upload="<?=url::filter($_GET['GroupId'])?>" fn="bendi.upload">
						<i class="lyicon-add mr_5px"></i><?=language('{/form.file_upload/}')?>
					</label>
					<?php 
						foreach ($_GET as $k => $v) {
							echo '<input type="hidden" name="'.$k.'" value="'.url::filter($v).'">';
						}
					?>
				</form>
				<!--  -->
				<?php
				$jext_files_size = jext_files::size();
				$HostStorageSize = c('HostStorageSize');
				?>
				<div class='text-center mt_15px'><?=language('{/panel.file.storage/}')?>:<span class="HostStorageSizeN ml_5px"><?=file::size($jext_files_size)?> / <?=$HostStorageSize?file::size($HostStorageSize):'--'?></span></div>
				<?php if ($HostStorageSize) { ?>
					<div class="HostStorageSizeP flex" style="background: #ddd;border-radius: 5px;margin: 15px;">
						<div style="width: <?=(int)($jext_files_size/$HostStorageSize*100)?>%;height: 5px;background: var(--mainColor);border-radius: 3px;"></div>
					</div>
				<?php } ?>
				<!-- 预览部分 开始 -->
				<div class='view scrollbar flex-1 height0'></div>
				<!-- 预览部分 结束 -->
			</div>
		
			<!-- 右侧栏 -->
			<div class="wcb_alert_list flex-column flex-1 fz14">
				<!-- 搜索 -->
				<div class='search p_15_20px flex-between'>
					<div class='addnewdir flex-middle2 flex-middle2 pointer'>
						<i class="lyicon-folder-filling fz26 mr_5px" color="main"></i>
						<span><?=language('{/form.new_dir/}')?></span>
						<input type='hidden' name='DirUId' value='<?=url::filter($_GET['UId']);?>'>
					</div>
					<form class="flex-middle2" onsubmit="return bendi.form(this)">
						<?php
						foreach ($_GET as $k => $v) {
							if (in_array($k, array('Ext','Name'))) {
								continue;
							}
							echo "<input type='hidden' name='{$k}' value='".htmlspecialchars($v)."' />";
						}
						?>
						<label class="ly_input_suffix width100" ly-drop-select="" fn="dbs_free_type_fn">
							<input type="text" size="small" placeholder="<?=language('{/form.all_file/}')?>" />
							<input type="hidden" name="Ext" value="<?=htmlspecialchars($_GET['Ext'])?>" />
							<script type="text">
								<?php
								echo str::json(array(
									array(
										'value' => 'img',
										'label' => language('{/form.img_file/}'),
									),
									array(
										'value' => 'mp4',
										'label' => language('{/form.mp4_file/}'),
									),
									array(
										'value' => 'doc',
										'label' => language('{/form.doc_file/}'),
									),
									array(
										'value' => 'mp3',
										'label' => language('{/form.mp3_file/}'),
									),
									array(
										'value' => 'other',
										'label' => language('{/form.other_file/}'),
									),
								));
								?>
							</script>
							<i class="lyicon-arrow-down-bold"></i>
						</label>
						<label class="ly_input width200 ml_10px"><input size="small" type='text' name='Name'></label>
						<label class="ly_btn ml_10px pointer" size="small" bg="main"><input type='submit' class="hide" /><?=language('{/global.search/}')?></label>
					</form>
				</div>
				<!--  -->
				<div class='quanbuwenj flex-1 scrollbar maxw maxh p_15_20px'>
					<div class='pt_10px pb_10px over flex-middle2'>
						<?php if ($_GET['UId']!='0,') { ?>
							<a class="pointer flex-middle2 mr_20px" color="main" onclick="bendi.uid(this)" data-uid="<?=htmlspecialchars(preg_replace('/[^,]+,$/','',$_GET['UId']))?>">
								<i class="lyicon-arrow-left-bold"></i>
								<span><?=language('{/form.back_parent_dir/}')?></span>
							</a>
						<?php } ?>
						<span><?=language('{/form.current_dir/}')?>：</span>
						<span color="text4"><?=$DirX?></span>
						<?php if ($_GET['Name']) { ?>
							<span class="ml_10px" color="text4">--> "<?=htmlspecialchars($_GET['Name'])?>"</span>
						<?php } ?>
					</div>
					<!--  -->
					<!-- 文件夹 -->
					<div class="wenjianjiahezi flex-wrap">
						<?php
						while ($v=db::result($dir)){
							$count = db::get_row_count('jext_files', "($__WHERE) and UId like '{$v['UId']}{$v['Id']},%'");
						?>
							<div class='wcb_fileitem dir'>
								<input type='checkbox' name='Id[]' class='hide' value='<?=$v['Id']?>' />
								<div class='img notcopy'>
									<div class="absolute max m-pic" onclick="bendi.uid(this)" data-uid='<?=$v['UId'].$v['Id']?>,'>
										<img file-ext />
									</div>
									<div class="tool" stopPropagation>
										<a class='wj_delete lyicon-ashbin'></a>
									</div>
									<div class="count absolute" count='<?=$count?>'><?=$count?></div>
								</div>
								<div class="filename" data-id="<?=$v['Id']?>" stopPropagation><?=$v['Name']?></div>
							</div>
						<?php } ?>
					</div>
					<!--  -->
					<div class='wenjbiaoti flex-middle2 <?=$dir->num_rows>0?'':'hide2'?>'>
						<div class="mr_10px"><?=language('{/form.file_list/}')?></div>
						<div class="b-top flex-1"></div>
					</div>
					<!--  -->
					<span class="bendi_file_span_box flex-wrap">
						<?php 
						while ($v=db::result($list)){
							$curday = date('Y.m.d', $v['AddTime']); 
							$curday_str = time::period($v['AddTime']);
						?>
							<label class='wcb_fileitem file'>
								<input type='checkbox' name='Id[]' class='hide' value='<?=$v['Id']?>' data-uid="<?=$v['UId'].$v['Id'].','?>" data-file='<?=$v['Path']?>' fn="bendi.choice" />
								<div class='img notcopy choice'>
									<div class="absolute max m-pic"><img file-ext='<?=img::cut($v['Path'], 200, 200)?>' /></div>
									<div class="tool" stopPropagation>
										<a class='wj_delete lyicon-ashbin' title='<?=language('global.del')?>'></a>
										<a href='<?=$v['Path']?>' class='lyicon-browse' title='<?=language('global.view')?>' target='_blank'></a>
									</div>
									<div class="bianji" stopPropagation>
										<a class='lyicon-link' title='<?=language('global.copy')?>' ly-text-copy="<?=$v['Path']?>"></a>
										<!-- <a class='lyicon-bianji' jfile-mod="<?=$v['Id']?>" title='<?=language('global.edit')?>'></a> -->
									</div>
									<div class='move lyicon-export' stopPropagation title='<?=language('form.move_file_to')?>'></div>
									<div class="is_check lyicon-select-bold"></div>
								</div>
								<div class="filesize mt_5px">size：<?=$v['Width'].'×'.$v['Height']?></div>
								<div class="filename" data-id="<?=$v['Id']?>" stopPropagation><?=$v['Name']?></div>
							</label>
						<?php } ?>
					</span>
					<div ajax-append="{page:1}" to=".bendi_file_span_box" visible="_visible_ajax_page" href="?<?=url::filter($_SERVER['QUERY_STRING'])?>" style="height:9px;"></div>
				</div>
			</div>
			
			<!-- 裁剪盒子 -->
			<div class="wcb_alert_cropper">
				<div class="ly_cropper"></div>
			</div>
		</div>

		<!-- 底部按钮 -->
		<div class="wcb_alert_btn flex-middle2 flex-right">
			<div class="number flex-1"><span>0</span> / <?=$number?></div>
			<div class="prev flex-btn hide2"><?=language('{/global.prev/}')?></div>
			<div class="next flex-btn hide2"><?=language('{/global.next/}')?></div>
			<div class="tocrop flex-btn hide2"><?=language('{/panel.cropper.to/}')?></div>
			<div class="cancel flex-btn hide2"><?=language('{/global.skip/}')?></div>
			<div class="at-confirm flex-btn fix"><?=$_GET['_NotChoice_']?language('{/global.close/}'):language('{/global.confirm/}')?></div>
			<div class="submit flex-btn hide2 fix"><span><?=language('{/panel.cropper.to/}')?></span><span><?=language('{/panel.cropper.success/}')?></span></div>
		</div>

		<!-- 上传进度 开始 -->
		<div class="bd_jd_tishi hide">
			<div class="closes absolute pointer" onclick="$(this).parent().hide()">✕</div>
			<div class="box absolute max scrollbar"><ul class="ul"></ul></div>
		</div>
		<!-- 上传进度 结束 -->
	</div>
</body>
</html>