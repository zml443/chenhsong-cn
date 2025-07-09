
var dbs_json = {
	order_by: function () {
		$('.-jsontable').each(function () {
			var el = $(this),
				dbsitem = el.parents('._dbs_item').eq(0),
				tr = el.find('.-box>*>tr');
			if (parseInt(dbsitem.find('.-add').attr('data-count'))<=dbsitem.find('.-box>*>*').size()) {
				dbsitem.find('.-add').addClass('gray not-allowed');
			} else {
				dbsitem.find('.-add').removeClass('gray not-allowed');
			}
			if (tr.size()==1) {
				tr.find('.-remove').hide();
			} else {
				tr.find('.-remove').show();
			}
			// 获取下标
			tr.each(function (i) {
				var b = $(this).children().eq(0);
					b.find('span').html('组'+(i+1));
				$(this).find('[name]').each(function () {
					var n = $(this).attr('name') || '';
					if (!n) return;
					$(this).attr({name: n.replace(/^([^\[]*)\[[0-9]*\]/, '$1['+i+']')});
				});
			});
		});
	},
	// 显示展开按钮
	show_open_btn: function(){
		$('.-jsontable').each(function(){
			var el = $(this),
				keep = el.find('.keep'),
				tr = el.find('table tr');
			if (tr.size()>1) keep.removeClass('hide2');
			else keep.addClass('hide2');
		});
	},
	show_tr: function(){
		$('.-jsontable tr').removeClass('hide2');
	},
	init_tr: function(){
		$('.-jsontable tr:eq(0)').removeClass('hide2');
	}
};

// 添加
$(document).on('click', '.-jsontable .-add', function () {
	var a = $(this);
	var n = parseInt(a.attr('data-count'));
	var p = a.parents('._dbs_item').eq(0);
	var tbody = p.find('.-box>*');
	var cp = p.find('.-copy');
	var size = tbody.children().size();
	if (n && n<=size) {
		return ;
	}
	var tr = $('<tr><td class="w_1"><span>组1</span></td><td>'+cp.html().replace(/\\\/script>/g,'/script>')+'</td><td class="-remove w_1 pointer"><i class="lyicon-ashbin" color="red"></i></td></tr>');
	tr.find('[exec]').removeAttr('exec');
	tr.find('[name]').each(function(){
		$(this).attr('name', ($(this).attr('name')||'').replace(/____/,''));
	});
	tr.find('.-remove').show();
	tbody.append(tr);
	// 下标整理
	dbs_json.order_by();
	dbs_json.show_tr();
	// 整理一下布局情况
	// _dbs_layout.init();
});
// 删除
$(document).on('click', '.-jsontable .-remove', function (e) {
	var a = $(this),
		p = a.parents('._dbs_item').eq(0),
		tbody = p.find('.-box>*'),
		tr = a.parents('tr:eq(0)');
	WP.$.alert({
		str: $.lang.notes.del_tip.replace('{{qty}}', 1),
		style: 'B',
		xy: $.xy(e, function(x, y) {return [x-180, y-100]}),
		cancel: 1,
		confirm: function () {
			tr.remove();
			dbs_json.init_tr();
			dbs_json.order_by();
		}
	});
	e.stopPropagation();
	return false;
});

// 展开
$(document).on('click', '.-jsontable .-keep', function(){
	var el = $(this),
		dbsitem = el.parents('._dbs_item').eq(0),
		tr = dbsitem.find('.-box tr'),
		cur = tr.is('.cur');
	tr.each(function(i){
		if (i) $(this).toggleClass('hide2');
	});
	el.find('span').toggleClass('hide2');
	el.toggleClass('cur');
});

$(document).ready(function () {
	dbs_json.show_open_btn();
	dbs_json.order_by();
});