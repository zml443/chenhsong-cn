<?php
// 已被使用的变量
// $name, $value, $row, $cfg


$bindTable = t($cfg['Cfg']['ma']);
$exna = $this->table.'_id';
$exid = (int)$this->row['Id'];
$ids = array();
if ($exid) {
	$res = db::query("select Id,{$exna} from {$bindTable} where {$exna}={$exid}");	
	while ($v = db::result($res)) {
		$ids[] = $v['Id'];
	}
}

?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content flex-middle2'>
		<!-- 开始 -->

			<div class="ly_btn pointer width150" hr-ef="?ma=<?=$cfg['Cfg']['ma']?>&l=selector-side&_popup_right_=1" fn="lydbsHrefIframeBoxFn">
				<?=language('{/global.set/}')?> (<span class="a"><?=count($ids)?></span>)
				<input type="hidden" name="<?=$name?>" value="<?=implode(',', $ids)?>">
			</div>)?>">
			<div class="ml_20px name"><?=count($ids)?></div>

		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script> 