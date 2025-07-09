<?php if ($this->search_xz) { ?>
	<section class="flex-middle2 flex-wrap <?=$lyCssConf['class']?>">
		<?php 
			foreach ($this->search_xz as $k => $v) {
				echo "
				<div class='zml_search_xz flex-max2 mr_10px'>
					<span class='mr_3px'>".$v['name'].":</span>
					<span class='mr_5px'>".($v['value']?:implode(',',(array)$v['values']))."</span>
					<i class='i lyicon-close flex-max2' onclick='lydbs_search_data.delete_xz(this)' data-name='".$v['get']."' to='.wangzhanshousuoform'></i>
				</div>";
			}
		?>
	</section>
<?php }?>