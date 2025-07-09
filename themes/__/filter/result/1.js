var lyfilter_result = {
    search:[],
    timer:'',
    url: window.location.href,
    createHtml(data){
        this.search = [];
        let html = '';
        let is_null = 0;
        let obj = data.json;


        for (const key in obj) {
            const value = obj[key];
            if(!this.search.includes(key)){
                this.search.push(key);
            }
            switch(key){
                case 'param_id':
                    for (const kk in value) {
                        let vv = value[kk];
                        vv&&vv.forEach(item => {
                            html += this.paramfn(item,key);
                        });
                    }
                break;
                case 'price':
                    if(!(value.min.value==''||value.max.value==''||(value.min.value==0&&value.max.value==0))){
                        html += this.pricefn(value,key);
                    }
                break;
                case 'cid':
                case 'tag':
                    value&&value.forEach(item => {
                        html += this.paramfn(item,key);
                    });
                break;
                default:
                    html += this.paramfn(item,key);
                break;
            }
            if(html!='') is_null++;
        }

        if(is_null>0){
            html += `<div class='lyfilter_result_list_li' data-type='all'>
                        <div class='lyfilter_result_list_name'>全部清除</div>
                        <i class='lyfilter_result_list_close lyicon-error'></i>
                    </div>`;
        }

        $('.lyfilter_result_list').html(html);
    },
    paramfn(item,key){
        return `<div class='lyfilter_result_list_li' data-val='${item.value}' data-type='${key}'>
                    <div class='lyfilter_result_list_name'>${item.label}</div>
                    <i class='lyfilter_result_list_close lyicon-error'></i>
                </div>`;
    },
    pricefn(value,key){
        return `<div class='lyfilter_result_list_li' data-val='' data-type='${key}'>
                    <div class='lyfilter_result_list_name'>价格：${value.min.value}~${value.max.value}</div>
                    <i class='lyfilter_result_list_close lyicon-error'></i>
                </div>`;
    }
};


$(document).on('click','.lyfilter_result_list_li',function(){
    let el = $(this);
    let type = el.attr('data-type');
    let value = el.attr('data-val');

    if(type == 'all'){
        el.parent().html('');
    }else{
        el.remove();
    }


    url = lyfilter_result.url;
    var reg = '';
    switch (type) {
        case 'all':
            lyfilter_result.search.forEach(v=>{
                reg = new RegExp("[\\?&]"+v+"=[^&]+","gi");
                url = url.replace(reg,'');
            })
        break;
        case 'price':
            url = url.replace(/[\?&]price=[^&]+/gi, '');
        break;
        case 'cid':
        case 'tag':
        case 'param_id':
            reg = new RegExp("([\\?&]"+type+"=[\\s\\S]*[,|]?)"+value+"([,|&])?","gi");
            url = url.replace(reg, '$1$2').replace(/\|\||,\|/g,'|').replace(/=,|=\|/g,'=').replace(/,,/g,',').replace(/,&/g,'&').replace(/,$/g,'')
        break;
        default:
            reg = new RegExp("[\\?&]"+key+"=[^&]+","gi");
            url = url.replace(reg,'');
            break;
    }
    lyfilter_result.url = url;
    window.history.replaceState(null, '', url);
    clearTimeout(lyfilter_result.timer);
    lyfilter_result.timer = setTimeout(()=>{
        location.reload();
    },500)
})


// 注册函数
ly2.lyfilter_result.reg(data=>{
    lyfilter_result.createHtml(data)
});