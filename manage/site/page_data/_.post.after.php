<?php
function_exists('c')||exit();

if ($this->is_add) {
	/*$has = db::result("select Id from wb_site_page_module where Id='".$this->row['Id']."' and Type='editor'");
	if (!$has) {
		db::insert('wb_site_page_module', array(
			'IsLock' => 1,
			'Name' => '页面内容',
			'Parts' => 'content',
			'Type' => 'editor',
			'Number' => 'w000/custom/editor',
			'wb_site_page_id' => $this->row['Id'],
		));
	}*/
}