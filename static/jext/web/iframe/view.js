
$('[jextstyle]').append(
	'[ly-iframe-view], [ly-iframe-view]{overflow:hidden; position:relative;}'
);

$.task.push(function () {
	_('[ly-iframe-view]').each(function() {
		var iv = $(this);
		iv.html('<div class="lyui-iframe-preview" relative><div style="height:0px;"></div></div>');
		$.__iframeview(iv);
	});
});

$.__iframeview = function (iv) {
	var u = iv.attr('ly-iframe-view');
	var box = iv.find('.lyui-iframe-preview');
	var boc = iv.find('.lyui-iframe-preview>*');
	var msk = $('<div mask absolute max style="z-index:3"></div>');
	var ifr = $('<iframe class="lyui-iframe-preview" autoheight name="ifr-v-'+Math.random()+'" '+(iv.is('[manual]')?'href':'src')+'="' + u + (u.search(/\?/)<0?'?':'&') + '&iframe-view=1&notwow=1" width="100%" frameborder="0" scrolling="no"></iframe>');
	var isload = 0;
	boc.append(ifr).append(msk);
	
	var thi = this;
	var w0 = iv.width();
	var w1 = parseInt(iv.attr('width')) || 1920;
	var s = w0 / w1;
	var h0 = parseInt(iv.attr('height')) || iv.height();
	var l = -(w1 / 2) * (1 - s);
	var transform = 'translate3d(' + l + 'px,0,0) scale(' + s + ')';
	boc.css({'-webkit-transform':transform, transform:transform, width:w1});
	var h5 = ifr.contents().find('body').height();
	ifr.css({height: h5});
	msk.css({height: h5});
	box.height(h5*s);
	var ding_shi = setInterval(()=>{
		try{
			var height = ifr.contents().find('body').height()
			ifr.height(height)
			box.height(height*s)
			msk.height(height)
		} catch {
			clearInterval(ding_shi)
		}
	}, 1000)
};