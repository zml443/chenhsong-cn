<ul class="ly_table_strip flex-middle2">
	<li class="r">
		<label class="ly_checkbox lyicon-select-bold" size="big"><input type='checkbox' all='[name=Id]' fn="$dbsChoiceAll"></label>
		<!-- <label class="ly_checkbox lyicon-minus-bold hide" size="big"><input type='checkbox' all='[name=Id]' fn="$dbsChoiceAll"></label> -->
	</li>
	<li class="a"><i class="lyicon-arrow-right-filling fz12"></i></li>
	<li class="n num hide2"></li>
	<?php
		/*if ($this->permit['edit']&&$this->dbc['UId']) {
			echo "<li class='n hide2' lydbs-move-category=''>".language('{/global.move_category/}')."</li>";
		}*/
		if ($this->permit['recycle']&&!$_GET['IsDel']) {
			echo "<li class='n hide2' dbs='recycle'>".language('{/global.recycle_bat/}')."</li>";
		} else if ($this->permit['del']) {
			$delete_check = '';
			if (is_file($this->path.'/_.delete.check.php')) {
				$delete_check = '?ma='.$_GET['ma'].'/_.delete.check';
			}
			echo "<li class='n hide2' dbs='del' data-check='{$delete_check}'>".language('{/global.del_bat/}')."</li>";
		}
		if ($this->permit['recycle']&&$_GET['IsDel']) {
			echo "<li class='n hide2' dbs='restore'>".language('{/global.restore_bat/}')."</li>";
		}
		if ($this->permit['export']) {
			$export_where = '';
			if (is_file($this->path.'/_.export.where.php')) {
				$export_where = '?ma='.$_GET['ma'].'/_.export.where';
			}
			$export_href = '?ma='.$_GET['ma'].'/_.export';
			echo "
				<a class='n hide2' lydbs-export='' data-href='{$export_href}' data-where='{$export_where}'>
					<i class='lyicon-export mr_3px'></i> <span>{/global.export/}</span>
				</a>
			";
		}
	?>
</ul>&nbsp;