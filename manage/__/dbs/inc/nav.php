<?php if ($mg_nav = permit::nav()) { ?>
	<section class="<?=$lyCssConf['class']?>" <?=r($lyCssConf,'class')?>>
		<?php
			$mg_nav_count = count((array)$mg_nav);
			$mg_nav_btn_class = $mg_nav_count>5?'':'ly_btn';
			foreach ((array)$mg_nav as $k => $v) {
				echo "<a hr-ef='{$v['url']}' class='zml_category {$mg_nav_btn_class} ".($v['cur']?'cur':'')."'>{$v['name']}</a>";
				/*if (strstr($v['url'], 'e=popup')) {
					echo "<a lydbs-popup='' data-url='{$v['url']}' class='zml_category {$mg_nav_btn_class} ".($v['cur']?'cur':'')."'>{$v['name']}</a>";
				} else {
					echo "<a hr-ef='{$v['url']}' class='zml_category {$mg_nav_btn_class} ".($v['cur']?'cur':'')."'>{$v['name']}</a>";
				}*/
			}
		?>
	</section>
<?php } ?>