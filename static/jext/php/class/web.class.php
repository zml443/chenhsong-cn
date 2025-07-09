<?php
class web {
	// 变量处理
	public static function code (&$val, $key) {
		// 数组
		if (is_array($val)) {
			foreach ($val as $k => $v) {
				if (preg_match('/\\D/', $k)) $k1 = $key.'.'.$k;
				else $k1 = "{$key}[$k]";
				$val[$k] = self::code($val[$k], $k1);
			}
		}
		return $val;
	}

	// 引用
	public static function quote ($__path, $__one) {
		// 设置变量
		foreach ((array)$__one['Data'] as $k => $v) {
			// 必须是英文字母+下划线+数字
			if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]+/', $k)) continue;
			${$k} = self::code($__one['Data'][$k], '.'.$k, $__one['DataType']);
		}
		// 内容
		if ($__one['use-backup']||$__one['create-backup']) {
			db::set_module_data(array(
				'path' => $__path,
				'use' => true,
				'create' => $__one['create-backup'],
				'clear' => $__one['create-backup']
			));
		}
		// 代号
		$No000 = preg_replace("/[^a-zA-Z0-9_]/",'_', $__one['Number'].($__one['Id']?'_':'').$__one['Id']);
		ob_start();
		if (is_file(c('root').$__path.'/config/var.json')) {
			echo '<script type="text/json" class="'.$No000.'VAR">'.file_get_contents(c('root').$__path.'/config/var.json').'</script>';
		}
		if (is_file(c('root').$__path.'/config/dat.json')) {
			echo '<script type="text/json" class="'.$No000.'DAT">'.file_get_contents(c('root').$__path.'/config/dat.json').'</script>';
		}
		include c('root').$__path.'/index.php';
		$__htm = ob_get_contents();
		ob_clean();
		$__htm = str_replace('No000', $No000, $__htm);
		$__htm = str_replace('Path000', $__path, $__htm);
		// 取消模板数据的备份
		db::clear_module_data();
		// 返回结果
		return $__htm;
	}

	// 获取
	public static function get($pageid, $array, $config=array()){
		$pageid || $pageid = '0';
		$html = '';
		$js = '';
		$css = '';
		foreach ((array)$array as $v) {
			$v = explode('-', $v);
			$one = array(
				'Id'		=>	$v[1],
				'Number'	=>	$v[0],
				'Data'		=>	g("{$$pageid}.{$v[0]}-{$v[1]}"),
				'use-backup' => $config['use-backup'],
				'create-backup' => $config['create-backup'],
			);
			if (is_dir(c('root').'/themes/module/'.$v[0])) {
				$html .= self::quote('/themes/module/'.$v[0], $one);
			}
			$js .= "{$v[0]}*{$v[1]},";
			$css .= "{$v[0]}*{$v[1]},";
		}
		$html = "
			<link rel='stylesheet' href='/themes/module/color.css' />
			<link rel='stylesheet' href='/module/css/i=$css' />
			$html
			<script src='/module/js/i=$js'></script>
		";
		return $html;
	}
}
?>