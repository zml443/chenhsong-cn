<?php
// c('lang', $_GET['']);
$_side_fload_file = c('root').'themes/__/side_fload/'.(g('wb_service.type')?:'01').'.php';
if (is_file($_side_fload_file)) include $_side_fload_file;
?>