<?php
// 已被使用的变量
// $name, $value, $row, $cfg


// 时间
if($row['EfTimeType']=='FixedTime'){
	$time0 = (int)$row['EfTime0'];
	$time1 = (int)$row['EfTime1'];
	$time = date('Y-m-d H:i', $time0).' ~ '.date('Y-m-d H:i', $time1);
	if($time1<c('time')){
		$status = '<div class="ly_btn_radius pointer" bg="default" size="mini">'.language('panel.time_status.end').'</div>';
	}elseif(c('time')<$time0){
		$status = '<div class="ly_btn_radius pointer" bg="main" size="mini">'.language('panel.time_status.prepare').'</div>';
	}else{
		$status = '<div class="ly_btn_radius pointer" bg="success" size="mini">'.language('panel.time_status.afoot').'</div>';
	}
}else{
	$GetTimeMap = array('day'=>'天','hour'=>'小时');
	$status = '<div class="ly_btn_radius pointer" bg="success" size="mini">'.language('panel.time_status.afoot').'</div>';
	$time = ("领取后".$row['EfTimeNumber'].$GetTimeMap[$row['EfTimeUnit']]."内有效").'<br>'.date('Y-m-d H:i', c('time')).' ~ '.date('Y-m-d H:i', strtotime('+'.$row['EfTimeNumber'].' '.$row['EfTimeUnit']));
}




// 叠加使用
if($row['NameCombined']){
    $combined = language('panel.free.Combined');
}



// 适用顾客	手动发放 / 系统发放
if($row['SendType'] == 'self'){
	if($row['MemberType'] == 'group'){
		$str = explode(',',$row['MemberGroupType']);
		foreach($str as $k => $v){
			$str[$k] = language('panel.select_member.group.'.$v);
		}
		$use_member = implode('，',$str);
	}
	$row['MemberType'] == 'all' && $use_member = language('panel.select_member.check.all');
	$row['MemberType'] == 'tag' && $use_member = $row['MemberTag'];
	$row['MemberType'] == 'id' && $use_member = $row['MemberId'];
}else{
	$row['GetRule'] == 'register' && $use_member = '完成会员注册';
	$row['GetRule'] == 'login' && $use_member = '登录成功';
	$row['GetRule'] == 'comment' && $use_member = '顾客评论成功';
	$row['GetRule'] == 'receive' && $use_member = '顾客确认收货';
	$row['GetRule'] == 'complete' && $use_member = '订单状态已完成';

}
$use_member = str_replace('{{customers}}',$use_member,language('panel.select_member.Useful'));



// 适用产品
if($row['UseProType'] == 'all'){
    $use_products = language('panel.select_products.all');;
}
if($row['UseProType'] == 'id'){
    $use_products = $row['UseProId'];
}
if($row['UseProType'] == 'category'){
    $use_products = $row['UseProCategory'];
}
$use_products = str_replace('{{product}}',$use_products,language('panel.select_products.Useful'));



// 优惠券类型&使用条件
if($row['FullType'] == 'Money'){
	$full_sale = str_replace(
		array('{{full}}','{{sale}}'),
		array(price::rate($row['FullMoney']),$row['FreeDiscount']),
		language('panel.free.money_number')
	);

	if($row['FreeType'] == 'Money'){
		$full_sale = str_replace(
			array('{{full}}','{{sale}}'),
			array(price::rate($row['FullMoney']),price::rate($row['FreeMoney'])),
			language('panel.free.money')
		);
	}
}else{
	$full_sale = str_replace(
		array('{{full}}','{{sale}}'),
		array($row['FullNumber'],$row['FreeDiscount']),
		language('panel.free.discount_money')
	);

	if($row['FreeType'] == 'Money'){
		$full_sale = str_replace(
			array('{{full}}','{{sale}}'),
			array($row['FullNumber'],price::rate($row['FreeMoney'])),
			language('panel.free.money_number')
		);
	}
}


// 使用规则
// 发放量
if ($row['DistributionQty']) {
	$dist = str_replace('{{qty}}',$row['DistributionQty'],language('panel.DistributionQty.view'));
}else{
    $dist = language('panel.DistributionQty.number');
}
// 单人限次
if ($row['UseQty']) {
	$single = str_replace('{{qty}}',$row['UseQty'],language('panel.UseQty.view'));
}else{
    $single = language('panel.UseQty.number');
}

?>

<div class='_dbs_item' data-dbs-type='<?=strtolower($cfg['Type'])?>' ajax-change="<?=$name?>">
	<div class='_dbs_content'>
		<!-- 开始 -->
			<div class="flex-between mb_10px">
				<div style="font-weight:bold;"><?=$row['Name']?></div>
				<?=$status?>
			</div>
			<div class="fz14" style="font-weight:bold;"><?=language('panel.Applicability')?></div>
			<div><?=$full_sale?></div>
			<div class="mt_10px fz14" style="font-weight:bold;"><?=language('panel.DetailedInformation')?></div>
			<div><?=$combined?></div>
			<div><?=$time?></div>
			<div><?=$use_member?></div>
			<div><?=$use_products?></div>
			<div><?=$dist?></div>
			<div><?=$single?></div>
		<!-- 结束 -->
	</div>
</div>