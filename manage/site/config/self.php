<?php include c('dbs.edit').'/default.php'; ?>
<script>
	$(document).ready(function(){
		var close_el = $('[name="close"]').prev(),
			close_detail_el = $('[name="close_detail"]'),
			close_detail_dbsitem = close_detail_el.parents('._dbs_item:eq(0)');
		function show_or_hide(){
			if (close_el.is(':checked')) {
				close_detail_dbsitem.removeClass('relative goaway');
			} else {
				close_detail_dbsitem.addClass('relative goaway');
			}
		}
		show_or_hide();
		close_el.on('click', function(){
			show_or_hide();
		});
	});
</script>