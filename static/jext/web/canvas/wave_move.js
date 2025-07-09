function WAVEMOVE (o) {
	var args = o.attr('args')||'';
	var color = o.attr('color')||'';
	var opacity = o.attr('opacity')||'';
	var time = o.attr('time')||'';
	if (args) {
		args = args.split(',');
	} else {
		args = ['900','300','200'];
	}
	if (color) {
		color = color.split(',');
	} else {
		color = ['#fff','#fff','#fff'];
	}
	if (opacity) {
		opacity = opacity.split(',');
	} else {
		opacity = ['.05','.05','.05'];
	}
	if (time) {
		time = time.split(',');
	} else {
		time = ['18','12','8'];
	}
	var i = {
		init: function() {
			var n = color,
				i = "100%",
				f = parseInt(args[0]),
				h = parseInt(args[1]),
				m = parseInt(args[2]),
				e = .5,
				t = 1,
				g = .5,
				r = .8 * -f,
				v = 0,
				y = [0, 0, 0],
				b = ["", "", ""],
				s = o.find('path')[0],
				l = o.find('path')[1],
				u = o.find('path')[2];
			d();
			var c = window.onresize;

			function d(e) {
				var t = o.width();
				var rand = (''+Math.random()).replace('.','');
				o.attr('wave_xzsd',rand).find('svg').css({top:-h/2});
				v = Math.ceil(t / f / 2) + 3, !0 !== e && (s.setAttribute("fill", n[0]), l.setAttribute("fill", n[1]), u.setAttribute("fill", n[2]));
				$('[jextstyle]').append(
					'[wave_xzsd="'+rand+'"]{overflow:hidden;}' +
					'[wave_xzsd="'+rand+'"] svg{position:relative;height:400%; width:'+f+'00px;}' +
					'[wave_xzsd="'+rand+'"] svg.s1{animation:waveMove1'+rand+' '+time[0]+'s linear infinite;opacity:'+opacity[0]+'}' +
					'[wave_xzsd="'+rand+'"] svg.s2{animation:waveMove2'+rand+' '+time[1]+'s linear infinite;opacity:'+opacity[1]+';margin-top:-400%;}' +
					'[wave_xzsd="'+rand+'"] svg.s3{animation:waveMove3'+rand+' '+time[2]+'s linear infinite;opacity:'+opacity[2]+';margin-top:-800%;}' +
					'@keyframes waveMove1'+rand+' {' +
						'from {transform: translate3d(-'+(f/6)+'px, 20px, 0px);}' +
						'to {transform: translate3d(-'+(f*2+f/6)+'px, 20px, 0px);}' +
					'}' +
					'@keyframes waveMove2'+rand+' {' +
						'from {transform: translate3d(-'+(f/3)+'px, 10px, 0px);}' +
						'to {transform: translate3d(-'+(f*2+f/3)+'px, 10px, 0px);}' +
					'}' +
					'@keyframes waveMove3'+rand+' {' +
						'from {transform: translate3d(-0, 0px, 0px);}' +
						'to {transform: translate3d(-'+f*2+'px, 0px, 0px);}' +
					'}'
				);
			}
			function p(e) {
				y[e] % (2 * f) == 0 && (y[e] = 0);
				var t = [y[e], h].join(",");
				if ("" === b[e]) {
					for (var n = f / 4 * (g + 1), i = -h / 2, r = -h / 2, o = f - n, a = f, s = 0, l = [n, i, o, r, a, s].join(" "), u = [n, i = r = h / 2, o, r, a, s].join(" "), c = "", d = 0; d < v; d++) c = c + "c" + l + "c" + u;
					var p = "l0," + m + " l-" + v * f * 2 + ",0Z";
					b[e] = [c, p].join("")
				}
				return ["M", t, b[e]].join("")
			}
			window.onresize = function() {
				c && c(), d(!0)
			}, requestAnimationFrame(function A() {
				s.setAttribute("d", p(0));
				l.setAttribute("d", p(1));
				u.setAttribute("d", p(2));
				y[0] -= e / 2;
				y[1] -= (e + t) / 2;
				y[2] -= (e + 2 * t) / 2;
			})
		}
	};
	i.init()
}

$.task.push(function () {
	_('[canvas-wave-move]').each(function(){
		var thi = $(this);
		thi.html(
			'<svg class="s1"><path></path></svg>' +
			'<svg class="s2"><path></path></svg>' +
			'<svg class="s3"><path></path></svg>'
		);
		WAVEMOVE(thi);
	});
});