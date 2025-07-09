<?php
include '../../../php/init.php';
$res = curl::init($_GET['url']);
header('Content-Type: image/jpeg');
echo $res[0];
?>