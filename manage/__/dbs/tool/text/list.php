<?php
// 已被使用的变量
// $name, $row, $cfg


?>

<?php if ($cfg['EditLi']) { ?>

	<?php if ($cfg['Lang']) { ?>
		<div mLanguage>
			<?php
				foreach ($this->language as $k => $v) {
					$n = $this->lang($name, $v);
			?>
				<div <?=$k?'hide':''?>>
					<span class='ly_input w160 clean'>
						<textarea autoHeight notEnter name='<?=$n?>' dbs="mod-list-input,<?=$row['Id']?>"><?=$row[$n]?></textarea>
					</span>
				</div>
			<?php } ?>
		</div>
	<?php } else { ?>
		<span class='ly_input w160 clean'>
			<textarea autoHeight notEnter name='<?=$name?>' dbs="mod-list-input,<?=$row['Id']?>"><?=$row[$name]?></textarea>
		</span>
	<?php } ?>

<?php 
	} else { 
		if ($cfg['Lang']) {
			echo $row[ln($name)];
		}
		else {
			echo $row[$name];
		}
	}
?>