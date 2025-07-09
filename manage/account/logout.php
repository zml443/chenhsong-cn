<?php
isset($c)||exit();
log::manage('wb_manage', "退出登录【".manage('UserName')."】");
unset_manage();
str::msg('', 1);