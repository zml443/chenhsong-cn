<?php

namespace dbs;
use db;
use str;
use url;

class config extends func {

	public $set = array();
	public $dbc = array();
	public $dbg = array();
	public $edit_head = array(); //编辑栏头部
	public $path = '';
	public $language = array(); //语言包
	public $dbname = ''; //数据库名
	public $table = ''; //数据表名
	public $table_copy = ''; //数据表名
	public $row = array(); //数据，列表时为多条数据，详细编辑时为单条数据
	public $before_row = array(); //更新前的数据记录
	public $total = 0; //总数
	public $limit = 0; //分页页数
	public $where = '1'; //条件
	public $orderby = 'Id asc'; //排序方式
	public $search = array(); //搜索栏 html 组件代码
	public $search_xz = array(); //搜索栏 已选择的搜索
	public $fields = array(); //当前表的字段
	public $fields_string = ''; //字段记录
	public $permit = array(); //权限
	public $ismanage = 0; //管理员数据修改状态
	public $is_mod = 0; //修改状态
	public $is_add = 0; //添加状态
	public $is_wb_manage_id = 0; //是否绑定管理员id
	public $is_monolingual = true; //是否单语言，用于判断是否要加后缀
	public $query_string = array(); //链接
	public $layout = array(); //布局
	public $is_ext_id = ''; //记录绑定id
	public $is_keep_GET = array();
	public $relative_table = array();
	public $add_to_edit = 0; //添加页完成立刻跳
	public $add_to_list = 0; //添加页完成立刻跳
	public $edit_to_list = 0; //添加页完成立刻跳
	public $edit_to_flush = 0; //修改完进行一次Ajax刷新
	public $add_url = ''; //重新定义添加链接
	public $edit_url = ''; //重新定义修改链接
	public $var = array(); //留出来给自定义变量使用的，避免变量名冲突
	public $u = array();
	public $ma = '';
	public $m = '';
	public $a = '';
	/**
	 * 类初始函数，负责整理配置参数
	 */
	public function __construct ($ma, $set=array()) {
		// 设置整理
		$this->set = array_merge(array(
			'm' => '',
			'a' => '',
			'dir' => c('dbs.dir'),
			'path' => '',
			'dbc' => array(),
			'dbg' => array(),
			'create' => 1,
			'language' => c('language'),
			'lang' => c('lang'),
			'permit' => array(),
			'list' => array(),
			'edit' => array(),
			'post' => array(),
		), $set);
		$this->u = @explode(',', $_GET['u']);
		$this->path = c('dbs.dir').'/'.$ma;


		// 链接整理
		$__current_path = '?u='.$_GET['u'].'&ma='.$_GET['ma'];
		$__current_path2 = '?u='.$_GET['u'].'&mg='.$_GET['ma'];
		$this->query_string = array_merge(array(
	        'list' => $__current_path, //列表链接
	        'list2' => $__current_path2, //列表链接
	        'add' => $__current_path2.'&d=add', //修改链接
	        'add2' => $__current_path2.'&d=add', //修改链接
	        'edit' => $__current_path.'&d=edit', //修改链接
	        'edit2' => $__current_path2.'&d=edit', //修改链接
	        'post' => $__current_path.'&d=post', //提交链接
	        'myorder' => $__current_path.'&d=myorder', //提交链接
	        'save-uid' => $__current_path.'&d=save-uid', //提交链接
		));
		$do_action_url = c('manage.permit.config.'.str_replace(',', '.', $_GET['u']));
		$do_action_url || $do_action_url = array();
		$do_action_url['list'] || $do_action_url['list'] = p($_GET['ma'].'.list');
		if ($do_action_url['list'] && (int)$do_action_url['list']==0) {
			$this->query_string['list'] = '?u='.$_GET['u'].'&'.$do_action_url['list'];
		}
		$do_action_url['edit'] || $do_action_url['edit'] = p($_GET['ma'].'.edit');
		if ($do_action_url['edit'] && (int)$do_action_url['edit']==0) {
			$this->query_string['edit'] = '?u='.$_GET['u'].'&'.$do_action_url['edit'];
		}
		if ($do_action_url['add'] && (int)$do_action_url['add']==0) {
			$this->query_string['add'] = '?u='.$_GET['u'].'&'.$do_action_url['add'];
		}

		$this->permit = $this->set['permit'];
		$this->permit['_ope'] = ($this->permit['edit']&&!$this->permit['_hide_edit']) || $this->permit['del'] || $this->permit['copy'];

		$DBC = new dbc($ma, array(
			'create' => 1,
			'lang' => c('lang'),
			'language' => c('language'),
		));
		$this->dbname = $DBC->dbname;
		$this->table = $DBC->table;
		$this->table_copy = $DBC->table_copy;
		$this->ma = $DBC->ma;
		$this->m = $DBC->m;
		$this->a = $DBC->a;
		$this->dbc = $DBC->dbc;
		$this->dbg = $DBC->dbg;
		$this->fields = $DBC->fields;
		$this->edit_head = $DBC->edit_head;
		$this->add_to_edit = $DBC->add_to_edit;
		$this->add_to_list = $DBC->add_to_list;
		$this->edit_to_list = $DBC->edit_to_list;
		$this->edit_to_flush = $DBC->edit_to_flush;
		$this->edit_url = $DBC->edit_url;
		$this->add_url = $DBC->add_url;
		$this->ismanage = $DBC->ismanage;
		$this->language = $DBC->language; // 语言设
		$this->lang = $DBC->lang; // 语言设
		$this->is_ext_id = $DBC->is_ext_id;
		$this->is_monolingual = $DBC->is_monolingual;
		$this->is_wb_manage_id = $DBC->is_wb_manage_id;
		$this->relative_table = $DBC->relative_table;
		$this->not_save = $DBC->not_save;
		$this->is_keep_GET = $DBC->is_keep_GET;

		if ($this->add_url) {
			$this->query_string['add'] = $this->add_url;
		}
		if ($this->edit_url) {
			$this->query_string['edit'] = $this->edit_url;
		}

		// 记录GET参数
		$keepGET = '';
		foreach ($this->is_keep_GET as $k => $v) {
			// if (isset($_GET[$k])) $keepGET .= "&{$k}={$_GET[$k]}";
			if (isset($_REQUEST[$k])) $keepGET .= "&{$k}={$_REQUEST[$k]}";
		}
		$this->query_string['list'] .= $keepGET;
		$this->query_string['list2'] .= $keepGET;
		$this->query_string['add'] .= $keepGET;
		$this->query_string['add2'] .= $keepGET;
		$this->query_string['edit'] .= $keepGET;
		$this->query_string['edit2'] .= $keepGET;
	}


	// 复制 草稿
	public function copy__copy ($dbconf) {
		// $fields = $dbconf['fields'];
		// $dbc = $dbconf['dbc'];
		$table = $dbconf['table'];
		$table_copy = $dbconf['table_copy'];
		// $is_ext_id = $dbconf['is_ext_id'];
		// $is_add = $dbconf['is_add'];
		// $is_mod = $dbconf['is_mod'];
		// $is_wb_manage_id = $dbconf['is_wb_manage_id'];
		$one = $dbconf['before_row'];
		
		if ($one) {
			db::insert($table_copy, str::code($one, 'addslashes'));
			// 复制详情
			if (db::has_table($table_copy.'_detail')) {
				$editor = db::query("select * from {$table}_detail where ExtId='{$one['Id']}'");
				while ($v = db::result($editor)) {
					unset($v['Id']);
					db::insert($table_copy.'_detail', str::code($v, 'addslashes'));
				}
			}
			// 复制tdk
			if (db::has_table($table_copy.'_tdk')) {
				$editor = db::query("select * from {$table}_tdk where ExtId='{$one['Id']}'");
				while ($v = db::result($editor)) {
					unset($v['Id']);
					db::insert($table_copy.'_tdk', str::code($v, 'addslashes'));
				}
			}
			// 自定义链接
			if (db::has_table('page_url__copy')) {
				$editor = db::query("select * from page_url where ExtId='{$one['Id']}' and ExtTable='{$table}'");
				while ($v = db::result($editor)) {
					unset($v['Id']);
					db::insert('page_url__copy', str::code($v, 'addslashes'));
				}
			}
			// 复制其它表
			/*foreach ($this->dbc as $k => $v) {
				if ($v['IsExtId'] && $v['Table']) {
					foreach ((array)$v['Table'] as $k1 => $v1) {
						$ex_table = $this->tablename($v1);
						$ex_field = db::fields($ex_table);
						$ex_na = $this->table.'_id';
						if ($ex_field[$ex_na]) {
							$ex_row = db::query("select * from {$ex_table} where `$ex_na`='$id'");
							while ($v2 = db::result($ex_row)) {
								unset($v2['Id']);
								$v2[$ex_na] = $new_id;
								db::insert($ex_table, str::code($v2, 'addslashes'));
							}
						}
					}
				}
			}*/
		}
	}
	
	/**
	 * 记录日志
	 * @return {void}
	 */
	public $logs = array();
	public function log ($str='') {
		if ($str) {
			$this->logs[] = $str;
		}
		else {
			d($this->logs);
		}
	}
}
?>