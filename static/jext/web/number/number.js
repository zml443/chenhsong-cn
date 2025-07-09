$.task.push(function() {
	// 数字叠加
	// <div data-number='0,1000,3s,1'></div>
	_('[data-number*=","]:not(input),[number*=","]:not(input)').each(function(){
		var e = $(this);
		e.html(NUMBERRUN.F(NUMBERRUN.S(e)));
		e.attr({visible:'NUMBERRUN.V(this)'});
	});
});

NUMBERRUN = {
	G: 51,
	// 计算
	V: function(e) {
		var thi = this;
		var a = thi.S(e);
		var b = Math.abs(a[0]-a[1]) / a[2] * thi.G;
		var c = setInterval(function() {
			if(a[5]>a[1]){
				a[5]-=b;
				a[5]=a[5]<=a[1]?a[1]:a[5];
			}else{
				a[5]+=b;
				a[5]=a[5]>=a[1]?a[1]:a[5];
			}
			a[0] = a[5];
			e.html(thi.F(a));
			if(a[0]==a[1]) clearInterval(c);
		}, thi.G);
	},
	// 拆分
	S: function(e) {
		var a = (e.attr('data-number') || e.attr('number')).split(',');
		return [parseFloat(a[0])||0, parseFloat(a[1])||0, parseFloat(a[2])*1000, parseInt(a[3])||0, a[1].length, parseFloat(a[0]), e.is('[comma]')];
	},
	// 数字处理
	F: function(a) {
		var num = parseInt(a[0]).toString();
		if (a[6]) return this.T(num);
		if (!a[3]) return num;
		var u = '';
		for(var i=0; i<a[4]-num.length; i++) u+='0';
		return u + num;
	},
	// 数字加逗号   比如  1,200,000
	T: function(num) {
		return parseFloat(num).toLocaleString();
	}
};