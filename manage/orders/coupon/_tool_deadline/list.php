<div class="nowrap">
	<?php
		// 已被使用的变量
		// $name, $row, $cfg
		if($row[$name.'Type']=='FixedTime'){
			echo $row[$name.'1']<c('time')?'已过期':(date('Y-m-d H:i',$row[$name.'0']).'<br>'.date('Y-m-d H:i',$row[$name.'1']));
		}else{
			$GetTimeMap = array('day'=>'天','hour'=>'小时');
			echo "领取后".$row[$name.'Number'].$GetTimeMap[$row[$name.'Unit']]."内有效";
		}
	?>
</div>