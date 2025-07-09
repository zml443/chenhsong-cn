<?php

$bindTable = t($cfg['Table'][0]);
$one = db::result("select * from {$bindTable} where Id='".$row[$name]."'");

echo $one[$cfg['Cfg']['name']];