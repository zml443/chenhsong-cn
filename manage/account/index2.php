<?php
// 防止胡乱进入
isset($c) || exit;
// 当前用户的权限
/*if (!p('account.index.list')) {
    echo lang('{/manage.manage.no_permit/}');
    return;
}*/

?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include '__/inc/style_script.php'; ?>
    <script src='/static/jext/web/echarts/echarts.min.js'></script>
    <script type='text/javascript' src='/manage/account/index2/_js.js' ></script>
</head>
<style>

</style>
<body bg="default">
    <div class="mt_20px mb_20px ml_20px mr_20px">
        <div class="wcb_index2_form inline-block relative">
            <span class="wcb_index2_form_span fz20 lh_2">
                <span><?=language('{/global.today/}')?></span><i class="wcb_index2_form_i ml_10px lyicon-arrow-down-bold"></i>
            </span>
            <div class="ul fz16 lh_1_6 absolute">
                <div class="item" data-name="today"><?=language('{/global.today/}')?></div>
                <div class="item" data-name="yesterday"><?=language('{/global.yesterday/}')?></div>
                <div class="item" data-name="lastweek"><?=language('{/global.last_7_day/}')?></div>
                <div class="item" data-name="lastmonth"><?=language('{/global.last_30_day/}')?></div>
            </div>
        </div>
    </div>
	<div cw="100%" class="wcb_index2_gird mt_20px mb_20px">
        <div class="_dbs_box">
            <div class="_dbs_item">
                <div class="fz20 pb_20px"><?=language('{/global.look_qty/}')?></div>
                <div class="flex-between">
                    <div class="flex-1 wcb_index2_click_el mr_10px"></div>
                    <div class="wcb_index2_echarts_el wcb_index2_click_month_el flex-1">
                        <div class="echartbox"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 2 -->
        <div class="_dbs_box">
            <div class="_dbs_item">
                <div class="fz20 pb_20px"><?=language('{/panel.analytics_referrer/}')?></div>
                <div class="wcb_index2_echarts_el wcb_index2_referrer_el flex-1">
                    <div class="echartbox"></div>
                </div>
            </div>
        </div>
        <!-- 3 -->
        <div class="_dbs_box">
            <div class="_dbs_item">
                <div class="fz20 pb_20px"><?=language('{/panel.analytics_website/}')?></div>
                <div class="fz14 lh_2 wcb_index2_referrer_url" color="main">
                </div>
            </div>
        </div>
        <!-- 4 -->
        <div class="_dbs_box">
            <div class="_dbs_item">
                <div class="flex-between flex-middle2 pb_20px">
                    <span class="fz20"><?=language('{/panel.new_feedback/}')?></span>
                    <a class="fz14" color="main" hr-ef="?u=feedback,feedback&m=feedback&a=index"><?=language('{/global.more/}')?></a>
                </div>
                <div class="wcb_index2_liuyan">
                    <?php
                        $liuyan = db::query("
                            select * from wb_feedback
                            order by AddTime desc
                            limit 6
                        ");
                        if ($liuyan->num_rows==0) {
                    ?>
                        <div class="flex-max" style="width:100%;height:400px;font-size:18px;">
                            <img src="/images/global/null2.png" alt="">
                            <div><?=language('{/panel.new_feedback_null/}')?></div>
                        </div>
                    <?php } else { ?>
                        <li class="wcb_index2_li">
                            <div class="new"></div>
                            <div class=""><?=language('{/dbs.field.Email/}')?></div>
                            <div class=""><?=language('{/dbs.field.Name/}')?></div>
                            <div class=""><?=language('{/dbs.field.AddTime/}')?></div>
                            <div class="search"></div>
                        </li>
                        <?php
                            while ($v=db::result($liuyan)) {
                            $v = str::code($v);
                        ?>
                            <li class="wcb_index2_li">
                                <div class="new"><?=$v['IsRead']?'':'NEW'?></div>
                                <div class=""><?=$v['Email']?></div>
                                <div class=""><?=$v['Name']?></div>
                                <div class=""><?=date("Y/m/d h:i:s",$v['AddTime'])?></div>
                                <a class="search" hr-ef="?u=feedback,feedback&mg=feedback/index&d=edit&Id=<?=$v['Id']?>"><i class="lyicon-search"></i></a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- 5 -->
        <div class="_dbs_box">
            <div class="_dbs_item">
                <div class="flex-between flex-middle2 pb_20px">
                    <span class="fz20"><?=language('{/panel.analytics_distribute/}')?></span>
                    <a class="fz14" color="main" hr-ef="?u=statistics,analytics&m=statistics&a=analytics"><?=language('{/global.more/}')?></a>
                </div>
                <div class="fz14 lh_2 wcb_index2_province" color="main"></div>
            </div>
        </div>
        <!-- 6 -->
        <div class="_dbs_box">
            <div class="_dbs_item">
                <div class="fz20 pb_20px"><?=language('{/panel.analytics_terminal/}')?></div>
                <div class="wcb_index2_client fz28 flex-column"></div>
            </div>
        </div>

	</div>

</div>
</body>
</html>