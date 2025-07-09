var _drop_select = {
    href: {
        address: $.path+'web/address/address.json',
        address_country: $.path+'web/address/country/index.json.php'
    },
    data: {},
    get(href,fn) {
    	if (this.href[href]) {
    		href = this.href[href];
    	}
    	if (this.data[href]) {
    		fn(this.data[href]);
    	} else if (typeof this.data[href]!='undefined') {
    		setTimeout(()=>{this.get(href, fn)},500);
    	} else {
    		this.data[href] = false;
            $.async('POST', href, {}, result=>{
                this.data[href] = result;
                fn(result);
            }, 'json');
    	}
    }
}

$.task.unshift(function(){
	_('[ly-drop-select]').each(function(){
		var el = $(this)
		var fn = $.callbackfn(el.attr('fn'),['change','init']);
		var drop = new drop_select_class({
			el: el,
			init(){
				$.eval(fn.init, el, this, this.value);
			},
			change(){
				$.eval(fn.change, el, this, this.value);
			},
		});
	});
});

//////////////////////////////////////////////////////
class drop_select_class {
	constructor(option){
		var el = option.el;
		this.option = option;
		this.el = option.el;
		this.type = el.attr('data-type')||'default';
		this.split_symbol = el.attr('data-split-label')||' / ';
		this.split_value = el.attr('data-split-value')||',';

		// 展示内容的input元素
		this.label_input = el.find('input:not([type="hidden"])');
		// 提交内容的input元素
		this.value_input = el.find('[type="hidden"]');
		// input提示信息
		this.placeholder = this.label_input.attr('placeholder');
		// 选中的变量,完整结构[{},{}]
		this.value_dat = [];
		// 选中的变量,value值[xxx,xxx]
		this.value = (this.value_input.val()||'').split(this.split_value);
		// 初始化内容
		this.value_init = this.value_input.val()||'';
		this.label_init = this.label_input.val()||'';
		this.is_init = 1;
		// 选中的变量名[xxx,xxx]
		this.label = [];
		// 控制下拉框能否关闭
		this.is_close = 0;
		// 输入框的内容，区别于搜索框
		this.value_self = '';
		// 是否展示搜索框
		this.is_search = el.attr('data-search')||0;
		// 搜索输入框
		this.search = '';
		// input的类型 radio / checkbox
		this.input_type = '';
		// input为radio类型 用来区分选项的name
		this.radio_name = '';

		// 判断input的类型，传进来的type无法直接适用的情况
		switch(this.type){
			case 'radio':
			case 'default':
				this.input_type = 'radio';
				break;
			default :
				this.input_type = 'checkbox';
				break;
		}

		// this.fn = $.callbackfn(el.attr('fn'),['change','init']);
		this.drop = this.el.drop({
			show: 0,
			html: $.lang.global.loading
		});

		// 选框的数据
		var script = el.find('script,textarea');
		if (script.is('[data-href]')) {
			var href = script.attr('data-href');
			_drop_select.get(href, result=>{
                this.data = result;
				this.init();
			})
		} else {
			this.data = script.json();
			this.init();
		}
		script.remove();
		this.el.addClass('lyui-drop-ui-parents');
	}


	//入口函数
	init(){
		if (this.data) {
			this.ary();
			this.ul();
			this.events();
			this.getData();
			// $.eval(this.fn.init, this.el, this);
			if (this.option.init) this.option.init.call(this);
		}
	}

	//处理数据
	ary(){
		let newdata = {}
		let index = 0
		var digui = (arr, dept, parent_index, long_value, long_label)=>{
			if (!newdata[dept]) {
				newdata[dept] = []
			}
			for (let k in arr) {
				let v = arr[k]
				if (!v.label) {
					v.label = v.value
				}
				let value2 = [...long_value, v.value]
				let label2 = [...long_label, v.label]
				let vv = {
					my_index: index,
					dept: dept,
					parent_index: parent_index,
					long_label: label2,
					long_value: value2,
					self_check: false,
					has_children: v.children&&!$.isEmptyObject(v.children)?1:0,
					self_children_check: false
				}
				for (let i in v) {
					if (i!='children') vv[i] = v[i]
				}
				if (v.children && !$.isEmptyObject(v.children)) {
					digui(v.children, dept+1, index, value2, label2)
				}
				newdata[dept].push(vv)
				index++
			}
		}
		if (this.data.length) {
			digui(this.data, 0, '', [], '')
		}
		this.new_ = newdata
		newdata = ''
	}


	/* 生成结构
		drop-select-search-res为搜索结果框
		drop-select-res为下拉结果框
		drop-select-ul为层级结构
		drop-select-dd为每一个选项
		drop-select-clean为清理按钮
		drop-select-search为搜索输入框
	*/
	ul(){
		this.radio_name = Math.random();
		// 选框的内容
		let html = '';
		// 搜索结果框的内容
		let res = '';

		for (let i in this.new_){
			html += `
				<dl class="drop-select-ul ${i==0?'':'hide'}" dept="${i}">
					${this.new_[i].map((v, k)=>{
						let key = i + '-' + k;
						return this.li(v,key);
					}).join('')}
				</dl>
			`;
			res += `
				${this.new_[i].map((v, k)=>{
					let key = i + '-' + k;
					return this.li(v,key,'search');
				}).join('')}
			`;
		}
		res = `<dl class="drop-select-ul drop-select-search-res hide">
					${res}
					<dd class="drop_not_data drop-select-dd flex-middle2 hide search_btn">暂无数据~</dd>
				</dl>`;

		// 判断有没有下拉的原始数据
		if(this.data&&this.data.length>0){
			// 新增清除选框内容选项,有选择内容是出现
			let ohtml = `<div class="notcopy">
							<div class="drop-select-clean">${$.lang.global.select_clean} <i class="lyicon-error"></i></div>
							<div class="drop-select-search hide"><input type="text" name="" placeholder="请输入关键词..." /><i class="lyicon-error"></i></div>
							<div class="flex">${res}<div class="drop-select-res flex">${html}</div></div>
						</div>`;
			this.el.drop_html(ohtml);
		}else{
			this.el.drop_html(`<div style="padding:10px">${$.lang.global.null}</div>`);
		}
	}

	// 生成 drop-select-dd 结构
	li(v,key,is_search=''){
		// 此变量为dd的展示内容
		var html = v.html?v.html:v.label;
		// 此变量控制是否有右箭头
		var has_child_icon = '';
		// 此变量用来控制是否是最后一级
		var has_child = '';
		// 判断有没有右箭头
		if(v.has_children){
			has_child_icon = '<i class="drop-select-icon lyicon-arrow-right-bold"></i>';
			has_child = 'data-has_children'
		}

		// 判断是不是给搜索生成结构,搜索展示long_label，选框展示label
		if(is_search){
			html = v.html?v.html:v.long_label.join(' / ');
			has_child_icon = '';
			has_child = '';
		}

		// 判断有没有勾选
		let flag = this.value.includes(v.value)&&this.value!='';
		// let cur = 0;
		return `<dd class="drop-select-dd flex-middle2 ${is_search&&'hide search_btn'}"
					value="${v.value}" 
					pinyin="${v.pinyin}"
					data-key="${key}"
					data-my_index="${v.my_index}"
					${has_child}
					data-parent_index="${v.parent_index}"
				>
					<div class="drop-select-check">
						<input 
							type="${this.input_type}"
							name="${this.radio_name}"
							${flag?'checked':''}
							class="${this.type=='default'?'hide':''}" 
							value="${v.value}" 
							data-key="${key}"
						/>
					</div>
					<span class="drop-select-span flex-1">${html}</span>
					${has_child_icon}
				</dd>`
	}


	//绑定事件
	events(){
		var _this = this;
		// 选项栏点击事件,展开与选中
		this.drop.on('click', '.drop-select-dd', function(event){
			if($(this).is('.search_btn')){
				let key = $(this).attr('data-key');
				let parent_k = $(this).attr('data-parent_index');
				let cur = _this.drop.find('.drop-select-ul:not(.drop-select-search-res) .drop-select-dd[data-key="'+key+'"]');
				let parent =_this.drop.find('.drop-select-ul:not(.drop-select-search-res) .drop-select-dd[data-my_index="'+parent_k+'"]');
				// _this.iptExpand({el:parent})
				_this.iptChange({el:cur});
				_this.end();
			}else{
				if (!$(this).is('[data-has_children]') || $(this).is('.open_cur')) {
					_this.iptChange({el:$(this)});
					_this.end();
				} else {
					_this.iptExpand({el:$(this)});
				}
			}
		});
		// 多选框选项勾选下级全选功能
		this.drop.on('click', '.drop-select-check', function(event){
			let parent = $(this).parent('.drop-select-dd');
			_this.iptExpand({el:parent});
			_this.iptChange({el:parent});
			_this.end();
			event.stopPropagation();
			return false;
		});
		// 清除选框 按钮
		this.drop.on('click', '.drop-select-clean', function(event){
			_this.cleanCheck();
		});
		// 清除搜索框 按钮
		this.drop.on('click', '.drop-select-search i', function(event){
			$(this).prev().val('');
			_this.drop.find('.drop-select-search input').val('')
			_this.search = '';
			_this.searchShow();
		});
		// 多选框选项关闭事件
		this.el.on('click', '.ly_options_dd_i', function(event){
			_this.closeCheck({el:$(this)});
			event.stopPropagation();
			_this.end();
			return false;
		});
		// 多选框选项关闭事件
		this.el.on('click', function(event){
			$(this).drop({});
		});
		// 选框聚焦
		this.label_input.on('focus', ()=>{
			this.label_input.attr('placeholder', this.iptPlace()).val('');
			this.is_close = 0;
			// 控制下拉选项是否显示清除项
			if(this.value_input.val()){
				this.drop.find('.drop-select-clean').css('display','flex');
			}else{
				this.drop.find('.drop-select-clean').css('display','none');
			}
			// 判断搜素有无框
			if(this.is_search){
				this.drop.find('.drop-select-search').css('display','flex');
			}else{
				this.drop.find('.drop-select-search').css('display','none');
			}
		});
		// 失去焦点
		this.label_input.on('blur', ()=>{
			this.getData();
		});
		// 输入框 没有搜索功能
		this.label_input.on('change', ()=>{
            var val = this.label_input.val();
			if(!['checkbox'].includes(this.type)){
				this.is_init = 0;
				this.value_self = val;
				this.getData();
			}
		});
		// 搜索框
		var timer;
		this.drop.on('keyup', '.drop-select-search', function() {
			_this.search = $(this).find('input').val();
			clearTimeout(timer);
			timer = setTimeout(()=>{
				_this.searchShow();
			},300)
		});
	}

	/*
	 * 展开下一级
	 * @param {any} opt
	 */
	iptExpand(opt){
		let my_index = opt.el.attr('data-my_index');
		let parent = opt.el.parent();
		parent.next().find('.drop-select-dd').hide().removeClass('open_cur');
		parent.next().find(`.drop-select-dd[data-parent_index=${my_index}]`).show();
		if(opt.el.is('[data-has_children]')){
			parent.next().show().nextAll().hide();
		}else{
			parent.nextAll().hide();
		}
		opt.el.addClass('open_cur cur').siblings().removeClass('open_cur cur');
	}


	/*
	 * input勾选
	 * @param {any} opt
	 */
	iptChange(opt){

		this.is_init = 0;

		// 提交时清空搜索框
		this.drop.find('.drop-select-search input').val('')
		this.search = '';
		this.searchShow();

		this.value_self = '';
		let input = opt.el.find('input');
		let flag = !input.is(':checked');
		if (!input.val()) {
			return false;
		}
		// checkbox选中时勾选所有的子集
		if (this.type=='checkbox'){
			if(flag){
				input.prop('checked','true');
			}else{
				input.removeAttr('checked');
			}
			function set(dd){
				//勾选的那个 my_index
				let parent = dd.parents('.drop-select-ul');
				let cur_top = dd.parents('.drop-select-dd').attr('data-my_index');
				parent.next().find('[data-parent_index="'+cur_top+'"] input').each((index,item)=>{
					let cur = $(item);
					if(flag){
						cur.prop('checked','true');
					}else{
						cur.removeAttr('checked');
					}
					set(cur);
				});
			}
			set(input);
		} else {
			input.prop('checked','true');
			this.is_close = 1;
		}
		this.getData();
	}

	/*
	 * 交互input时对placeholder的控制
	 * @param {any} opt
	 */
	iptPlace(){
		if(this.type == 'checkbox'){
			if(this.value_input.val()){
				return '';
			}else{
				return this.placeholder;
			}
		}else{
			return this.label.join(',')||this.placeholder;
		}
	}

	/*
	 * 清除选项框内容
	 * @param {any} 无
	 */
	cleanCheck(){
		this.el.find('input').val('');
		this.label_input.attr('placeholder',this.placeholder);
		this.label = '';
		this.value = '';
		this.value_self = '';
		this.drop.find('.drop-select-dd').each((i, el)=>{
			el = $(el);
			el.find('input:checked').removeAttr('checked');
			el.removeClass('cur');
		})
		this.getData();
		this.end();
		// 关闭选项
		this.el.drop_hide();
	}

	/*
	 * 关闭(删除)多选 选项框选项
	 * @param {any} opt
	 */
	closeCheck(opt){
		let dd = opt.el;
		let my_index = dd.parent('.ly_options_dd').attr('data-my_index');
		let dept = dd.parent('.ly_options_dd').attr('data-dept');
		let dept_el = this.drop.find(`.drop-select-res .drop-select-ul[dept="${dept}"] .drop-select-dd[data-my_index="${my_index}"]`);
		// 取消勾选
		dept_el.find('input:checked').removeAttr('checked');
		dept_el.find('.drop-select-check').removeClass('cur');
		this.getData();
	}


	/*
	 * 判断是否显示搜索框
	 * @param {any} opt
	 */
	searchShow(){
		var _this = this;
		if(this.search&&this.search!=''){
			// 搜索框有内容就展开搜索结果
			this.drop.find('.drop-select-search-res').removeClass('hide');
			this.drop.find('.drop-select-res').addClass('hide');
			let res_num = 0;
			this.drop.find('.drop-select-search-res').find('.drop-select-dd:not(.drop_not_data)').each(function(){
				var el = $(this);
				var key = el.attr('data-key').split('-');
				var v = _this.new_[key[0]][key[1]];
				var py = v.pinyin && v.pinyin.includes(_this.search);
				if( v.long_label.join('/').includes(_this.search)||py){
					res_num++;
					$(this).removeClass('hide');
				}else{
					$(this).addClass('hide');
				}
			});
			// 判断有无搜索结果，没搜到就展示 drop_not_data
			if(res_num){
				this.drop.find('.drop-select-search-res .drop_not_data').addClass('hide');
			}else{
				this.drop.find('.drop-select-search-res .drop_not_data').removeClass('hide');
			}
		}else{
			this.drop.find('.drop-select-search-res').addClass('hide');
			this.drop.find('.drop-select-res').removeClass('hide');
		}
	}



	// 选中勾选的数据
	getCheck(){
		this.value_dat = [];
		this.value = [];
		this.label = [];
		// value_self存在时则为手动输入，不存在即为勾选选项
		if(this.value_self){
			this.value_dat.push({
				long_value: this.value_self,
				long_label: this.value_self,
			});
			this.value.push(this.value_self);
			this.label.push(this.value_self);
		}else{
			this.drop.find('.drop-select-res input:checked').each((i, el)=>{
				el = $(el);
				let key = el.attr('data-key').split('-');
				let val = this.new_[key[0]][key[1]];
				this.value_dat.push(val);
				this.value.push(val.value);
				this.label.push(val.long_label.join(this.split_symbol));
			})
		}
	}

	//显示数据
	getData(){
		this.getCheck();
		// 单选提交一条数据，多选提交所有checked
		switch(this.type){
			case 'checkbox':
				// 多选 有输入时
				let options = '';
				// 遍历多选数组，并生成结构
				if(this.value_dat.length>0){
					for(let i=0;i<this.value_dat.length;i++){
						let v = this.value_dat[i].long_label.join(this.split_symbol);
						options += `<span class="ly_options_dd" data-my_index=${this.value_dat[i].my_index} data-dept=${this.value_dat[i].dept}>
										<span>${v}</span><i class="ly_options_dd_i lyicon-error ly_drop_unclick"></i>
									</span>`;
					}
					// 删除原有选项，重新生成选项栏
					let dd = this.el.find('.ly_options_dd');
					dd&&dd.remove();
					this.label_input.before(options);
					this.label_input.val('');
				}else{
					this.el.find('.ly_options_dd')&&this.el.find('.ly_options_dd').remove();
				}
				break;
			default:
				// 关闭下拉,is_close存在时不关闭下拉
				if(this.is_close){
					this.el.drop_hide();
				}
				if (this.label.length==0) {
					this.label = this.value;
				}
				this.label_input.val(this.label.join(','));
				break;
		}
		// 通过 , 组合提交数据
		// console.log(this.value);
		this.value_input.val(this.value.join(this.split_value));

		if (this.is_init && this.value.length==0) {
			this.value_input.val(this.value_init);
			this.label_input.val(this.label_init||this.value_init);
			// this.value_init = this.value_input.val()||'';
			// this.label_init = this.label_input.val()||'';
			// this.is_init = 1;
		}

		// input提示语
		this.label_input.attr('placeholder', this.iptPlace());
	}

	end(){
		if (this.option.change) this.option.change.call(this);
		// this.value_input.trigger('change');
		// this.label_input.trigger('change');
		this.el.trigger('change');
	}
}