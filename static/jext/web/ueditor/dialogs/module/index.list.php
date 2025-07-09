<script>
	$.include($.path+'php/class/dbs/__/js/dbs.js');
	$.include($.path+'php/class/dbs/__/js/layout.js');
	$.include($.path+'php/class/dbs/__/js/mLanguage.js');
	$.include($.path+'php/class/dbs/__/js/nav/nav.js');
	$.include($.path+'php/class/dbs/__/js/seo.js');
</script>

<style>
	html{background: var(--bg);}
	.ueditor-use{opacity:0; padding:9px 20px; background:#41a6ec; color:#fff; border-radius:3px;}
	tr:hover .ueditor-use{opacity:1;}
	.-wrap{background: #fff;padding: 30px;}
</style>

<div class="-wrap">
	<div class='-liHead' position-follow="{}">
		<div clean>
			<div class='tool fl'>
				<?php if ($this->permit['add']) { ?>
					<a class='a add m-pic' dbs='add' hr-ef='<?=$this->query_string['edit']?>'><span>+</span><span>{/global.add/}</span></a>
				<?php } ?>
				<?php if ($this->permit['del']) { ?>
					<a class='a del m-pic' dbs='del'><?=img::svg("/static/images/ico/del.svg");?><span>{/global.del_bat/}</span></a>
				<?php } ?>
			</div>
			<div class='fr'><?=$this->ctl['search'];?></div>
		</div>
	</div>
	<!--  -->
	<table class="-list">
		<thead>
			<tr>
				<td class="-td" d="_id"><?=$this->th('_Id')?></td>
				<td class="-td" d="name">名称</td>
				<td style="width:.1%" nowrap></td>
				<td class="-td" d="_ope">操作</td>
			</tr>
		</thead>
		<tbody>
		<?php
		$row = db::get_all('jext_ueditor_mdl', "1", "*", db::get_order_by());
		foreach ($row as $k => $v) {
		?>
			<tr>
				<td class="-td" d="_id"><?=$this->li('_Id', $v)?></td>
				<td class="-td" d="name"><?=$this->li('Name', $v)?></td>
				<td style="width:.1%;padding-right:30px;" nowrap><div class="pointer ueditor-use trans">使用</div></td>
				<td class="-td" d="_ope"><?=$this->li('_Ope', $v)?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>

<script>
	$(document).on('click', '.ueditor-use', function () {
		WP.$.__ueditor_module.use($(this).parents('tr:eq(0)').find('[name="Id"]').val());
	});
</script>