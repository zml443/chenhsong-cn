var lyma_upload_img = {
    change(el, files){
    	for (var v of files) {
			el.addClass('cur').find('.img').attr('file-ext', v.path);
			el.find('input').val(v.path);
    		break;
    	}
    },
}
