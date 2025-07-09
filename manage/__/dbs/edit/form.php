<form>
	<?php 
		if ($this->dbg) {
			$row = $this->row = g($this->table);
		} else {
			$Id = (int)$_GET['Id'];
			$row = $this->row = str::code(db::result("select * from {$this->table} where Id='{$Id}'"));
		}
		foreach ($this->layout['field'] as $k => $v) {
			foreach ($v['field'] as $k1 => $v1) {
				echo $this->ed($k1, $row);
			}
		}
		foreach ($this->layout['right'] as $k => $v) {
			foreach ($v['field'] as $k1 => $v1) {
				echo $this->ed($k1, $row);
			}
		}
	?>
	<input type='hidden' name='Id' value='<?=$row['Id']?>'>
</form>
