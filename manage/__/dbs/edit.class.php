<?php

namespace dbs;
use str;
use db;
use url;
use file;

class edit extends config {
	// html 布局
	public function html () {
		$this->edit_where();
		if ( ($this->is_add&&!$this->permit['add']) || ($this->is_mod&&!$this->permit['edit']) ) {
		    return \js::location('/manage/', '', 'top');
		}
		$this->edit_layout();
		$file = c('dbs.dir').$_GET['ma'].'/'.$_GET['E'].'.php';
		is_file($file) || $file = c('dbs.edit').$_GET['e'].'.php';
		is_file($file) || $file = c('dbs.edit').'default.php';
		ob_start();
		is_file($file) && include $file;
		$html = ob_get_contents();
		ob_end_clean();
		// return language_all($html);
		return $html;
	}

	// 布局
	public function edit_layout () {
		// 按照字段排列
		$this->layout = array(
			'field' => array(),
			'right' => array(),
		);
		foreach ($this->dbc as $k => $v) {
			if ($this->is_mod && $v['EditHide']) {
				continue;
			} else if ($this->is_add && $v['AddHide']) {
				continue;
			}
			if ($this->is_add) {
				unset($this->dbc[$k]['EditShow']);
			}
			if ($_GET['_alert_side_']) {
				$v['Group'] = $v['GroupRight'];
				unset($v['GroupRight']);
			}
			if ($v['GroupRight']) {
				$n = $v['GroupRight']['name'];
				$this->layout['right'][$n] || $this->layout['right'][$n] = array(
					'name' => language('dbs.group.'.$n)?:$n,
					'field' => array(),
				);
				$v['GroupTip'] && $this->layout['right'][$n]['tip'] = $v['GroupTip'];
				$this->layout['right'][$n]['field'][$k] = 1;
			} else if ($v['Group']) {
				$n = $v['Group']['name'];
				$this->layout['field'][$n] || $this->layout['field'][$n] = array(
					'name' => language('dbs.group.'.$n)?:$n,
					'field' => array(),
				);
				$v['GroupTip'] && $this->layout['field'][$n]['tip'] = $v['GroupTip'];
				$this->layout['field'][$n]['field'][$k] = 1;
			} else {
				$this->layout['field']['base'] || $this->layout['field']['base'] = array(
					'name' => language('dbs.group.base'),
					'field' => array(),
				);
				$v['GroupTip'] && $this->layout['field']['base']['tip'] = $v['GroupTip'];
				$this->layout['field']['base']['field'][$k] = 1;
			}
		}
		if (count($this->layout['field'])<2 && count($this->layout['right'])==0) {
			$this->layout['field']['base']['name'] = '';
		}
	}
	public function edit_where(){
		if ($_GET['d']=='add') {
			$this->is_mod = 0;
		} else {
			$this->is_mod = $_GET['Id'] || $_GET['_edit_insert_'] || (!$this->permit['list'] && $this->permit['edit']);
		}
		$this->is_add = !$this->is_mod;	
		if ($this->table=='wb_manage') {
			if ($this->is_mod && !$_GET['Id']) {
				$_GET['Id'] = manage('Id');
			}
		} else if (db::has_table($this->table)) {
			$Id = (int)$_GET['Id'];
			if (!$Id && $this->is_mod) {
				$insert_data = array();
				$search_where = '';
				/*foreach ($this->fields as $k => $v) {
					if (isset($_GET[$k])) {
						$insert_data[$k] = $_GET[$k];
						$search_where .= " and `$k`='{$_GET[$k]}'";
					}
				}*/
				foreach ($this->dbc as $k => $v) {
					if ($v['Search']) {
						if (isset($_GET[$k])) {
							$insert_data[$k] = $_GET[$k];
							$search_where .= " and `$k`='{$_GET[$k]}'";
						}
					}
				}
				$Id = db::result("select Id from {$this->table} where 1 {$search_where}", 'Id');
				$Id || $Id = db::insert($this->table, $insert_data);
				$_GET['Id'] = $Id;
			}
		}
		if ($_GET['Id']) {
			$Id = (int)$_GET['Id'];
			$this->where .= " and Id='$Id'";
		}
		// 管理员绑定
		if ($this->fields['wb_manage_id'] && manage('Level')!=1 && !$this->permit['allow']) {
			if ($this->ismanage) { //如果是管理员表也可以看到自己的那一条数据
				$this->where .= " and (wb_manage_id='".manage('Id')."' or Id='".manage('Id')."')";
			} else {
				$this->where .= " and wb_manage_id='".manage('Id')."'";
			}
		}
		if ($this->is_mod) {
			foreach ($this->dbc as $k => $v) {
				if ($v['Search']) {
					if (isset($_GET[$k])) {
						$this->where .= " and `$k`='{$_GET[$k]}'";
					}
				}
			}
		}
		if ($this->where!='1') {
			if ($this->fields['IsRead']) {
				db::update($this->table, $this->where, array('IsRead'=>1));
			}
		} else {
			$this->where = '0';
		}
	}

}

?>