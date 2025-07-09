<?php

include '../../../../php/init.php';


$type1 = '../cfg/'.($_POST['GroupId']?str_replace('../','',$_POST['GroupId']):'default').'.php';
if (is_file($type1)) {
	include $type1;
} else {
	str::msg('配置错误', 0);
}

if (!$__PERMISSION) {
	str::msg('权限不足', 0);
}

if (!$__WHERE) {
	str::msg('配置错误', 0);
}

/*
 * 参数
 * 
**/
extract($_POST, EXTR_PREFIX_ALL, 'p');


/*
 * 添加文件夹
 * 
**/
if ($p_do == 'add') {
	$UId = $p_UId ? $p_UId : '0,';
	if (!$p_Name) {
		str::msg('名字不能为空', 0);
	} else if (db::get_row_count('jext_files', $__WHERE . " and UId='$UId' and Name='$p_Name' and Type=0")) {
		str::msg('名字重复', 0);
	}
	$Id = db::insert('jext_files', array(
		'UId'		=>	$UId,
		'Dept'		=>	substr_count($UId, ','),
		'ExtId'		=>	$__ADDDIR['ExtId'] ? $__ADDDIR['ExtId'] : 0,
		'ExtId2'	=>	$__ADDDIR['ExtId2'] ? $__ADDDIR['ExtId2'] : 0,
		'GroupId'	=>	$__ADDDIR['GroupId'] ? $__ADDDIR['GroupId'] : $p_GroupId,
		'Name'		=>	$__ADDDIR['Name'] ? $__ADDDIR['Name'] : $p_Name,
		'Path'		=>	'',
		'AddTime'	=>	time(),
		'Type'		=>	0,
		'IsTmp'		=>	0
	));
	log::manage('jext_files', '添加文件夹');
	str::msg(array(
		'Name'	=>	$p_Name,
		'Id'	=>	$Id,
		'UId'	=>	$p_UId . $Id . ',',
	), 1);
}



/*
 * 删除文件
 * 
**/
else if ($p_do == 'del') {
	$ids = explode(',', $p_Id);
	$arr = array();
	$__DELWHERE = $__DELWHERE ? $__DELWHERE : $__WHERE;
	function delete_file($file){
		$root = c('root');
		if (c('aliyun_oss.id') && strstr($file, '.aliyuncs.com')) {
			aliyun_oss::delete_file($file);
		} else {
			file::unlink($root.$file, 1);
		}
	}
	foreach ($ids as $k => $v) {
		$v = (int)$v;
		if ($v) {
			$one = db::result("select * from jext_files where {$__DELWHERE} and Id='{$v}'");
			if ($one) {
				$arr[] = $one;
				delete_file($one['Path']);
				$all = db::query("select * from jext_files where {$__DELWHERE} and find_in_set('{$one['Id']}', UId)");
				while ($v1 = db::result($all)) {
					delete_file($v1['Path']);
					$arr[] = $v1;
				}
				db::query("delete from jext_files where {$__DELWHERE} and (find_in_set('{$one['Id']}', UId) or Id='{$one['Id']}')");
			}
		}
	}
	log::manage('jext_files', '删除文件');

	$jext_files_size = jext_files::size();
	$HostStorageSize = c('HostStorageSize');
	exit(str::json(array(
		'ret' => 1,
		'msg' => '已删除',
		'HostStorageSize' => file::size($HostStorageSize),
		'jext_files_size' => file::size($jext_files_size),
		'storage_percentage' => $HostStorageSize?round($jext_files_size/$HostStorageSize,2)*100:0
	)));
	// str::msg('', 1);
}


/*
 * 移动文件
 * 
**/
else if ($p_do == 'move') {
	$ids = explode(',', $p_Id);
	$p_UId = $_POST['UId'] ? $_POST['UId'] : '0,';
	foreach ($ids as $k => $v) {
		$v = (int)$v;
		db::query("update jext_files set UId = '{$p_UId}' where {$__WHERE} and Id = '{$v}'");
	}
	log::manage('jext_files', '移动文件，id:'.$p_Id);
	str::msg('', 1);
}


/*
 * 移动文件
 * 
**/
else if ($p_do == 'move_html') {
	$category = db::ly_drop_select_category('UId', 'jext_files', "{$__WHERE} AND Type=0", "Id asc");
	echo str::json($category);
	exit;
}



/*
 * 编辑图片
 * 
**/
else if ($p_do == 'mod_html') {
	$id = (int)$_POST['id'];
	$row = db::result("select * from jext_files where Id='$id' and {$__WHERE}");
	$category = db::category("Id", $row['CateId'], "jext_files_category");
?>
	<style>
		.jfilemodstyle{}
		.jfilemodstyle td{padding:5px 0;}
		.jfilemodstyle .a{padding-right:20px; font-size:14px; line-height:28px; vertical-align:top;}
		.jfilemodstyle .b select{border:1px solid #ddd; border-radius:4px; height:28px; padding-left:5px;}
		.jfilemodstyle .b textarea{border:1px solid #ddd; border-radius:4px; width:400px; height:120px; resize:none; padding:3px 7px;}
	</style>
	<form>
		<table class="jfilemodstyle">
			<tr>
				<td class="a">类别</td>
				<td class="b"><select name="CateId"><option value="">--请选择--</option><?=$category?></select></td>
			</tr>
			<tr>
				<td class="a">标签</td>
				<td class="b"><textarea name="Tag"><?=$row['Tag']?></textarea></td>
			</tr>
		</table>
		<input type="hidden" name="Id" value="<?=$id?>" />
		<input type="hidden" name="do" value="mod" />
	</form>
<?php
	exit;
}


/*
 * 编辑图片
 * 
**/
else if ($p_do == 'mod') {
	$Id = (int)$_POST['Id'];
	db::update('jext_files', "Id='$Id' and {$__WHERE}", array(
		'CateId' => (int)$_POST['CateId'],
		'Tag' => str_replace(array("\r", "\t"), '', str_replace(array('，',';','；',"\n"), ',', $_POST['Tag']))
	));
	str::msg('', 1);
}




/*
 * 修改名称
 * 
**/
else if ($p_do == 'mod_name') {
	$Id = (int)$_POST['id'];
	db::update('jext_files', "Id='$Id' and {$__WHERE}", array(
		'Name' => $_POST['name']
	));
	str::msg('', 1);
}
?>