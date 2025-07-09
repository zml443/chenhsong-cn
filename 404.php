<?php
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
?>
<!DOCTYPE html>
<html lang="<?=c('lang')?>" class="scrollbar">
<head>
	<?php if (saas::$page_url) { ?>
		<link rel='canonical' href='<?=url::domain('', 1).saas::$page_url;?>' />
	<?php } ?>
	<meta name="robots" content="noindex, nofollow">
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<link rel="stylesheet" href="/static/jext/css/global.css">
	<link rel="stylesheet" href="/static/css/404.css">
</head>

<body>
<div id='global_404'>
	<div class='enter'>
		<div class='d_0 i-pic'><img src="/static/images/global/404.jpg" /></div>
		<div class="d_1 i-pic"><img src="/static/images/global/404_0.png" /></div>
		<a class="return_home block" href="<?=server::domain(1);?>">返回首页</a>
	</div>
</div>
<div id="global_tech_support" class="fixed">本网站由高端网站建设服务商——<a href="https://www.szlianya.net/" title="联雅网络" target="_blank">联雅网络</a>提供服务</div>
</body>
</html>