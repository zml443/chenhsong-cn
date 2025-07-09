<?php
// 已被使用的变量
// $name, $value, $row, $cfg

if ($name_tmp=strstr($name,'[')) {
	$name_tmp = explode('][', substr($name_tmp, 1,-1));
	$row_tmp = $row;
	foreach ($name_tmp as $v) {
		$row_tmp = $row_tmp[$v];
	}
	$json = $row_tmp;
} else {
	$name_tmp = $name;
	$json = str::json(htmlspecialchars_decode($row[$name]), 'decode');
}
// $tds = $copyresult = $result = $tr = "";
if (!$cfg['EditShow']) {
	if ($cfg['Add']) {
		$ext = '.0';
	}
	// foreach ($cfg['Cfg'] as $k => $v) {
	// 	$n = "{$name}{$ext}.{$k}";
	// 	$str = $this->form_func($n, $cfg['Add']?$json[0]:$json, $v);
	// 	$result.=$str;
	// 	if ($cfg['Add']) {
	// 		$n = "____{$name}{$ext}.{$k}";
	// 		$copyresult .= $this->form_func($n, $json[0], $v);
	// 	}
	// }
	foreach ($cfg['Cfg'] as $k => $v) {
		$n = "{$name}{$ext}.{$k}";
		$str = $this->form_func($n, $cfg['Add']?$json[0]:$json, $v);
		$result.=$str;
		if ($cfg['Add']) {
			$n = "____{$name}{$ext}.{$k}";
			$copyresult .= $this->form_func($n, array(), $v);
		}
	}
	if ($cfg['Add']) {
		if (!$json) {
			$tr .= '<tr>';
				$tr .= '<td class="w_1"><span>组1</span></li>';
				$tr .= '<td>'.$result.'</td>';
				$tr .= '<td class="-remove w_1 pointer"><i class="lyicon-ashbin" color="red"></i></td>';
			$tr .= '</tr>';
		}
		foreach ($json as $k => $v ) {
			// if(!$k) continue;
			$ext = ".{$k}";
			$tds = '';
			foreach ($cfg['Cfg'] as $k1 => $v1) {
				$n = "{$name}{$ext}.{$k1}";
				$tds .= $this->form_func($n, $json[$k], $v1);
			}
			$tr .= '<tr class="'.($k?'hide2':'').'">';
				$tr .= '<td class="w_1"><span>组1</span></li>';
				$tr .= '<td>'.$tds.'</td>';
				$tr .= '<td class="-remove w_1 pointer"><i class="lyicon-ashbin" color="red"></i></td>';
			$tr .= '</tr>';
		}
	}
}


?>

<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content -jsontable'>
		<!-- 开始 -->

			<?php if ($cfg['EditShow']) { ?>
				<?=str::ary_html($json);?>
			<?php } else { ?>
				<?php if ($cfg['Add']) { ?>
					<table class="ly_table_line -box maxw margin-bottom-10">
						<tbody><?=$tr?></tbody>
					</table>
					<div class="flex mt_20px" ly-sticky="center" data-type="bottom" bg="white">
						<a class="-add ly_btn" bg="main" size="mini" data-count="<?=$cfg['Count']?>"><?=language('{/global.add/}')?></a>
						<a class="-keep ly_btn ml_10px cur flex-middle2" bg="warning" size="mini">
							<span><?=language('{/global.open/}')?></span>
							<span class="hide2" bg="warning" size="mini"><?=language('{/global.pack_up/}')?></span>
						</a>
					</div>
					<!-- <script class='-copy hide' type="text"><?//=str_replace('</script>', '<\\/script>', $copyresult)?></script> -->
					<div class='-copy hide'><?=$copyresult?></div>
				<?php } else { ?>
					<table class="ly_table_line -box maxw margin-bottom-10">
						<tbody><tr><td class="w_1"></td><td><?=$result?></td></tr></tbody>
					</table>
					<!-- <div></div> -->
				<?php } ?>
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>

<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>