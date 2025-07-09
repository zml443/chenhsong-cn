<?php

namespace dbs;
use db;
use str;
use url;

class dbc {

	public $ma = '';
	public $m = '';
	public $a = '';
	public $dbc = array();
	public $dbg = array();
	public $edit_head = array(); //编辑栏头部
	public $edit_to_list = 0; //添加页完成立刻跳
	public $add_to_list = 0; //添加页完成立刻跳
	public $add_to_edit = 0; //添加页完成立刻跳
	public $edit_to_flush = 0; //修改完进行一次Ajax刷新
	public $add_url = ''; //重新定义添加链接
	public $edit_url = ''; //重新定义修改链接
	public $language = array(); //语言包
	public $dbname = ''; //数据库名
	public $table = ''; //数据表名
	public $table_copy = ''; //草稿表
	public $fields = array(); //当前表的字段
	public $fields_copy = array(); //当前表的字段
	public $ismanage = 0; //管理员数据修改状态
	public $is_wb_manage_id = 0; //是否绑定管理员id
	public $is_monolingual = true; //是否单语言，用于判断是否要加后缀
	public $is_ext_id = ''; //记录绑定id
	public $is_ext_id_first = ''; //优先记录绑定id， 用于 is_ext_id 的比较
	public $is_keep_GET = array();
	public $relative_table = array();
	public $create = 0;
	public $not_save = 0;
	/**
	 * 类初始函数，负责整理配置参数
	 */
	public function __construct ($ma, $setting=array()) {
		$file = c('dbs.dir').'/'.$ma.'.conf.php';
		if (is_file($file)) {
			$conf = include $file;
		} else {
			return $this;
		}
		if (!$conf || !is_array($conf)) {
			return $this;
		}
		// 库
		$this->dbname = $setting['dbname'];
		$this->create = $setting['create'];
		$this->ma = $ma;
		$ma_ary = explode('/', $ma);
		$this->m = $ma_ary[0];
		$this->a = $ma_ary[1];
		// 当前状态
		$this->language = $setting['language']; // 语言设
		$this->lang = $setting['lang']; // 语言设
		// 表名
		$this->table = t($ma);
		// 草稿表表名
		if ($conf['open_copy']) {
			$this->table_copy = $this->table.'__copy';
		}
		$this->ismanage = $this->table=='wb_manage';
		$this->edit_head = $conf['edit_head'];
		$this->add_to_edit = $conf['add_to_edit'];
		$this->add_to_list = $conf['add_to_list'];
		$this->edit_to_list = $conf['edit_to_list'];
		$this->edit_to_flush = $conf['edit_to_flush'];
		$this->add_url = $conf['add_url'];
		$this->edit_url = $conf['edit_url'];
		$this->not_save = $conf['not_save'];
		
		if ($conf['dbg']) {
			$this->dbg = 1;
			$this->dbc = $conf['dbg'];
		} else {
			$this->dbc = $conf['dbc'];
		}
		// 配置数组
		$this->setup();
		// 创建数据表
		$this->create_table();
		if ($this->table_copy) {
			$this->create_table_copy();
		}

		// d($this->fields);
		return $this;
	}

	// 设置配置数组
	public function setup () {
		$default = include dirname(__FILE__).'/static/dbc.php';
		foreach ((array)$this->dbc as $k => $v) {
			if ($k=='wb_manage_id') {
				$this->is_wb_manage_id = manage('Id');
			}
			if ($v['Lang']) {
				$this->is_monolingual = false;
			}
			if ($v && $vv=$default[$k]) {
				if ($v===1) {
					$this->dbc[$k] = $vv;
				} else if (is_array($v)) {
					$this->dbc[$k] = array_merge($vv, $v);
				} else {
					unset($this->dbc[$k]);
					continue;
				}
			} else if (!$v || $v===1) {
				unset($this->dbc[$k]);
				continue;
			}
			if ($v['UnSet']) {
				unset($this->dbc[$k]);
				continue;
			}
			if (strstr($k, '_')) {
				$name_ext = ltrim(strrchr($k, '_'), '_');
				if (in_array($name_ext, $this->language)) unset($this->dbc[$k]);
			}
			// 设置配置信息
			$v = $this->fill_key($k, $this->dbc[$k]);
			// 绑定其他表
			if ($v['Table']) foreach ((array)$v['Table'] as $table_path) { // 导入关联数据表
				$log_table_name = t($table_path);
				if (!c('dbs.record_existing_data_sheet.'.$this->dbname.$log_table_name)) { // 防止无限循环
					c('dbs.record_existing_data_sheet.'.$this->dbname.$log_table_name, 1);
					$newDBC = new dbc($table_path, array(
						'create' => $this->create,
						'language' => $this->language,
						'lang' => $this->lang,
					));
					if (!$newDBC->dbg && $newDBC->dbc) $this->relative_table[$newDBC->table] = array(
						'dbc' => $newDBC->dbc,
						'fields' => $newDBC->fields,
						'is_ext_id' => $newDBC->is_ext_id
					);
				}
			}
		}
	}
	/**
	 * 补充配置信息，
	 * 注：此过程数据库字段尚未生成，之后还需要将配置附加到字段里面 见 $this->fields()
	 * @param {string} $key 键值，也代表这字段名
	 * @param {array} &$val 配置参数的地址变量
	 * @return {array}
	 */
	public function fill_key ($key, &$cfg) {
		if (stristr($cfg['Type'], 'attr')) {
			$cfg['Field'] = array();
			foreach ($cfg['Args'] as $k => $v) {
				$cfg['Field'][$k] = array('Sql'=>array('tinyint(1)', 0));
			}
		}
		if ($cfg['AddSave'] && !$cfg['EditHide']) {
			$cfg['EditShow'] = 1;
		}
		if ($cfg['EditSave']) {
			$cfg['AddHide'] = 1;
		}
		if ($cfg['Type']=='bind-id' && !$this->is_ext_id_first) {
			$this->is_ext_id = $key;
		}
		if ($cfg['IsBindId'] && !$this->is_ext_id_first) {
			$this->is_ext_id_first = $key;
			$this->is_ext_id = $key;
		}
		if (strtolower($cfg['Type'])=='bind-a') {
			$cfg['IsBindA'] = 1;
		}
		if (in_array(strtolower($cfg['Type']), array('bind-id', 'bind-b', 'hidden'))) {
			!$cfg['Search'] && $cfg['Search'] = '=';
			$cfg['IsKeepGET'] = 1;
		}
		// d($cfg['Type']);
		if (in_array(strtolower($cfg['Type']), array('editor', 'editor_open'))) {
			$cfg['IsEditor'] = 1;
		}
		$cfg['Sql'] && $cfg['Sql']=(array)$cfg['Sql'];
		if (!$cfg['Name']) {
			$cfg['Name'] = language('{/dbs.field.'.$key.'/}');
		}
		if ($cfg['Lang']) {
			foreach ($this->language as $k => $v) {
				$cfg['Field'][$key.'_'.$v] = array(
					'Sql' => $cfg['Sql'],
					'NotNull' => $k?'':$cfg['NotNull'],
					'NotRepeat' => $cfg['NotRepeat'],
					'EditHide' => $cfg['EditHide'],
					'AddHide' => $cfg['AddHide'],
					'EditShow' => $cfg['EditShow'],
					'EditSave' => $cfg['EditSave'],
					'AddSave' => $cfg['AddSave'],
					'NotSave' => $cfg['NotSave'],
					'IsOnly' => $cfg['IsOnly'],
					'IsEditor' => $cfg['IsEditor'],
					'Name' => $cfg['Name']
				);
				if (is_array($cfg['NotNull'])) {
					$cfg['Field'][$key.'_'.$v]['NotNull'] = in_array($v, $cfg['NotNull']);
				}
				if ($k==0) {
					$cfg['Field'][$key.'_'.$v]['ChangeName'] = $key;
				}
			}
			unset($cfg['Sql'], $cfg['NotNull'], $cfg['NotRepeat']);
		}
		// 以下为选填项，当没有相关内容，则跳过，不插入数据库
		foreach ((array)$cfg['Field'] as $k => $v) {
			if (!isset($cfg['Field'][$k]['Name'])) $cfg['Field'][$k]['Name'] = $cfg['Name'];
			if (!isset($cfg['Field'][$k]['NotNull'])) $cfg['Field'][$k]['NotNull'] = $cfg['NotNull'];
			if (!isset($cfg['Field'][$k]['EditHide'])) $cfg['Field'][$k]['EditHide'] = $cfg['EditHide'];
			if (!isset($cfg['Field'][$k]['AddHide'])) $cfg['Field'][$k]['AddHide'] = $cfg['AddHide'];
			if (!isset($cfg['Field'][$k]['EditShow'])) $cfg['Field'][$k]['EditShow'] = $cfg['EditShow'];
			if (!isset($cfg['Field'][$k]['EditSave'])) $cfg['Field'][$k]['EditSave'] = $cfg['EditSave'];
			if (!isset($cfg['Field'][$k]['AddSave'])) $cfg['Field'][$k]['AddSave'] = $cfg['AddSave'];
			if (!isset($cfg['Field'][$k]['NotSave'])) $cfg['Field'][$k]['NotSave'] = $cfg['NotSave'];
		}
		if ($cfg['List'] && !is_array($cfg['List'])) {
			$cfg['List'] = array('name'=>$cfg['List']);
		}
		if ($cfg['Group'] && !is_array($cfg['Group'])) {
			$cfg['Group'] = array('name'=>$cfg['Group']);
		}
		if ($cfg['GroupRight'] && !is_array($cfg['GroupRight'])) {
			$cfg['GroupRight'] = array('name'=>$cfg['GroupRight']);
		}
		if ($cfg['IsKeepGET']) $this->is_keep_GET[$key] = $cfg; 
		return $cfg;
	}
	/**
	 * 创建一个数据表，表部分框架以固定
	 * @return {void}
	 */
	public function create_sql($table){
		db::query("
			create table if not exists ".$this->dbname.$table." (
			  `Id` int(11) not null AUTO_INCREMENT,
			  `MyOrder` smallint(5) default '10000',
			  `AddTime` int(11) default '0',
			  `EditTime` int(11) default '0',
			  `IsDel` tinyint(1) default '0',
			  `IsLock` tinyint(1) default '0',
			  PRIMARY KEY (`Id`),
			  KEY `MyOrder` (`MyOrder`),
			  KEY `AddTime` (`AddTime`),
			  KEY `IsDel` (`IsDel`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
		");
	}
	public function create_table_copy(){
		$this->create_sql($this->table_copy);
		$this->fields_copy = db::fields($this->dbname.$this->table_copy);
		foreach ($this->fields as $k => $v) {
			$auto_increment = '';
			if ($v['Extra']=='auto_increment') {
				$auto_increment = 'AUTO_INCREMENT';
			}
			$default = '';
			if ($v['Default']) {
				$default = "default '{$v['Default']}'";
			}
			$null = $v['Null']=='NO' ? "not null" : "null";
			if ($this->fields_copy[$k]) {
				if ($this->fields_copy[$k]['Type']!=$v['Type']) db::query("alter table ".$this->dbname.$this->table_copy." change `$k` `$k` {$v['Type']} {$null} {$default} {$auto_increment}");
			} else {
				db::query("alter table ".$this->dbname.$this->table_copy." add `{$k}` {$v['Type']} {$null} {$default} {$auto_increment}");
			}
		}
		// 草稿的自定义链接表
		if (!db::has_table('page_url__copy')) {
			db::query("CREATE TABLE ".$this->dbname."page_url__copy LIKE page_url");
			db::query("alter table ".$this->dbname."page_url__copy AUTO_INCREMENT=1");
		}
		if (!db::has_table($this->table_copy.'_tdk')) {
			db::query("CREATE TABLE ".$this->dbname.$this->table_copy."_tdk LIKE ".$this->dbname.$this->table."_tdk");
			db::query("alter table ".$this->dbname.$this->table_copy."_tdk AUTO_INCREMENT=1");
		}
		if (!db::has_table($this->table_copy.'_detail')) {
			db::query("CREATE TABLE ".$this->dbname.$this->table_copy."_detail LIKE ".$this->dbname.$this->table."_detail");
			db::query("alter table ".$this->dbname.$this->table_copy."_detail AUTO_INCREMENT=1");
		}
		// 复制扩展条件
		$table_search_where_extid = $this->table.'_search_where_extid';
		if (db::has_table($table_search_where_extid)) {
			$where_extid_fields = db::fields($this->dbname.$table_search_where_extid);
			if (!$where_extid_fields[$this->table_copy.'_id']) {
				db::query("alter table ".$this->dbname.$table_search_where_extid." add `".$this->table_copy."_id` text null default ''");
				db::query("update ".$this->dbname.$table_search_where_extid." set ".$this->table_copy."_id = ".$this->table."_id");
			}
		}
	}
	public function create_table(){
		c('dbs.record_existing_data_sheet.'.$this->dbname.$this->table, 1);
		if ($this->dbg || !$this->create) {
			return ;
		}
		$this->create_sql($this->table);
		$this->fields = db::fields($this->dbname.$this->table);
		// 判断Id是否为主键
		if (strtolower($this->fields['Id']['Key'])!='pri') {
			// db::query("truncate ".$this->dbname.$this->table);
			db::query("alter table ".$this->dbname.$this->table." add primary key (Id)");
		}
		if (strtolower($this->fields['Id']['Extra'])!='auto_increment') {
			db::query("alter table ".$this->dbname.$this->table." change Id Id int not null AUTO_INCREMENT");
			$id = db::result("select Id from ".$this->dbname.$this->table, 'Id');
			$id || $id = 0;
			db::query("alter table ".$this->dbname.$this->table." AUTO_INCREMENT = ".((int)$id+1));
		}
		if ($this->table_copy) {
			if (!$this->fields['IsUnpublished']) {
				$this->fields['IsUnpublished'] = array(
					'Field' => 'IsUnpublished',
					'Type' => 'tinyint(1)',
					'Default' => '0',
				);
				db::query("alter table ".$this->dbname.$this->table." add `IsUnpublished` tinyint(1) null default '0' after `Id`");
			}
		}
		if (!$this->fields['MyOrder']) {
			$this->fields['MyOrder'] = array(
				'Field' => 'MyOrder',
				'Type' => 'smallint(5)',
				'Default' => '10000',
			);
			db::query("alter table ".$this->dbname.$this->table." add `MyOrder` smallint(5) null default '10000' after `Id`");
		}
		if (!$this->fields['AddTime']) {
			$this->fields['AddTime'] = array(
				'Field' => 'AddTime',
				'Type' => 'int(11)',
				'Default' => '0',
			);
			db::query("alter table ".$this->dbname.$this->table." add `AddTime` int(11) null default '0' after `Id`");
		}
		if (!$this->fields['EditTime']) {
			$this->fields['EditTime'] = array(
				'Field' => 'EditTime',
				'Type' => 'int(11)',
				'Default' => '0',
			);
			db::query("alter table ".$this->dbname.$this->table." add `EditTime` int(11) null default '0' after `Id`");
		}
		if (!$this->fields['IsDel']) {
			$this->fields['IsDel'] = array(
				'Field' => 'IsDel',
				'Type' => 'tinyint(1)',
				'Default' => '0',
			);
			db::query("alter table ".$this->dbname.$this->table." add `IsDel` tinyint(1) null default '0' after `Id`");
		}
		if (!$this->fields['IsLock']) {
			$this->fields['IsLock'] = array(
				'Field' => 'IsLock',
				'Type' => 'tinyint(1)',
				'Default' => '0',
			);
			db::query("alter table ".$this->dbname.$this->table." add `IsLock` tinyint(1) null default '0' after `Id`");
		}
		// $this->fields = db::fields($this->dbname.$this->table);
		// $this->savefields = ',Id,MyOrder,AddTime,EditTime,IsDel,';
		foreach ((array)$this->dbc as $k => $v) {
			$this->fields($k, $this->dbc[$k]);
		}
	}
	/**
	 * 此变量用于记录添加字段的时候
	 * 将字段进行有规律的排序
	 * 作用于 $this->fields() 函数
	 */
	public $table_after = 'IsDel';
	/**
	 * 添加字段
	 * @param {string} $name 字段名称
	 * @param {array} $cfg 此为dbc的配置参数
	 */
	public function fields ($name, $cfg) {
		// if ($cfg['Sql']) $this->savefields .= $name.',';
		if ($cfg['Sql']) if (!$this->fields[$name]) {
			$this->alter($name, $cfg['Sql'], 'add');
			$this->table_after = $name;
		} else {
			$typ = $cfg['Sql'];
			$type0 = explode('(', $this->fields[$name]['Type']);
			$type0[0] = strtolower(trim($type0[0]));
			$type0[1] = strtolower(trim(rtrim($type0[1],')')));
			$type1 = explode('(', $typ[0]);
			$type1[0] = strtolower(trim($type1[0]));
			$type1[1] = strtolower(trim(rtrim($type1[1], ')')));
			if($type0[0]=='int' && !$type0[1]) $type0[1]='11';
			if($type1[0]=='int' && !$type1[1]) $type1[1]='11';
			if($type0[0]=='numeric') $type0[0]='decimal';
			if($type1[0]=='numeric') $type1[0]='decimal';
			if($type0[0]!=$type1[0] || $type0[1]!=$type1[1]){
				$this->alter($name, $typ, 'change');
			}
			$this->table_after = $name;
		}
		if (isset($this->fields[$name])) {
			$this->fields[$name]['NotNull'] = $cfg['NotNull'];
			$this->fields[$name]['NotRepeat'] = $cfg['NotRepeat'];
			$this->fields[$name]['EditShow'] = $cfg['EditShow'];
			$this->fields[$name]['EditHide'] = $cfg['EditHide'];
			$this->fields[$name]['EditAdd'] = $cfg['EditAdd'];
			$this->fields[$name]['AddHide'] = $cfg['AddHide'];
			$this->fields[$name]['NotSave'] = $cfg['NotSave'];
			$this->fields[$name]['AddSave'] = $cfg['AddSave'];
			$this->fields[$name]['EditSave'] = $cfg['EditSave'];
			$this->fields[$name]['IsRand'] = $cfg['IsRand'];
			$this->fields[$name]['IsEditor'] = $cfg['IsEditor'];
			$this->fields[$name]['Name'] = $cfg['Name'];
		}
		if ($cfg['Field']) foreach ($cfg['Field'] as $k => $v) $this->fields($k, $v);
	}
	/**
	 * 判断 字段类型是否正确
	 * @param {string} $t sql的类型
	 * @return {bool}
	 */
	public function type_correct ($t) {
		$sty = 'int|float|numeric|double|tinyint|smallint|mediumint|char|text|longtext';
		if (strstr($t, '(')) return preg_match('/^('.$sty.'|varchar)(\([0-9,]+\))$/i', $t);
		else return preg_match('/^('.$sty.')$/i', $t);
	}
	/**
	 * 添加，改变字段
	 * @param {string} $name 字段名称
	 * @param {string} $typ 字段类型 , 如 int(11)
	 * @param {string} $act 行为类型，add:表示追加字段，chage:只能修改字段
	 */
	public function alter ($name, $typ, $act='add') {
		if (!$this->type_correct($typ[0])) {
			return false;
		}
		if (stripos($typ[0], 'text')===false) {
			$default = isset($typ[1]) ? addslashes($typ[1]) : '';
			if (preg_match('/(int|tinyint|numeric|decimal|float)/i', $typ[0])) {
				$default = (float)$default;
			}
			$default = "default '$default'";
		} else {
			$default = '';
		}
		if ($this->create) {
			if ($act=='add') {
				$na_ext = ltrim(strrchr($name, '_'), '_');
				$na = str_replace('_'.$na_ext, '', $name);
				if ($this->fields[$name]) {
					db::query("alter table ".$this->dbname.$this->table." change `$name` `$name` {$typ[0]} null {$default}");
				} else if ($na_ext==$this->language[0] && $this->fields[$na] && !$this->fields[$name]) { // 单语言切换成多语言，则直接把名字给改了
					db::query("alter table ".$this->dbname.$this->table." change `$na` `$name` {$typ[0]} null {$default}");
				} else if ($this->fields[$name.'_'.$this->language[0]] && !$this->fields[$name]) { // 多语言切换成单语言，则直接把名字给改了
					$na = $name.'_'.$this->language[0];
					db::query("alter table ".$this->dbname.$this->table." change `$na` `$name` {$typ[0]} null {$default}");
				} else {
					db::query("alter table ".$this->dbname.$this->table." add `$name` {$typ[0]} null {$default} after `".$this->table_after."`");
				}
			} else {
				db::query("alter table ".$this->dbname.$this->table." change `$name` `$name` {$typ[0]} null {$default} after `".$this->table_after."`");
			}
		}
		$this->fields[$name] = array(
			'Field' => $name,
			'Type' => $typ[0],
			'Default' => $typ[1]
		);
	}
}
?>