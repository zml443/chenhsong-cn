<?php

// 添加
if ($this->is_add) {
	if ((float)$_POST['FirstPrice']<=0) {
		str::msg('请设置首重', 0);
	}
}
