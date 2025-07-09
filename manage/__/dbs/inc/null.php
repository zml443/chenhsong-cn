<?php
$IncludeNull = language('menu.'.implode('.', $this->u));
?>
<div class="zmlnav_null flex-max2 <?=$lyCssConf['class']?>" <?=r($lyCssConf,'class')?>>
	<div class="flex-1">
		<div class="name"><?=$IncludeNull['module_null_title']?></div>
		<div class="brief"><?=$IncludeNull['module_brief']?></div>
		<a class="btn ly_btn_radius pointer" bg="main" hr-ef='<?=$this->query_string['add']?>'><?=$IncludeNull['module_null_add']?></a>
	</div>
	<div class="img"><img src="<?=$IncludeNull['module_null_pic']?>" /></div>
</div>