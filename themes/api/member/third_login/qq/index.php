<?php
isset($c)||exit;
require_once dirname(__FILE__)."/API/qqConnectAPI.php";
$qc = new QC();
$qc->qq_login();
exit;
?>