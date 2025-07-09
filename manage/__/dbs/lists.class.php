<?php
namespace dbs;
use str;
use db;
use page;
use img;
use url;

class lists extends config {

	// 获取 html 代码，用于编辑数据
	public function html () {
		if (!$this->permit['list']) {
			return \js::location('/manage/', '', 'top');
		    // return array('msg'=>language('{/notes.no_permit/}'), 'ret'=>5001);
		}
		// 列表整理
		$this->orderby = db::get_order_by($this->permit['orderby']?:'desc');
		$this->limit = (int)$_GET['_limit_'];
		$this->limit<1 && $this->limit = 12;

		$this->list_layout();
		$this->list_where();
		$file = c('dbs.dir').$_GET['ma'].'/'.$_GET['L'].'.php';
		is_file($file) || $file = c('dbs.list').$_GET['l'].'.php';
		is_file($file) || $file = c('dbs.list').'default.php';
		ob_start();
		is_file($file) && include $file;
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	// 条件整理
	public function list_where () {
		// $this->where = '1';
		if ($this->fields['UId']) {
			if ($_GET['_UId']) {
				$uid = (int)$_GET['_UId'];
				$this->where .= " and find_in_set('$uid', UId)";
			}
			else if ($this->permit['_add']) {
				$this->where .= " and Dept<=2";
			}
		}
		if ($this->dbc['UId'] && $this->dbc['UId']['Dept']) {
			$this->where .= " and Dept<=".$this->dbc['UId']['Dept'];
		}
		// 指定id
		// 5.3.2.22.11.8 当 _sel_ids 传过来一个空数据时，会导致数据不正确，改成 isset() 判断
		if (isset($_REQUEST['_sel_ids'])) $_GET['Id'] = $_REQUEST['_sel_ids'];
		if (isset($_GET['Id'])) {
			$_sel_ids = explode(',', $_GET['Id']);
			$_sel_ids_string = '0';
			foreach ($_sel_ids as $v) {
				$_sel_ids_string .= ",".(int)$v;
			}
			$this->where .= " and Id in($_sel_ids_string)";
		}
		// 绑定id
		// $ex_na=$this->is_ext_id;
		// if ($ex_na && $this->fields[$ex_na]) {
		// 	$ex_id = (int)$_GET[$ex_na];
		// 	$this->where .= " and `$ex_na`=$ex_id";
		// }
		// 回收站
		if ($this->permit['recycle']) {
			$this->where .= $_GET['IsDel'] ? ' and IsDel=1' : ' and IsDel=0';
		}
		// 管理员绑定
		if ($this->fields['wb_manage_id'] && manage('Level')!=1 && !$this->permit['allow']) {
			if ($this->ismanage) { //如果是管理员表也可以看到自己的那一条数据
				$this->where .= " and (wb_manage_id='".manage('Id')."' or Id='".manage('Id')."')";
			} else {
				$this->where .= " and wb_manage_id='".manage('Id')."'";
			}
		}
		// 搜索栏
		$__query_string = url::to_array(url::query_string('keyword,page,pg'));
		foreach ($__query_string as $k => $v) {
			$this->search['hidden'] .= '<input type="hidden" name="'.htmlspecialchars($k).'" value="'.htmlspecialchars(urldecode($v)).'">';
		}
		$this->search['layout'] = array();
		foreach ($this->dbc as $k => $v) {
			if ($v['Search']=='%') {
				$this->search['keyword'][$k] = $v;
			} else if ($v['Search']=='=') {
				if (isset($_GET[$k])) {
					$this->where .= " and `$k`='{$_GET[$k]}'";
				}
			} else if ($v['Search']) {
				$this->search_func($k, $this->dbc[$k]);
			}
		}
		if ($kw=$_GET['keyword']) {
			foreach ($this->search['keyword'] as $k => $v) {
				if ($v['Lang']) {
					foreach ($this->language as $v1) {
						$__kw_where .= " or `{$k}_{$v1}` like '%{$kw}%'";
					}
				} else {
					$__kw_where .= " or `$k` like '%{$kw}%'";
				}
			}
		}
		$__kw_where && $this->where .= ' and ('.ltrim($__kw_where, ' or').')';
		$this->where .= $this->list_ext_where;
		// d($this->where);
	}

	// 列表布局整理
	public function list_layout () {
		$this->layout = array();
		$my_order = 100;
		foreach ($this->dbc as $k => $v) {
			if ($v['List']) {
				if ((int)$v['List']['name']) {
					$key = $k;
				} else {
					$key = $v['List']['name'];
				}
				// $key = (int)$v['List']?$k:$v['List'];
				$this->layout[$key] || $this->layout[$key] = array(
					'my_order' => $my_order++,
					'name' => $v['Name'],
					'field' => array()
				);
				if ($v['Type']=='image'	|| $v['Type']=='img') {
					$this->layout[$key]['my_order'] = 5;
					$this->layout[$key]['class'] = 'w_1';
				} else if ($k=='Name') {
					$this->layout[$key]['my_order'] = 6;
				}
				/*if (preg_match('/^(ip|day|daytime|deadline)$/', $v['Type'])) {
					$this->layout[$key]['class'] = 'nowrap';
				}*/
				$this->layout[$key]['field'][$k] = $v;
			}
		}
		$cmf_arr = array_column($this->layout, 'my_order');
		array_multisort($cmf_arr, SORT_ASC, $this->layout);
	}

	// 整理总数
	public function list_total () {
		if ($this->set['list']['total']) {
			return ;
		}
		$this->set['list']['total'] = db::get_row_count($this->table, $this->where);
	}

}
?>