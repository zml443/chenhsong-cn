<?php
// 防止恶意进入
function_exists('c')||exit;

if (!p('orders.index.export')) {
	str::msg('权限不够');
}

// 积分兑换订单-导出 开始 ===============================================================================================
$ExcelContents = array(
	//设置行高
	array(
		'cell'			=>	'A1',// 单元格
		'val'			=>	'',// 内容
		'height'		=>	'21',// 行高
	),
	array(
		'cell'			=>	'A2',// 单元格
		'val'			=>	'',// 内容
		'height'		=>	'24',// 行高
	),
	array(
		'cell'			=>	'A3',// 单元格
		'val'			=>	'',// 内容
		'height'		=>	'25.5',// 行高
	),
	array(
		'cell'			=>	'A4',// 单元格
		'val'			=>	'',// 内容
		'height'		=>	'23.25',// 行高
	),
	array(
		'cell'			=>	'A5',// 单元格
		'val'			=>	'',// 内容
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'A6',// 单元格
		'val'			=>	'',// 内容
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'A7',// 单元格
		'val'			=>	'',// 内容
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'A8',// 单元格
		'val'			=>	'',// 内容
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'A9',// 单元格
		'val'			=>	'',// 内容
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'A10',// 单元格
		'val'			=>	'',// 内容
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'B2',// 单元格
		// 'height'		=>	'25.5',// 行高
		'imgary'		=>	array(
			0	=>	array(
				'Path'			=>	c('root')."/static/images/ico/79a73f60-4287-4de4-b370-eaae4b3131f7.png",
				'OffsetX'    	=>	'0',
				'OffsetY'    	=>	'0',
				'Rotation'   	=>	'0',
				'Width'      	=>	'47',
				'Height'     	=>	'47',
				'Shadow'     	=> array(//阴影
						'Visible'   =>  'false',
						'Direction' =>  '0',
				),
			)
		),
	),
	
	array(
		'cell'			=>	'C2',// 单元格
		'val'			=>	'销售出库单',// 内容
		'style'			=>	"size:20px;weight:true;wrap:false;family:等线;",// 样式
	),
	array(
		'cell'			=>	'C3',// 单元格
		'val'			=>	' Sales delivery order',// 内容
		'style'			=>	"size:10px;wrap:false;valign:top;color:7f7f7f7f;family:等线;",// 样式
	),
	array(
		'cell'			=>	'B4',// 单元格
		'val'			=>	'出库单号：',// 内容
		'style'			=>	"size:10px;wrap:false;valign:top;align:right;family:等线;",// 样式
	),
	array(
		'cell'			=>	'C4',// 单元格
		'val'			=>	'',// 内容
		'style'			=>	"size:10px;wrap:false;valign:top;family:等线;",// 样式
	),
	array(
		'cell'			=>	'D4',// 单元格
		'val'			=>	'',// 内容
		'style'			=>	"size:10px;wrap:false;valign:top;family:等线;",// 样式
	),
	array(
		'cell'			=>	'E4',// 单元格
		'val'			=>	'',// 内容
		'style'			=>	"size:10px;wrap:false;valign:top;family:等线;",// 样式
	),
	array(
		'cell'			=>	'F4',// 单元格
		'val'			=>	'',// 内容
		'style'			=>	"size:10px;wrap:false;valign:top;family:等线;",// 样式
	),
	array(
		'cell'			=>	'G4',// 单元格
		'val'			=>	'',// 内容
		'style'			=>	"size:10px;wrap:false;valign:top;family:等线;",// 样式
	),
	array(
		'cell'			=>	'H4',// 单元格
		'val'			=>	'',// 内容
		'style'			=>	"size:10px;wrap:false;valign:top;family:等线;",// 样式
	),
	array(
		'cell'			=>	'I4',// 单元格
		'val'			=>	'出库日期：',// 内容
		'style'			=>	"size:10px;wrap:false;valign:top;family:等线;",// 样式
	),
	array(
		'cell'			=>	'J4',// 单元格
		'val'			=>	'',// 内容
		'style'			=>	"size:10px;wrap:false;valign:top;family:等线;",// 样式
	),
	array(
		'cell'			=>	'K4',// 单元格
		'val'			=>	'',// 内容
		'style'			=>	"size:10px;wrap:false;valign:top;family:等线;",// 样式
	),
	array(
		'cell'			=>	'B5:K5',// 单元格
		'val'			=>	'客户信息',// 内容
		'style'			=>	"size:11px;wrap:false;valign:center;align:center;family:等线;background:59595959;color:ffffffff;weight:true;",// 样式
	),
	
	array(
		'cell'			=>	'B6',// 单元格
		'val'			=>	'客户姓名',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;border:1px d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'C6:F6',// 单元格
		'val'			=>	'广州联雅网络科技有限公司',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;border:1px d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'G6',// 单元格
		'val'			=>	'订单编号',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;border:1px d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'H6:K6',// 单元格
		'val'			=>	'SD-20200910001',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;border:1px d9d9d9d9;",// 样式
	),
	
	
	array(
		'cell'			=>	'B7',// 单元格
		'val'			=>	'收货地址',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;border:1px d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'C7:F7',// 单元格
		'val'			=>	'广州市越秀区越秀南路185号',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;border:1px d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'G7',// 单元格
		'val'			=>	'联系电话',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;border:1px d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'H7:K7',// 单元格
		'val'			=>	'020-123456',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;border:1px d9d9d9d9;",// 样式
	),
	
	
	array(
		'cell'			=>	'B8',// 单元格
		'val'			=>	'开户银行',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;border:1px d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'C8:F8',// 单元格
		'val'			=>	'中国工商银行 复兴路支行',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;border:1px d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'G8',// 单元格
		'val'			=>	'税　　号',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;border:1px d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'H8:K8',// 单元格
		'val'			=>	'9144030******6726XG',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;border:1px d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'B9:K9',// 单元格
		'val'			=>	'货品清单',// 内容
		'style'			=>	"size:11px;wrap:false;valign:center;align:center;family:等线;background:59595959;color:ffffffff;weight:true;",// 样式
	),
);

$pro_list = array(
	array(
		'Name'=>'预制板',
		'Model'=>'A-C10',
		'Unit'=>'件',
		'Qty'=>15,
		'Price'=>80,
		'Total'=>1200,
		'Status'=>'Y'
	),
	array(
		'Name'=>'预制板',
		'Model'=>'A-C10',
		'Unit'=>'件',
		'Qty'=>15,
		'Price'=>80,
		'Total'=>1200,
		'Status'=>'Y'
	),
	array(
		'Name'=>'预制板',
		'Model'=>'A-C10',
		'Unit'=>'件',
		'Qty'=>15,
		'Price'=>80,
		'Total'=>1200,
		'Status'=>'Y'
	),
	array(
		'Name'=>'预制板',
		'Model'=>'A-C10',
		'Unit'=>'件',
		'Qty'=>15,
		'Price'=>80,
		'Total'=>1200,
		'Status'=>'Y'
	),
	array(
		'Name'=>'预制板',
		'Model'=>'A-C10',
		'Unit'=>'件',
		'Qty'=>15,
		'Price'=>80,
		'Total'=>1200,
		'Status'=>''
	),
	array(
		'Name'=>'预制板',
		'Model'=>'A-C10',
		'Unit'=>'件',
		'Qty'=>15,
		'Price'=>80,
		'Total'=>1200,
		'Status'=>''
	),
	array(
		'Name'=>'预制板',
		'Model'=>'A-C10',
		'Unit'=>'件',
		'Qty'=>15,
		'Price'=>80,
		'Total'=>1200,
		'Status'=>''
	),
	array(
		'Name'=>'预制板',
		'Model'=>'A-C10',
		'Unit'=>'件',
		'Qty'=>15,
		'Price'=>80,
		'Total'=>1200,
		'Status'=>''
	),
);
$ExcelContents = array_merge($ExcelContents,array(
	array(
		'cell'			=>	'B10',// 单元格
		'val'			=>	'序号',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;background:a6a6a6a6;color:ffffffff;weight:true;border:1px #d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'C10:D10',// 单元格
		'val'			=>	'货品名称',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;background:a6a6a6a6;color:ffffffff;weight:true;border:1px #d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'E10:F10',// 单元格
		'val'			=>	'规格型号',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;background:a6a6a6a6;color:ffffffff;weight:true;border:1px #d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'G10',// 单元格
		'val'			=>	'单位',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;background:a6a6a6a6;color:ffffffff;weight:true;border:1px #d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'H10',// 单元格
		'val'			=>	'数量',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;background:a6a6a6a6;color:ffffffff;weight:true;border:1px #d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'I10',// 单元格
		'val'			=>	'单价',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;background:a6a6a6a6;color:ffffffff;weight:true;border:1px #d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'J10',// 单元格
		'val'			=>	'货款',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;background:a6a6a6a6;color:ffffffff;weight:true;border:1px #d9d9d9d9;",// 样式
	),
	array(
		'cell'			=>	'K10',// 单元格
		'val'			=>	'已发货',// 内容
		'style'			=>	"size:10px;wrap:false;valign:center;align:center;family:等线;background:a6a6a6a6;color:ffffffff;weight:true;border:1px #d9d9d9d9;",// 样式
	),
));
$start_num = 11;
foreach((array)$pro_list as $k=>$v){
	if(($k+1)%2==0){
		$style='size:10px;wrap:false;valign:center;align:center;family:等线;background:f2f2f2f2;border:1px #d9d9d9d9;';
	}else{
		$style='size:10px;wrap:false;valign:center;align:center;family:等线;border:1px #d9d9d9d9;';
	}
	$ExcelContents = array_merge($ExcelContents,array(
		array(
			'cell'			=>	'B'.$start_num,// 单元格
			'val'			=>	$k+1,// 内容
			'style'			=>	$style,// 样式
			'height'		=>	'30',// 行高
		),
		array(
			'cell'			=>	'C'.$start_num.':D'.$start_num,// 单元格
			'val'			=>	$v['Name'],// 内容
			'style'			=>	$style,// 样式
			'height'		=>	'30',// 行高
		),
		array(
			'cell'			=>	'E'.$start_num.':F'.$start_num,// 单元格
			'val'			=>	$v['Model'],// 内容
			'style'			=>	$style,// 样式
			'height'		=>	'30',// 行高
		),
		array(
			'cell'			=>	'G'.$start_num,// 单元格
			'val'			=>	$v['Unit'],// 内容
			'style'			=>	$style,// 样式
			'height'		=>	'30',// 行高
		),
		array(
			'cell'			=>	'H'.$start_num,// 单元格
			'val'			=>	$v['Qty'],// 内容
			'style'			=>	$style,// 样式
			'height'		=>	'30',// 行高
		),
		array(
			'cell'			=>	'I'.$start_num,// 单元格
			'val'			=>	$v['Price'],// 内容
			'style'			=>	$style,// 样式
			'height'		=>	'30',// 行高
		),
		array(
			'cell'			=>	'J'.$start_num,// 单元格
			'val'			=>	$v['Total'],// 内容
			'style'			=>	$style,// 样式
			'height'		=>	'30',// 行高
		),
		array(
			'cell'			=>	'K'.$start_num,// 单元格
			'val'			=>	$v['Status'],// 内容
			'style'			=>	$style,// 样式
			'height'		=>	'30',// 行高
		),
	));
	$start_num++;
}

$ExcelContents = array_merge($ExcelContents,array(
	array(
		'cell'			=>	'B'.$start_num,// 单元格
		'val'			=>	'合计',// 内容
		'style'			=>	'size:11px;wrap:false;valign:center;align:center;family:等线;background:59595959;color:ffffffff;weight:true;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'C'.$start_num.':I'.$start_num,// 单元格
		'val'			=>	'贰万柒仟叁佰贰拾伍',// 内容
		'style'			=>	'size:11px;wrap:false;valign:center;align:center;family:等线;background:59595959;color:ffffffff;weight:true;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'J'.$start_num.':K'.$start_num,// 单元格
		'val'			=>	'27,325.00',// 内容
		'style'			=>	'size:11px;wrap:false;valign:center;align:center;family:等线;background:59595959;color:ffffffff;weight:true;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
));

$start_num++;
$ExcelContents = array_merge($ExcelContents,array(
	array(
		'cell'			=>	'B'.$start_num,// 单元格
		'val'			=>	'我司名称',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'C'.$start_num.':F'.$start_num,// 单元格
		'val'			=>	'北京稻壳科技有限公司',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'G'.$start_num,// 单元格
		'val'			=>	'我司税号',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'H'.$start_num.':K'.$start_num,// 单元格
		'val'			=>	'9144030******6726XG',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
));

$start_num++;
$ExcelContents = array_merge($ExcelContents,array(
	array(
		'cell'			=>	'B'.$start_num,// 单元格
		'val'			=>	'开户银行',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'C'.$start_num.':F'.$start_num,// 单元格
		'val'			=>	'中国建设银行 九仙桥支行',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'G'.$start_num,// 单元格
		'val'			=>	'联系电话',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'H'.$start_num.':K'.$start_num,// 单元格
		'val'			=>	'010-123456',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
));

$start_num++;
$ExcelContents = array_merge($ExcelContents,array(
	array(
		'cell'			=>	'B'.$start_num,// 单元格
		'val'			=>	'出货仓',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'C'.$start_num.':F'.$start_num,// 单元格
		'val'			=>	'北京仓',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'G'.$start_num,// 单元格
		'val'			=>	'开单日期',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
	array(
		'cell'			=>	'H'.$start_num.':K'.$start_num,// 单元格
		'val'			=>	'2020/9/10',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;border:1px #d9d9d9d9;',// 样式
		'height'		=>	'30',// 行高
	),
));

$start_num++;
$ExcelContents = array_merge($ExcelContents,array(
	array(
		'cell'			=>	'B'.$start_num,// 单元格
		'val'			=>	'制单：',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;',// 样式
		'height'		=>	'24',// 行高
	),
	array(
		'cell'			=>	'F'.$start_num,// 单元格
		'val'			=>	'配送：',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;',// 样式
		'height'		=>	'24',// 行高
	),
	array(
		'cell'			=>	'J'.$start_num,// 单元格
		'val'			=>	'客户签收：',// 内容
		'style'			=>	'size:10px;wrap:false;valign:center;align:center;family:等线;',// 样式
		'height'		=>	'24',// 行高
	),
));
$start_num++;
excel::export(array(// 设置内容
	'PrintArea'=>'A1:L'.$start_num,
	'hideGridlines'=>1,
	'Margin'=>0.5,
	'ColumnWidth'	=>	array(// 列宽
		'A'	=> 3.75,
		'B'	=> 10,
		'C'	=> 8,
		'D'	=> 8,
		'E'	=> 8,
		'F'	=> 8,
		'G'	=> 10,
		'H'	=> 8,
		'I'	=> 8,
		'J'	=> 8,
		'K'	=> 8,
		'L'	=> 3.75,
	),
		
	'GlobalStyle'	=>	array(//全局样式
		'Border'	=> 0,
		// 'Height'	=> 30,
		'NoWrap' => 1,
	),
	
	'ExcelContents' => $ExcelContents

),'feedback.'.date('ymd'));

// 积分兑换订单-导出 结束 ===============================================================================================
