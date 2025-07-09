

class lyvue_input_tag {
	// 初始化
	constructor(el, option){
		this.el = el;
		this.option = {
			url: '',
			...option
		};
		this.canInput = 0;
		this.allTag = [];
		this.hidden_el = el.find('input[type="hidden"]');
		this.text_el = el.find('input[type="text"]');
		this.tag = [];
		var tag = (el.find('input[type="hidden"]').val()||'').split(',');
		for (var v of tag) this.add(v);
		this.get();
		this.event();
		this.over();
	}
	// 获取远程标签数据
	get(){
		if (!this.option.url) {
			this.canInput = 1;
			return;
		}
		this.dropEl = this.el.drop({
			show: 0,
			html: `
				<div class="ly-tagBox width450">
					<div class="ly-tagBox-ul"></div>
					<div class=""></div>
				</div>
			`,
		});
		$.async('GET', this.option.url.list, {_limit_:9999}, result=>{
			if (result.total) {
				for (var v of result.children) this.add2(v);
				this.over();
			}
			this.canInput = 1;
		},'json');
	}
	post(name){
		$.async('POST', this.option.url.post, {Name:name, _incomplete_:1}, result=>{
			if (result.ret==1) {
				this.add2(result.data);
				this.over();
			}
		},'json');
	}
	// 绑定事件
	event(){
		var _this = this;
		this.el.on('keydown', 'input', function(e){
			if (!_this.canInput) return false;
			var a = $(this);
			if (e.key==',' || e.key=='Enter') {
				var n = a.val();
				_this.add(n);
				_this.post(n);
				_this.over();
				_this.setData();
				e.preventDefault();
				e.stopPropagation();
				return false;
			}
		});
		this.el.on('click', '.ly_options_dd_i', function(e){
			_this.del($(this).attr('data-i'));
		});
		this.el.on('click', function(e){
			$(this).drop({mask: 0});
			e.stopPropagation();
		});
	}
	// 添加
	add(name){
		if (!name) return;
		var i = this.tag.length;
		this.tag.push(name);
		this.text_el.before(`<div class="ly_options_dd notcopy" data-i="${i}"><span>${name}</span><i class="ly_options_dd_i lyicon-error" data-i="${i}"></i></div>`);
	}
	// 删除
	del(i){
		this.tag.splice(i, 1);
		this.el.find('[data-i="'+i+'"]').remove();
		this.over();
		this.setData();
	}
	// 添加
	add2(v){
		this.allTag.push(v);
		this.dropEl.find('.ly-tagBox-ul').append(`<div class="ly-tagBox-li notcopy" data-i="${v.Id}"><span class="ly-tagBox-name">${v.Name}</span><i class="ly-tagBox-i lyicon-error" data-id="${v.Id}"></i></div>`);
	}
	// 结束
	over(){
		// 是否提示内容
		var placeholder = $.lang.notes.tag_placeholder;
		if (this.tag.length) {
			this.text_el.removeAttr('placeholder');
		} else {
			this.text_el.attr('placeholder', placeholder);
		}
		// 已选中的标签不可见
		for (var v of this.allTag) {
			var a = this.dropEl.find('[data-i="'+v.Id+'"]');
			if (this.tag.includes(v.Name)) a.addClass('hide2');
			else a.removeClass('hide2');
		}
	}
	// 设置数据
	setData(){
		this.hidden_el.val(this.tag.join(','));
		this.text_el.val('');
	}
};

// 定时任务
$.task.push(()=>{
	_('[lyvue-input-tag]').each(function(){
		var el = $(this);
		var data = {};
		if (el.is('[data-url-list]')) {
			data.url = {
				list: '/manage/?ma=tag/index&l=json',
				post: '/manage/?ma=tag/index&d=post',
				del: '/manage/?ma=tag/index&d=del'
			}
		}
		el.o('a', new lyvue_input_tag(el, data));
	});
});

$('html').click(()=>{$('[lyvue-input-tag]').drop_hide()});
// 下拉框点击
$('html').on('click', '.ly_drop .ly_drop_content', function(e){
	e.stopPropagation();
});