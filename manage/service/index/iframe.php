<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>
<style>
	:root{
		--mainColor: <?=g('website.mainColor')?>;
	}
</style>
<body class="manage-preview-body">
	<?php
		$file = c('root').'themes/__/side_fload/'.str_replace('..','',$_GET['number']).'.php';

		if (is_file($file)) include $file;
	?>
	
</body>
</html>