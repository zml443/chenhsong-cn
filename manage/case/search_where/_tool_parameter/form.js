// 拖拽回调
var case_search_tool_parameter = {
    // 初始化时触发
    init: function (el) {
        this.mod_index(el);
    },
    // 拖拽排序改变后触发
    change: function (el) {
        this.mod_index(el);
    },
    // 以下是业务代码，不是回调函数
    mod_index: function (el) {
        el.find('tr').each(function(i){
        	i = parseInt(i);
            $(this).find('input,select,textarea').each(function(){
                var inp = $(this);
                var name = inp.attr('name');
                if (name){
                	var new_name = name.replace(/^(.*)\[[0-9]*\]/, '$1['+i+']');
					inp.attr({'name':new_name});
				};
            });
            $(this).find('.myorderby').val(i+1);
        });
    }
};

// 生成筛选项表格
var case_search_tool_parameter_list = {
	el:'',
	drop_opt:'',
	init(){
		this.el = $('.PSearch_table tbody');
		// 下拉选项
		this.drop_opt = $('.PSearch_table_drop_type').html();
		// tr数据
		var data = $('.PSearch_table_tr_data').json();
		var ohtml = '';
		if(data.length){
			ohtml = data.map(v=>{
				return this.li(v);
			}).join('');
			this.el.append(ohtml);
		}
		this.len();
	},
	// 生成tr
	li(item){
		let rand = Math.random().toString();
		rand = rand.replace('0.','K');
		return `
			<tr>
				<td class="w_1">
					<div class="lyicon-drag pointer"></div>
				</td>
				<td stopPropagation>
					<input class="ly_input width200" type="text" name="wb_case_search_where_extid[0][Name]" size="small" autocomplete="off" placeholder="名称" value="${item.Name||''}" />
					<input type="hidden" name="wb_case_search_where_extid[0][Id]" value="${item.Id||''}">
					<input class="myorderby" type="hidden" name="wb_case_search_where_extid[0][MyOrder]" value="${item.MyOrder||''}">
				</td>
				<td stopPropagation>
					<a class="mr_5px"><span>${item.wb_case_id?item.wb_case_id.split(',').length:'0'}</span>个案例</a>
					<a class="PSearch_table_sider" color="main" lydbs-association-list="" data-ma="case/index" data-title="" fn='dbs_case_list_cb'>
						<input class="${rand}" type="hidden" name="wb_case_search_where_extid[0][wb_case_id]" value="${item.wb_case_id||''}">关联
					</a>
				</td>
				<td class="w_1" stopPropagation>
					<div class="ly_gap_10px">
						<a class="PSearch_table_del ly_btn_round lyicon-ashbin" bg="light"></a>
					</div>
				</td>
			</tr>
		`
	},
	// 添加
	add(){
		this.el.append(this.li({}));
		this.len();
	},
	// 删除
	del(el){
		let index = el.parents('tr').index();
		this.el.find('tr').eq(index).remove();
		this.len();
	},
	// 判断是否有tr存在
	len(){
		// 没数据时显示 空图片
		if(this.el.find('tr').size()){
			$('.PSearch_table_null_opt').addClass('hide');
			if($('.PSearch_table_null_opt .reset').size()){
				$('.PSearch_table_null_opt .reset').remove();
			}
		}else{
			$('.PSearch_table_null_opt').removeClass('hide').append('<input class="reset" type="hidden" name="Data" value="">');
		}
		// 重排name
		case_search_tool_parameter.mod_index(this.el);
	},
}

// 初始化
$(document).ready(function(){
	case_search_tool_parameter_list.init();
})


$(document).on('click','.PSearch_table_add',function(){
	case_search_tool_parameter_list.add();
})


$(document).on('click','.PSearch_table_del',function(){
	case_search_tool_parameter_list.del($(this));
})


// 产品关联回调
var dbs_case_list_cb = {
	init(el,data){
		this.submit(el,data);
	},
	submit(el,data){
		el.find("input[type='hidden']").val(data.value.join(','))
		el.prev().find('span').html(data.value.length);
	}
}
