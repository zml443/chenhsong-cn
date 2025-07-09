$(document).ready(function(){
    $(".wcb_index2_form").hover(function(){
        $(".wcb_index2_form").addClass('cur');
    },function(){
        $(".wcb_index2_form").removeClass('cur')
    });
})

$(document).on('click','.wcb_index2_form .item',function(event){
    let el = $(this)
    let parent = el.parents('.wcb_index2_form')
    parent.removeClass('cur')
    if(el.hasClass('dangqianxiang')){
        return
    }else{
        el.addClass('dangqianxiang').siblings().removeClass('dangqianxiang')
        update_el.update(el)
    }
})


let update_el = {
    current: 'today',
    date_str:{
        today: $.lang.global.today,
        yesterday:$.lang.global.yesterday,
        lastweek:$.lang.global.last_7_day,
        lastmonth:$.lang.global.last_30_day,
    },

    // 处理数据
    update(el){
        // 更新时间参数
        if(el){
            update_el.current = el.attr('data-name')
            // 更新时间选框内容
            el.parent('.wcb_index2_form').find('.wcb_index2_form_span > span').html(update_el.date_str.current)
        }
        // 请求参数
        let para = {sort_type:'pv',data_limit:10,time:update_el.current}

        // 除最新询盘的所有数据
        $.async('POST', '?ma=account/index2/gailan', {...para,group_type:'domain'}, result=>{
            if(result.ret==1){
                update_el.click_el(result.data.click)
                update_el.click_month_el(result.data.click_month)
                update_el.referrer_el(result.data.ref_title)
                update_el.referrer_url_el(result.data.ref_domain)
                update_el.province_el(result.data.province)
                update_el.client_el(result.data.client)
            }
            // console.log('测试数据',result);
        }, 'json')
    },

    // 流量 列表
    click_el(result){
        // console.log('click_el',result);
        let html = ''
        if(result){
            for(let key in result){
                html +=`
                    <li class="wcb_index2_li ${key==update_el.current?'cur':''}">
                        <div class="time">${result[key].Title}</div>
                        <div class="num">${parseInt(result[key].Pv)||0}</div>
                        <div class="num">${parseInt(result[key].Uv)||0}</div>
                    </li>`
            }
            html = `<div class="flex-1 wcb_index2_click_el">
                        <li class="wcb_index2_li">
                            <div class=""></div>
                            <div class="">${$.lang.global.look_qty}</div>
                            <div class="">${$.lang.global.visitor_uv}</div>
                        </li>
                        ${html}
                    </div>`
        }else{
            html = `<div>${$.lang.global.null}</div>`
        }
        // 处理结构
        $('.wcb_index2_click_el').html(html)
    },
    // 流量 柱状图
    click_month_el(result){
        // console.log('click_month_el',result);
        if(result){
            // 处理结构
            update_el.click_month_el_echarts(result)
        }
    },
    // 流量来源
    referrer_el(result){
        // console.log('referrer_el',result);
        if(result){
            let total = 0
            for(let key in result) {
                total +=  parseInt(result[key].Pv_all)
            }
            if(total){
                // console.log('referrer_el',total);
            }
            // 处理结构
            update_el.referrer_el_echarts(result)
        }
    },
    // 来源网址
    referrer_url_el(result){
        // console.log('referrer_url_el',result);
        if(result){
            let html = ''
            for(let key in result) {
                if(!result[key].ReferrerUrl){
                    result[key].ReferrerUrl = $.lang.panel.direct_visit
                }else{
                    let url = result[key].ReferrerUrl.match(/https?:\/\/([^\/]+)\//i);
                    result[key].ReferrerUrl = url[0]
                }
                html += `<div class="flex-between mb_10px">
                            <div color="main">${result[key].ReferrerUrl}</div>
                            <div color="text4">${result[key].Pv_all}</div>
                        </div>`
            }
            $('.wcb_index2_referrer_url').html(`<div class="fz14 lh_2 wcb_index2_referrer_url" color="main">${html}</div>`)
        }
    },
    // 访问分布
    province_el(result){
        // console.log('province_el',result);
        if(result){
            let total = 0
            let html = ''
            for(let key in result) {
                total +=  parseInt(result[key].Pv_all)
            }
            if(total){
                for(let key in result) {
                    let pct = ((parseInt(result[key].Pv_all)/total)*100).toFixed(2)
                    html +=`<div class="flex-between mb_10px">
                                <div color="text">${result[key].Title}</div>
                                <div color="text">${pct}</div>
                                <div color="text4">${result[key].Pv_all}</div>
                            </div>`
                }
            }
            // 处理结构
            $('.wcb_index2_province').html(`<div class="fz14 lh_2 wcb_index2_province">${html}</div>`)
        }
    },
    // 访问终端
    client_el(result){
        // console.log('client_el',result);
        if(result){
            let pc = 0
            let mobile = 0
            let total = 0
            let pc_pct = 0
            let mobile_pct = 0
            for(let key in result) {
                total +=  parseInt(result[key].Pv_all)
                if(result[key].Title == 'PC'){
                    pc = parseInt(result[key].Pv_all)
                }else{
                    mobile += parseInt(result[key].Pv_all)
                }
            }
            if(total){
                if(pc){
                    pc_pct = ((pc/total)*100).toFixed(2)
                    mobile_pct = (100 - pc_pct).toFixed(2)
                }else{
                    pc_pct = 0
                    mobile_pct = 100
                }
            }else{
                pc_pct = 0
                mobile_pct = 0
            }
            // 处理结构
            let html = `<div class="pc flex-middle2 flex-right mb_10px">${pc_pct}%</div>
                        <div class="mobile flex-middle2 flex-right">${mobile_pct}%</div>
                        `
            $('.wcb_index2_client').html(html)
        }
    },

    click_month_el_echarts(result){
        var echart_box = $('.wcb_index2_click_month_el')
        echart_box.find('.echartbox').remove()
        echart_box.append(`<div class="echartbox"></div>`)
        //
        var el = $('.wcb_index2_click_month_el .echartbox')
        var mychart = echarts.init(el[0])
        if(result){
            // 处理数据
            var series = []
            let Pv_arr = [];
            let Title_arr = [];
            for(let key in result) {
                Pv_arr.push(result[key].Pv)
                Title_arr.push(result[key].Title)
            }
            series.push({
                name: 'Pv',
                type: 'bar',
                stack: '',
                smooth: true,
                data: Pv_arr
            })
            mychart.setOption({
                tooltip: {
                	trigger: 'axis'
                },
                color:['#409eff'],
                grid: {
                    left: '0%',
                    right: '4%',
                    bottom: '0%',
                    top:'10%',
                    containLabel: true
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: true,
                    data: Title_arr,
                    axisLabel:{
                        rotate:Title_arr.length>7?40:0,
                    }
                },
                yAxis: {
                    type: 'value'
                },
                series: series
            })
        }
    },

    referrer_el_echarts(result){
        var echart_box = $('.wcb_index2_referrer_el')
        echart_box.find('.echartbox').remove()
        echart_box.append(`<div class="echartbox"></div>`)
        //
        var el = $('.wcb_index2_referrer_el .echartbox')
        var mychart = echarts.init(el[0])
        let Pv_arr = [];
        if(result){
            // 计算总数
            let total = 0
            for(let key in result) {
                total +=  parseInt(result[key].Pv_all)
            }
            // 计算比例
            for(let key in result) {
                let num = ((result[key].Pv_all/total)*100).toFixed(2)
                let title = `${result[key].Title} ${num}%`
                Pv_arr.push({
                    value:result[key].Pv_all,
                    name:title,
                })
            }
            mychart.setOption({
                tooltip: {
                    trigger: 'item'
                },
                grid: {
                    top: '5%',
                    left: 'center'
                },
                legend: {
                    top: 'bottom'
                },
                series: [
                    {
                        name: '',
                        type: 'pie',
                        radius: ['50%', '70%'],
                        avoidLabelOverlap: false,
                        itemStyle: {
                            borderRadius: 10,
                            borderColor: '#fff',
                            borderWidth: 5
                        },
                        label: {
                            show: true,
                            position: 'center'
                        },
                        emphasis: {
                            label: {
                                show: true,
                                fontSize: 20,
                                fontWeight: 'bold',
                            },
                        },
                        labelLine: {
                            show: false
                        },
                        data: Pv_arr
                    }
                ]
            })
        }
    }
}

window.onload = function(){
    update_el.update()
}






