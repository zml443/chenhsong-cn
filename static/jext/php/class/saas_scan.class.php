<?php
class saas_scan {
	public $dir = ''; //模板目录
	public $web_number = ''; //站点编号
	public $page_type = ''; //页面类型
	public $all_local_module = array(); //全部本地模板

	// public $table_page = ''; //编号
	// public $table_page_module = ''; //编号
	// public $table_page_module_children = ''; //编号

	// 
	public function __construct($setting){
		/*if ($setting['is_copy']) {
			$this->table_page = 'wb_site_page_copy';
			$this->table_page_module = 'wb_site_page_module_copy';
			$this->table_page_module_children = 'wb_site_page_module_children_copy';
		} else {
			$this->table_page = 'wb_site_page';
			$this->table_page_module = 'wb_site_page_module';
			$this->table_page_module_children = 'wb_site_page_module_children';
		}*/
		if (!$setting['web_number'] || c('HostType')!='customized') {
			return;
		}
		$this->web_number = $setting['web_number'];
		$this->page_type = $setting['page_type'];
		$this->dir = c('root')."module/";
		$this->path = "/module/";
		// 站点录入
		$this->web();
		// 页面检查
		$this->check();
	}

	// 录入站点
	public function web(){
		$conf = include $this->dir.$this->web_number.'/_.conf.php';
		$web = lydb::result("select * from ss_web where Number='".$this->web_number."'");
		$data = array(
			'Number' => $this->web_number,
			'Tag' => $conf['tag'],
			'IsUsed' => 1,
			'Picture' => $this->path.$this->web_number.'/pc.jpg',
			'PictureMobile' => $this->path.$this->web_number.'/mobile.jpg',
		);
		if ($web) {
			lydb::update('ss_web', "Id='".$web['Id']."'", $data);
			$id = $web["Id"];
		} else {
			$id = lydb::insert('ss_web', $data);
		}
		$this->page(array(
			'ss_web_id' => $id,
			'web_conf' => $conf
		));
	}

	// 录入页面
	public function page($conf){
		$page_res = lydb::query("select * from ss_page where ss_web_id='".$conf['ss_web_id']."'");
		$page = array();
		while ($v = lydb::result($page_res)) {
			$page[$v['Number']] = $v;
		}
		$update_bat = array();
		$insert_bat = array();
		$page_list = $conf['web_conf']['page_list'];
		foreach ($page_list as $k => $v) {
			$pp = $page[$v['path']];
			$cc = include $this->dir.$v['path'].'/_.conf.php';
			$data = array(
				'Number' => $v['path'],
				'ss_web_id' => $conf['ss_web_id'],
				'IsLock' => 1,
				'NotSeo' => $cc['seo']?0:1,
				'Name' => trim($cc['name']),
				'Type' => trim($cc['type']),
				'Tag' => trim($cc['tag']),
				'HaveHeader' => $cc['parts']['header']?1:0,
				'HaveLefter' => $cc['parts']['left']?1:0,
				'HaveFooter' => $cc['parts']['footer']?1:0,
				'HaveRighter' => $cc['parts']['right']?1:0,
			);
			if ($pp) {
				$data['Id'] = $pp['Id'];
				$update_bat[] = $data;
			} else {
				$data['HeaderOpacity'] = $cc['header_opacity'];
				// $insert_bat[] = $data;
				$data['Id'] = lydb::insert('ss_page', $data);
			}
			$this->module(array(
				'ss_web_id' => $conf['ss_web_id'],
				'ss_page_id' => $data['Id'],
				'page_conf' => $cc
			));
			unset($page[$v['path']]);
		}
		// lydb::insert_bat('ss_page', $insert_bat);
		lydb::update_bat('ss_page', 'Id', $update_bat);
		// 删除多余的页面
		$del_id = '0';
		foreach ($page as $k => $v) {
			$del_id .= ','.$v['Id'];
		}
		lydb::delete('ss_page', "Id in($del_id)");
	}

	// 录入模板
	public function module($conf){
		$module_res = lydb::query("select * from ss_page_module where ss_web_id='".$conf['ss_web_id']."' and ss_page_id='".$conf['ss_page_id']."'");
		$module = array();
		while ($v = lydb::result($module_res)) {
			$module[$v['Number']] = $v;
		}
		$update_bat = array();
		$module_parts = $conf['page_conf']['parts'];
		$all_local_module = array();
		foreach ($module_parts as $kk => $vv) {
			if (($kk=='header'||$kk=='footer') && $conf['page_conf']['type']!='index') {
				continue;
			}
			foreach ($vv['module'] as $k => $v) {
				$pp = $module[$v['path']];
				$cc = include $this->dir.$v['path'].'/index.conf.php';
				$data = array(
					'Name' => $cc['title'],
					'Number' => $v['path'],
					'Type' => $cc['type'],
					'Parts' => $kk,
					'MyOrder' => $k+1,
					'ss_web_id' => $conf['ss_web_id'],
					'ss_page_id' => $conf['ss_page_id'],
					'Data' => addslashes(str::json(array('variable'=>$v['variable'])))
				);

				$all_local_module[$v['path']] = $data;
				/*$data = array(
					'Number' => $v['path'],
					'PersonalExclusive' => $cc['personal_exclusive'],
					'web_number' => $web_name,
					'Name' => $cc['title'],
					'Width' => $cc['width'],
					'Type' => $cc['type'],
					'PageType' => $cc['page_type']=='index'?'index':'inner',
					'Parts' => $kk,
					'IsChildren' => $cc['is_children'],
				);*/
				if ($pp) {
					$data['Id'] = $pp['Id'];
					$update_bat[$pp['Id']] = $data;
				} else {
					$data['Id'] = lydb::insert('ss_page_module', $data);
				}
				unset($module[$v['path']]);
			}
		}
		lydb::update_bat('ss_page_module', 'Id', $update_bat);
		// 删除多余的页面
		$del_id = '0';
		foreach ($module as $k => $v) {
			$del_id .= ','.$v['Id'];
		}
		lydb::delete('ss_page_module', "Id in($del_id)");
		$this->all_local_module[$conf['page_conf']['type']] = $all_local_module;
	}

	// 检查 copy 页面的模板是否一致
	public function check(){
		$web = db::result("select * from wb_site_web where Used=1 limit 1");
		if (!$this->page_type || !$web) {
			return;
		}
		$page = db::result("select * from wb_site_page_copy where wb_site_web_id='{$web['Id']}' and Type='".$this->page_type."' limit 1");

		$all_local_module = $this->all_local_module[$this->page_type];
		$module_copy_res = db::query("select * from wb_site_page_module_copy where wb_site_page_id='{$page['Id']}'");
		$update_bat = array();
		$del_id = '0';
		// d($all_local_module);
		while ($v=db::result($module_copy_res)) {
			$module = $all_local_module[$v['Number']];
			if ($module) {
	        	unset($module['Id'], $module['ss_web_id'], $module['ss_page_id'], $module['Data'], $module['Tag'], $module['IsRead']);
				$update_bat[$v['Id']] = $module;
				unset($all_local_module[$v['Number']]);
			} else {
				$del_id .= ','.$v['Id'];
			}
		}
		lydb::delete('wb_site_page_module_copy', "Id in($del_id)");
		lydb::update_bat('wb_site_page_module_copy', 'Id', $update_bat);
		foreach ((array)$all_local_module as $k => $module) {
			$module['wb_site_web_id'] = $web['Id'];
            $module['wb_site_page_id'] = $page['Id'];
			unset($module['Id'], $module['ss_web_id'], $module['ss_page_id'], $module['Data'], $module['Tag'], $module['IsRead']);
			$module['Id'] = db::insert('wb_site_page_module_copy', $module);
		}
	}
}
?>