<?php
/*
$data_excel = array(// 设置内容
		
	'ColumnWidth'	=>	array(// 列宽
		'A'	=> 24,
		'B'	=> 24,
		'C'	=> 30,
		'D'	=> 24,
		'E'	=> 30,
	),
		
	'GlobalStyle'	=>	array(//全局样式
		'Border'	=> 1,
		'Height'	=> 30,
	),
	
	'ExcelContents' => array(// 内容
		
		array(
			'cell'			=>	'A1',// 单元格
			'val'			=>	'报名类别报名类别报名类别报名类别报名类别报名类别报名类别报名类别报名类别报名类别报名类别报名类别报名类别报名类别报名类别',// 内容
			'height'		=>	'30',// 行高
		),
		
		array(
			'cell'			=>	'B1:E1',// 单元格
			'imgary'		=>	array(
				0	=>	array(
					'Path'			=>	c('root')."/u_file/photo/20191108/3349fd1add.jpg",
					'OffsetX'    	=>	'0',
					'OffsetY'    	=>	'0',
					'Rotation'   	=>	'0',
					'Width'      	=>	'100',
					'Height'     	=>	'50',
					'Shadow'     	=> array(//阴影
							'Visible'   =>  'false',
							'Direction' =>  '0',
					),
				)
			),
			'val'			=>	$products_category,// 内容
			'style'			=>	"size:10",// 样式
		),
		
		array(
			'cell'			=>	'A2:E3',// 单元格
			'val'			=>	$products_category,// 内容
			'style'			=>	"size:10",// 样式
		),
		
	),

);

$excel_name = "test名称";// 文件名称

excel::export($data_excel,$excel_name);// 开始导出
*/

class excel {
	public static $az = array();

	// 初始化
	public static function init () {
		$arr = range('A', 'Z');
		$ary = $arr;
		for ($i=0; $i<5; ++$i) {
			$num = $arr[$i];
			foreach ((array)$arr as $v) {
				$ary[] = $num.$v;
			}
		}
		self::$az = $ary;
	}
	
	// 单元格、事件、动作
	public static function cellstyle($cell,$event,$action,$objPHPExcel){
		$cellstyle = array(
			'align' =>  array(// 水平对齐方式
				'left'		=>  PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'center'	=>  PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'right'		=>  PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			),
			
			'valign'=> array(// 垂直对齐方式
				'top'		=>   PHPExcel_Style_Alignment::VERTICAL_TOP,
				'center'	=>   PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'bottom'	=>   PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
			),
			
			'weight'   =>   array(// 字体粗细
				'normal'          =>  'false',
				'lighter'         =>  'false',
				'bold'            =>  'true',
				'bolder'          =>  'true',
			),
		);
		if($event=='align'){// 水平设置
			$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal($cellstyle[$event][$action]);
		}elseif($event=='valign'){// 垂直设置
			$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setVertical($cellstyle[$event][$action]);
		}elseif($event=='weight'){// 字体粗细
			$weight = $action=='true'?true:false;
			$objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setBold($weight);
		}elseif($event=='size'){// 字体大小
			$objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setSize($action);
		}elseif($event=='family'){// 字体类型
			$objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setName($action);
		}elseif($event=='color'){// 字体颜色color
			$objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->getColor()->setARGB($action);// 此为8位数的web颜色，可在谷歌F12输出color查看，例：FF0000FA（红色）
		}elseif($event=='underline' && $action=='true'){// 是否需要下划线
			$objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
		}elseif($event=='background'){// 背景颜色
			$objPHPExcel->getActiveSheet()->getStyle($cell)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objPHPExcel->getActiveSheet()->getStyle($cell)->getFill()->getStartColor()->setARGB($action);// 此为8位数的web颜色，可在谷歌F12输出color查看，例：FF0000FA（红色）
		}elseif($event=='wrap'){
			$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setWrapText($action=='true'?true:false);
		}elseif($event=='border'){
			$action = explode(' ',$action);
			$action && $action[0] = (int)$action[0];
			$objPHPExcel->getActiveSheet()->getStyle($cell)->applyFromArray(array(
				'borders'=>array(
					'allborders' => array(
					    //'style' => PHPExcel_Style_Border::BORDER_THICK,// 边框是粗的
					    'style' => $action[0]==1?PHPExcel_Style_Border::BORDER_THIN:PHPExcel_Style_Border::BORDER_THICK,
					    'color' => array('argb' => str_replace('#','',$action[1])),// 边框颜色
					),
				)
			));
		}
	}
	
	public static function export($data_excel,$excel_name,$down=0){// 自定义导出
		include_once 'excel.class/PHPExcel.php';
		include_once 'excel.class/PHPExcel/Writer/Excel5.php';
		include_once 'excel.class/PHPExcel/IOFactory.php';
		$objPHPExcel=new PHPExcel();
		//Set properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");//创建人
		$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");//最后修改人
		$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");//标题
		$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");//题目
		$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");//关键字
		$objPHPExcel->getProperties()->setDescription('office 2007 openxml php');//描述
		$objPHPExcel->getProperties()->setCategory("Test result file");//种类
		
		//按语言版本
		$objPHPExcel->getActiveSheet()->setTitle('sheet1');// 设置sheet的name
		$activeSheet = $objPHPExcel->getActiveSheet();

		// 初始设定
		$data_excel['GlobalStyle'] || $data_excel['GlobalStyle'] = array();
		
		//列宽
		foreach((array)$data_excel['ColumnWidth'] as $k => $v){
			self::$az[$k] && $k = self::$az[$k];
			$objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth($v+0.72);// 注意:实际宽度与设置的宽度相差0.72个点，所以这里加上0.72
			// $objPHPExcel->getActiveSheet()->getColumnDimension($k)->setAutoSize(false)->setWidth($v+0.78);//设置默认字体为微软雅黑后，实际宽度与设置的宽度相差0.78个点
		}
		$border_column = $k;
		
		// 默认设置
		/* $objPHPExcel->getDefaultStyle()->getFont()->setName('微软雅黑');// 字体，建议不设置默认字体及字体大小，设置后表格及表格上的图片会出现拉伸的情况
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(12);//字体大小 */
		$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(26);// 行高
		$objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);// 水平设置-左边
		$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// 垂直设置-居中
		
		// 设置页边距 
		if($data_excel['Margin']){
			$margin = $data_excel['Margin'] / 2.54;//1英寸 = 2.54厘米
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($margin);
		}
		
		//设置水平居中
		$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
		
		//指定打印区域
		$data_excel['PrintArea'] && $objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea($data_excel['PrintArea']);
		
		//隐藏网格线
		$data_excel['hideGridlines'] && $objPHPExcel->getActiveSheet()->setShowGridlines(false);
		
		$border_total = 0;
		foreach((array)$data_excel['ExcelContents'] as $k => $v){
			
			preg_match_all("/[0-9]+/", $v['cell'], $cell);
			
			$lineNumber=end($cell[0]);
			if($border_total<$lineNumber) $border_total=$lineNumber;
			
			$oldCell = '';
			if(strstr($v['cell'],':')){
				$activeSheet->mergeCells($v['cell']);// 单元格设置->是否合并
				$oldCell = $v['cell'];
				$v['cell']=str_replace(strstr($v['cell'],':'),'',$v['cell']);
			}
			
			$v['height'] || $v['height'] = $data_excel['GlobalStyle']['Height'];
			if($v['height']){// 行高
				$objPHPExcel->getActiveSheet()->getRowDimension($cell[0][0])->setRowHeight($v['height']);
			}
			
			if($v['imgary']){// 图片
				foreach((array)$v['imgary'] as $k1 => $v1) {
					$objDrawing = new PHPExcel_Worksheet_Drawing();
					$objDrawing->setResizeProportional(true);
					// $objDrawing->setHeight(47);
					$objDrawing->setPath($v1['Path']);
					$objDrawing->setCoordinates($v['cell']);
					$objDrawing->setOffsetX((int)$v1['OffsetX']);
					$objDrawing->setOffsetY((int)$v1['OffsetY']);
					$objDrawing->setRotation((int)$v1['Rotation']);
					if($v1['Shadow']){
						$objDrawing->getShadow()->setVisible(($v1['Shadow']['Visible']=='true'?true:false));
						$objDrawing->getShadow()->setDirection((int)$v1['Shadow']['Direction']);
					}
					$objDrawing->setWidthAndHeight((int)$v1['Width'],(int)$v1['Height']);
					$objDrawing->setWorksheet($activeSheet);
				}
			}
			
			if(!is_numeric($v['val'])){// 内容->判断是否数字
				$objPHPExcel->getActiveSheet()->setCellValueExplicit($v['cell'], $v['val'], PHPExcel_Cell_DataType::TYPE_STRING);// 数字的输出方法
			}else{
				$objPHPExcel->getActiveSheet()->setCellValue($v['cell'], $v['val']);// 非数字的输出方法
			}
			
			if($v['style']){// 单元格样式
				$style = explode(';',$v['style']);
				foreach((array)$style as $k1 => $v1){
					$styleTwo = explode(':',$v1);
					self::cellstyle($oldCell?:$v['cell'],$styleTwo[0],$styleTwo[1],$objPHPExcel);
				}
			}
			
		}
		
		$border_total = "A1:{$border_column}{$border_total}";// 总数
		
		/***********************画出单元格边框*****************************/
        $styleArray = array();
        if ($data_excel['GlobalStyle']['Border']) {
            $styleArray['borders'] = array(
                'allborders' => array(
                    //'style' => PHPExcel_Style_Border::BORDER_THICK,// 边框是粗的
                    'style' => $data_excel['GlobalStyle']['Border']==1 ? PHPExcel_Style_Border::BORDER_THIN : PHPExcel_Style_Border::BORDER_THICK,
                    //'color' => array('argb' => 'FFFF0000'),// 边框颜色
                ),
            );
        }
        if ($styleArray) $activeSheet->getStyle($border_total)->applyFromArray($styleArray);
        /***********************画出单元格边框结束*****************************/
		
		// 其他设置
		$data_excel['GlobalStyle']['NoWrap'] || $objPHPExcel->getActiveSheet()->getStyle($border_total)->getAlignment()->setWrapText(true);//自动换行
		$objPHPExcel->setActiveSheetIndex(0);// 指针返回第一个工作表

		ob_end_clean();
		ob_start();
		/*if($down){
			$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save(c('root').c('u_file_dir').$excel_name.'.xls');
			return c('u_file_dir').$excel_name.'.xls';
		}else{
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment;filename={$excel_name}.xls");
			header("Cache-Control: max-age=0");
			$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}*/
		if($down){
			$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save(c('root').c('u_file_dir').$excel_name.'.xlsx');
			return c('u_file_dir').$excel_name.'.xlsx';
		}else{
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment;filename={$excel_name}.xlsx");
			header("Cache-Control: max-age=0");
			$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		}
		unset($objPHPExcel, $ary, $attr_column, $fixed_ary);
		exit;
	}

	// 下标自增长
	// @param string $i 参数等于0时表示重置下标
	// @return string 返回下标结果
	public static $index_number = 0;
	public static function list_array_index ($i, $val, $n=-1) {
		if ($n>=0) {
			self::$index_number = $n+1;
		}
		else {
			$n = self::$index_number;
			self::$index_number++;
		}
		return array(
			'cell' => self::$az[$n].$i,
			'val' => $val
		);
	}


	// 导入的excel数据
	public static function upload_data ($xls_file, $number=0) {
		$tmp_xls_file = c('tmp_dir').'excel_file'.str_replace(array('.xlsx','.xls'),'.php',$xls_file);
		if(is_file(c('root').$tmp_xls_file)){
			$data = require c('root').$tmp_xls_file;
			$row = count($data);
		}
		if(!$row){
			ini_set("memory_limit","-1");
			ini_set('max_execution_time',0);
			include 'excel.class/PHPExcel/IOFactory.php';
			$objPHPExcel = PHPExcel_IOFactory::load(c('root').$xls_file);
			$sheet = $objPHPExcel->getSheet(0);//工作表0
			$row = $sheet->getHighestRow();//取得总行数
			$column = $sheet->getHighestColumn();//取得总列数
			$data = $sheet->toArray();
			//生成json文件，加快第二次读取数据的速度，不过第一次就会很慢
			if (!$number || $row>$number) {
				$contents="<?php return ".str::ary_dump($data).';';
				file::write_php($tmp_xls_file, $contents);
			}
		}
		return array(
			'data' => $data,
			'count' => $row,
			'file' => $tmp_xls_file
		);
	}
	
}
excel::init();