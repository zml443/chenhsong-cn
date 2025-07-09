<?php

namespace dbs;
use db;
use str;
use url;
use img;

class func {
	/**
	 * 整理一下表名称
	 * @param {string} $table 文件名
	 * @return {string}
	 */
	public function tablename ($table) {
		if (!$table) return '';
		$table = preg_replace('/_index$/', '', str_replace('/', '_', $table));
		if (preg_match('/^(_jext|_data|wb)_/', $table)) {
			return preg_replace('/^_/', '', $table);
		} else {
			return 'wb_'.$table;
		}
	}
	public function input_name ($name) {
		$name = explode('.', $name);
		$new_name = '';
		foreach ($name as $k => $v) {
			if ($k) {
				$new_name .= "[{$v}]";
			} else {
				$new_name .= $v;
			}
		}
		return $new_name;
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
	 * 排序下拉
	 * @param {int} $myorder 排序编号
	 * @return {string}
	 */
	public function my_order ($myorder) {
		return db::my_order($myorder);
	}
	/**
	 * 整理多语言的后缀，包含了json格式的情况
	 * @param {string} $n 字段名称
	 * @param {string} $l 语言后缀
	 * @return {string}
	 */
	public function lang ($n, $l) {
		return strpos($n,']') ? str_replace(']$', '_'.$l.']', $n.'$') : $n.'_'.$l;
	}
	/**
	 * 追加一个后缀
	 * @param {string} $n 字段名称
	 * @param {string} $l 语言后缀
	 */
	public function ext_name ($n, $l) {
		return strpos($n,']') ? str_replace(']$', $l.']', $n.'$') : $n.$l;
	}
	/**
	 * 导入功能文件
	 * @param {string} $dir 功能对应的文件夹
	 * @param {string} $type 功能名称
	 * @return {string}
	 */
	public function include_type_file ($dir, $type) {
		$_r0 = dirname(__FILE__) . '/tool/';
		$__f = $_r0.$type.'/'.$dir.'.php'; if (is_file($__f)) return $__f;
		$__f = $_r0.strtolower($type).'/'.$dir.'.php'; if (is_file($__f)) return $__f;
		// $__f = $_r0.lcfirst($type).'/'.$dir.'.php'; if (is_file($__f)) return $__f;

		$_r0 = c('root');
		$__f = $_r0.$type.'/'.$dir.'.php'; if (is_file($__f)) return $__f;
		$__f = $_r0.strtolower($type).'/'.$dir.'.php'; if (is_file($__f)) return $__f;
		// $__f = $_r0.lcfirst($type).'/'.$dir.'.php'; if (is_file($__f)) return $__f;
		return '';
	}

	// 导入搜索文件
	public function search_func ($name, $cfg=array(), $prefix_name='') {
		$type = $cfg['Type'];
		$__f = self::include_type_file('search', $type);
		$__h = '';
		if ($__f) {
			// ob_start();
			include $__f;
			// $__h = ob_get_contents();
			// ob_end_clean();
		}
		return $__h;
	}

	// 导入列表的功能文件
	public function list_func ($name, $row, $cfg=array(), $prefix_name='') {
		if ($cfg['ListType']) {
			$type = $cfg['ListType'];
		} else {
			$type = $cfg['Type'];
		}
		$__f = self::include_type_file('list', $type);
		$__h = '';
		if ($__f) {
			ob_start();
			include $__f;
			$__h = ob_get_contents();
			ob_end_clean();
		} else {
			$__h = $type;
		}
		return $__h;
	}

	// 导入 form 功能文件
	// $prefix_name 为 input name 的前缀，用于json命名的拼接
	public function form_func ($name, $row, $cfg=array(), $prefix_name='') {
		$type = $cfg['Type'];
		$__f = self::include_type_file('form', $type);
		$__h = '';
		if ($__f) {
			if (strpos($name, '.')) { //json会经过这里
				$__name = explode('.', $name);
				$name = $__name[0];
				$count = count($__name);
				foreach ($__name as $k => $v) {
					if (!$k) continue;
					$name.="[$v]";
				}
				$__ex = $v;
			} else {
				$__ex = $name;
			}
			$value = @$row[$__ex];
			if ($cfg['Lang']) { //多语言
				$value = array();
				foreach ($this->language as $v) {
					$vv = $row[$__ex.'_'.$v];
					$value[$v] = is_array($vv) ? str::code(str::json($vv)) : $vv;
				}
			} else if (is_array($value)) {
				// 这个是为了模拟数据库的json格式
				$value = $value ? str::code(str::json($value)) : '';
			}
			ob_start();
			include $__f;
			$__h = ob_get_contents();
			ob_end_clean();
		}
		return $__h;
	}
	
	/**
	 * 获取组件
	 * @param {string} $name 字段名
	 * @param {array} $v 数据
	 * @return {string}
	 */
	public function ed ($name, $v=array(), $cfg=array()) {
		$cfg||$cfg=$this->dbc[$name];
		if ($name=='_Id') {
			return "<input type='hidden' name='Id' value='{$v['Id']}'><input type='hidden' name='ex_na' value='{$_GET['ex_na']}'><input type='hidden' name='ex_id' value='{$_GET['ex_id']}'>";
		}
		else {
			return $this->form_func($name, $v, $cfg);
		}
	}
	public function li ($name, $v=array(), $cfg=array()) {
		$v||$v=array();
		$cfg||$cfg=$this->dbc[$name];
		if ($name=='_Id') {
			$html = "<label class='-id-checkbox'><input type='checkbox' name='Id' data-id value='{$v['Id']}'></label>";
		}
		else if ($name=='_Ex') {
			$html = "<input type='hidden' name='ex_na' value='{$_GET['ex_na']}'><input type='hidden' name='ex_id' value='{$_GET['ex_id']}'>";
		}
		else if ($name=='_MyOrder') {
			$html = "<select class='ly_input' size='mini' name='MyOrder' or='{$v['MyOrder']}' dbs='myorder' i='{$v['Id']}' data-id='{$v['Id']}'>".$this->my_order($v['MyOrder'])."</select>";
			$cfg['NotSubmitLi'] = 1;
		}
		else if ($name=='_UId') {
			$width = $this->permit['_add']>1?$this->permit['_add']:'900';
			$html = "<div class='-uid-btn' dbs='editdb' wh='[{$width},0]' href='".$this->query_string['list']."&_UId={$v['Id']}'>+</div>";
		}
		else if ($name=='_Ope') {
			$more = '';
			if ($_GET['IsDel']) {
				if ($this->permit['del']) {
					$del = "<a class='ly_btn_round lyicon-close' bg='light' dbs='del' data-id='{$v['Id']}'></a>";
				}
				$restore = "<a class='ly_btn_round lyicon-huifu' bg='light' dbs='restore' data-id='{$v['Id']}' ly-tip-bubble='{direction:top_center}' data-tip-contents='".language('{/global.restore/}')."'></a>";
			}
			else {
				if ($this->permit['del'] && !($this->ismanage && $v['Id']==manage('Id'))) {
					if ($this->permit['recycle']&&!$_GET['IsDel']) {
						$recycle = "<a class='ly_btn_round lyicon-ashbin' bg='light' dbs='recycle' data-id='{$v['Id']}' ly-tip-bubble='{direction:top_center}' data-tip-contents='".language('{/global.recycle/}')."'></a>";
					} else {
						$delete_check = '';
						if (is_file($this->path.'/_.delete.check.php')) {
							$delete_check = '?ma='.$_GET['ma'].'/_.delete.check';
						}
						$del = "<a class='ly_btn_round lyicon-close ".($v['IsLock']?'not-event gray':'')."' bg='light' dbs='del' data-id='{$v['Id']}' data-check='{$delete_check}' ly-tip-bubble='{direction:top_center}' data-tip-contents='".language('{/global.del/}')."'></a>";
					}
				}
				if ($this->permit['copy']) {
					$copy = "<a class='ly_btn_round lyicon-copy' bg='light' lydbs-copy='' data-id='{$v['Id']}' ly-tip-bubble='{direction:top_center}' data-tip-contents='".language('{/global.copy/}')."'></a>";
				}
				if ($this->permit['edit'] && !$this->permit['_hide_edit']) {
					$editurl = $this->query_string['edit']."&Id={$v['Id']}";
					$_edit_popup = ($this->permit['_edit']?"dbs-edit-popup='' wh='[{$this->permit['_edit']},0]' href='$editurl'":"hr-ef='$editurl'");
					$edit = "<a class='ly_btn_round lyicon-bianji' bg='light' dbs='edit' {$_edit_popup} ly-tip-bubble='{direction:top_center}' data-tip-contents='".language('{/global.edit/}')."'></a>";
				}
			}
			$html = "<div class='ly_gap_10px'>{$edit}{$copy}{$restore}{$recycle}{$del}</div>";
		}
		else {
			$html = $this->list_func($name, $v, $cfg);
		}
		if ($cfg['NotSubmitLi']) {
			return '<form class="-tddiv" data-key="'.$name.'" data-id="'.$v['Id'].'" data-type="'.strtolower($cfg['Type']).'">'.$html.'</form>';
		} else {
			return '<form class="-tddiv" data-key="'.$name.'" lydbs-submit-list data-id="'.$v['Id'].'" 1212 data-type="'.strtolower($cfg['Type']).'">'.$html.'</form>';
		}
	}
	public function th ($name, $v=array(), $cfg=array()) {
		$cfg||$cfg=$this->dbc[$name];
		if ($name=='_Id') {
			return "<label class='-id-checkbox'><input type='checkbox' all='[name=Id]'></label>";
		} else {
			$field = $this->set['list']['layout'][$name];
			return $field ? $field['name'] : '';
		}
	}
}

?>