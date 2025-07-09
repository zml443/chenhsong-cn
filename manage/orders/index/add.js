var orders_index_add = $.store('orders_index_add',{
    state: {
        step: 0, //步骤

        product_el:'',  //产品列表
        products:[],  //补充变量：Number-买的数量，Specs-选择的商品规格，popup_id-弹窗id，Total-总价
        address:{}, //配送地址
        cost:{ //订单费用
            Price:0,//所选商品总价
            Freight:0,//运费
            Sale:0,//折扣
            Taxation:0,//税费
            Commission:0,//手续费
            OrderPrice:0,//订单总价
        },

    },
    // 初始化
    init(){
        this.page.tab(2);
    },

    page:{
        data:{},
        tab(step){
            let flag = this.isnext(step);
            if(flag){
                $('.orders_index_add_step').children().eq(step).addClass('cur').prevAll().addClass('cur next-cur')
                $('.orders_index_add_step').children().eq(step).removeClass('next-cur').nextAll().removeClass('cur next-cur');
                $('.orders_index_add_tab_box').children().eq(step).removeClass('hide2').siblings().addClass('hide2');
                $('.orders_index_add_tab_con').children().eq(step).removeClass('hide2').siblings().addClass('hide2');
            }else{
                console.log('验证不通过');
            }
        },
        isnext(step){
            let store = this.store();
            let state = store.state;
            let flag = 0;

            // 下一步就验证
            if(state.step==0&&step>state.step){
                // if(!state.products.length){
                //     WP.$.alert({str:'请选择产品',cancel: 1,})
                //     return
                // }else{
                //     console.log(store.state.products);
                // }
                console.log('选择产品',state);
            }
            if(state.step==1&&step>state.step){
                state.address = $('.address_form').json2();
                store.apply.html();
                console.log('填写地址',state);
            }
            if(state.step==2&&step==2){
                console.log('提交',state);
            }


            state.step = step;
            return flag=1;
        },
        submit(){
            let store = this.store();
            let state = store.state;
            this.isnext(2);
        },
    },

    // 1、
    // 处理数据
    add: {
        data:{},
        getData(element){
            let store = this.store();
            let state = store.state;
            let _this = this;
            state.product_el = $(element);
            WP.$.iframeBox({
                url: '?ma=products/index&l=selector',
                confirm(iframe,result){
                    let ids = result.join(',');
                    state.product_el.find("input[type='hidden']").val(ids);
                    $.async('GET','?ma=products/index&l=json',{Id:ids,_limit_:10000},res=>{
                        _this.initArr(res['children']);
                    },'json')
                },
            });
        },
        // 初始化
        initArr(data){
            let store = this.store();
            let state = store.state;
            data.forEach(v => {
                let index = state.products.findIndex(item=>{return item.Id==v.Id});
                if(v.wb_products_parameter){
                    state.products.push({Number:1, popup_id:('k'+Math.random()).replace('.',''), ...v,});
                }else{
                    if(index>-1){
                        state.products[index].Number++;
                    }else{
                        state.products.push({Number:1, popup_id:('k'+Math.random()).replace('.',''), ...v,});
                    }
                }
            });
            // 生成结构
            this.aryArr();
        },
        // 修改参数
        updateParams(opt){
            let store = this.store();
            let state = store.state;
            let oldval = state.products[opt.id];
            let newval = opt.data;
            let index = state.products.findIndex(item=>{return item.Id==newval.Id&&(item.Specs&&newval.Specs&&item.Specs.ids==newval.Specs.ids)});
            if(index>-1){
                state.products[index].Number += newval.Number;
                state.products.splice(opt.id,1);
            }else{
                oldval.Specs = newval.Specs;
            }
            this.aryArr();
        },
        // 修改数量
        updateNum(opt){
            let store = this.store();
            let state = store.state;
            state.products[opt.id].Number = opt.value;
            this.aryArr();
        },
        // 删除产品
        delete(id){
            let store = this.store();
            let state = store.state;
            state.products.splice(id,1);
            this.aryArr();
        },
        //整理数组
        aryArr(){
            let store = this.store();
            let state = store.state;
            state.cost.Price = 0;//商品总价
            console.log('state',state.products,lyGlobal);

            state.products.forEach((v,i) => {
                let result = lyGlobal.wb_products_parameter_price({row:v, wb_products_parameter_id:v.Specs?v.Specs.ids:''});
                if(result.Picture.path) state.products[i].Picture = result.Picture;
                state.products[i].Price = result.Price;
                state.products[i].Stock = result.Stock;
                state.products[i].SKU = result.SKU;
                state.products[i].wb_products_parameter_id_buy = result.wb_products_parameter_id_buy;
                state.products[i].wb_products_parameter_buy = result.wb_products_parameter_buy;
                // 计算每个产品的多规格总价
                let total_price = parseFloat(state.products[i].Number) * parseFloat(state.products[i].Price);
                state.products[i].Total = total_price;
                // 记录所选产品总价
                state.cost.Price+=total_price;
            });

            store.lists.html();
        }
    },
    // 产品列表
    lists:{
        data:{},
        html(){
            let store = this.store();
            let state = store.state;
            let html = `
                    ${state.products.map((v,index) =>{
                        return `<tr data-id="${index}">
                                    <td class="w_1">
                                        <div class="ly_img"><img src="${v.Picture.path||''}" /></div>
                                    </td>
                                    <td>
                                        <div>${v.Name}</div>
                                        <div class="text-line">${v.wb_products_parameter?v.Specs&&v.Specs.label||'<div color="text3">未选择</div>':'<div color="text3">无可选参数</div>'}</div>
                                    </td>
                                    <td>${v.Price||'0.00'}</td>
                                    <td>
                                        <label class="width80"><input class="ly_input width80" style="text-align:right;" type="text" size="small" name="Number" value="${v.Number||1}" onchange="${this.event('update')}" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></label> / ${v.Stock||'0'}
                                    </td>
                                    <td>${v.Total||'0.00'}</td>
                                    <td class="w_1">
                                        <div class="ly_gap_10px">
                                            <a class="ly_btn_round lyicon-bianji" bg="light" onclick="${this.event('ext')}"></a>
                                            <a class="ly_btn_round lyicon-close" bg="light" onclick="${this.event('del')}"></a>
                                        </div>
                                    </td>
                                </tr>`
                    }).join('')}
                `;
            state.product_el.parents('._dbs_box').find('tbody').html(html);
        },
        // 修改商品数量
        update(el){
            let store = this.store();
            let id = $(el).parents('tr').attr('data-id');
            let value = parseInt($(el).val());
            $(el).val(value);
            store.add.updateNum({id,value})
        },
        // 删除商品
        del(el){
            let store = this.store();
            store.add.delete($(el).parents('tr').attr('data-id'));
        },
        // 选择商品规格
        ext(el){
            let store = this.store();
            store.extParams.html($(el).parents('tr').attr('data-id'))
        },
    },
    // 产品规格选择
    extParams:{
        data:{},
        html(ext_id){
            let store = this.store();
            let state = store.state;
            let id = ext_id;
            let params = $.json(state.products[id].wb_products_parameter);
            let html = `
                <form class="p_30_0px maxh flex-column">
                    <div class="flex-right p_0_30px"><i class="fz24 close lyicon-guanbi pointer"></i></div>
                    <div class="flex-1 scrollbar p_0_30px">
                        ${params.length?params.map(item=>{
                            let dd = ''
                            item['children']&&item['children'].forEach(vv => {
                                let flag = state.products[id].Specs&&state.products[id].Specs.ids.split(',').includes(vv.id+'');
                                dd += `<label class="ly_btn_checkbox pointer mr_10px">
                                        <i class="lyicon-select-bold mr_5px">
                                            <input type="radio" ${flag?'checked':''} name="${item.type+'_'+item.id}" data-type="${item.name}" data-label="${vv.name}" value="${vv.id}" />
                                        </i>
                                        <span>${vv.name}</span>
                                    </label>`;
                            });
                            return `<div class="mb_15px">请选择${item.name}：<div class="flex p_10_0px">${dd}</div></div>`
                        }).join(' '):'暂无可选参数'}
                    </div>
                    <div class="flex p_0_30px" ly-sticky="bottom">
                        <div class="confirm ly_btn_radius pointer mr_15px" bg="main">确认</div><div class="cancel ly_btn_radius pointer">取消</div>
                    </div>
                </form>`;
            WP.$.alert_side({
                id: state.products[id].popup_id,
                data: {
                    str: html
                },
                css: {width:350, right:0}, //弹窗大小和位置
                init(el){
                    el.on('click', '.close, .confirm, .cancel', function () {
                        console.log('关闭');
                        $(this).popup_remove();
                    });
                    el.on('click', '.confirm', function () {
                        let obj = $(this).parents('form').json2();
                        let arr = [];
                        for (let key in obj) {
                            let val = obj[key];
                            arr.push(val);
                        }
                        arr.sort(function(a,b){
                            return a.value - b.value
                        })
                        let Specs = {ids:arr.map(v=>{return v.value}).join(','), label:arr.map(v=>{return v.type+':'+v.label}).join(' / ')};
                        store.add.updateParams({id:id,data:{ ...state.products[id],Specs}});
                        console.log('提交',Specs);
                    });
                },
            });
        },
    },

    // 2、
    // 选择配送地址
    shipping:{
        data:{},
        html(data){
            $('form').find('[name]').each(function(){
                let name = $(this).attr('name');
                let val = data[name];
                val && $(this).val(val);
            })
        },
        getData(id){
            $.async('GET','?ma=member/address&l=json',{_sel_ids:id},res=>{
                res.children && this.html(res.children[0]);
            },'json');
        },
    },

    apply:{
        data:{

        },
        html(){
            let store = this.store();
            let state = store.state;
            this.aryCost();
            // 费用列表
            $('.apply_table').find('[data-up]').each(function(){
                let name = $(this).attr('data-up');
                let val = state.cost[name];
                $(this).html(val);
                console.log('val',val,name);
            })
        },
        aryCost(){
            let store = this.store();
            let state = store.state;
            let cost = {
                Freight:0,//运费
                Sale:0,//折扣
                Taxation:0,//税费
                Commission:0,//手续费
                OrderPrice:0,//订单总价
            }
        }
    }


});


// 选择会员的回调-动态的修改选择配送地址的hr-ef
var select_members= {
    init(el,obj){
        console.log('select_members_init',obj.list);
    },
    confirm(el,obj){
        let href = $(el).parents('._dbs_box').find('[hr-ef]');
        let str = href.attr('hr-ef');
        if(obj.list.length){
            href.attr('hr-ef',str.replace(/wb_member_id=(\d)*/g, 'wb_member_id='+obj.list[0].value));
        }else{
            href.attr('hr-ef',str.replace(/wb_member_id=(\d)*/g, 'wb_member_id='));
        }
        console.log('select_members_confirm',obj.list);
    }
}

// 选择配送地址的回调
var shipping_address= {
    confirm(el,popup,res){
        console.log('shipping_address_confirm',res);
        if(res.length) orders_index_add.shipping.getData(res[0].id)
    }
}


var apply_type_sale_cb = {
    init(el, checked){
        if(checked) this.click(el);
    },
    click(el, checked){
        var type = el.val();
        if(type=='all') {
            el.parents('._dbs_content').find('.tab_content > *[data-con]').addClass('hide2');
        }else{
            el.parents('._dbs_content').find('.tab_content > *[data-con="'+type+'"]').removeClass('hide2').siblings('[data-con]').addClass('hide2');
        }
    }
};


$(document).ready(function(){
    orders_index_add.init()
})