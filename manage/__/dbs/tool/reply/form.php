<?php
// 已被使用的变量
// $name, $value, $row, $cfg

$field_key = array();
foreach ($cfg['Field'] as $k => $v) $field_key[] = $k;
$text_name = $field_key[0];
$open_name = $field_key[1];

?>
<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<label class='switchery ml_5px'>
			<input type='checkbox' value='1' <?=$row[$open_name]?'checked':''?> fn="__dbs_reply_" />
			<input type='hidden' name='<?=$open_name?>' value='<?=$open?'1':'0'?>' />
		</label>
		<?php if ($cfg['Lang']) { ?><span class='langselbox'></span><?php } ?>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
			
			<span class='ly_input h90 mt_10px'>
				<textarea autoHeight name='<?=$text_name?>'><?=$row[$text_name]?:$cfg['Value']?></textarea>
			</span>

		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>