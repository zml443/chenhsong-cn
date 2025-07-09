<?php
// 防止胡乱进入
isset($c) || exit;


?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include '__/inc/style_script.php'; ?>
</head>
<style>



</style>
<body bg="default">
	<div cw="100%" class="wcb_anaccc_gird mt_20px mb_20px">
        <div class="_dbs_box">
            <div class="_dbs_item">
                <div class="wcb_anaccc_tip">
                    <div class="tip flex-between mb_40px">
                        <span><?=language('{/panel.transaction_data/}')?></span>
                        <a href=""><?=language('{/global.detail/}')?></a>
                    </div>
                    <div class="flex-middle2 mb_40px"><?=language('{/global.sale/}')?><span class="ml_10px">$0.00</span></div>
                    <div class="flex-middle2"><?=language('{/global.orders_qty/}')?><span class="ml_10px">0</span></div>
                </div>
            </div>
        </div>

        <div class="_dbs_box" style="grid-row: span 2;">
            <div class="_dbs_item">
                <div class="flex-between">
                    <!--  -->
                    <div style="width:100%;">
                    <?php
                        $time_start=strtotime(date("Y-m-d",strtotime("-7 day")));
                        $time_end=strtotime(date("Y-m-d",strtotime("tomorrow")));
                        $click = db::result("
                            select sum(Uv) as Uv,Type,Time from analytics_click
                            where Type='day' and Time between {$time_start} and {$time_end}
                        ");
                        $cart_res = db::result("
                            select sum(Uv) as Uv,Type,Time from analytics_url_click
                            where Type='day' and Link='/cart' and Time between {$time_start} and {$time_end}
                        ");
                        $checkout_res = db::result("
                            select sum(Uv) as Uv,Type,Time from analytics_url_click
                            where Type='day' and Link in('/cart/checkout','/cart/buynow') and Time between {$time_start} and {$time_end}
                        ");
                        $cart_rate = intval(($cart_res['Uv']/($click['Uv']?$click['Uv']:1))*100);
                        $checkout_rate = intval(($checkout_res['Uv']/($click['Uv']?$click['Uv']:1))*100);
                    ?>
                        <div class="wcb_analytics_top mb_30px">
                            <div class="title flex-middle2">
                                <?=language('{/global.conversion_rate/}')?>
                                <span class="time ml_10px">(<?=language('{/global.last_7_day/}')?>)</span>
                            </div>
                            <span class="val"><?=$cart_rate+$checkout_rate?>%</span>
                        </div>
                        <li class="wcb_anaccc_operate flex-max2 mt_10px">
                            <div class="action"></div>
                            <div class="num"><?=language('{/global.visitor/}')?></div>
                            <div class="rate"><?=language('{/global.conversion_rate/}')?></div>
                        </li>
                        <li class="wcb_anaccc_operate flex-max2 bg mt_10px">
                            <div class="action"><?=language('{/panel.enter_store/}')?></div>
                            <div class="num"><?=$click['Uv']?></div>
                            <div class="rate"></div>
                        </li>
                        <li class="wcb_anaccc_operate flex-max2 bg mt_10px">
                            <div class="action"><?=language('{/panel.add_cart/}')?></div>
                            <div class="num"><?=(int)$cart_res['Uv']?></div>
                            <div class="rate"><?=$cart_rate?>%</div>
                        </li>
                        <li class="wcb_anaccc_operate flex-max2 bg mt_10px">
                            <div class="action"><?=language('{/panel.checkout/}')?></div>
                            <div class="num"><?=(int)$checkout_res['Uv']?></div>
                            <div class="rate"><?=$checkout_rate?>%</div>
                        </li>
                        <li class="wcb_anaccc_operate flex-max2 bg mt_10px">
                            <div class="action"><?=language('panel.payment')?></div>
                            <div class="num">0</div>
                            <div class="rate">0%</div>
                        </li>
                    </div>
                    <!--  -->
                    <div class="flex-max" style="width:100%;">
                        <div class="wcb_anaccc_circle flex-max">
                            <div class="num flex-max"><?=(int)db::result("select count(*) as a from wb_member where AddTime>".(c('time')-30*86400),'a')?></div>
                            <div class="name"><?=language('{/global.visitor_all/}')?></div>
                            <div class="day"><?=language('{/global.last_30_day/}')?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="_dbs_box">
            <div class="_dbs_item">
                <div class="wcb_anaccc_tip">
                    <div class="tip mb_40px"><span><?=language('panel.wait')?></span></div>
                    <a class="flex-between flex-middle2 mb_40px">
                        <div class="flex-middle2">
                            <i class="lyicon-transport"></i>
                            <?=str_replace('{{qty}}', '<span class="ml_5px mr_5px">0</span>', language('panel.orders_wait'))?>
                        </div>
                        <i class="lyicon-arrow-right-bold"></i>
                    </a>
                    <a class="flex-between flex-middle2">
                        <div class="flex-middle2">
                            <i class="lyicon-wallet"></i>
                            <?=str_replace('{{qty}}', '<span class="ml_5px mr_5px">0</span>', language('panel.orders_pay'))?>
                        </div>
                        <i class="lyicon-arrow-right-bold"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="_dbs_box">
            <div class="_dbs_item">
                <ul class="wcb_analytics_tabs flex-between">
                    <li class="li cur"><?=language('panel.sale_ranking')?></li>
                    <!-- <li class="li">加购产品</li> -->
                    <!-- <li class="li">浏览产品</li> -->
                </ul>
                <div>
                    <div class="flex-max" style="width:100%;height:400px;font-size:18px;">
                        <img src="/images/global/null2.png" alt="">
                        <div><?=language('global.null')?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="_dbs_box">
            <div class="_dbs_item flex-between">
                <!--  -->
                <div class="mr_40px" style="width:100%;">
                    <div class="wcb_analytics_top mb_20px">
                        <div class="title flex-between flex-middle2">
                            <span><?=language('{/global.look_qty/}')?></span>
                            <span class="time ml_10px flex-1">(<?=language('global.last_7_day')?>)</span>
                            <a class="a" href=""><?=language('{/global.detail/}')?></a>
                        </div>
                    </div>
                    <div class="wcb_analytics_echarts wcb_analytics_chartbox1">
                        <div class="echartbox"></div>
                    </div>
                </div>
                <!--  -->
                <div style="width:100%;">
                    <div class="wcb_analytics_top mb_20px">
                        <div class="title flex-between flex-middle2">
                            <span><?=language('{/global.visitor_qty/}')?></span>
                            <span class="time ml_10px flex-1">(<?=language('global.last_7_day')?>)</span>
                            <a class="a" href=""><?=language('{/global.detail/}')?></a>
                        </div>
                    </div>
                    <div class="wcb_analytics_echarts wcb_analytics_chartbox2">
                        <div class="echartbox"></div>
                    </div>
                </div>
            </div>
        </div>

	</div>

	<script src='/static/jext/web/echarts/echarts.min.js'></script>

	<script>
        (function(){
            var update_chart = function(){
			// 获取的表单数据
            var now = new Date();
            var day = now.getDate()+1;
            var month = now.getMonth()+1;
            var year = now.getFullYear();
            var past = now - 7 * 24 * 3600 * 1000;
            var last_day = new Date(past).getDate()
            var last_month = new Date(past).getMonth()+1
            var last_year = new Date(past).getFullYear()

			var now_time_start = `${last_year}-${last_month>9?'':'0'}${last_month}-${last_day}`
			var now_time_end = `${year}-${month>9?'':'0'}${month}-${day}`
			var para = {now_time_start:now_time_start,now_time_end:now_time_end,compare:''}
			$.async('POST', '?ma=statistics/analytics/click', para, result=>{
				charts.el_pv(result)
				charts.el_uv(result)
			}, 'json')
		}

		var charts = {
			el_pv(result){
				var echart_box = $('.wcb_analytics_chartbox1')
				echart_box.find('.echartbox').remove()
				echart_box.append(`<div class="echartbox"></div>`)
				//
				var el = $('.wcb_analytics_chartbox1 .echartbox')
				var mychart = echarts.init(el[0])
				var series = []
				if(result.ret == 1){
                    for(let key in result) {
                        if(key=='pv'||key=='past_pv'){
                            series.push({
                                name: key=='pv'&&$.lang.global.look_current||key=='past_pv'&&$.lang.global.contrast,
                                type: 'line',
                                stack: '',
                                smooth: true,
                                data: result[key]
                            })
                        }
                    }
					mychart.setOption({
						tooltip: {
							trigger: 'axis'
						},
						color:['#62d1de','#ddd'],
						grid: {
							left: '0%',
							right: '4%',
							bottom: '0%',
                            top:'10%',
							containLabel: true
						},
						xAxis: {
							type: 'category',
							boundaryGap: false,
							data: result.xAxis,
							axisLabel:{
								rotate:result.xAxis.length>7?40:0,
							}
						},
						yAxis: {
							type: 'value'
						},
						series: series
					})
				}
			},
			el_uv(result){
				var echart_box = $('.wcb_analytics_chartbox2')
				echart_box.find('.echartbox').remove()
				echart_box.append(`<div class="echartbox"></div>`)
				//
				var el = $('.wcb_analytics_chartbox2 .echartbox')
				var mychart = echarts.init(el[0])
				var series = []
				if(result.ret == 1){
                    for(let key in result) {
                        if(key=='uv'||key=='past_uv'){
                            series.push({
                                name: key=='uv'&&$.lang.global.visitor_current||key=='past_uv'&&$.lang.global.contrast,
                                type: 'line',
                                stack: '',
                                smooth: true,
                                zlevel:key=='uv'?1:0,
                                data: result[key]
                            })
                        }
                    }
					mychart.setOption({
						tooltip: {
							trigger: 'axis'
						},
						color:['#62d1de','#ddd'],
						grid: {
							left: '0%',
							right: '4%',
							bottom: '0%',
							top:'10%',
							containLabel: true
						},
						xAxis: {
							type: 'category',
							boundaryGap: false,
							data: result.xAxis,
							axisLabel:{
								rotate:result.xAxis.length>7?40:0,
							}
						},
						yAxis: {
							type: 'value'
						},
						series: series
					})
				}
			}
		}

		window.onload = function(){
            update_chart();
        }

		})()
    </script>

</div>
</body>
</html>