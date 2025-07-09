<?php

include '../../../../php/init.php';

$Id = (int)$_GET['Id'];
// db::query("update jext_ueditor_mdl set `Times`=`Times`+1");
$row = db::result("select MyEditor from jext_ueditor_mdl where Id={$Id}");
echo $row['MyEditor'];