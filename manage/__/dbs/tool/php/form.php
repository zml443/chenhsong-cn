<?php
// 已被使用的变量
// $name, $value, $row, $cfg

// d($name, $value, $row, $cfg);

$rand = str::rand();
?>

<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<div class="-html-ace">
				<ul class="tab flex" tab="{}" to=".-html-ace .con.t<?=$rand?>">
					<li class="li">html</li>
					<li class="li">php</li>
					<li class="li">js</li>
					<li class="li">css</li>
				</ul>
				<ul class="con t<?=$rand?>">
					<div acode="" autoheight mode="php"><textarea name='<?=$name?>Html' hide><?=$row[$name.'Html']?></textarea></div>
					<div acode="" autoheight mode="php"><textarea name='<?=$name?>Php' hide><?=$row[$name.'Php']?></textarea></div>
					<div acode="" autoheight mode="javascript"><textarea name='<?=$name?>Js' hide><?=$row[$name.'Js']?></textarea></div>
					<div acode="" autoheight mode="css"><textarea name='<?=$name?>Css' hide><?=$row[$name.'Css']?></textarea></div>
				</ul>
			</div>

		<!-- 结束 -->
	</div>
</div>