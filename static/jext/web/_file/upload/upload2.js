function ly_file_upload (option) {
	// 数据整理
	function data(){
		var files = [];
		for (var i in option.files) {
			if (typeof(option.files[i])!='object') {
				continue;
			}
			files.push(option.files[i]);
		}
		if (option.reverse) option.files =  files.reverse();
		for (var i in option.files) {
			src(option.files[i]);
		}
	}
	// 将图片文件设置成预览状态
	function src(v){
		v.move = 0;
		v.progress = 0;
		if (v.name.search(/\.(png|jpe?g|svg|ico|webp)$/i) > -1) {
			var x = new FileReader();
			x.readAsDataURL(v);
			x.onloadend = function(e) {
				option.qty++;
				v.src = this.result;
			}
		} else {
			option.qty++;
			v.src = v.name;
		}
	}
	function upload(i){
		if (!option.files[i]) {
			if (option.progress) option.progress(option);
			if (option.end) option.end(option);
			return false;
		} else if (option.files[i].progress>=100) {
			upload(i+1);
			return false;
		}
		var s = option.files[i].move;
		var e = s + option.size;
		if (e>option.files[i].size) e = option.files[i].size;
		var form = new FormData();
		form.append('--file', option.files[i].slice(s, e));
		form.append('--size', option.files[i].size);
		form.append('--name', option.files[i].name);
		form.append('--move', e);
		form.append('--type', option.type);
		for (var k in option.form) {
			form.append(k, option.form[k]);
		}
		option.files[i].move = e;
		option.files[i].progress = parseFloat(((e / option.files[i].size) * 100).toFixed(2));
		request(form, i);
	}
	// 上传
	function request(form, i){
		var t;
		var xhr = new XMLHttpRequest();
		xhr.open('POST', option.url, true);
		xhr.onreadystatechange = function(){
			clearTimeout(t);
			t = setTimeout(function(){
				if (xhr.readyState==4 && xhr.status==200) {
					result = JSON.parse(xhr.responseText);
					if (result.ret==-1) {
						option.files[i].move -= option.size;
					} else {
						if (result.ret==0) option.files[i].progress = 100;
						option.files[i].data = result;
						option.files[i].result = result;
						if (option.progress) option.progress(option);
					}
					upload(i);
				} else {
					request(form, i);
				}
			}, 100);
		};
		xhr.send(form);
	}
	// 开始执行
	option = {
		reverse: 1,
		qty: 0,
		size: 1 * 1024 * 1024,
		form:{},
		...option
	};
	// 不支持文件处理
	if (typeof(FileReader)=='undefined') {
		if (option.error) option.error(this);
		return this;
	}
	// 整理数据
	data();
	// 上传文件
	var start = setInterval(()=>{
		if (option.qty==option.files.length) {
			var go = 1;
			if (option.start) {
				go = option.start(option);
				if (typeof(go)=='undefined') go = 1;
			}
			clearInterval(start);
			if (go) upload(0);
		}
	}, 300);
}