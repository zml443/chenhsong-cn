<?php

// 防止胡乱进入
isset($c) || exit;


?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<link rel="stylesheet" href="/themes/default/css/svg.css">
<body>
	
	
	<?php 
		$_side_fload_file = c('root').'themes/__/side_fload/'.$_GET['n'].'.php';
		if (is_file($_side_fload_file)) include $_side_fload_file;
	 ?>
	
</body>
</html>