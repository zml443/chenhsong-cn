<?php

if ($this->is_add) {
	$_POST['IsManually'] = 1;
}


if ($_POST['wb_member_id']) {
	$member_id = (int)$_POST['wb_member_id'];
	$member = db::result("select Id,UId from wb_member where Id='{$member_id}'");
	if ($member) {
		$_POST['UId'] = $member['UId'].$member['Id'].',';
	} else {
		unset($_POST['wb_member_id']);
	}
}
