/*<style>
    .jext-cursor-move{width: 80px;height: 80px;border: 2px solid red; border-radius: 50%;top: -40px;left: -40px;z-index: 300;}
    .jext-cursor-move[type='play']{background: cyan;}
    .jext-cursor-move[type='close']{background: chartreuse;}
</style>*/
// $('[jextstyle]').append('.jext-cursor-move{opacity:0;transition:all .2s linear;pointer-events:none;}');
$('[jextstyle]').append('.jext-cursor-move{opacity:0;pointer-events:none;}');

if (typeof($.__cursor_move)=='undefined') $.__cursor_move = {
    init:function () {
        var thi = this;
        thi.obj = $('.jext-cursor-move');
        if (!thi.obj.size()) {
            thi.obj = $('<div class="jext-cursor-move fixed"></div>');
            $('body').append(thi.obj);
        }
    },
    move:function (e,a) {
        var thi = this;
        var x = e.clientX;
        var y =  e.clientY;
        thi.obj.css({transform: "translate3d("+x+"px,"+y+"px,0)"});
        if (!thi.obj.is('.load')) {
           thi.obj.addClass('load');
            setTimeout(function () {
                thi.obj.addClass('init').css({opacity:1});
            }, 300);
        } else if (thi.obj.is('.init')) {
           thi.obj.css({opacity:1});
        }
    },
    leave : function (e) {
        var thi = this;
        thi.isIn = 0;
        setTimeout(function () {
            if (!thi.isIn) thi.obj.css({opacity:0});
        });
    },
    enter : function (a) {
        var thi = this;
        thi.init();
        thi.isIn = 1;
        thi.obj.attr('type', a.attr('cursor-move'));
    }
};

$(document).on({
    mousemove: function (e) {
        $.__cursor_move.move(e);
    },
    mouseover: function (e) {
        $.__cursor_move.enter($(this));
    },
    mouseleave: function (e) {
        $.__cursor_move.leave(e);
    }
}, '[cursor-move]');