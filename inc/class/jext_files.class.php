<?php
class jext_files {

	public static function size(){
		$size = db::result("select sum(Size) as a from jext_files where GroupId in('manage','manage_default')", 'a');
		return $size;
	}


}
