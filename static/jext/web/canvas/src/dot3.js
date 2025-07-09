$('[jextstyle]').append("[canvas-src^='dot3,']{background-color: #222;}");

$.task.push(function () {
    _('[canvas-src^="dot3,"]').each(function () {
        var thi = $(this);
        thi.append('<canvas width="1920" height="572"></canvas>');

    var c = thi.find('canvas')[0];
    var cxt = c.getContext('2d');
    var w = c.width = thi.width();
    var h = c.height = thi.height();
    var _w = w * 0.5;
    var _h = h * 0.5;
    var arr = [];
    var cnt = 0;

    window.addEventListener('load', resize);
    window.addEventListener('resize', resize, false);

    function resize() {
      c.width = w = thi.width();
      c.height = h = thi.height();
      c.style.position = 'absolute';
      c.style.left = (thi.width() - w) *
        .01 + 'px';
      c.style.top = (thi.height() - h) *
        .01 + 'px';
    }

    function anim() {
      cnt++;
      if (cnt % 6) draw();
      window.requestAnimationFrame(anim);
    }
    anim();

    function draw() {

      var splot = {
        x: rng(_w - 900, _w + 900),
        y: rng(_h - 900, _h + 900),
        r: rng(20, 80),
        spX: rng(-1, 1),
        spY: rng(-1, 1)
      };

      arr.push(splot);
      while (arr.length > 100) {
        arr.shift();
      }
      cxt.clearRect(0, 0, w, h);

      for (var i = 0; i < arr.length; i++) {

        splot = arr[i];;
        cxt.fillStyle = rndCol();
        cxt.beginPath();
        cxt.arc(splot.x, splot.y, splot.r, 0, Math.PI * 2, true);
        cxt.shadowBlur = 80;
        cxt.shadowOffsetX = 2;
        cxt.shadowOffsetY = 2;
        cxt.shadowColor = rndCol();
        cxt.globalCompositeOperation = 'lighter';
        cxt.fill();

        splot.x = splot.x + splot.spX;
        splot.y = splot.y + splot.spY;
        splot.r = splot.r * 0.96;
      }
    }

    function rndCol() {
      var r = Math.floor(Math.random() * 180);
      var g = Math.floor(Math.random() * 60);
      var b = Math.floor(Math.random() * 100);
      return "rgb(" + r + "," + g + "," + b + ")";
    }

    function rng(min, max) {
      return Math.floor(Math.random() * (max - min + 1)) + min;
    }
});
});