WP.dbs_upload_img = {
    change(el, files){
    	for (var v of files) {
			el.addClass('cur').find('.img').attr('file-ext', v.path);
			el.find('input').val(v.path);
    		break;
    	}
    },
}


$(document).on('click',"[fn='WP.dbs_upload_img'] .close", function(event){
    let el = $(this)
    let parent = el.parents("[fn='WP.dbs_upload_img']").eq(0)
    parent.removeClass('cur');
    parent.find('input').val('');
    event.stopPropagation()
    event.preventDefault()
});