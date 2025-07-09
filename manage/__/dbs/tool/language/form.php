<?php
// 已被使用的变量
// $name, $value, $row, $cfg





?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<div class="ly_input_suffix" ly-drop-select>
			    <input type="text" value="" placeholder="" />
			    <input type="hidden" name="<?=$name?>" value="<?=$row[$name]?:c("language.0")?>" />
			    <i class="lyicon-arrow-down-bold"></i>
			    <script type="text">
					<?php
						$language = array();
						foreach ($this->language as $k => $v) {
							$language[] = array(
								'label' => language("language.".$v),
								'value' => $v,
							);
						}
						echo str::json($language);
					?>
			    </script>
			</div>

		<!-- 结束 -->
	</div>
</div>