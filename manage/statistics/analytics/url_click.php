<?php
class analytics_click {
    // 按天排序
    static public function dayData($star_time,$end_time){
        $res = db::query("
            select Link,sum(Uv) as Uv_all,sum(Pv) as Pv_all from analytics_url_click
            where Type='day' and Time between {$star_time} and {$end_time}
            group by Link
            order by sum(Uv) desc
            limit 10
        ");
        while ($v = db::result($data_pv_day_past)) {
            $url_data[] = $v;
        }
        return array(
            'arr' => $url_data,
            'ret' => 1
        );
    }

}




// 接收查询时间
$time_star = strtotime($_POST['now_time_start']);
$time_end = strtotime($_POST['now_time_end']);

$data = analytics_click::dayData($time_star,$time_end);

echo str::json($data);
exit;
?>
