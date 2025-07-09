<?php
// 已被使用的变量
// $name, $value, $row, $cfg


// $table = $this->table;

// $seo = str::code(db::result("select * from data_seo where `ExtTable`='{$table}' and ExtId='{$row['Id']}'"));
$seo = $this->table_copy ? db::seo($this->table_copy, $row['Id']) : db::seo($this->table, $row['Id']);
$seo = (array)str::code($seo);


$cfg = array(
	'Name' => language('{/global.title/}'),
	'Type' => 'text',
	'Lang' => $this->dbc['Language']?0:1
);
echo $this->form_func('SeoTitle', $seo, $cfg);

$cfg = array(
	'Name' => language('{/global.keyword/}'),
	'Type' => 'seo_keyword',
	'Lang' => $this->dbc['Language']?0:1
);
echo $this->form_func('SeoKeyword', $seo, $cfg);

// 
$cfg = array(
	'Name' => language('{/global.brief/}'),
	'Type' => 'textarea',
	'Lang' => $this->dbc['Language']?0:1
);
echo $this->form_func('SeoDescription', $seo, $cfg);
?>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>