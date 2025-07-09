<?php

// 防止胡乱进入
isset($c) || exit;


?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<link rel="stylesheet" href="/themes/default/css/svg.css">
<body>
	
	<?php include 'inc/header.php'; ?>

	<?php include 'inc/banner.php'; ?>
	
{{(content_html)}}

	<?php include 'inc/footer.php'; ?>

	<?php include 'inc/side_fload.php'; ?>
	
	<?php include 'inc/third.php'; ?>
	
</body>
</html>