<?php


$option = array(// 设置圆环
	'tooltip'	=>	array(// 鼠标移入显示数据
						'trigger'	=>	'item',// 默认item，不用就none
					),
	'color'		=>	array('#8c97cb', '#3be1a8', '#00b7ee'),// 顺时针饼图颜色数组
	'graphic'	=>	array(
						'type'	=>	'text',// 类型为文本
						'left'	=>	'center',// 水平居中
						'top'	=>	'center',// 垂直居中
						'style'	=>	array(
										'text'			=>	'文本内容',// 文本内容
										'fill'			=>	'#333',// 文本颜色
										'fontSize'		=>	'24',// 文字大小
										'fontWeight'	=>	'700',// 文本加粗
										'fontFamily'	=>	'Arial',// 文字字体
									)
					),
	'series'	=>	array(
						'type'					=>	'pie',// 类型是饼图pie
						'radius'				=>	array('72%', '100%'),// 左边是内圈宽度，右边是外圈宽度
						'avoidLabelOverlap'		=>	false,// 防止重叠，标签过多建议开启
						'itemStyle'				=>	array(
															'borderColor'		=>	'#fff',// 圆环间的边框颜色
															'borderWidth'		=>	'2',// 圆环间的边框大小
													),
						'label'					=>	array('show' => false),// 在圆环外展示圆环的数据
						'labelLine'				=>	array('show' => false),// 展示圆环数据时的线条设置
						'data'					=>	array(
														array('value'=>'500',	'name'=>'aaa'),
														array('value'=>'1000',	'name'=>'bbb'),
														array('value'=>'2000',	'name'=>'ccc'),
													),
						'emphasis'				=>	array('scale' => false)// 关闭鼠标移入圆环放大效果，true就开启
					),
);

echo jxs::json($option);
