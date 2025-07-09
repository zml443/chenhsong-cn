<?php
namespace dbs;
use str;
use permit;
use db;
use js;

include dirname(__FILE__).'/func.class.php';
include dirname(__FILE__).'/config.class.php';
include dirname(__FILE__).'/data.class.php';
include dirname(__FILE__).'/edit.class.php';
include dirname(__FILE__).'/lists.class.php';
include dirname(__FILE__).'/dbc.class.php';

class get {
	/**
	 * 类初始函数，负责整理配置参数
	 * @return {void}
	 */
	public static function html () {
		$set = array_merge(array(
			'path'   => $_GET['ma'],
			'permit' => permit::all($_GET['ma']),
			'list' => array(),
			'edit' => array(),
			'post' => array(),
		));
		// 
		$d_ary = array('list', 'edit', 'add', 'post', 'del', 'recycle', 'restore', 'copy', 'myorder', 'save-seo', 'save-uid', 'list-config');
		if ($_GET['_edit_insert_']) {
			$_GET['d'] = 'edit';
		}
		if (($_GET['e']||$_GET['E']) && !$_GET['l'] && !$_GET['L'] && !$_GET['d']) {
			$_GET['d'] = 'edit';
		}
		in_array($_GET['d'], $d_ary) || $_GET['d'] = 'list';
		if ($_GET['d']=='list' && !$set['permit']['list'] && $set['permit']['edit']) {
			$_GET['d'] = 'edit';
		}
		switch ($_GET['d']) {
			// 数据保存
			case 'post':
				$dbs = new data($_GET['ma'], $set);
				$result = $dbs->save();
				$result['id'] = (int)$_POST['Id'];
				exit(str::json($result));
			// 提交seo
			case 'save-seo':
				$dbs = new data($_GET['ma'], $set);
				$result = $dbs->save_seo();
				exit(str::json($result));
			// 批量转移分类
			case 'save-uid':
				$dbs = new data($_GET['ma'], $set);
				$result = $dbs->save_uid();
				exit(str::json($result));
			// 删除
			case 'del':
				$dbs = new data($_GET['ma'], $set);
				$result = $dbs->delete();
				exit(str::json($result));
			// 回收站
			case 'recycle':
				$dbs = new data($_GET['ma'], $set);
				$result = $dbs->recycle();
				exit(str::json($result));
			// 回收站-还原
			case 'restore':
				$dbs = new data($_GET['ma'], $set);
				$result = $dbs->restore();
				exit(str::json($result));
			// 复制
			case 'copy':
				$dbs = new data($_GET['ma'], $set);
				$result = $dbs->copy();
				exit(str::json($result));
			// 排序
			case 'myorder':
				$dbs = new data($_GET['ma'], $set);
				$result = $dbs->myorderby();
				exit(str::json($result));
			// 列表
			case 'list':
				$lists = new lists($_GET['ma'], $set);
				echo $lists->html();
				break;
			// 编辑
			case 'add':
			case 'edit':
				$edit = new edit($_GET['ma'], $set);
				echo $edit->html();
				break;
		}
	}
}
get::html();