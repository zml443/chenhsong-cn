<?php
class saas_db {
	// 填充多语言字段
	public static function fill_page_module_feild(){
		$fields = db::fields('wb_site_page_module');
		$fields2 = db::fields('wb_site_page_module_children');
		$fields3 = db::fields('wb_site_page');
		$fields4 = db::fields('wb_site_page_module_copy');
		$fields5 = db::fields('wb_site_page_module_children_copy');
		$fields6 = db::fields('wb_site_page_copy');
		$language_name = c('language_name');
		// 2023.11.1 旧站点因为缺少该字段，需要补充
		// ===========================
		if (!$fields['wb_site_web_id']) {
			db::query("alter table wb_site_page_module add `wb_site_web_id` int(11) default '0'");
		}
		if (!$fields2['wb_site_web_id']) {
			db::query("alter table wb_site_page_module_children add `wb_site_web_id` int(11) default '0'");
		}
		if (!$fields3['wb_site_web_id']) {
			db::query("alter table wb_site_page add `wb_site_web_id` int(11) default '0'");
		}
		// ===========================
		foreach ($language_name as $k => $v) {
			if (!$fields['Data_'.$k]) {
				db::query("alter table wb_site_page_module add `Data_{$k}` longtext null");
			}
			if (!$fields2['Data_'.$k]) {
				db::query("alter table wb_site_page_module_children add `Data_{$k}` longtext null");
			}
			if (!$fields3['Name_'.$k]) {
				db::query("alter table wb_site_page add `Name_{$k}` longtext null");
			}
			if (!$fields4['Data_'.$k]) {
				db::query("alter table wb_site_page_module_copy add `Data_{$k}` longtext null");
			}
			if (!$fields5['Data_'.$k]) {
				db::query("alter table wb_site_page_module_children_copy add `Data_{$k}` longtext null");
			}
			if (!$fields6['Name_'.$k]) {
				db::query("alter table wb_site_page_copy add `Name_{$k}` longtext null");
			}
		}
	}

	// 导入数据
	public static function insert($style='', $conf=array()){
		self::fill_page_module_feild();
		if ($style=='copy') {
			$table_page = 'wb_site_page_copy';
			$table_page_module = 'wb_site_page_module_copy';
			$table_page_module_children = 'wb_site_page_module_children_copy';
		} else {
			$table_page = 'wb_site_page';
			$table_page_module = 'wb_site_page_module';
			$table_page_module_children = 'wb_site_page_module_children';
		}
		$language_name = c('language_name');
		// 导入单个页面
		if ($conf['page_type']) {
            $page_where = "IsUsed=1";
            if (in_array(c('HostTag'), array('shop', 'shopen'))) {
                $page_where .= " and Tag='shop'";
            } else {
                $page_where .= " and Tag='web'";
            }
			$all = lydb::query("select * from ss_page where $page_where and Type='{$conf['page_type']}' limit 1");
		// 导入整个站点
		} else {
			if (!$conf['ss_web_id']) {
				$web = lydb::result("select * from ss_web where Number='{$conf['web_number']}'");
				if (!$web) {
				    return array('ret'=>0);
				}
				$conf['ss_web_id'] = $web['Id'];
			}
			// 判断是否有站点
			if (!$conf['wb_site_web_id']) {
				db::update('wb_site_web', '1', array('Used'=>0));
				$conf['wb_site_web_id'] = db::insert('wb_site_web', array(
					'Used' => 1,
					'Number' => $conf['web_number'],
					'AddTime' => c('time'),
					'EditTime' => c('time'),
				));
			}
			$all = lydb::query("select * from ss_page where ss_web_id='{$conf['ss_web_id']}'");
		}
		if ($all->num_rows==0) {
		    return array('ret'=>0);
		}
		while ($v = lydb::result($all)) {
	        if ($v['Type']=='other') {
	        	continue;
	        } else {
	        	$page_row = db::result("select * from {$table_page} where Type='{$v['Type']}' and wb_site_web_id='{$conf['wb_site_web_id']}' limit 1");
	        }
	        // 如果已经有页面了，就不录入了
	        if ($page_row) {
	        	continue;
	        }
	        $page = $v;
			foreach ((array)$language_name as $lang => $langv) {
				$page['Name_'.$lang] = $v['Name'];
			}
			$page['wb_site_web_id'] = $conf['wb_site_web_id'];
	        unset($page['Id'], $page['Name'], $page['ss_web_id'], $page['IsUsed'], $page['HavePicture'], $page['Picture'], $page['PictureMobile'], $page['IsRead']);
	        $page['Id'] = db::insert($table_page, str::code($page, 'addslashes'));
		    // 获取模板
		    $module_all = lydb::query("select * from ss_page_module where ss_page_id='{$v['Id']}' order by MyOrder asc,Id asc");
		    while ($v1 = db::result($module_all)) {
	        	// 修补模板类型
	        	if (!$v1['Type'] && is_file(c('module.dir').$v1['Number'].'/index.conf.php')) {
	        		$v1_conf = include c('module.dir').$v1['Number'].'/index.conf.php';
	        		$v1['Type'] = $v1_conf['type'];
	        		$v1['IsLock'] = 1;
	        		lydb::update("ss_page_module", "Id='{$v1['Id']}'", array('Type'=>$v1['Type']));
	        	}
	            $module = $v1;
				$module['wb_site_web_id'] = $conf['wb_site_web_id'];
	            $module['wb_site_page_id'] = $page['Id'];
	            $module['IsLock'] = 1;
				foreach ($language_name as $k => $v) {
					$module['Data_'.$k] = $module['Data'];
				}
	            unset($module['Id'], $module['ss_web_id'], $module['ss_page_id'], $module['Data'], $module['Tag'], $module['IsRead']);
	            $module['Id'] = db::insert($table_page_module, str::code($module, 'addslashes'));
	            // 获取子模板
	            $children_all = lydb::query("select * from ss_page_module_children where ss_page_module_id='{$v1['Id']}' order by MyOrder asc,Id asc");
                while ($v2 = db::result($children_all)) {
                	// 修补模板类型
		        	if (!$v2['Type'] && is_file(c('module.dir').$v2['Number'].'/index.conf.php')) {
		        		$v2_conf = include c('module.dir').$v2['Number'].'/index.conf.php';
		        		$v2['Type'] = $v2_conf['type'];
		        		$v2['IsLock'] = 1;
		        		lydb::update("ss_page_module_children", "Id='{$v2['Id']}'", array('Type'=>$v2['Type']));
		        	}
                    $children = $v2;
					$children['wb_site_web_id'] = $web_id;
                    $children['wb_site_page_id'] = $page['Id'];
                    $children['wb_site_page_module_id'] = $module['Id'];
					foreach ($language_name as $k => $v) {
						$children['Data_'.$k] = $children['Data'];
					}
                    unset($children['Id'], $children['ss_web_id'], $children['ss_page_id'], $children['ss_page_module_id'], $children['Data'], $children['Tag'], $children['IsRead']);
                    $children['Id'] = db::insert($table_page_module, str::code($children, 'addslashes'));
                }
	        }
		}
		return array('ret'=>1);
	}

	// 导入自定义页面
	public static function insert_custom($style='', $conf=array()){
		self::fill_page_module_feild();
		if ($style=='copy') {
			$table_page = 'wb_site_page_copy';
			$table_page_module = 'wb_site_page_module_copy';
			$table_page_module_children = 'wb_site_page_module_children_copy';
		} else {
			$table_page = 'wb_site_page';
			$table_page_module = 'wb_site_page_module';
			$table_page_module_children = 'wb_site_page_module_children';
		}
		$id = db::insert($table_page, array(
			'wb_site_web_id' => $conf['wb_site_web_id'],
			'wb_site_page_data_id' => $conf['wb_site_page_data_id'],
		));
		db::insert($table_page_module, array(
			'IsLock' => 1,
			'Name' => '页面内容',
			'Parts' => 'content',
			'Type' => 'editor',
			'Number' => 'w005/service/detail',
			'wb_site_web_id' => $conf['wb_site_web_id'],
			'wb_site_page_id' => $id,
		));
		return array('ret'=>1);
	}

}
?>