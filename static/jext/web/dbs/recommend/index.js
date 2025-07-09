WP.$.include(WP.$.path + 'web/dbs/recommend/index.css');
var _lydbs_recommend = {
	svg: {
		delete: '<svg class="svg" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" height="18"><path d="M202.666667 256h-42.666667a32 32 0 0 1 0-64h704a32 32 0 0 1 0 64H266.666667v565.333333a53.333333 53.333333 0 0 0 53.333333 53.333334h384a53.333333 53.333333 0 0 0 53.333333-53.333334V352a32 32 0 0 1 64 0v469.333333c0 64.8-52.533333 117.333333-117.333333 117.333334H320c-64.8 0-117.333333-52.533333-117.333333-117.333334V256z m224-106.666667a32 32 0 0 1 0-64h170.666666a32 32 0 0 1 0 64H426.666667z m-32 288a32 32 0 0 1 64 0v256a32 32 0 0 1-64 0V437.333333z m170.666666 0a32 32 0 0 1 64 0v256a32 32 0 0 1-64 0V437.333333z"></path></svg>',
	},
	// 初始化
	init(obj) {
		this.obj = obj
		this.href = obj.attr('data-href')
		this.id = obj.find('input').val()||''
		this.number = parseInt(obj.attr('data-number'))||0
		this.length = this.id.split(',').length
		this.iframe = ''
		this.ui()
	},
	// ui 界面
	ui() {
		var thi = this;
		WP.$.alert({
			str: `
				<div id="_dbs_recommend_selector" class="absolute max maxh flex">
					<div class="left">
						<div class="category">--- 已经选择的相关数据 ---</div>
						<ul class="ul"></ul>
					</div>
					<div class="right"><iframe src="${this.href}" frameborder="0" height="100%" width="100%"></iframe></div>
				</div>
			`,
			wh: [1100, 700],
			type: 'border',
			title: '相关数据选择',
			init(alert_el) {
				thi.ul = alert_el.find('#_dbs_recommend_selector .left .ul');
				thi.get();
				// 删除
				alert_el.on('click', '.left [data-close]', function() {
					var li = $(this).parents('.li')
					var id = li.attr('data-i')
					li.remove()
					thi.set()
				});
				thi.iframe = alert_el.find('.right iframe')
				thi.iframe.iframe('task', function() {
					var body = $(this).contents().find('body');
					body.find('.-tr').each(function(){
						var tr = $(this),
							id = tr.find('[data-id]').val()||0;
						if (thi.id && thi.id.search(new RegExp('^'+id+',|,'+id+',|,'+id+'$|^'+id+'$'))>=0) {
							tr.addClass('cur');
						}
					}).click(function() {
						thi.insert(thi.get_data($(this)))
					});
				});
			},
			cancel: 1,
			confirm(alert_el) {
				var fn = $.callbackfn(thi.obj.attr('fn'),'change')
				thi.id = thi.id.replace(/^,|,$/g, '');
				thi.obj.find('input').val(thi.id);
				$.eval(fn.change, thi.obj, thi.id);
			}
		});
	},
	// 获取
	get_data(el) {
		return {
			id: el.find('[name="Id"]').val()||0,
			name: el.find('[data-key="Name"]').text()||el.find('[data-key="UserName"]').text()||el.find('[data-key="Email"]').text()||el.find('[data-key="Phone"]').text()||el.find('[data-key="FirstName"]').text()+' '+el.find('[data-key="LastName"]').text()||'',
			picture: el.find('img').attr('src')||el.find('[name="Face"] img').attr('src')||'',
			brief: el.find('[data-key="Brief"]').text()||el.find('[data-key="BriefDescription"]').text()||''
		};
	},
	get() {
		$.async('POST', this.href+'&xxxxxxxxx=1', {_sel_ids:this.id}, result=>{
			result = $.htmlbody(result);
			result.find('.-tr').each((i, el)=>{
				this.insert(this.get_data($(el)));
			})
		})
	},
	/**
	 * 获取已选数据的信息
	 * @return {JSON} dat 选中后返回的数据
	 */
	insert(option) {
		var li = `
			<li class="li ${option.picture?'ispic':''}" data-i="${option.id}">
				${option.picture && `
					<div class="img m-pic" data-picture><img src="${option.picture}" /></div>
				`}
				<div class="name" data-name>${option.name}</div>
				${option.brief && `
					<div class="brief" data-brief><img src="${option.brief}" /></div>
				`}
				<div class="close flex-max2" data-close>${this.svg.delete}</div>
			</li>
		`
		if (this.length>=this.number) {
			this.ul.find('.li').each((i,e)=>{
				if (i>=this.number-1) $(e).remove()
			})
		}
		if (!this.ul.find('.li[data-i="'+option.id+'"]').size()) this.ul.append(li)
		this.set()
	},
	// 设置id
	set() {;
		this.iframe.contents().find('.-tr').removeClass('cur')
		this.id = [];
		this.ul.find('.li').each((i,e)=>{
			let id = $(e).attr('data-i')
			this.id.push(id);
			this.iframe.contents().find('[data-id][value="'+id+'"]').parents('.-tr').addClass('cur')
		});
		this.length = this.id.length
		this.id = this.id.join(',')
	}
};


// 点击选择
$(document).on('click', '[lydbs-recommend]', function(event){
	_lydbs_recommend.init($(this));
});
