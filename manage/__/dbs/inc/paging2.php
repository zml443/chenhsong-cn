<section class="flex-middle2 <?=$lyCssConf['class']?>" <?=r($lyCssConf,'class')?>>
<?php
	$page = page::html(array(
		// 'type' => 'search2',
		'page' => $_GET['pg'],
		'limit' => $this->limit,
		'total' => (int)db::get_row_count($this->table, $this->where)
	));
	echo $page['html'];
	// echo str_replace('href=', 'hr-ef=', $page['html']);
?>
</section>