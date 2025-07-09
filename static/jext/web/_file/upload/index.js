var __file_upload_list = {
	// 拖拽排序
	sort: function(el) {
		var name = el.attr('name');
		r = new RegExp('^' + name.replace(/\[/g, '\\[').replace(/\]/g, '\\]') + '\\[[0-9]*\\]', '');
		el.children().each(function(i) {
			var t = $(this);
			t.find('[num]').html(i + 1);
			t.find('input,textarea').each(function() {
				n = $(this).attr('name');
				if (n) {
					n = n.replace(r, name + '\[' + i + '\]');
					$(this).attr('name', n);
				}
			});
		});
	}
};
// 绑定拖拽排序
__file_upload_list.drag = {
	end: function (el) {
		__file_upload_list.sort(el);
	}
};
// 绑定分段上传
__file_upload_list.upload = {
	after: function (el, files) {
		for (var i in files) {
			var v = files[i],
				li = el.find('[path="' + i + '"]');
			if (li.size()) {
				li.find('[jd]').html(v.progress + '%');
				if (v.data && v.data.ret==1) {
					li.find('[name$="[path]"]').val(v.data.msg.Path);
				}
			} else {
				var pic = $(
					'<li class="m-pic relative" path="' + i + '">'+
						'<img file-ext="' + v.src + '" />'+
						'<div absolute max m-pic><span inline-block v-bottom jd>' + v.progress + '%</span></div>'+
						'<input type="hidden" name="' + el.attr('name') + '[0][path]" value="" />' +
					'</li>'
				);
				el.find('ul').append(pic);
			}
		}
		__file_upload_list.sort(el.find('ul'));
	}
};

$.task.push(function () {
	_('[file-upload]').each(function () {
		var el = $(this);
		if (el.is('div')) {
			el.addClass('JextFileUploadDiv clean').append(
				'<ul dragsort fn="__file_upload_list.drag" name="' + el.attr('name') + '"></ul>'+
				'<label add m-pic ' +
					' file-upload="' + el.attr('file-upload') + '" ' +
					' name="' + el.attr('name') + '" ' +
					' fn="__file_upload_list.upload" ' +
					' count="' + (el.attr('count')||10000) + '" ' +
				'>' +
					'<i class="inline-block v-middle"></i>'+ 
				'</label>'
			);
		}
		else if (!el.find('input[type=file]').size()) {
			el.append('<input type="file" class="hide" accept="'+el.attr('accept')+'" />');
		}
	})
	.find('input[type=file]').attr({multiple:''}).change(function(a, b, c) {
		var el = $(this);
		var form_el = el.parents('form');
		var parent_el = el.parents('[file-upload]');
		var fn = $.callbackfn(parent_el.attr('fn'), 'before,after,end');
		$.upload({
			files: el[0].files,
			url: $.path + 'web/file/upload/inc/save.php',
			type: parent_el.attr('file-upload'),
			form_el: form_el.size()?form_el[0]:'',
			start(option){
				$.eval(fn.before, el, option.files);
			},
			progress(option){
				$.eval(fn.after, el, option.files);
			},
			end(option){
				$.eval(fn.end, el, option.files);
			},
		})
	});
});




/*
	ui: function() {
		var thi = this;
		thi.POP = WP.$.alert({
			str: 
				'<div JEXTFILEUPLOAD absolute max>' +
					'<div uitit>' + $.lang.upload.title + '</div>' +
					'<ul absolute max uibox mcscroll><div list clean></div></ul>' +
				'</div>'
			,
			type: 'over',
			wh:[650, 480],
			init: function(a) {
				a.bd.find('[uibox] [list]').append(
					'<label file="add" relative fl file-upload ismyself fn="$.__file_upload.uifunc();">' +
						'<div absolute max m-pic>' +
							'<i inline-block v-middle></i>' +
						'</div>' +
					'</label>'
				);
			}
		});
	},
	uifunc: function(file) {
		var thi = this;
		var a = thi.POP.bd.find('[uibox] [list]');
		for (var i in file) {
			var v = file[i];
			var l = a.find('[file="' + i + '"]');
			if (l.size()) {
                if (v.data && v.data.ret == 0) {
                    l.find('[jd]').html($.lang.invalid);
                } else {
                    l.find('[jd]').html(v.progress + ' %');
                }
			} else {
				a.find('[file="add"]').before(
					'<div file="' + i + '" relative fl over>' +
						'<div absolute max m-pic>' +
							'<img file-ext="' + v.src + '" alt="" />' +
						'</div>' +
						'<div jd absolute max>' + v.progress + ' %</div>' +
					'</div>'
				);
			}
		}
	},
*/

/*
var EventUtil ={
    addHandler: function(element, type, handler){
        if(element.addEventListener){
            element.addEventListener(type, handler, false);
        }else if(element.attachEvent){
            element.attachEvent("on" + type, handler, false);
        }
    },

    removeEventListener: function(element, type, handler){
        if(element.removeEventListener){
            element.removeEventListener(type, handler, false);
        }else if(element.detachEvent){
            element.detachEvent("on" + type, handler, false);
        }
    }
}

EventUtil.addHandler(dragElement, "drop", function(event){
    event.preventDefault();
    event.stopPropagation();

    var files = event.dataTransfer.files[0];

    file.info(files);

});

EventUtil.addHandler(dragElement, "dragenter", function(event){
    event.preventDefault();
    event.stopPropagation();
});

EventUtil.addHandler(dragElement, "dragover", function(event){
    event.preventDefault();
    event.stopPropagation();
});



 */