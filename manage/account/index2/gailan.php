<?php
class analytics_click {
    static public $time = '';       //查询时间端 today,yesterday,lastweek,lastmonth    time
    static public $star_time = 0;   //查询起始时间 now_time_start
    static public $end_time = 0;    //查询结束时间 now_time_end
    static public $sort = '';       //合并uv和pv，通过某一种进行排序 sort_type
    static public $limit = 10;      //查询的数据条数 data_limit
    static public $group = '';      //group合并类型，有参数就拿Domain,默认Title类型 group_type

    static public function init(){
        // 接收传来的查询时间  一个时间段变量
        self::$time = $_POST['time'];
        if(self::$time=='yesterday'){
            self::$star_time = strtotime("-1 day");
            self::$end_time = strtotime("today");
        }else if(self::$time=='lastweek'){
            self::$star_time = strtotime("-7 day");
            self::$end_time = strtotime("today ");
        }else if(self::$time=='lastmonth'){
            self::$star_time = strtotime("-30 day");
            self::$end_time = strtotime("today ");
        }else{
            // 没有对应就拿今天
            self::$star_time = strtotime("today");
            self::$end_time = strtotime("today +1 day");
        }
        // 处理成凌晨时间戳时间戳
        self::$star_time = strtotime(date("Y-m-d",self::$star_time));
        self::$end_time = strtotime(date("Y-m-d",self::$end_time));

        // group合并类型
        self::$group = $_POST['group_type'];

        // 排序方式
        self::$sort = $_POST['sort_type'];
        if(strtolower(self::$sort)=='uv'){
            // 默认通过Uv排序
            self::$sort = 'Uv';
        }else if(strtolower(self::$sort)=='pv'){
            self::$sort = 'Pv';
        }else{
            self::$sort = 'Uv';
        }

        // 拿取条数
        self::$limit = $_POST['data_limit'];
        if(!self::$limit){
            // 默认拿10条数据
            self::$limit = 10;
        }else{
            self::$limit = (int)(self::$limit);
        }
        
        $data['ref_title'] = self::referrer_title();
        $data['ref_domain'] = self::referrer_domain();
        $data['province'] = self::data_province();
        $data['client'] = self::data_client();
        $data['click'] = self::data_click();
        $data['click_month'] = self::data_click_month();
        
        echo str::json(array(
            'data'=> $data,
            'ret' => 1,
        ));
        exit;
    }

    // 按天排序 通过标题合并 流量来源
    static public function referrer_title(){
        $res = db::query("
            select Title,sum(Uv) as Uv_all,sum(Pv) as Pv_all from analytics_referrer
            where Type='day' and Time between ".self::$star_time." and ".self::$end_time."
            group by Title
            order by sum(".self::$sort.") desc
            limit ".self::$limit."
        ");
        while ($v = db::result($res)) {
            $res_last[] = $v;
        }
        return $res_last;
    }
    // 按天排序 通过域名合并 来源网址
    static public function referrer_domain(){
        $res = db::query("
            select Domain,ReferrerUrl,sum(Uv) as Uv_all,sum(Pv) as Pv_all from analytics_referrer
            where Type='day' and Time between ".self::$star_time." and ".self::$end_time."
            group by Domain
            order by sum(".self::$sort.") desc
            limit ".self::$limit."
        ");
        while ($v = db::result($res)) {
            $res_last[] = $v;
        }
        return $res_last;
    }

    // 访问分布
    static public function data_province(){
        $res = db::query("
            select Title,sum(Uv) as Uv_all,sum(Pv) as Pv_all from analytics_country
            where Type='day' and Time between ".self::$star_time." and ".self::$end_time."
            group by Title
            order by sum(".self::$sort.") desc
            limit ".self::$limit."
        ");
        while ($v = db::result($res)) {
            $res_last[] = $v;
        }
        return $res_last;
    }

    // 访问终端
    static public function data_client(){
        $res = db::query("
            select Title,sum(Uv) as Uv_all,sum(Pv) as Pv_all from analytics_client
            where Type='day' and Time between ".self::$star_time." and ".self::$end_time."
            group by Title
            order by sum(".self::$sort.") desc
            limit ".self::$limit."
        ");
        while ($v = db::result($res)) {
            $res_last[] = $v;
        }
        return $res_last;
    }

    // 流量 全部时间段
    static public function data_click(){
        // 今天
        $time_start=strtotime(date("Y-m-d",strtotime("today")));
        $click_today = db::result("
            select sum(Uv) as Uv,sum(Pv) as Pv,Type,Time from analytics_click
            where Type='day' and Time = {$time_start}
        ");
        $click_today['Title'] = language('{/global.today/}');
        // 昨天
        $time_start=strtotime(date("Y-m-d",strtotime("yesterday")));
        $time_end=strtotime(date("Y-m-d",strtotime("today")));
        $click_yesterday = db::result("
            select sum(Uv) as Uv,sum(Pv) as Pv,Type,Time from analytics_click
            where Type='day' and Time >= {$time_start} and Time < {$time_end}
        ");
        $click_yesterday['Title'] = language('{/global.yesterday/}');
        // 过去七天
        $time_start=strtotime(date("Y-m-d",strtotime("-7 day")));
        $time_end=strtotime(date("Y-m-d",strtotime("yesterday")));
        $click_lastweek = db::result("
            select sum(Uv) as Uv,sum(Pv) as Pv,Type,Time from analytics_click
            where Type='day' and Time >= {$time_start} and Time < {$time_end}
        ");
        $click_lastweek['Title'] = language('{/global.last_7_day/}');
        // 过去三十天
        $time_start=strtotime(date("Y-m-d",strtotime("-30 day")));
        $time_end=strtotime(date("Y-m-d",strtotime("yesterday")));
        $click_lastmonth = db::result("
            select sum(Uv) as Uv,sum(Pv) as Pv,Type,Time from analytics_click
            where Type='day' and Time >= {$time_start} and Time < {$time_end}
        ");
        $click_lastmonth['Title'] = language('{/global.last_30_day/}');
        return array(
            'today' =>  $click_today,
            'yesterday' =>  $click_yesterday,
            'lastweek' =>  $click_lastweek,
            'lastmonth' =>  $click_lastmonth
        );
    }

    // 流量 过去6个月
    static public function data_click_month(){
        $time_start=strtotime(date("Y-m",strtotime("-5 month")));
        $time_end=strtotime(date("Y-m",strtotime("now")));
        // $month_name = array('一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月');
        $month_now = (int)date("m",strtotime("now"));

        // 初始数组
        $res_init = array();
        // 初始key
        $month_index = $month_now;

        // 常规月份
        for($i=0;$i<6;$i++){
            $title = $month_index;
            if($title<10){
                $title="0".$title."月";
            }else{
                $title=$title."月";
            }
            $res_init[$month_index] = array(
                'Uv'    => '0',
                'Pv'    => '0',
                'Title' => $title,
            );
            $month_index -= 1;
            if($month_index<=0){$month_index=12;}
        }
        // 中文月份
        //for($i=0;$i<6;$i++){
            // $month_index -= 1;//月份数组0-11
            // if($month_index<0){$month_index+=12;}
            // // 数组key，通过每个月数字记录，故$month_index+1
            // $res_init[$month_index+1] = array(
            //     'Uv'    => '0',
            //     'Pv'    => '0',
            //     'Title' => $month_name[$month_index],
            // );
        //}

        $res = db::query("
            select sum(Uv) as Uv,sum(Pv) as Pv,Type,Time from analytics_click
            where Type='month' and Time >= {$time_start} and Time <= {$time_end}
            group by Time
        ");
        // 查询数据后进行更改
        while ($v=db::result($res)) {
            if($v['Time']){
                $index = (int)date("m",$v['Time']);
                $res_init[$index]['Uv'] = $v['Uv'];
                $res_init[$index]['Pv'] = $v['Pv'];
            }
        }
        // 生成前端需要的数据结构
        $res_last = array();
        $res_index = $month_now-5;//包括本月，故向前推五月
        if($res_index<0){$res_index+=12;}
        // 重新遍历排序
        for($i=0;$i<6;$i++){
            if($res_index>12){$res_index-=12;}
            $res_last[] = $res_init[$res_index]?:array('Pv'=>0,'Uv'=>0,'Title'=>'');
            $res_index += 1;
        }
        return $res_last;
    }
}

analytics_click::init();

?>
