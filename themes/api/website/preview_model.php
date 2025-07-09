<?php

if ($_POST['unset']) {
	unset($_SESSION['website_preview_model']);
}

exit(str::json(array(
	'msg' => '',
	'ret' => 1
)));