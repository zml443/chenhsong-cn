<?php
if (member('Id')) {
	log::member('logout', '退出登录');
	unset_member();
	str::msg('退出登录',1);	
} else {
	str::msg('退出登录失败',0);
}
?>