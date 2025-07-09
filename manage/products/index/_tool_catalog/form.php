<?php
// 已被使用的变量
// $name, $prefix_name, $row, $cfg
?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
			<?/*?>
			<div hr-ef="?ma=<?=$cfg['Cfg']['ma']?>&_alert_side_=1&<?=$name?>=<?=$row['Id']?>">
                <div class="ly_btn pointer width150" bg="main"><?=$cfg['Name']?></div>
            </div>
			<?*/?>

			<?php if ($this->is_add) {?>

				<div class="ly_btn pointer width150" bg="main" onclick="products_color(this)"><?=$cfg['Name']?></div>
			<?php } else { ?>
				<div hr-ef="?ma=<?=$cfg['Cfg']['ma']?>&_alert_side_=1&wb_products_id=<?=$row['Id']?>" class="ly_btn pointer width150" bg="main">
					<?=$cfg['Name']?>
				</div>
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>

<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>