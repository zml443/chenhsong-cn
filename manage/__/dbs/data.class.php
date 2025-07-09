<?php

namespace dbs;
use str;
use db;
use log;
use file;
use url;


class data extends config {
	// 记录提交上来的文件路径
	public $file_path = array();
	public function each_file_path ($file) {
		if (is_array($file)) {
			foreach ($file as $v) $this->each_file_path($v);
		} else if (preg_match('#^/[a-zA-Z0-9_\\-\\.][a-zA-Z\\-\\/\\.\\\\ :0-9_]+$#', $file)) {
			$this->file_path[] = $file;
		}/* else if (preg_match('#^[a-zA-Z\\-\\/\\.\\\\ :0-9_]*$#', $file)) {
			$this->file_path[] = $file;
		}*/
	}


	// 将临时文件改成保存状态
	public function save_tmp_file_path () {
		if ($this->file_path) {
			$new_file_path = array();
			foreach ($this->file_path as $v) {
				$new_file_path[] = str_replace("'", '', $v);
			}
			db::update($this->dbname.'jext_files', "Path in('".implode("','", $new_file_path)."')", array(
				'IsTmp' => 0
			));
		}
	}


	// 整理录入的数据
	public function value ($value, $field) {
		// if ($field['IsFile']) $this->each_file_path($value);
		$mayBeFile = 0;
		if (preg_match('/^(int|tinyint|smallint|mediumint)/i', $field['Type'])) { // 整型
			if (!is_array($value) && preg_match('/^[0-9]+[\\/\\-\\.][0-9]+/', $value)) {
				$value = strtotime($value);
			}
			$value = (int)$value;
		} else if (preg_match('/^(float|numeric|double|decimal)/i', $field['Type'])) { // 浮点数
			$value = (float)$value;
		} else if (preg_match('/^(text|longtext)$/i', $field['Type'])) { // json 格式
			if (is_array($value)) {
				$value = str::code($value, 'stripslashes');
				$value = str::code(str::json($value),'addslashes');
				$mayBeFile = 1;
			}
		} else if (is_array($value)) { // 字符串，逗号隔开，并且去重
			$value = implode(',', array_filter($value));
		} else if (!$value) { // 空
			$value = '';
		} else {
			$mayBeFile = 1;
		}
		if ($mayBeFile) $this->each_file_path($value);
		return $value;
	}


	// 事前录入
	public function save_before(&$_ARG, $dbconf){
		$data = array();
		// 配置
		$fields = $dbconf['fields'];
		$dbc = $dbconf['dbc'];
		$table = $dbconf['table'];
		$table_copy = $dbconf['table_copy'];
		$is_ext_id = $dbconf['is_ext_id'];
		$is_add = $dbconf['is_add'];
		$is_mod = $dbconf['is_mod'];
		$is_wb_manage_id = $dbconf['is_wb_manage_id'];
		$BeforeRow = $dbconf['before_row'];
		// 数据绑定管理员
		if ($is_wb_manage_id) {
			if ($is_add) {
				$_ARG['wb_manage_id'] = manage('Id');
				$_ARG['past_wb_manage_id'] = $_ARG['wb_manage_id'];
			} else if (manage('Level')!='1') {
				unset($_ARG['wb_manage_id']);
				unset($_ARG['past_wb_manage_id']);
			}
		}
		// 草稿表的发布状态
		// 自定义链接
		if ($_ARG['PageUrl']) {
			$_ARG['PageUrl'] = preg_replace('#//+#', '/', trim(preg_replace('/[^\\-\\/_a-zA-Z0-9]/', '-', $_ARG['PageUrl']), '/'));
			$page_dir = $_ARG['PageUrl_Dir'] = preg_replace('#//+#', '/', trim($_ARG['PageUrl_Dir'], '/'));
			$page_url_where = "Url='{$_ARG['PageUrl']}' and PrefixUrl='$page_dir'";
			if ($_ARG['Id']) {
				$page_url_where .= " and ExtId<>'{$_ARG['Id']}'";
			}
			$page_one = db::result("select * from `page_url` where $page_url_where");
			if ($page_one) {
				return array('msg'=>'链接已被使用，请重新填写', 'error_field'=>'PageUrl', 'ret'=>0);
			}
		}
		// 删除状态
		if ($_ARG['IsDel']) {
			$data['IsDel'] = (int)$_ARG['IsDel'];
		}
		// 改变排序
		if ((int)$_ARG['MyOrder']) {
			$data['MyOrder'] = (int)$_ARG['MyOrder'];
		}
		// 密码加密
		if ($_ARG['Password']) {
			$_ARG['Password'] = str::password($_ARG['Password']);
		}
		// 账号锁定
		if ($_ARG['IsLoginLock'] && $table=='wb_manage' && manage('Id')==$_ARG['Id']) {
			return array('msg'=>'无法锁定自身账号', 'ret'=>1);
		}
		// 插入时间
		if ($_ARG['AddTime']) {
			$data['AddTime'] = strtotime($_ARG['AddTime']);
		} else if ((int)$_ARG['Id']==0) {
			$data['AddTime'] = c('time');
		}
		// 记录修改时间
		$data['EditTime'] = c('time');
		// 去掉固定设置好的
		unset($fields['Id'], $fields['IsDel'], $fields['MyOrder'], $fields['EditTime']);
		// 通过字段保存数据
		// UId
		if (isset($_ARG['UId'])) {
			$_ARG['UId'] || $_ARG['UId']='0,';
			$uid_last_id = trim(strrchr(rtrim($_ARG['UId'],','),','),',');
			if ((int)$uid_last_id) {
				$uid_row = db::get_one($table, "Id='$uid_last_id'", 'UId,Id');
				if (!$uid_row || $uid_row['UId'].$uid_row['Id'].','!=$_ARG['UId']) {
					return array('msg'=>'UId 错误', 'error_field'=>'UId', 'ret'=>0);
				}
			} else {
				$_ARG['UId']='0,';
			}
			$_ARG['Dept'] = substr_count($_ARG['UId'], ',');
		}
		// ip
		if ($dbc['Ip'] && $is_add) {
			$_ARG['Ip'] || $_ARG['Ip']=ip::get();
		}
		// 处理数据
		foreach ($fields as $k => $v) {
			if ($v['NotSave'] || ($is_add && $v['EditSave']) || ($is_mod && $v['AddSave'])) {
				continue;
			}
			// 判断是否为随机数
			if ($v['IsRand']) {
				if ($is_add || ($is_mod&&!$BeforeRow[$k])) {
					$has_table = $table;
					foreach ((array)$cfg['HasTable'] as $v) $has_table .= ','.t($v);
					$_ARG[$k] = db::randcode($has_table, $k, $v['IsRand']['Type'], $v['IsRand']['Prefix']);
				} else if (isset($_ARG[$k])) {
					unset($_ARG[$k]);
				}
			}
			// 需要正确格式，或者不能为空
			if ($_ARG['_incomplete_']) {
				$v['NotNull'] = 0;
			}
			if ($v['NotNull'] && (isset($_ARG[$k]) || $is_add)) {
				if (!$_ARG[$k]) {
					$n = str_replace('{{name}}',$v['Name'], language('notes.notnull'));
					return array('msg'=>$n, 'ret'=>0);
				}
			}
			//只保存$_ARG提交过来的数据
			if (isset($_ARG[$k])) $data[$k] = $this->value($_ARG[$k], $v);
			//判断字段重复
			if ($v['NotRepeat'] && $data[$k]) {
				$vwh = "1=1";
				if ($Id) {
					$vwh .= " and Id<>$Id";
				}
				if ($_ARG['UId'] && $fields['UId']) { //当有父子层数关系的时候，就判断当前层数内是否重复
					$vwh .= " and UId='{$_ARG['UId']}'";
				}
				if ($is_ext_id && $fields[$is_ext_id] && $_ARG[$is_ext_id]) { //当有父子层数关系的时候，就判断当前层数内是否重复
					$ex_id = (int)$_ARG[$is_ext_id];
					$vwh .= " and `$is_ext_id`='{$ex_id}'";
				}
				$vwh .= " and `$k`='{$data[$k]}'";
				$res = db::result("select Id from ".$table." where {$vwh}", 'Id');
				if ($res) {
					$n = str_replace('{{name}}', $v['Name'], language('notes.notrepeat'));
					return array('msg'=>$n, 'ret'=>0);
				}
			}
		}
		return array('data'=>$data, 'ret'=>1);
	}


	// 保存事后数据
	public function save_after(&$_ARG, $dbconf){
		$fields = $dbconf['fields'];
		$dbc = $dbconf['dbc'];
		$table = $dbconf['table'];
		$table_copy = $dbconf['table_copy'];
		$is_ext_id = $dbconf['is_ext_id'];
		$is_add = $dbconf['is_add'];
		$is_mod = $dbconf['is_mod'];
		$is_wb_manage_id = $dbconf['is_wb_manage_id'];
		$Row = $dbconf['row'];
		$BeforeRow = $dbconf['before_row'];
		foreach ($dbc as $name => $val) {
			// 保存编辑器内容
			if ($val['IsEditor']) {
				if ($val['Lang']) {
					foreach ($this->language as $v) {
						$n = $name.'_'.$v;
						if (isset($_ARG[$n])) {
							$_ARG[$n] = file::get_remote_img($_ARG[$n]);
							if ($table_copy) {
								db::editor_mod($table_copy, $_ARG['Id'], $n, $_ARG[$n]);
							}
							if (!$_POST['_save_copy_'] || !$table_copy) {
								db::editor_mod($table, $_ARG['Id'], $n, $_ARG[$n]);
							}
						}
					}
				} else {
					if (isset($_ARG[$name])) {
						$_ARG[$name] = file::get_remote_img($_ARG[$name]);
						if ($table_copy) {
							db::editor_mod($table_copy, $_ARG['Id'], $name, $_ARG[$name]);
						}
						if (!$_POST['_save_copy_'] || !$table_copy) {
							db::editor_mod($table, $_ARG['Id'], $name, $_ARG[$name]);
						}
					}
				}
			}
			// bind-A 关联类型的处理
			if ($val['IsBindA'] && isset($_ARG[$name])) {
				$_where_ext_table = t($v['Cfg']['ma']);
				$exna = $table.'_id';
				$exid = $Row['Id'];
				if (db::has_table($_where_ext_table)) {
					$hasfields = db::fields($_where_ext_table);
					if ($hasfields[$exna]) {
						db::update($_where_ext_table, "`{$exna}`='{$exid}'", array(
							$exna => 0
						));
						$add_ids = explode(',', (string)$_ARG[$name]);
						$add_id = '0';
						foreach ($add_ids as $v) {
							$add_id .= ','.(int)$v;
						}
						db::update($_where_ext_table, "Id in({$add_id})", array(
							$exna => $exid
						));
					}
				}
			}
		}
		// UId 改变，子数据也需要一并改变
		// =======================================
		if ($dbc['UId'] && $is_mod && $Row['Id'] && $BeforeRow['UId']!=$Row['UId']) {
			$new_uid = $Row['UId'].$Row['Id'].',';
			$cur_uid = $BeforeRow['UId'].$BeforeRow['Id'].',';
			$new_dept = db::get_all($table, "find_in_set({$Row['Id']},UId)", "Id,UId");
			$uid_array = array();
			foreach ($new_dept as $k1 => $v1) {
				$uid_array[$v1['UId']] = str_replace($cur_uid, $new_uid, $v1['UId']);
			}
			foreach ($uid_array as $k1 => $v1) {
				db::update($table, "UId='$k1'", array(
					'UId' => $v1,
					'Dept'=> substr_count($v1, ',')
				));
			}
		}
		// =======================================
		// 自定义链接+草稿
		$page_url_data = array(
			'ExtId'		=>	$Row['Id'],
			'ExtTable'	=>	$table,
			'Url'		=>	$_ARG['PageUrl'],
			'PrefixUrl'	=>	$_ARG['PageUrl_Dir']
		);
		if ($table_copy) {
			$page_url_one = db::result("SELECT * FROM page_url__copy WHERE ExtId='{$page_url_data['ExtId']}' AND ExtTable='{$page_url_data['ExtTable']}'");
			if ($page_url_one['Id']) {
				db::update('page_url__copy', "Id='{$page_url_one['Id']}'", $page_url_data);
			} else {
				db::insert('page_url__copy', $page_url_data);
			}
		}
		if (!$_POST['_save_copy_'] || !$table_copy) {
			$page_url_one = db::result("SELECT * FROM page_url WHERE ExtId='{$page_url_data['ExtId']}' AND ExtTable='{$page_url_data['ExtTable']}'");
			if ($page_url_one['Id']) {
				db::update('page_url', "Id='{$page_url_one['Id']}'", $page_url_data);
			} else {
				db::insert('page_url', $page_url_data);
			}
		}
		// =======================================
		// 插入扩展条件
		$_where_ext_table = $table.'_search_where_extid';
		$_has_where_ext_table = db::has_table($_where_ext_table);
		if ($_ARG['_where_extid_add'] || $_ARG['_where_extid_del']) {
			$exna = $table_copy ? $table_copy.'_id' : $table.'_id';
			$exid = $Row['Id'];
			if ($_has_where_ext_table) {
				$hasfields = db::fields($_where_ext_table);
				if ($hasfields[$table_copy.'_id'] && !$table_copy) {
					db::query("alter table {$_where_ext_table} drop {$table_copy}_id");
				}
				if ($hasfields[$exna]) {
					$bat = array();
					$ids = "'".str_replace(',', "','", (string)$_ARG['_where_extid_add'])."'";
					$res = db::query("select * from {$_where_ext_table} where Id in($ids)");
					while ($v=db::result($res)) {
						if (strpos(','.$v[$exna].',', ','.$exid.',')===false) {
							$vd_id = trim($v[$exna].','.$exid, ',');
							$bat[$v['Id']] = array(
								'Id' => $v['Id'],
								$exna => $vd_id
							);
						}
					}
					$ids = "'".str_replace(',', "','", (string)$_ARG['_where_extid_del'])."'";
					$res = db::query("select * from {$_where_ext_table} where Id in($ids)");
					while ($v=db::result($res)) {
						$v[$exna] = ','.$v[$exna].',';
						if (strpos($v[$exna], ','.$exid.',')!==false) {
							$vd_id = trim(str_replace(','.$exid.',', ',', $v[$exna]), ',');
							$bat[$v['Id']] = array(
								'Id' => $v['Id'],
								$exna => $vd_id
							);
						}
					}
					db::update_bat($_where_ext_table, "Id", $bat);
				}
			}
		}
		if ($_has_where_ext_table && !$_POST['_save_copy_'] && $table_copy) {
			$_where_ext_table = $table.'_search_where_extid';
			$exna = $table.'_id';
			$exna_copy = $table_copy.'_id';
			$exid = $Row['Id'];
			$res = db::query("select * from {$_where_ext_table} where find_in_set('{$exid}',$exna_copy) or find_in_set('{$exid}',$exna)");
			while ($v=db::result($res)) {
				$v[$exna_copy] = ','.$v[$exna_copy].',';
				if (strpos($v[$exna_copy], $exid)===false) {
					$vd_id = trim(str_replace(','.$exid.',', ',', ','.$v[$exna].','), ',');
				} else {
					$vd_id = str_replace(','.$exid.',', ',', ','.$v[$exna].',');
					$vd_id = trim($vd_id.','.$exid, ',');
				}
				$bat[$v['Id']] = array(
					'Id' => $v['Id'],
					$exna => preg_replace('/,+/', ',', $vd_id)
				);
			}
			db::update_bat($_where_ext_table, "Id", $bat);
		}
		// 关联表
		/*if (($_ARG['_bind_id_add'] || $_ARG['_bind_id_del'] || $_ARG['_bind_id_before']) && $dbc['_bind_id_add']) {
			$_where_ext_table = t($dbc['_bind_id_add']['Cfg']['ma']);
			$exna = $table.'_id';
			$exid = $Row['Id'];
			// d($_where_ext_table);
			if (db::has_table($_where_ext_table)) {
				$hasfields = db::fields($_where_ext_table);
				if ($hasfields[$exna]) {
					$add_id = explode(',', (string)$_ARG['_bind_id_add']);
					$del_id = explode(',', (string)$_ARG['_bind_id_del']);
					if ($add_id) {
						$ids = "'".implode("','", $add_id)."'";
						db::update($_where_ext_table, "Id in({$ids})", array(
							$exna => $exid
						));
					}
					if ($del_id) {
						$ids = "'".implode("','", $del_id)."'";
						db::update($_where_ext_table, "Id in({$ids})", array(
							$exna => 0
						));
					}
				}
			}
		}*/
		// =======================================
	}
	

	// 保存相关数据
	public function save_relative(){
		foreach ($this->relative_table as $table => $conf) {
			if ($_POST[$table] && is_array($_POST[$table])) {
				if (!is_array($_POST[$table][0])) {
					$_POST[$table] = array($_POST[$table]);
				}
				$is_ext_id = $conf['is_ext_id'];
				$all = db::all("select * from {$table} where {$is_ext_id}='{$this->row['Id']}'", 'Id');
			    $has_id = [];
			    foreach ($_POST[$table] as $key => &$_ARG) {
			        $before_row = array();
			        $is_add = 0;
			        $is_mod = 0;
			        if ($_ARG['Id']) {
			        	if ($all[$_ARG['Id']]) {
			        		$before_row = $all[$_ARG['Id']];
			        		$has_id[] = $_ARG['Id'];
			        		$is_mod = 1;
			        	} else {
			        		$is_add = 1;
			        	}
			        } else {
			        	$is_add = 1;
			        }
			        $_ARG[$is_ext_id] = $this->row['Id'];
	        		$ddd = $this->save_before($_ARG, array(
						'table' => $table,
						'table_copy' => $conf['table_copy'],
						'fields' => $conf['fields'],
						'dbc' => $conf['dbc'],
						'is_ext_id' => $is_ext_id,
						'is_add' => $is_add,
						'is_mod' => $is_mod,
						'before_row' => $before_row,
					));
					if ($ddd['ret']!=1) {
						continue;
					}
					if ($is_mod) {
						$ARG['Id'] = (int)$before_row['Id'];
						db::update($table, "Id={$ARG['Id']}", $ddd['data']);
					} else {
						$ARG['Id'] = db::insert($table, $ddd['data']);
					}
					$row = db::result("select * from {$table} where Id={$ARG['Id']}");
					// 事后录入数据
					$this->save_after($ARG, array(
						'table' => $table,
						'table_copy' => $conf['table_copy'],
						'fields' => $conf['fields'],
						'dbc' => $conf['dbc'],
						'is_ext_id' => $is_ext_id,
						'is_add' => $is_add,
						'is_mod' => $is_mod,
						'row' => $row,
						'before_row' => $before_row,
					));
			    }
			    $delete_bat = [];
			    foreach ($all as $k => $v) if(!in_array($k, $has_id)) $delete_bat[] = (int)$v['Id'];
			    $delete_bat && db::delete($table, "Id in(".implode(',', $delete_bat).")" );
			}
			// 
		}
		// 
	}

	// 保存数据到数据库
	public function save () {
		if ( ($this->is_add&&!$this->permit['add']) || ($this->is_mod&&!$this->permit['edit']) ) {
		    return array('msg'=>language('{/notes.no_permit/}'), 'ret'=>5001);
		}
		if ($this->not_save) {
			return array('msg'=>'无法修改', 'ret'=>0);
		}
		if ($this->dbg) {
			return $this->save_group();
		}
		// 通过id判断修改或者添加
		$_POST['Id'] = (int)$_POST['Id'];
		if ($_POST['Id']) {
			$this->is_mod = true;
			$Id = (int)$_POST['Id'];
			// 判断是否有草稿
			if ($this->table_copy) {
				$cRow = db::result("select * from ".$this->table_copy." where Id=$Id");
				if (!$cRow) {
					$cRow = db::result("select * from ".$this->table." where Id=$Id");
					if ($cRow) {
						db::query("INSERT INTO ".$this->table_copy." SELECT * FROM ".$this->table." WHERE Id=$Id");
					}
				}
				$this->before_row = $cRow;
			} else {
				$this->before_row = db::result("select * from ".$this->table." where Id=$Id");
			}
			if (!$this->before_row) {
				return array('msg'=>'数据不存在，无法修改', 'ret'=>0);
			}
			if ($this->is_wb_manage_id && manage('Level')!='1' && $this->before_row['wb_manage_id']!=$this->is_wb_manage_id) {
				return array('msg'=>'当前用户无权限修改此数据', 'ret'=>0);
			}
		} else {
			$this->is_add = true;
			$this->before_row = array();
		}
		// ========================================================================
		// 保存前处理数据
		$file = $this->path.'/_.post.before.php'; is_file($file) && include $file;
		// 保存数据
		$result = $this->save_before($_POST, array(
			'table' => $this->table,
			'table_copy' => $this->table_copy,
			'fields' => $this->fields,
			'is_ext_id' => $this->is_ext_id,
			'is_add' => $this->is_add,
			'is_mod' => $this->is_mod,
			'dbc' => $this->dbc,
			'before_row' => $this->before_row
		));
		if ($result['ret']==1) {
			$data = $result['data'];
		} else {
			return $result;
		}
		// 修改或者添加
		$log_name = $data['Name']?:$data[ln('Name')];
		if (!$log_name && $this->before_row) $log_name = $this->before_row['Name']?:$this->before_row[ln('Name')];
		if ($this->before_row) {
			$Id = (int)$this->before_row['Id'];
			if ($this->table_copy) {
				db::update($this->table_copy, "Id=$Id", $data);
			}
			if (!$_POST['_save_copy_'] || !$this->table_copy) {
				db::update($this->table, "Id=$Id", $data);
			}
			log::manage($this->table, '修改，id：'.$_POST['Id'].'，'.$log_name);
		} else {
			unset($data['EditTime']);
			$Id = $_POST['Id'] = db::insert($this->table, $data);
			if ($this->table_copy) {
				$new_row = db::result("select * from ".$this->table." where Id=$Id");
				db::insert($this->table_copy, str::code($new_row, 'addslashes'));
				// db::query("INSERT INTO ".$this->table_copy." SELECT * FROM ".$this->table." WHERE Id=$Id");
			}
			log::manage($this->table, '添加，id：'.$_POST['Id'].'，'.$log_name);
		}
		// 获取最新数据
		if ($this->table_copy) {
			$this->row = db::result("select * from ".$this->table_copy." where Id=$Id");
			$yuanben_row = db::result("select * from ".$this->table." where Id=$Id");
			$this->row['Href'] = url::set($yuanben_row, $this->table);
			$yuanben_row['IsUnpublished'] = $yuanben_row['EditTime']!=$this->row['EditTime']?1:0;
			db::update($this->table, "Id='$Id'", array(
				'IsUnpublished' => $yuanben_row['IsUnpublished']
			));
		} else {
			$this->row = db::result("select * from ".$this->table." where Id=$Id");
			$this->row['Href'] = url::set($this->row, $this->table);
		}
		// 录入seo
		if ($this->dbc['Seo']) $this->save_seo();
		// 事后录入数据
		$this->save_after($_POST, array(
			'table' => $this->table,
			'table_copy' => $this->table_copy,
			'fields' => $this->fields,
			'is_ext_id' => $this->is_ext_id,
			'is_add' => $this->is_add,
			'is_mod' => $this->is_mod,
			'dbc' => $this->dbc,
			'row' => $this->row,
			'before_row' => $this->before_row,
		));
		// 事后录入关联
		$this->save_relative();
		// 保存编辑器内容
		// 将临时文件改成保存文件
		$this->save_tmp_file_path();
		// 保存后执行文件
		$file = $this->path.'/_.post.after.php'; is_file($file) && include $file;
		// ========================================================================
		$this->query_string['edit'] .= '&Id='.$this->row['Id'];
		$this->query_string['edit2'] .= '&Id='.$this->row['Id'];
		return array(
			'id' => $this->row['Id'],
			'is_add' => $this->is_add,
			'is_mod' => $this->is_mod,
			'edit_to_flush' => $this->edit_to_flush,
			'add_to_edit' => $this->add_to_edit,
			'add_to_list' => $this->add_to_list,
			'edit_to_list' => $this->edit_to_list,
			'query_string' => $this->query_string,
			'data' => $this->row, 
			'msg' => language('notes.ok'),
			'ret' => 1
		);
	}
	
	// 保存数据到数据库
	public function save_group(){
		if (!$this->permit['edit']) {
		    return array('msg'=>language('{/notes.no_permit/}'), 'ret'=>5001);
		}
		$this->before_row = g($this->table);
		$file = $this->path.'/_.post.before.php'; is_file($file) && include $file;
		// $group = $this->set['group'][0];
		$data = array();
		foreach ($this->dbc as $k => $v) {
			if (isset($_POST[$k])) {
				$data[$k] = str::code($_POST[$k],'stripslashes');
			}
			if ($v['Field']) {
				foreach ($v['Field'] as $k1 => $v1) {
					$data[$k1] = str::code($_POST[$k1],'stripslashes');
				}
			}
		}
		if ($data) {
			g($this->table, $data);
			log::manage($this->table, '修改');	
		}
		$this->row = g($this->table);
		$file = $this->path.'/_.post.after.php'; is_file($file) && include $file;
		return array(
			'id' => $this->row['Id'],
			'is_dbg' => 1,
			'is_add' => $this->is_add,
			'is_mod' => $this->is_mod,
			'edit_to_flush' => $this->edit_to_flush,
			'add_to_edit' => $this->add_to_edit,
			'add_to_list' => $this->add_to_list,
			'edit_to_list' => $this->edit_to_list,
			'query_string' => $this->query_string,
			'msg' => language('notes.ok'),
			'ret' => 1
		);
		return str::message(language('notes.ok'), 1);
	}
	

	// 保存seo数据
	public function save_seo(){
		if ( ($this->is_add&&!$this->permit['add']) || ($this->is_mod&&!$this->permit['edit']) ) {
		    return array('msg'=>language('{/notes.no_permit/}'), 'ret'=>5001);
		}
		$array = array();
		if ($this->dbc['Language']) {
			$array['IsMonolingual'] = 1;
			$array['SeoTitle'] = $_POST['SeoTitle'];
			$array['SeoKeyword'] = $_POST['SeoKeyword'];
			$array['SeoDescription'] = $_POST['SeoDescription'];
		} else {
			$array['IsMonolingual'] = 0;
			foreach ($this->language as $v) {
				$n = $this->lang('SeoTitle', $v);
				$array[$n] = $_POST[$n];
				$n = $this->lang('SeoKeyword', $v);
				$array[$n] = $_POST[$n];
				$n = $this->lang('SeoDescription', $v);
				$array[$n] = $_POST[$n];
			}
		}
		if (isset($_POST['SeoType'])) {
			$array['Type'] = $_POST['SeoType'];
		}
		$id = (int)$_POST['Id'];
		if ($this->table_copy) {
			db::seo_mod($this->table_copy, $id, $array);
		}
		if (!$_POST['_save_copy_'] || !$this->table_copy) {
			db::seo_mod($this->table, $id, $array);
		}
		$row = db::get_one($this->table, "Id='$id'");
		$name = $row['Name']?:$row[ln('Name')];
		log::manage($this->table, '修改 “'.addslashes($name).'” SEO');
		return str::message(language('notes.ok'), 1);
	}


	// 设置列表的配置
	public function list_config(){
		g("dbs.".$this->table."_list_search", str::code(array(
			'list' => (array)$_POST['list'],
			'search' => (array)$_POST['search']
		),'stripslashes'));
		return str::message(language('notes.ok'), 1);
	}


	// 回收站
	public function recycle () {
		if (!$this->permit['recycle']) {
		    return array('msg'=>language('{/notes.no_permit/}'), 'ret'=>5001);
		}
		$file = $this->path.'/_.recycle.before.php'; is_file($file) && include $file;
		$ids = explode(',', $_POST['Id']);
		$id = '0';
		foreach ($ids as $k => $v) {
			$v = (int)$v;
			$id .= ",".$v;
		}
		db::query("update ".$this->table." set IsDel=1 where Id in($id)");
		log::manage($this->table, '转移到回收站，Id='.$_POST['Id']);
		$file = $this->path.'/_.recycle.after.php'; is_file($file) && include $file;
		return str::message(language('notes.ok'), 1);
	}


	// 恢复
	public function restore () {
		if (!$this->permit['restore']) {
		    return array('msg'=>language('{/notes.no_permit/}'), 'ret'=>5001);
		}
		$file = $this->path.'/_.restore.before.php'; is_file($file) && include $file;
		$ids = explode(',', $_POST['Id']);
		$id = '0';
		foreach ($ids as $k => $v) {
			$v = (int)$v;
			$id .= ",".$v;
		}
		db::query("update ".$this->table." set IsDel=0 where Id in($id)");
		log::manage($this->table, '还原数据，Id='.$_POST['Id']);
		$file = $this->path.'/_.restore.after.php'; is_file($file) && include $file;
		return str::message(language('notes.ok'), 1);
	}


	// 删除
	public function delete () {
		if (!$this->permit['del']) {
		    return array('msg'=>language('{/notes.no_permit/}'), 'ret'=>5001);
		}
		$file = $this->path.'/_.delete.before.php'; is_file($file) && include $file;
		$ids = explode(',', $_POST['Id']);
		$id = '0';
		$uid = '';
		foreach ($ids as $v) {
			$v = (int)$v;
			if ($v) {
				$id .= ','.$v;
				$uid .= " or find_in_set('$v', UId)";
			}
		}
		$id = ltrim($id, ',');
		$uid = ltrim($uid, ' or');
		
		$table = $this->table;
		if ($this->table=='wb_manage') {
			if (!strstr(','.$id.',', manage('Id'))) {
				db::query("delete from {$table} where IsLock=0 and Id in($id)");
				log::manage($this->table, '删除管理员，id：'.$id);
				return str::message(language('notes.ok'), 1);
			}
		} else if ($_POST['Id']) {
			if ($this->is_wb_manage_id && manage('Level')!='1') {
				$rows = db::all("select Id,wb_manage_id from {$table} where IsLock=0 and Id in($id)");
				foreach ($rows as $v) {
					if ($v['wb_manage_id']!=$this->is_wb_manage_id) {
						return str::message('当前用户无权限修改此数据', 0);
					}
				}
			}
			$all_row = db::query("select Id from {$table} where IsLock=0 and Id in($id)");
			$id = '0';
			while ($v = db::result($all_row)) {
				$id .= ','.$v['Id'];
			}
			db::query("delete from {$table} where IsLock=0 and Id in($id)");
			db::query("delete from page_url where ExtTable='".$this->table."' and ExtId in($id)");
			if (db::has_table($table.'_tdk')) {
				db::query("delete from {$table}_tdk where ExtId in($id)");
			}
			if (db::has_table($table.'_detail')) {
				db::query("delete from {$table}_detail where ExtId in($id)");
			}
			if ($this->dbc['UId']) {
				db::query("delete from {$table} where $uid");
			}
			// 删除关联表
			foreach ($this->dbc as $k => $v) {
				if ($v['IsExtId']) {
					foreach ((array)$v['Table'] as $k1 => $v1) {
						$ex_table = $this->tablename($v1);
						db::query("delete from {$ex_table} where ".$this->table."_id in($id)");
					}
				}
			}
			log::manage($this->table, '删除数据'.$table.'，id：'.$id);
			$file = $this->path.'/_.delete.after.php'; is_file($file) && include $file;
			return str::message(language('notes.ok'), 1);
		}
		return str::message(language('notes.fail'));
	}
	


	// 复制
	public function copy () {
		if (!$this->permit['copy']) {
		    return array('msg'=>language('{/notes.no_permit/}'), 'ret'=>5001);
		}
		$file = $this->path.'/_.copy.before.php'; is_file($file) && include $file;
		$table = $this->table;
		$id = (int)$_POST['Id'];
		$one = db::result("select * from $table where Id='$id'");
		if ($one) {
			if ($this->is_wb_manage_id && manage('Level')!='1' && $one['wb_manage_id']!=$this->is_wb_manage_id) {		
				return str::message('当前用户无权限修改此数据', 0);
			}
			unset($one['Id']);
			$one['AddTime'] = $one['AddTime'] = c('time');
			$new_id = db::insert($table, str::code($one, 'addslashes'));
			// 复制详情
			if (db::has_table($table.'_detail')) {
				$editor = db::query("select * from {$table}_detail where ExtId='$id'");
				while ($v = db::result($editor)) {
					unset($v['Id']);
					$v['ExtId'] = $new_id;
					db::insert($table.'_detail', str::code($v, 'addslashes'));
				}
			}
			// 复制tdk
			if (db::has_table($table.'_tdk')) {
				$editor = db::query("select * from {$table}_tdk where ExtId='$id'");
				while ($v = db::result($editor)) {
					unset($v['Id']);
					$v['ExtId'] = $new_id;
					db::insert($table.'_tdk', str::code($v, 'addslashes'));
				}
			}
			// 复制其它表
			foreach ($this->dbc as $k => $v) {
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
			}
			$file = $this->path.'/_.copy.after.php'; is_file($file) && include $file;
			log::manage($this->table, '复制数据，id：'.$id.'，新id：'.$new_id);
			return str::message(language('notes.ok'), 1);
		}
		return str::message(language('notes.fail'));
	}
	

	// 排序
	public function myorderby () {
		if (!$this->permit['edit']) {
		    return array('msg'=>language('{/notes.no_permit/}'), 'ret'=>5001);
		}
		$ids = is_array($_POST['Id'])?$_POST['Id']:explode(',', $_POST['Id']);
		$orderby = is_array($_POST['MyOrder'])?$_POST['MyOrder']:explode(',', $_POST['MyOrder']);
		foreach ($ids as $k => $v) {
			$v = (int)$v;
			$r = (int)$orderby[$k];
			if ($v) {
				db::query("update ".$this->table." set MyOrder=$r where Id=$v");
			}
		}
		log::manage($this->table, '修改排序，id：'.$_POST['Id']);
		return str::message(language('notes.ok'), 1);
	}
	

	// 转移分类
	public function save_uid () {
		if (!$this->permit['edit']) {
		    return array('msg'=>language('{/notes.no_permit/}'), 'ret'=>5001);
		}
		$_POST['UId'] || $_POST['UId'] = '0,';
		$where = '0';
		if ($_POST['Id']) {
			$ids = explode(',', (string)$_POST['Id']);
			$ids_where = '0';
			foreach ($ids as $v) {
				if ($v=(int)$v) {
					$ids_where .= ','.$v;
					$uids_where .= " and find_in_set('$v',UId)=0";
				}
			}
			$where = "Id in($ids_where) {$uids_where}";
		}
		$row = db::get_all($this->table, $where, 'Id,UId');
		if (!$row) {
			return str::message('数据错误');
		}
		$ids_where = '0';
		foreach ($row as $k => $v) {
			$ids_where .= ','.$v['Id'];
			$new_uid = $_POST['UId'].$v['Id'].',';
			$cur_uid = $v['UId'].$v['Id'].',';
			$new_dept = db::get_all($this->table, "find_in_set({$v['Id']},UId)", "Id,UId");
			$uid_array = array();
			foreach ($new_dept as $k1 => $v1) {
				$uid_array[$v1['UId']] = str_replace($cur_uid, $new_uid, $v1['UId']);
			}
			foreach ($uid_array as $k1 => $v1) {
				db::update($this->table, "UId='$k1'", array(
					'UId' => $v1,
					'Dept'=> substr_count($v1, ',')
				));
			}
		}
		$where = "Id in($ids_where)";
		db::update($this->table, $where, array(
			'UId' => $_POST['UId'],
			'Dept'=> substr_count($_POST['UId'], ',')
		));
		log::manage($this->table, '转移分类，id：'.$_POST['Id']);
		return str::message(language('notes.ok'), 1);
	}

}

?>