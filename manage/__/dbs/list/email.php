<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body>


	<div class="wrap_for_list">
		<div class="wbox_top"><?php include c('dbs.inc').'/title.php';?></div>
		<div class="wbox_list ly_bg_fff">
			<div class="" sticky="{}">
				<div class="ly_bg_fff ly_zindex21 clean"><?php include dirname(__FILE__).'/inc/header2.php';?></div>
			</div>
			<!--  -->
			<section id="dbs_list_box" class="clean">
				<ul class='ly_choice'>
					<?php
						$pg = $_GET['pg']-1;
						$pg<0 && $pg = 0;
						$row = db::get_limit($this->table, $this->where, '*', $this->orderby, $pg*$this->limit, $this->limit);
						foreach ($row as $k => $v) {
							$v = str::code($v);
					?>
			            <li class='notcopy' data-email='<?=$v['Email']?>/<?=$v['UserName']?>'>
			                <?=$v['Email']?><span>/<?=$v['UserName']?></span>
			            </li>
					<?php } ?>
				</ul>
				<input type='hidden' name='ex_na' value='<?=$_GET['ex_na']?>' />
				<input type='hidden' name='ex_id' value='<?=$_GET['ex_id']?>' />
			</section>
			<!--  -->
		</div>
	</div>


</body>
</html>