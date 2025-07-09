<?php


class analytics_click {
    // 按天排序
    static public function dayData($star_time,$end_time, $past_star_time,$past_end_time){
        $res = db::query("
        select * from analytics_click
        where Type='day' and Time between {$star_time} and {$end_time}
        ");
        $day_list = self::dayList($res, $star_time, $end_time);
        if ($past_star_time && $past_end_time) {
            $past_res = db::query("
                select * from analytics_click
                where Type='day' and Time between {$past_star_time} and {$past_end_time}
            ");
            $past_day_list = self::dayList($past_res, $past_star_time, $past_end_time);
        }
        return array(
            'xAxis' => $day_list['xAxis'],
            'pv' => $day_list['pv'],
            'uv' => $day_list['uv'],
            'ip' => $day_list['ip'],
            'past_pv' => $past_day_list['pv'],
            'past_uv' => $past_day_list['uv'],
            'past_ip' => $past_day_list['ip'],
            'ret' => 1,
        );
    }
    // 01/01 - 01/31
    static public function dayList($data, $star_time, $end_time){
        $option_data = array();
        while ($v = db::result($data)) {
            $option_data[$v['Time']] = $v;
        }
        $time_list = array();
        $pv_list = array();
        $uv_list = array();
        $ip_list = array();

        $days = (int)(abs($end_time - $star_time) / 86400);
        for($j=0; $j<$days; $j++)
        {
            $dd = $star_time+$j*86400;
            $time_list[] = date("m-d",$dd);
            $pv_list[] = (int)$option_data[$dd]['Pv'];
            $uv_list[] = (int)$option_data[$dd]['Uv'];
            $ip_list[] = (int)$option_data[$dd]['Ip'];
        }
        return array(
            'xAxis' => $time_list,
            'pv' => $pv_list,
            'uv' => $uv_list,
            'ip' => $ip_list,
        );
    }


    // 小时排序
    static public function hourData($star_time,$end_time, $past_star_time,$past_end_time){
        $res = db::query("
            select * from analytics_click
            where Type='hour' and Time between {$star_time} and {$end_time}
        ");
        $hour_list = self::hourList($res, $star_time);

        if ($past_star_time && $past_end_time) {
            $past_res = db::query("
                select * from analytics_click
                where Type='hour' and Time between {$past_star_time} and {$past_end_time}
            ");
            
            $past_hour_list = self::hourList($past_res, $past_star_time);
        }
        return array(
            'xAxis' => $hour_list['xAxis'],
            'pv' => $hour_list['pv'],
            'uv' => $hour_list['uv'],
            'ip' => $hour_list['ip'],
            'past_pv' => $past_hour_list['pv'],
            'past_uv' => $past_hour_list['uv'],
            'past_ip' => $past_hour_list['ip'],
            'ret' => 1,
        );
    }

    // 00:00 - 23:00 处理小时类型数据
    static public function hourList($data, $star_time){
        $option_data = array();
        while ($v = db::result($data)) {
            $option_data[$v['Time']] = $v;
        }
        $time_list = array();
        // $time_msg = array();
        $pv_list = array();
        $uv_list = array();
        $ip_list = array();
        for($j=0; $j<24; $j++)
        {
            $dd = $star_time+$j*3600;
            $time_list[] = "".($j>9?'':'0')."$j:00";
            // $time_msg[] = "".($j>9?'':'0')."$j:00 - $j:59";
            $pv_list[] = (int)$option_data[$dd]['Pv'];
            $uv_list[] = (int)$option_data[$dd]['Uv'];
            $ip_list[] = (int)$option_data[$dd]['Ip'];
        }
        return array(
            'xAxis' => $time_list,
            'pv' => $pv_list,
            'uv' => $uv_list,
            'ip' => $ip_list,
        );
    }


}




// 接收查询时间
$time_star = strtotime($_POST['now_time_start']);
$time_end = strtotime($_POST['now_time_end']);

// 查询时间相差
$past_time = $time_end - $time_star;

// 判断有无对照，有对照则获取对照时间段
if($_POST['compare']=='last_issue'){
    $past_time_star = $time_star - $past_time;
    $past_time_end = $time_end - $past_time;
}else if($_POST['compare']=='last_year'){
    $past_time_star = strtotime('-1 year',$time_star);
    $past_time_end = strtotime('-1 year',$time_end);
}

// 判断查询类型
if($past_time>86400){
    $data = analytics_click::dayData($time_star,$time_end,$past_time_star,$past_time_end);
}else{
    $data = analytics_click::hourData($time_star,$time_end,$past_time_star,$past_time_end);
}
echo str::json($data);
exit;





// 查询条件数据
    // // 判断有无对照时间
    // if($_POST['compare']&&$_POST['compare'] != ''){
    //     $past_time_star = $db_time_star - $past_time;
    //     $past_time_end = $db_time_end - $past_time;
    //     // 查询对照条件数据
    //     $data_pv_day_past = db::query("
    //         select distinct * from analytics_click
    //         where Type='{$type}' and Time between {$past_time_star} and {$past_time_end}
    //     ");
    // }


    // if($type=='hour'){
    //     // 对比数组
    //     $option_data_past = array();
    //     while ($v = db::result($data_pv_day_past)) {
    //         $option_data_past[$v['Time']] = $v;
    //     }
    //     $time_list_past = array();
    //     $time_msg_past = array();
    //     $pv_list_past = array();
    //     $uv_list_past = array();
    //     $ip_list_past = array();
    //     for($j=0; $j<24; $j++)
    //     {
    //         $dd = $past_time_star+$j*3600;
    //         $time_list_past[] = "".($j>9?'':'0')."$j:00";
    //         $time_msg_past[] = "".($j>9?'':'0')."$j:00 - $j:59";
    //         $pv_list_past[] = (int)$option_data_past[$dd]['Pv'];
    //         $uv_list_past[] = (int)$option_data_past[$dd]['Uv'];
    //         $ip_list_past[] = (int)$option_data_past[$dd]['Ip'];
    //     }
    // }else if($type=='day'){

    // }
//






// $option = array(
//     'title' => array(
//         'text' => '访问量(PV)'
//     ),
//     'tooltip' => array(
//         'trigger' => 'axis'
//     ),
//     'grid' => array(
//         'left' => '3%',
//         'right' => '4%',
//         'bottom' => '3%',
//         'containLabel' => true,
//     ),
//     'xAxis' => array(
//         'type' => 'category',
//         'boundaryGap' => false,
//         'data' => $time_list,
//         'axisLabel' => array(
//             'interval' => 3
//         ),
//     ),
//     'yAxis' => array(
//         'type' => 'value'
//     ),
//     'series' => array(
//         array(
//             'data' => $pv_list,
//             'type'=> 'line'
//         )
//     )
// );



// echo str::json($option);
// exit;
?>
