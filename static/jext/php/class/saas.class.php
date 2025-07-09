<?php
class saas {
	public static $row = array();
	public static $page_url = '';
	public static $is404 = array();
	public static $seo = array();
	public static $header_include = array(); //头部导入
	public static $parts_current = array();
	public static $page_current = array();
	public static $page_config = array();
	// 导入条件筛选ui
	public static function include_filter_html($lyCssConf){
		foreach ($lyCssConf as $k => $v) {
			$$k = $v;
		}
		if (is_file($file)) {
			include $file;
		} else if (is_file(c('root').$file)) {
			include c('root').$file;
		}
		// return $html;
	}
	// 引用
	public static function quote ($__module, $__config=array()) {
		if (!$__module || (!$__module['inline'] && $__module['is_hide'])) {
			return array(
				'js' => '',
				'css' => '',
				'html' => '',
				'variable' => array(),
			);
		}
		if (!is_dir(c('module.dir').$__module['path'])) {
			return array(
				'js' => '',
				'css' => '',
				'html' => '<div class="temp_null_div flex-max2" style="height:200px;background:#f1f1f1;font-size:20px;color:#000;">'.$__module['path'].'</div>',
				'variable' => array(),
			);
		}
		// 代号
		$No000 = preg_replace("/[^a-zA-Z0-9_]/",'_', strtolower($__module['path']).'_'.$__module['id']);
		$Path000 = c('module.path').trim($__module['path'], '/');
		// 代码
		$__css = '';
		$__js = '';
		$__html = '';
		$__variable = array();
		$__children_module = array();
		// 子模块
		foreach ((array)$__module['children'] as $k => $v) {
			$res = self::quote($v);
			$__css .= $res['css'];
			$__js .= $res['js'];
			$__children_module[] = $res['html'];
		}
		// 提取变量
		// d($__module['variable']);
		foreach ((array)$__module['variable'] as $k => $v) {
			if (is_array($v) && $v['Value']) {
				$$k = $v['Value'];
			} else {
				$$k = array();
			}
			if ($__config['variable']) $__variable[$k] = $$k;
			self::$header_include[] = saas_inc::append($v);
		}
		$__variable_file = c('module.dir').$__module['path'].'/index.db.php';
		if (is_file($__variable_file)) {
			$__variable_array = include $__variable_file;
			foreach ($__variable_array as $k => $v) {
				$$k = $v;
				if ($__config['variable']) $__variable[$k] = $$k;
			}
		}
		// 只返回数据
		if ($__config['variable']) {
			return array(
				'variable' => $__variable
			);
		}
		// 返回内嵌式代码
		if ($__config['inline']) {
			ob_start();
			include c('module.dir').$__module['path'].'/index.php';
			echo "<style>";
				include c('module.dir').$__module['path'].'/index.css';
				$__lang_css = c('module.dir').$__module['path'].'/index.'.c('lang').'.css';
				if (is_file($__lang_css)) include $__lang_css;
			echo "</style>";
			echo "<script>";
				include c('module.dir').$__module['path'].'/index.js';
			echo "</script>";
			$__html = ob_get_contents();
			ob_clean();
		} else {
			// 按照文件导入方式返回代码
			ob_start();
			include c('module.dir').$__module['path'].'/index.php';
			$__html = ob_get_contents();
			ob_clean();
			ob_start();
			include c('module.dir').$__module['path'].'/index.css';
			$__lang_css = c('module.dir').$__module['path'].'/index.'.c('lang').'.css';
			if (is_file($__lang_css)) include $__lang_css;
			$__css .= ob_get_contents();
			ob_clean();
			ob_start();
			include c('module.dir').$__module['path'].'/index.js';
			$__js .= ob_get_contents();
			ob_clean();
		}
		$__js = str_replace(array('No000', 'Path000'), array($No000, $Path000), $__js)."\r\n\r\n";
		$__css = str_replace(array('No000', 'Path000'), array($No000, $Path000), $__css)."\r\n\r\n";
		$__html = str_replace(array('No000', 'Path000'), array($No000, $Path000), $__html);
		/////////////////////////////////////////////

		$__class = '';
		$__module['is_hide'] && $__class .= 'absolute goaway';
		if ($__module['is_children_module']) {
			$__html = "<children-module class='block clean {$__class}' keyname='{$__module['id']}'>{$__html}</children-module>";
		} else {
			if ($__module['type']=='header') {
				if (self::$parts_current['opacity']) {
					$__html = "<module class='block clean {$__class} module-{$__module['type']}' parts='{$__module['parts']}' type='{$__module['type']}' keyname='{$__module['id']}'>{$__html}</module>";
				} else {
					$__html = "<module class='block {$__class} module-{$__module['type']}' parts='{$__module['parts']}' type='{$__module['type']}' keyname='{$__module['id']}'>{$__html}</module>";
				}
			} else {
				$__html = "<module class='block clean {$__class} module-{$__module['type']}' parts='{$__module['parts']}' type='{$__module['type']}' keyname='{$__module['id']}'>{$__html}</module>";
			}
		}
		// 返回结果
		return array(
			'js' => $__js,
			'css' => $__css,
			'html' => $__html,
		);
	}

	// 合并变量
	public static function merge_variable($one){
		// 默认配置
		$path = str_replace('..', '', $one['Number']);
		$module_dir = c('module.dir').$path.'/';
		$index_cn = $module_dir.'index.conf.php';
		$index_en = $module_dir.'index.conf.en.php';
		if (!is_dir($module_dir)) {
			$module = array(
				'is_null' => 1
			);
		} else if (c('lang')=='cn' || c('lang')=='tc' || !is_file($index_en)) {
			$module = include $index_cn;
		} else {
			$module = include $index_en;
		}
		$module['id'] = $one['Id'];
		$module['path'] = $one['Number'];
		$module['is_hide'] = $one['IsHide'];
		$module['is_lock'] = $one['IsLock'];
		$module['parts'] = $one['Parts'];
		// 指定模板配置
		// 代號
		if ($one[ln('Data')]) {
			if(is_array($one[ln('Data')])){
				$mod_data = $one[ln('Data')];
			} else {
				$mod_data = str::json($one[ln('Data')], 'decode');
			}
			foreach ((array)$mod_data as $k => $v) {
				if ($k=='variable' && $v && is_array($v)) {
					foreach ($v as $k1 => $v1) {
						$module['variable'][$k1]['TempValue'] = $module['variable'][$k1]['Value'];
						if ($module['variable'][$k1]) $module['variable'][$k1]['Value'] = saas_arr::deal($v1['Value'], $module['variable'][$k1]);
					}
				}
			}
		}
		str::replace('Path000', c('module.path').$one['Number'].'/', $module);
		return $module;
	}

	public static function conf_copy($setting){
		if ($_GET['_inline_view_']) {
			$setting['inline'] = 1;
		}
		$id = (int)$setting['id'];
		$page_id = (int)$setting['page_id'];
		$type = $setting['type'];
		if ($setting['check_local']) {
			// 本地检查 - 扫描模板
			new saas_scan(array(
				'web_number' => c('HostName'),
				'page_type' => $type,
			));
		}
		$web = db::result("select * from wb_site_web where Used=1 limit 1");
		if (!$web) {
			return array();
		}
		if ($id) {
			$page_data = db::result("select * from wb_site_page_data where Id='{$id}' limit 1");
			if ($page_data) {
				$page_sql = "select * from wb_site_page_copy where wb_site_page_data_id='{$page_data['Id']}' and wb_site_web_id='{$web['Id']}' limit 1";
				$page = db::result($page_sql);
				if (!$page) {
					$result = saas_db::insert_custom('copy', array(
						'wb_site_web_id' => $web['Id'],
						'wb_site_page_data_id' => $page_data['Id'],
					));
					if ($result['ret']==1) {
						$page = db::result($page_sql);
					} else {
						return array();
					}
				}
			} else {
				return array();
			}
		} else if ($page_id) {
			$page = db::result("select * from wb_site_page_copy where Id='{$page_id}' limit 1");
		} else {
			$page_sql = "select * from wb_site_page_copy where Type='{$type}' and wb_site_web_id='{$web['Id']}' limit 1";
			$page = db::result($page_sql);
			$result = saas_db::insert('copy', array(
				'wb_site_web_id' => $web['Id'],
				'page_type' => $type,
				'check_local' => $setting['check_local']
			));
			if ($result['ret']==1) {
				$page = db::result($page_sql);
			}
		}
		// 获取页面类型
		// $page_type = lydb::result("select * from ss_page_type where Name='{$page['Type']}' limit 1");
		// d($page_type);
		if ($setting['module_id']) {
			$module_id = explode(',', $setting['module_id']);
			$module_ids = "0";
			foreach ($module_id as $v) {
				$module_ids .= ",".(int)$v;
			}
			$where = " and Id in($module_ids)";
		} else {
			$where = '';
		}
		$config = array(
			'id' => $page['Id'],
			'wb_site_page_data_id' => $page['wb_site_page_data_id'],
			'title' => $page['Name'],
			'header_opacity' => $page['HeaderOpacity']?:'default',
			'is_hidden' => $page['IsHidden'],
			'type' => $page['Type'],
			'width' => $page['Width'],
			'style' => $page['Style'],
			'is_only_content' => $setting['is_only_content'],
			'wrap' => 'default',
			'inline' => $setting['inline'],
			'variable' => $setting['variable'],
			'pure' => $setting['pure'], // 是否需要纯净的HTML代码
			'parts' => array(),
		);
		if (!$_GET['_inline_view_'] && $config['is_hidden']) {
			return $config;
		}
		// 先获取子模板
		$children = db::query("select * from wb_site_page_module_children_copy where wb_site_page_id='{$page['Id']}' and wb_site_web_id='{$web['Id']}' {$where} order by MyOrder asc,Id asc");
		$children_row = array();
		while ($v = db::result($children)) {
			$vc = self::merge_variable($v);
			if ($vc['is_null']) continue;
			$vc['inline'] = $setting['inline'];
			$vc['is_children'] = true;
			$children_row[$v['wb_site_page_module_id']] || $children_row[$v['wb_site_page_module_id']] = array();
			$children_row[$v['wb_site_page_module_id']][] = $vc;
		}
		// 
		if (!$config['is_only_content']) {
			$header = db::query("select * from wb_site_page_module_copy where Parts='header' and wb_site_web_id='{$web['Id']}' {$where} order by MyOrder asc,Id asc");
			$header_row = array();
			while ($v = db::result($header)) {
				$v['IsLock'] = 1;
				$v['Parts'] = 'header';
				$vc = self::merge_variable($v);
				if ($vc['is_null']) continue;
				$vc['inline'] = $setting['inline'];
				if ($children_row[$v['Id']]) {
					$vc['children'] = $children_row[$v['Id']];
				}
				$header_row[] = $vc;
			}
			$config['parts']['header'] = array(
				'module' => $header_row
			);
		}
		// 
		$content = db::query("select * from wb_site_page_module_copy where wb_site_page_id='{$page['Id']}' and wb_site_web_id='{$web['Id']}' and Parts='content' {$where} order by MyOrder asc,Id asc");
		$content_row = array();
		while ($v = db::result($content)) {
			$v['Parts'] = 'content';
			$vc = self::merge_variable($v);
			if ($vc['is_null']) continue;
			$vc['inline'] = $setting['inline'];
			if ($children_row[$v['Id']]) {
				$vc['children'] = $children_row[$v['Id']];
			}
			$content_row[] = $vc;
		}
		$config['parts']['content'] = array(
			'module' => $content_row
		);
		// 
		if (!$config['is_only_content']) {
			$footer = db::query("select * from wb_site_page_module_copy where Parts='footer' and wb_site_web_id='{$web['Id']}' {$where} order by MyOrder asc,Id asc");
			$footer_row = array();
			while ($v = db::result($footer)) {
				$v['IsLock'] = 1;
				$v['Parts'] = 'footer';
				$vc = self::merge_variable($v);
				if ($vc['is_null']) continue;
				$vc['inline'] = $setting['inline'];
				if ($children_row[$v['Id']]) {
					$vc['children'] = $children_row[$v['Id']];
				}
				$footer_row[] = $vc;
			}
			$config['parts']['footer'] = array(
				'module' => $footer_row
			);
		}
		// 结束返回配置
		return $config;
	}
	public static function conf($setting){
		if ($_GET['_inline_view_']) {
			$setting['inline'] = 1;
		}
		if (saas::$is404) {
			return array();
		}
		if (saas::$row && saas::$row['PageUrl'] && !page_url::$is_used) {
			return array();
		}
		$id = (int)$setting['id'];
		$type = $setting['type'];
		if ($id) {
			$page_data = db::result("select * from wb_site_page_data where Id='{$id}' limit 1");
			if ($page_data) {
				// $page_sql = "select * from wb_site_page where wb_site_page_data_id='{$page_data['Id']}' and wb_site_web_id='{$web['Id']}' limit 1";
				$page_sql = "select * from wb_site_page where wb_site_page_data_id='{$page_data['Id']}' limit 1";
				$page = db::result($page_sql);
				if (!$page) {
					$result = saas_db::insert_custom('', array(
						'wb_site_web_id' => 0,
						'wb_site_page_data_id' => $page_data['Id'],
					));
					if ($result['ret']==1) {
						$page = db::result($page_sql);
					} else {
						return array();
					}
				}
			} else {
				return array();
			}
		} else {
			$page = db::result("select * from wb_site_page where Type='{$type}' limit 1");
			if (!$page) {
				$result = saas_db::insert('', array(
					'wb_site_web_id' => 0,
					'page_type' => $type,
				));
				if ($result['ret']==1) {
					$page = db::result("select * from wb_site_page where Type='{$type}' limit 1");
				}
			}
		}
		// 获取页面类型
		// $page_type = lydb::result("select * from ss_page_type where Name='{$page['Type']}' limit 1");
		// d($page_type);
		if ($setting['module_id']) {
			$module_id = explode(',', $setting['module_id']);
			$module_ids = "0";
			foreach ($module_id as $v) {
				$module_ids .= ",".(int)$v;
			}
			$where = " and Id in($module_ids)";
		} else {
			$where = '';
		}
		$config = array(
			'id' => $page['Id'],
			'title' => $page['Name'],
			'header_opacity' => $page['HeaderOpacity']?:'default',
			'is_hidden' => $page['IsHidden'],
			'is_only_content' => $setting['is_only_content'],
			'type' => $page['Type'],
			'width' => $page['Width'],
			'wrap' => 'default',
			'style' => $page['Style'],
			'inline' => $setting['inline'],
			'variable' => $setting['variable'],
			'pure' => $setting['pure'], // 是否需要纯净的HTML代码
			'parts' => array(),
		);
		if (!$_GET['_inline_view_'] && $config['is_hidden']) {
			return $config;
		}
		// 先获取子模板
		$children = db::query("select * from wb_site_page_module_children where wb_site_page_id='{$page['Id']}' {$where} order by MyOrder asc,Id asc");
		$children_row = array();
		while ($v = db::result($children)) {
			$vc = self::merge_variable($v);
			if ($vc['is_null']) continue;
			$vc['inline'] = $setting['inline'];
			$vc['is_children'] = true;
			$children_row[$v['wb_site_page_module_id']] || $children_row[$v['wb_site_page_module_id']] = array();
			$children_row[$v['wb_site_page_module_id']][] = $vc;
		}
		// 
		if (!$config['is_only_content']) {
			$header = db::query("select * from wb_site_page_module where Parts='header' {$where} order by MyOrder asc,Id asc");
			$header_row = array();
			while ($v = db::result($header)) {
				$v['IsLock'] = 1;
				$v['Parts'] = 'header';
				$vc = self::merge_variable($v);
				if ($vc['is_null']) continue;
				$vc['inline'] = $setting['inline'];
				if ($children_row[$v['Id']]) {
					$vc['children'] = $children_row[$v['Id']];
				}
				$header_row[] = $vc;
			}
			$config['parts']['header'] = array(
				'module' => $header_row
			);
		}
		// 
		$content = db::query("select * from wb_site_page_module where wb_site_page_id='{$page['Id']}' and Parts='content' {$where} order by MyOrder asc,Id asc");
		$content_row = array();
		while ($v = db::result($content)) {
			$v['Parts'] = 'content';
			$vc = self::merge_variable($v);
			if ($vc['is_null']) continue;
			$vc['inline'] = $setting['inline'];
			if ($children_row[$v['Id']]) {
				$vc['children'] = $children_row[$v['Id']];
			}
			$content_row[] = $vc;
		}
		$config['parts']['content'] = array(
			'module' => $content_row
		);
		// 
		if (!$config['is_only_content']) {
			$footer = db::query("select * from wb_site_page_module where Parts='footer' {$where} order by MyOrder asc,Id asc");
			$footer_row = array();
			while ($v = db::result($footer)) {
				$v['IsLock'] = 1;
				$v['Parts'] = 'footer';
				$vc = self::merge_variable($v);
				if ($vc['is_null']) continue;
				$vc['inline'] = $setting['inline'];
				if ($children_row[$v['Id']]) {
					$vc['children'] = $children_row[$v['Id']];
				}
				$footer_row[] = $vc;
			}
			$config['parts']['footer'] = array(
				'module' => $footer_row
			);
		}
		// 结束返回配置
		return $config;
	}

	public static function config($setting){
		if ($_SESSION['website_preview_model']) {
			return self::conf_copy($setting);
		} else {
			return self::conf($setting);
		}
	}

	// 通过文件获取配置
	public static function file_conf($file){
		$config = include $file;
		$config['id'] = 0;
		$config['inline'] = 1;
		$data_ln = ln('Data');
		foreach ($config['parts'] as $k => $v) {
			foreach ((array)$v['module'] as $k1 => $v1) {
				if ($v1['children']) {
					$v1_children = $v1['children'];
				} else {
					$v1_children = 0;
				}
				$v1 = self::merge_variable(array(
					'Id' => 0,
					'Number' => $v1['path'],
					$data_ln => array(
						'variable' => $v1['variable']
					),
				));
				$v1['inline'] = 1;
				if ($v1_children) {
					foreach ($v1_children as $k2 => $v2) {
						$v2 = self::merge_variable(array(
							'Id' => str::rand(15),
							'Number' => $v2['path'],
							$data_ln => array(
								'variable' => $v2['variable']
							),
						));
						$v2['inline'] = 1;
						$v2['is_children_module'] = 1;
						$v1['children'][] = $v2;
					}
				}
				$config['parts'][$k]['module'][$k1] = $v1;
			}
		}
		return $config;
	}

	// 解析配置文件
	public static function html($setting){
		////////////////////////////////////////////////////////////////////
		if (is_string($setting)) {
			$config = self::file_conf($setting);
			$config['is_config_file'] = 1;
		} else {
			$config = self::config($setting);
		}
		if (!$config) {
			return '';
		}
		// 列表页面隐藏后调用指定的其它页面
		if (!$_GET['_inline_view_'] && !$config['is_config_file'] && $config['is_hidden']) {
			// 重置 $_GET 参数，参数必须是确定的
			if (in_array($config['type'], array('products', 'server', 'solution', 'case'))) {
				if ($_GET['id']) {
					$_GET['cid'] = $_GET['id'];
					unset($_GET['id']);
				}
			}
			// 重新获取页面
			switch ($config['type']) {
				case 'products':
					$setting = array(
						'type' => 'products-detail',
					);
					break;
				case 'server':
					$setting = array(
						'type' => 'server-detail',
					);
					break;
				case 'solution':
					$setting = array(
						'type' => 'solution-detail',
					);
					break;
				case 'case':
					$setting = array(
						'type' => 'case-detail',
					);
					break;
			}
			$config = self::config($setting);
		}
		self::$page_config = $config;
		$html = array();
		$variable = array();
		$js = '';
		$css = '';
		foreach ($config['parts'] as $k0 => $v0) {
			self::$parts_current = $v0;
			foreach ((array)$v0['module'] as $k1 => $v1) {
				$res = self::quote($v1, array(
					'inline' => $config['inline'],
					'variable' => $config['variable'],
					'pure' => $config['pure'],
					'wrap' => $config['wrap'],
					'is_config_file' => $config['is_config_file'],
					'check_local' => $config['check_local'],
				));
				$js .= $res['js'];
				$css .= $res['css'];
				$variable[$v1['path']] = $res['variable'];
				$html[$k0] .= $res['html'];
			}
		}
		if ($config['variable']) {
			return $variable;
		}
		if (!$config['inline']) {
			file::write_php(c('website.dir').'/page/'.$config['id'].'/js.js', $js);
			file::write_php(c('website.dir').'/page/'.$config['id'].'/css.css', $css);
		}
		if ($config['pure']) {
			return $html['header'].$html['content'].$html['footer'];
		} else {
			if ($config['wrap']=='side') {
				return include __DIR__.'/saas/side.php';
			} else {
				return include __DIR__.'/saas/default.php';
			}
		}
	}
}

include_once c('root').'inc/seo.php';

?>