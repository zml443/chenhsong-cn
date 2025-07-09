$(document).ready(()=>{
	serviceBox.init();
});
// 
var serviceBox = {
	units: [
		{
			type: 'feedback',
			name: '在线留言',
		},
		{
			type: 'wechat',
			name: '微信',
		},
		{
			type: 'qq',
			name: 'QQ',
		},
		{
			type: 'sina',
			name: '微博',
		},
		{
			type: 'tel',
			name: '电话',
		},
		{
			type: 'mobile',
			name: '手机',
		},
		{
			type: 'xhs',
			name: '小红书',
		},
		{
			type: 'dy',
			name: '抖音',
		},
		{
			type: 'email',
			name: '邮箱',
		},
		{
			type: 'questionnaire',
			name: '调查问卷',
		},
		{
			type: 'facebook',
			name: 'Facebook',
		},
		{
			type: 'instagram',
			name: 'Instagram',
		},
		{
			type: 'twitter',
			name: 'Twitter',
		},
		{
			type: 'LinkedIn',
			name: 'LinkedIn',
		},
		{
			type: 'YouTube',
			name: 'YouTube',
		},
	],
	// 
	svgType: '01',
	data: [],
	// 初始化
	init(){
		this.$el = {
			list: $('#xxxList'),
			add: $('#xxxAdd'),
			json: $('#xxxJson'),
			preview: $('#preview'),
			style: $('#xxxStyle')
		};
		this.lang = this.$el.add.attr('data-lang');
		// 创建列表布局
		// this.lihtml();
		var data = this.$el.json.json();
		for(var i in data){
			this.add(data[i])
		}
		this.preview();
	},
	// 预览
	preview_style:[],
	preview(){
		var sty = this.$el.style.attr('data-type');
		var x = 0;
		if (this.preview_style.indexOf(sty)<0) {
			this.preview_style.push(sty);
		} else {
			var x = 1;
		}
		$.async('POST', '?ma=service/index/preview&d=post&n=01', {}, result=>{
			if (x) {
				result = result.replace(/<script/g,'<script class="hide" type="text"');
			}
			this.$el.preview.html(result)
		});
	},
	// 设置定位
	setPosition(el){
		el = $(el);
		var v = parseInt(el.val());
		$.async('POST', '?ma=service/index/_change_type', {position:v}, result=>{
			if ([1,4,7].indexOf(v)>=0) {
				$('body').addClass('OnTheLeft').removeClass('OnTheRight');
			} else {
				$('body').removeClass('OnTheLeft').addClass('OnTheRight');
			}
			this.preview();
		});
	},
	// 设置类型
	setStyle(el){
		el = $(el);
		var v = el.val();
		$.async('POST', '?ma=service/index/_change_type', {type:v}, result=>{
			this.$el.style.attr('data-type', v);
			this.preview();
		});
	},
	// 提交
	post(data, fn){
		var id = parseInt(data.Id);
		$.async('POST', '?ma=service/index&d=post', data, result=>{
			if (result.ret==1) {
				data = {...data, ...result.data};
				if (id) this.dom(data);
				else this.add(data);
			}
			if (fn) fn(result);
			this.preview();
		}, 'json');
	},
	// 事件
	IsOpen(el){
		el = $(el);
		var Id = el.attr('data-id');
		setTimeout(()=>{
			$.async('POST', '?ma=service/index&d=post', {IsOpen:el.is(':checked')?1:0, Id:Id}, result=>{
				// 
			}, 'json');
		},100);
	},
	IsDel(el){
		el = $(el);
		var _this = this;
		var Id = el.attr('data-id');
		WP.$.alert({
			str: $.lang.notes.del_tip.replace('{{qty}}', 1),
			style: 'B',
			confirm(){
				$.async("POST", "?ma=service/index&d=del", {Id:Id}, result=>{
					_this.preview();
				},'json');
				el.parents('.zhj_zxkf_li').remove();
			}
		});
	},
	IsEdit(el){
		el = $(el);
		var Id = el.attr('data-id');
		var lo = WP.$.alert('loading...');
		$.async('GET', '?ma=service/index&e=json', {Id:Id}, result=>{
			lo.popup_remove(()=>{
				if (result.ret==1) {
					this.edit(result.data);
				}
			});
			this.preview();
		}, 'json');
	},
	IsCopy(el){
		el = $(el);
		var _this = this;
		var Id = el.attr('data-id');
		WP.$.alert({
			str: $.lang.notes.copy_tip,
			style: 'B',
			confirm(alert_el){
				var lo = WP.$.alert('loading...');
				var href = '?ma=service/index&d=copy';
				$.async('POST', href, {Id:Id}, result=>{
					lo.popup_remove(function(){
						if (result.ret==1) {
							location.reload();
						}
					});
					_this.preview();
				}, 'json');
			}
		});
	},
	// 图标链接
	svg(t){
		return `/static/images/side_fload/${this.svgType}/${t}.svg`
	},
	// 添加
	add(v){
		if (typeof(v.Picture)=='string') v.Picture = $.json(v.Picture);
		var h = `
			<div class="zhj_zxkf_li flex-middle2" data-id="${v.Id}">
				<div class="decoration lyicon-drag"></div>
				<div class="icon m-pic"><img src="${this.svg(v.Type)}" onload="SVGInject(this)"></div>
				<div class="text flex-1">${v.Name}</div>

				<div class="select flex-middle2">
					<div><label class='ly_switchery'><input type="checkbox" name='' value='1' ${parseInt(v.IsOpen)?'checked':''} onclick="serviceBox.IsOpen(this)" data-id="${v.Id}" /></label></div>
					<div class="open">关闭</div>
					<div class="close">开启</div>
				</div>

				<a class="edit lyicon-shichangtiaocha-" onclick="serviceBox.IsEdit(this)" data-id="${v.Id}"></a>
				<a class="add lyicon-copy" onclick="serviceBox.IsCopy(this)" data-id="${v.Id}"></a>
				<a class="delete lyicon-ashbin" onclick="serviceBox.IsDel(this)" data-id="${v.Id}"></a>
			</div>
		`;
		this.data.push(v);
		this.$el.list.append(h);
	},
	dom(v){
		var el = $('.zhj_zxkf_li[data-id="'+v.Id+'"]');
		el.find('.text').html(v.Name);
	},
	// 
	edit(row){
		if (!row) {
			row = {};
			var is_add = 1;
		} else {
			var is_edit = 1;
		}
		var _this = this;
		WP.$.alert({
			zIndex: 90,
			str: `
				<form class="zhj_zxkf_editPop">
					
					<div class="fz16">名称</div>
					<label class="ly_input mt_10px"><textarea name="Name" placeholder="名称" autoheight>${row.Name||''}</textarea></label>

					<div class="fz16 mt_30px mb_10px">选择类型</div>
					<div class="flex-wrap gap_10px b-bottom pb_30px">
						${this.units.map(
							v => `
								<label class="zhj_zxkf_unit flex-max2 flex-column  ${is_edit&&v.type!=row.Type?'hide2':''}">
									<input class="hide" type="radio" name="Type" value="${v.type}" ${v.type==row.Type?'checked':''} />
									<div class="icon m-pic"><img src="${this.svg(v.type)}" onload="SVGInject(this)"></div>
									<div class="name">${v.name}</div>
								</label>
							`
						).join('')}
					</div>

					<div class="TC hide2 mt_20px">
						<div class="flex-middle2">
							<div class="fz16">使用系统窗口</div>
						</div>
						<div class="mt_10px"><label class='ly_switchery'><input type="checkbox" name='IsPopup' value='1' ${parseInt(row.IsPopup)?'checked':''} /></label></div>
					</div>

					<div class="NNB hide2 mt_20px">
						<div class="flex-middle2">
							<div class="NumberName fz16">号码/账号/链接</div>
							<div class="fz20 ml_10px lyicon-help-filling" color="main"></div>
						</div>
						<label class="ly_input mt_10px"><textarea name="Number" autoheight>${row.Number||''}</textarea></label>
					</div>
					
					<div class="PB hide2 mt_20px">
						<div class="fz16">添加二维码</div>
						<div class="flex-middle2 mt_10px">
							<label class='ly_file ${row.Picture?'cur':''}' file-selector='manage' fn='WP.lyma_upload_img'>
								<img class="img" file-ext='${row.Picture}' />
								<i class="add"></i>
								<input type='hidden' name='Picture' value='${row.Picture}'>
							</label>
							<div class="text ml_20px fz14" color="text3">请上传1:1尺寸</br>jpg / GIF / PNG图片</div>
						</div>
					</div>

					<input type="hidden" name="Id" value="${row.Id||0}" />
					<input type="hidden" name="Language" value="${this.lang||''}" />
					
					<div class="zhj_zxkf_editFoot flex-middle2 flex-right mt_20px b-top pt_20px">
						<a class="btn cancel flex-max2 el-popup-close">取消</a>
						<a class="btn fulfil flex-max2">完成</a>
					</div>
				</form>
			`,
			init(aEl){
				var $NNB = aEl.find('.NNB');
				var $NumberName = aEl.find('.NumberName');
				var $Name = aEl.find('[name="Name"]');
				var $PB = aEl.find('.PB');
				var $TC = aEl.find('.TC');
				// 提交
				aEl.on('click', '.fulfil', function(){
					_this.post(aEl.find('form').json(), result=>{
						if (result.ret==1) aEl.popup_remove();
					});
				});
				// 选择类型
				aEl.on('click', '.zhj_zxkf_unit input', function(){
					show_type($(this));
				});
				// 互动
				var show_type = (inp, init)=>{
					var t = inp.val();
					var x = 1;
					var y = 0;
					var z = 0;
					var xName = '链接';
					if (['wechat', 'email', 'qq'].includes(t)) {
						xName = '账号';
					}
					if (['tel', 'mobile'].includes(t)) {
						xName = '号码';
					}
					if (['dy'].includes(t)) {
						x = 0;
					}
					if (['wechat', 'dy'].includes(t)) {
						y = 1;
					}
					if (['feedback'].includes(t)) {
						z = 1;
					}
					if (x) $NNB.removeClass('hide2');
					else $NNB.addClass('hide2');
					if (y) $PB.removeClass('hide2');
					else $PB.addClass('hide2');
					if (z) $TC.removeClass('hide2');
					else $TC.addClass('hide2');
					$NumberName.html(xName);
					if (!init) $Name.val(inp.siblings('.name').text());
				};
				show_type(aEl.find('.zhj_zxkf_unit input:checked').eq(0), 1);
				// 
			}
		});
		// 
	},
	// 
	changeType(){
		var style = this.$el.style.attr('data-type');
		WP.$.alert({
			title: '风格选择',
			// wh: [700,0],
			str: `
				<form class="flex-wrap" style="gap:20px">
					${['01','02','03','04','05','06'].map(
						v => `
							<label class="flex-middle2 flex-column flex-1">
								<i class="ly_radio"></i>
								<input class="radio hide" type="radio" name="radio" value="${v}" ${v==style?'checked':''} onclick="" />
								<div class="view"><img width="90px" src="/static/images/side_fload/view/${v}.jpg" /></div>
							</label>
						`
					).join('')}
				</form>
			`,
			init(aEl){
				aEl.on('click','.radio', function(){
					serviceBox.setStyle(this);
					aEl.popup_remove();
				});
			}
		});
	}
}