<?php

class log {
	// 系统日志
	public static function manage ($table_name, $description) {
		if (!manage('Id') || manage('Id')==-1) {
			return false;
		}
		$referer = str_replace(strstr($_SERVER['HTTP_REFERER'],'?'), '', $_SERVER['HTTP_REFERER']);
		$data = array(
			'wb_manage_id' => (int)manage('Id'),
			'UserName'	=> manage('UserName'),
			'Module' 	=> $table_name,
			'Log' 		=> $description,
			'Ip' 		=> ip::get(),
			'Referer'	=> $referer,
			'AddTime' 	=> c('time'),
			'GetData' 	=> str::json_code(str::json($_GET)),
			'PostData' 	=> str::json_code(str::json($_POST)),
		);
		db::insert('wb_manage_log', $data);
	}

	/**
	 * 会员日志
	 */
	public static function member ($module, $description) {
		/*if (!member('Id')) {
			return false;
		}*/
		$referer = str_replace(strstr($_SERVER['HTTP_REFERER'],'?'), '', $_SERVER['HTTP_REFERER']);
		$data = array(
			'wb_member_id' => (int)member('Id'),
			'UserName'	=> member('UserName'),
			'Module' 	=> $module,
			'Log' 		=> $description,
			'Ip' 		=> ip::get(),
			'Referer'	=> $referer,
			'AddTime' 	=> c('time'),
			'GetData' 	=> str::json_code(str::json($_GET)),
			'PostData' 	=> str::json_code(str::json($_POST)),
		);
		db::insert('wb_member_log', $data);
	}

	// 提醒日志， GroupId = member ， manage  ,  default
	public static function member_tips ($data=array(), $ids='') {
		$data = array_merge($data, array(
			'session_id'	=> c('session_id'),
			'AddTime'	=> c('time'),
		));
		if ((!$data['wb_member_id'] && !$data['wb_manage_id'])) {
			return false;
		}
		$data['Id'] = db::insert('jext_tips', $data);
		$is_member = preg_match('/^member/', $data['GroupId']);
		$is_read = !$data['Url']&&!$data['Fn'] ? 1 : 0; //默认就是阅读状态
		// 按照id
		$aaa = array();
		$idname = $is_member?'wb_member_id':'wb_manage_id';
		if (!is_array($ids)) $ids = explode(',', $ids);
		foreach ($ids as $v) {
			$i = is_array($v) ? (int)$v['Id'] : (int)$v;
			if ($i) $aaa[] = array(
				'TipsId' 	=> $data['Id'],
				'ReadTime' 	=> $is_read,
				$idname		=> $i,
			);
		}
		if ($is_member) db::insert_bat('jext_tips_member', $aaa);
		else db::insert_bat('jext_tips_manage', $aaa);
		
	}
}