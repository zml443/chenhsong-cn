<?php
// 已被使用的变量
// $name, $value, $row, $cfg
// d($name, $value, $row, $cfg);

?>
<?php if ($cfg['EditLi']) { ?>

	<?php if ($cfg['Lang']) { ?>
		<div mLanguage>
			<?php
				foreach ($this->language as $k => $v) {
					$n = $this->lang($name, $v);
			?>
				<div <?=$k?'hide':''?>>
					<span class='ly_input w200 90 clean'>
						<textarea autoHeight notEnter name='<?=$n?>' dbs="mod-list-input,<?=$row['Id']?>"><?=$row[$n]?></textarea>
					</span>
				</div>
			<?php } ?>
		</div>
	<?php } else { ?>
		<span class='ly_input w200 90 clean'>
			<textarea autoHeight notEnter name='<?=$name?>' dbs="mod-list-input,<?=$row['Id']?>"><?=$row[$name]?></textarea>
		</span>
	<?php } ?>

<?php 
	} else { 
		if ($cfg['Lang']) {
			echo '<div style="min-width:160px">'.nl2br($row[ln($name)]).'</div>';
		}
		else {
			echo '<div style="min-width:160px">'.nl2br($row[$name]).'</div>';
		}
	}
?>