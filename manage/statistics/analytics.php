<?php
// 防止胡乱进入
isset($c) || exit;
// 当前用户的权限
if (!p($_GET['m'].'.'.$_GET['a'].'.list')) {
    echo lang('{/manage.manage.no_permit/}');
    return;
}

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

	<div cw="100%" class="mt_20px mb_20px">
		<div class="wcb_analytics_title flex-middle2">
			<?=language('panel.analytics')?> 
			<!-- <a class="flex-middle2" href=""><i class="lyicon-export"></i><?=language('global.export')?></a> -->
		</div>
		<div class="_dbs_box">
			<div class="_dbs_item">
				<div class="wcb_analytics_select flex-middle2 mb_40px">
					<label class="sele ly_input_suffix inline-flex relative">
						<input class="pointer" type="text" placeholder="<?=language('global.today')?>" readonly="true">
						<div class="time_box">
							<!-- 时间选择 -->
							<form class="time" id="analytics_form_01">
								<!--  -->
								<div class="tip"><?=language('global.day_range')?></div>
								<div class="flex-middle2 flex-wrap mb_10px">
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px">
											<input type="radio" checked name="radio" data-start="<?=date("Y-m-d",strtotime("today"))?>" data-end="<?=date("Y-m-d",strtotime("today +1 day"))?>"/>
										</i>
										<span><?=language('global.today')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="radio" name="radio"  data-start="<?=date("Y-m-d",strtotime("-1 day"))?>" data-end="<?=date("Y-m-d",strtotime("today"))?>"/></i>
										<span><?=language('global.yesterday')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="radio" name="radio" data-start="<?=date("Y-m-d",strtotime("-7 day"))?>" data-end="<?=date("Y-m-d",strtotime("today"))?>"/></i>
										<span><?=language('global.last_7_day')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="radio" name="radio" data-start="<?=date("Y-m-d",strtotime("-30 day"))?>" data-end="<?=date("Y-m-d",strtotime("today"))?>"/></i>
										<span><?=language('global.last_30_day')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="radio" name="radio" data-start="<?=date('Y-m-d', strtotime("this week Monday"))?>" data-end="<?=date('Y-m-d', strtotime("this week Sunday +1 day"))?>"/></i>
										<span><?=language('global.this_week')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="radio" name="radio" data-start="<?=$cur_month = date('Y-m-01', strtotime(date("Y-m-d")))?>" data-end="<?=date('Y-m-d', strtotime("$cur_month +1 month"))?>"/></i>
										<span><?=language('global.this_month')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="radio" name="radio" data-start="<?=date('Y-m-d', strtotime("this week Monday -7 day"))?>" data-end="<?=date('Y-m-d', strtotime("this week Monday"))?>"/></i>
										<span><?=language('global.last_week')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="radio" name="radio" data-start="<?=$last_month = date("Y-m-01",strtotime("last month"))?>" data-end="<?=date('Y-m-d', strtotime("$last_month +1 month"))?>"/></i>
										<span><?=language('global.last_month')?></span>
									</label>
								</div>
								<!--  -->
								<div class="tip"><?=language('global.contrast')?></div>
								<div class="flex-middle2 mb_10px">
									<label class="flex-middle2 mr_20px pointer">
										<i class="ly_radio mr_5px"><input type="checkbox" name="checkbox" value="last_issue"  data-number="1" /></i>
										<span><?=language('global.prev_issue')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="checkbox" value="last_year" name="checkbox" /></i>
										<span><?=language('global.last_year')?></span>
									</label>
								</div>
								<!--  -->
								<div class="btn flex-middle2">
									<div class="flex-max2" onclick="update_chart()"><?=language('global.confirm')?></div>
									<div class="flex-max2"><?=language('global.cancel')?></div>
								</div>
							</form>
						</div>
						<i class="lyicon-arrow-down-bold"></i>
					</label>
					<!-- 对比时间tip -->
					<div class="date_tip"><span></span></div>
				</div>

				<div class="flex-between">
					<div class="mr_40px" style="width:100%;">
						<!--  -->
						<div class="wcb_analytics_top">
							<span class="title"><?=language('global.look_pv')?></span>
							<div class="rate_pv_num flex-middle2"><span class="val"><?=language('global.rise_rate')?></span><span class="rate"></span></div>
						</div>
						<!--  -->
						<div class="wcb_analytics_echarts wcb_analytics_chartbox1">
							<div class="echartbox"></div>
						</div>
					</div>

					<div style="width:100%;">
						<!--  -->
						<div class="wcb_analytics_top">
							<span class="title"><?=language('global.visitor_uv')?></span>
							<div class="rate_uv_num flex-middle2"><span class="val"><?=language('global.rise_rate')?></span><span class="rate"></span></div>
						</div>
						<!--  -->
						<div class="wcb_analytics_echarts wcb_analytics_chartbox2">
							<div class="echartbox"></div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="_dbs_box">
			<div class="_dbs_item">

				<div class="wcb_analytics_select flex-middle2 mb_40px">
					<label class="sele ly_input_suffix inline-flex relative pointer">
						<input class="pointer" type="text" placeholder="<?=language('global.today')?>" readonly="true">
						<div class="time_box">
							<!-- 时间选择 -->
							<form class="time" id="analytics_form_02">
								<!--  -->
								<div class="tip"><?=language('global.day_range')?></div>
								<div class="flex-middle2 flex-wrap mb_10px">
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px">
											<input type="radio" checked name="radio" data-start="<?=date("Y-m-d",strtotime("today"))?>" data-end="<?=date("Y-m-d",strtotime("today +1 day"))?>"/>
										</i>
										<span><?=language('global.today')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="radio" name="radio"  data-start="<?=date("Y-m-d",strtotime("-1 day"))?>" data-end="<?=date("Y-m-d",strtotime("today"))?>"/></i>
										<span><?=language('global.yesterday')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="radio" name="radio" data-start="<?=date("Y-m-d",strtotime("-7 day"))?>" data-end="<?=date("Y-m-d",strtotime("today"))?>"/></i>
										<span><?=language('global.last_7_day')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="radio" name="radio" data-start="<?=date("Y-m-d",strtotime("-30 day"))?>" data-end="<?=date("Y-m-d",strtotime("today"))?>"/></i>
										<span><?=language('global.last_30_day')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="radio" name="radio" data-start="<?=date('Y-m-d', strtotime("this week Monday"))?>" data-end="<?=date('Y-m-d', strtotime("this week Sunday +1 day"))?>"/></i>
										<span><?=language('global.this_week')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="radio" name="radio" data-start="<?=$cur_month = date('Y-m-01', strtotime(date("Y-m-d")))?>" data-end="<?=date('Y-m-d', strtotime("$cur_month +1 month"))?>"/></i>
										<span><?=language('global.this_month')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="radio" name="radio" data-start="<?=date('Y-m-d', strtotime("this week Monday -7 day"))?>" data-end="<?=date('Y-m-d', strtotime("this week Monday -1 day"))?>"/></i>
										<span><?=language('global.last_week')?></span>
									</label>
									<label class="flex-middle2 pointer">
										<i class="ly_radio mr_5px"><input type="radio" name="radio" data-start="<?=$last_month = date("Y-m-01",strtotime("last month"))?>" data-end="<?=date('Y-m-d', strtotime("$last_month +1 month"))?>"/></i>
										<span><?=language('global.last_month')?></span>
									</label>
								</div>
								<!--  -->
								<div class="btn flex-middle2">
									<div class="flex-max2" onclick="update_tab()"><?=language('global.confirm')?></div>
									<div class="flex-max2"><?=language('global.cancel')?></div>
								</div>
							</form>
						</div>
						<i class="lyicon-arrow-down-bold"></i>
					</label>
				</div>

				<div class="">
					<!--  -->
					<ul class="wcb_analytics_tabs mb_20px">
						<li class="li cur"><?=language('global.landing_page')?></li>
						<li class="li"><?=language('global.referrer')?></li>
						<li class="li"><?=language('global.country_region')?></li>
						<li class="li"><?=language('global.equipment')?></li>
					</ul>
					<!--  -->
					<ul class="bind wcb_analytics_binds">
						<li class="li active"></li>
						<li class="li"></li>
						<li class="li"></li>
						<li class="li"></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<script src='/static/jext/web/echarts/echarts.min.js'></script>
	<script>
		// 处理时间提交任务
		var update_chart = function(){
			// 获取的表单数据
			var now_time_start = $('#analytics_form_01 [name="radio"]:checked').attr('data-start')
			var now_time_end = $('#analytics_form_01 [name="radio"]:checked').attr('data-end')
			var check = $('#analytics_form_01 [name="checkbox"]:checked')||''
			var compare = check&&check.val()
			var para = {now_time_start:now_time_start,now_time_end:now_time_end,compare:compare}

			// 对比时间提示
			var diff_num = new Date(now_time_end).getTime() - new Date(now_time_start).getTime();
			var diff = diff_num;
			if(compare=='last_year'){
				let year = new Date().getFullYear()
				diff = ((year%4 == 0&&year%100 != 0)||year%400 == 0)?366:365;
				diff = diff_num + diff*86400000
			}
			var start_tip = new Date(new Date(now_time_start).getTime() - diff).date('Y-m-d');
			var end_tip = new Date(new Date(now_time_end).getTime() - diff -86400000).date('Y-m-d');
			var time_tip = diff_num>86400000?`对比<span>${start_tip}/${end_tip}</span>`:`对比<span>${end_tip}</span>`
			$('.wcb_analytics_select .date_tip span').html(compare?time_tip:``)

			// 提交表单数据
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
				//转化率数据
				var rate_data = []
				//
				if(result.ret == 1){
					//处理echart配置数据
                    for(let key in result) {
                        if(key=='pv'||key=='past_pv'){
                            series.push({
                                name: key=='pv'&&$.lang.global.look_current||key=='past_pv'&&$.lang.global.contrast,
                                type: 'line',
                                stack: '',
								smooth: true,
								zlevel:key=='pv'?1:0,
                                data: result[key]
                            })
							rate_data.push(result[key])
                        }
                    }
					// 实例echarts
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
					//计算转换率
					var compare = $('#analytics_form [name="checkbox"]:checked').val()
					var now_res = 0;
					var past_res = 0;
					var pv_el_rate = $('.rate_pv_num .rate')
					//
					for(let i=0;i<rate_data[0].length;i++){
						now_res+=rate_data[0][i]
						past_res+=rate_data[1]&&rate_data[1][i]
					}
					var res = this.rate(now_res,past_res)
					pv_el_rate.removeClass('up down')
					if(!compare){ pv_el_rate.html(`--`); }
					else{
						var str = `${Math.abs(res)}%`;
						if(res<0){
							pv_el_rate.addClass('down');
						}else if(res>0){
							pv_el_rate.addClass('up');
						}else{
							str = res;
						}
						pv_el_rate.html(str);
					}
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
				//转换率
				var rate_data = []
				//
				if(result.ret == 1){
					//处理echart配置数据
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
							rate_data.push(result[key])
                        }
                    }
					// 实例echarts
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
					
					//计算转换率
					var compare = $('#analytics_form [name="checkbox"]:checked').val()
					var now_res = 0;
					var past_res = 0;
					var uv_el_rate = $('.rate_uv_num .rate')
					//
					for(let i=0;i<rate_data[0].length;i++){
						now_res+=rate_data[0][i]
						past_res+=rate_data[1]&&rate_data[1][i]
					}
					var res = this.rate(now_res,past_res)
					uv_el_rate.removeClass('up down')
					if(!compare){ uv_el_rate.html(`--`); }
					else{
						var str = `${Math.abs(res)}%`;
						if(res<0){
							uv_el_rate.addClass('down');
						}else if(res>0){
							uv_el_rate.addClass('up');
						}else{
							str = res;
						}
						uv_el_rate.html(str);
					}
				}
			},
			rate(now,past){
				var res = 0;
				now = parseInt(now);
				past = parseInt(past);
				if(now&&!past){
					res = 100;
				}else if((!now&&past)||(!now&&!past)){
					res = $.lang.global.rise_null;
				}else{
					res = (((now-past)/past)*100).toFixed(2)
				}
				return res
			}
		}



		// ————————————————————————————————————————————
		var update_tab = function(){
			// 获取的表单数据
			var now_time_start = $('#analytics_form_02 [name="radio"]:checked').attr('data-start')
			var now_time_end = $('#analytics_form_02 [name="radio"]:checked').attr('data-end')
			var para = {now_time_start:now_time_start,now_time_end:now_time_end}
			

			// 着陆页
			$.async('POST', '?ma=statistics/analytics/url_click', para, result=>{
				$('.wcb_analytics_binds .li').eq(0).html(tab_el.link_el(result.arr))
			}, 'json')
			// 来源渠道
			$.async('POST', '?ma=statistics/analytics/referrer', para, result=>{
				$('.wcb_analytics_binds .li').eq(1).html(tab_el.ref_el(result.arr))
			}, 'json')
			// 国家/地区
			$.async('POST', '?ma=statistics/analytics/province', para, result=>{
				$('.wcb_analytics_binds .li').eq(2).html(tab_el.address_el(result.arr))
			}, 'json')
			// 设备
			$.async('POST', '?ma=statistics/analytics/client', para, result=>{
				$('.wcb_analytics_binds .li').eq(3).html(tab_el.client_el(result.arr))
			}, 'json')
		}
		

		var tab_el = {
			null_el:`<div class="flex-max" style="width:100%;height:400px;font-size:18px;">
                        <img src="/images/global/null2.png" alt="">
                        <div>${$.lang.global.null}</div>
                    </div>`,
			link_el(data){
				var element = '';
				if(data){
					for(let i=0;i<data.length;i++){
						element+=`
							<tr>
								<td>${data[i].Link}</td>
								<td>${data[i].Uv_all}</td>
							</tr>
						`;
					}
					return `<table class="ly_table_list maxw">
							<thead>
								<tr>
									<td class="w_1">${$.lang.global.referrer}</td>
									<td class="w_1">${$.lang.global.visitor}</td>
								</tr>
							</thead>
							<tbody>
								${element}
							</tbody>
						</table>`
				}
				return this.null_el
				
			},
			ref_el(data){
				var element = '';
				if(data){
					for(let i=0;i<data.length;i++){
						element+=`
							<tr>
								<td>${data[i].Title}</td>
								<td>${data[i].Pv_all}</td>
								<td>${data[i].Uv_all}</td>
								<td><a>${$.lang.global.detail}</a></td>
							</tr>
						`;
					}
					return `<table class="ly_table_list maxw">
							<thead>
								<tr>
									<td class="w_1">${$.lang.global.referrer}</td>
									<td class="w_1">${$.lang.global.look_qty}</td>
									<td class="w_1">${$.lang.global.visitor}</td>
									<td class="w_1"></td>
								</tr>
							</thead>
							<tbody>
								${element}
							</tbody>
						</table>`
				}
				return this.null_el
				
			},
			address_el(data){
				var element = '';
				if(data){
					for(let i=0;i<data.length;i++){
						element+=`
							<tr>
								<td>${data[i].Title}</td>
								<td>${data[i].Pv_all}</td>
								<td>${data[i].Uv_all}</td>
							</tr>
						`;
					}
					return `<table class="ly_table_list maxw">
							<thead>
								<tr>
									<td class="w_1">${$.lang.global.country_region}</td>
									<td class="w_1">${$.lang.global.look_qty}</td>
									<td class="w_1">${$.lang.global.visitor}</td>
								</tr>
							</thead>
							<tbody>
								${element}
							</tbody>
						</table>`
				}
				return this.null_el
			},
			client_el(data){
				var element = '';
				if(data){
					for(let i=0;i<data.length;i++){
						element+=`
							<tr>
								<td>${data[i].Title}</td>
								<td>${data[i].Pv_all}</td>
								<td>${data[i].Uv_all}</td>
							</tr>
						`;
					}
					return `<table class="ly_table_list maxw">
							<thead>
								<tr>
									<td class="w_1">${$.lang.global.equipment}</td>
									<td class="w_1">${$.lang.global.look_qty}</td>
									<td class="w_1">${$.lang.global.visitor}</td>
								</tr>
							</thead>
							<tbody>
								${element}
							</tbody>
						</table>`
				}
				return this.null_el
			}
		}


		window.onload = function(){
			update_tab();
			update_chart();
		}

		$('.wcb_analytics_tabs .li').click(function(){
			var el = $(this);
			var index = $('.wcb_analytics_tabs .li').index(this)
			console.log(index);
			el.addClass('cur').siblings().removeClass('cur')
			$('.wcb_analytics_binds .li').eq(index).addClass('active').siblings().removeClass('active')
		})


	</script>
</div>
</body>
</html>