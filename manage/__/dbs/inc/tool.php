<section <?=r($lyCssConf)?>>
	<?php 
		if ($this->permit['add']) {
			echo "
				<a class='zml_add_btn mr_5px nowrap' hr-ef='".$this->query_string['add']."'>
					<i class='i lyicon-add-bold flex-max2'></i>
					<span>".language('{/global.add/}')."</span>
				</a>
			";
		}
		/*if ($this->permit['add']) {
			echo "<a class='ly_btn mr_5px' size='small' bg='main' hr-ef='".$this->query_string['add']."'><span>".language('{/global.add/}')."</span></a>";
		}*/
		/*if ($this->permit['edit']&&$this->dbc['UId']) {
			echo "<a class='ly_btn mr_5px' size='small' lydbs-move-category=''><i class='lyicon-switch mr_3px'></i><span>".language('{/global.move_category/}')."</span></a>";
		}
		if ($this->permit['recycle']&&!$_GET['IsDel']) {
			echo "<a class='ly_btn mr_5px' size='small' dbs='recycle'><i class='lyicon-ashbin mr_3px'></i><span>".language('{/global.recycle_bat/}')."</span></a>";
		} else if ($this->permit['del']) {
			$delete_check = '';
			if (is_file($this->path.'/_.delete.check.php')) {
				$delete_check = '?ma='.$_GET['ma'].'/_.delete.check';
			}
			echo "<a class='ly_btn mr_5px' size='small' dbs='del' data-check='{$delete_check}'><i class='lyicon-ashbin mr_3px'></i><span>".language('{/global.del_bat/}')."</span></a>";
		}
		if ($this->permit['recycle']&&$_GET['IsDel']) {
			echo "<a class='ly_btn mr_5px' size='small' dbs='restore'><i class='lyicon-huifu mr_3px'></i><span>".language('{/global.restore_bat/}')."</span></a>";
		}*/
		if ($this->permit['export']) {
			$export_where = '';
			if (is_file($this->path.'/_.export.where.php')) {
				$export_where = '?ma='.$_GET['ma'].'/_.export.where';
			}
			$export_href = '?ma='.$_GET['ma'].'/_.export';
			echo "
				<a class='ly_btn mr_5px' size='small' lydbs-export='' data-href='{$export_href}' data-where='{$export_where}'>
					<i class='lyicon-export mr_3px'></i> <span>{/global.export/}</span>
				</a>
			";
		}
	?>
</section>
