<?php

function_exists('c') || exit;

$dir_ary = array(
	'linear_thin' => array(
		'name' => language('{/dbs.websvg.linear_thin/}'),
		'tag' => 'linear',
		'weight' => 'thin',
		'label' => array(
			'common' => array(
				'name' => language('{/dbs.websvg.common/}'),
			),
			'medical' => array(
				'name' => language('{/dbs.websvg.medical/}'),
			),
			'rubbish' => array(
				'name' => language('{/dbs.websvg.rubbish/}'),
			),
			'furnishings' => array(
				'name' => language('{/dbs.websvg.furnishings/}'),
			)
		),
	),
	'linear_blod' => array(
		'name' => language('{/dbs.websvg.linear_bold/}'),
		'tag' => 'linear',
		'weight' => 'bold',
		'label' => array(
			'common' => array(
				'name' => language('{/dbs.websvg.common/}'),
			),
			'furnishings' => array(
				'name' => language('{/dbs.websvg.furnishings/}'),
			),
		),
	),
	'area_bold' => array(
		'name' => language('{/dbs.websvg.planarity_bold/}'),
		'tag' => 'area',
		'weight' => 'bold',
		'label' => array(
			'common' => array(
				'name' => language('{/dbs.websvg.common/}'),
			),
			'furnishings' => array(
				'name' => language('{/dbs.websvg.furnishings/}'),
			),
		),
	),
);

$_POST['type'] || $_POST['type'] = 'linear_thin';
$_POST['tag'] || $_POST['tag'] = 'linear';
$_POST['weight'] || $_POST['weight'] = 'thin';
$_POST['label'] || $_POST['label'] = 'common';

// 
foreach ($dir_ary as $k => &$vv) {
	if ($k==$_POST['type']) {
		$vv['_cur_'] = 1;
		foreach ($vv['label'] as $k2 => &$vv2) {
			if ($k2==$_POST['label']) {
				$vv2['_cur_'] = 1;
			}
		}
	}
}


$where = "1";
if ($_POST['tag']) {
	$where .= " and Tag='{$_POST['tag']}'";
}
if ($_POST['label']) {
	$where .= " and Label='{$_POST['label']}'";
}
if ($_POST['weight']) {
	$where .= " and Weight='{$_POST['weight']}'";
}
$row = lydb::query("select * from ss_svg where $where");
$list_ary = array();
while ($v = lydb::result($row)) {
	$list_ary[] = array(
		'type' => $v['Tag'],
		'path' => $v['Path'],
	);
}

// 
exit(str::json(array(
	'dir' => $dir_ary,
	'list' => $list_ary,
)));