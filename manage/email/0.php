<?php
// 当前用户的权限
if (!p('email.0.edit')) {
    echo language('notes.no_permit');
    return;
}
?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include '__/inc/style_script.php'; ?>
</head>


<body bg="default" class="pb_30px">

	<div class='mt_30px' cw="750">
		<a class="flex-middle2 ly-h5" hr-ef="back()"><i class="lyicon-arrow-left-bold"></i> <?=language('{/global.set/}')?></a>
		<div class='ly-h3 mt_10px mb_20px'><?=language('menu.set.email.module_name')?></div>
	</div>
	
	<div class="_dbs_box" cw="750">
		<div class="_dbs_item flex-between flex-middle2">
			<span class="ly-h4"><?=language('{/panel.from_name/}')?></span>
			<div class="ly_btn_radius pointer she_zhi_you_xiang" size="small" bg="main"><?=language('{/global.set/}')?></div>
		</div>
		<div class="_dbs_item fz14">
			<div class="mb_10px">
				<?=language('{/panel.from_email/}')?>：
				<span class="wb_email_config_FromEmail" color="text3"><?=g('wb_email_config.FromEmail')?></span>
			</div>
			<div class="mb_10px">
				<?=language('{/panel.from_name/}')?>：
				<span class="wb_email_config_FromName" color="text3"><?=g('wb_email_config.FromName')?></span>
			</div>
			<div class="mb_20px">
				<?=language('{/panel.email_service/}')?>：
				<span class="mr_5px" color="text3"><?=language('{/panel.email_qty/}')?></span>
				<span color="text3">(<?=str_replace('{{qty}}', 0, language('panel.email_send_surplus'))?>)</span>
			</div>
			<div class="ly_warning_tip flex-middle2 p_10px">
				<i class="lyicon-prompt-filling mr_5px" color="red"></i>
				<span><?=str_replace('{{qty}}', 0, language('panel.send_email_qty'))?></span>
			</div>
		</div>
	</div>
	<script>
		var change_email_config = {
			name(data){
				$('.wb_email_config_FromEmail').html(data.FromEmail)
				$('.wb_email_config_FromName').html(data.FromName)
			}
		}
		$(document).on('click', '.she_zhi_you_xiang', function(){
			WP.$.alert_side({
				data: `
					<div class="flex-column maxh">
						<div class="maxw ly-h4 mt_45px mb_20px flex-middle2" cw="100%">
							<span>${$.lang.panel.set_email}</span>
							<i class="lyicon-close ly-h3 ml_50px return pointer"></i>
						</div>
						<div class="maxw flex-1 body p_0_20px" style="height:1px;overflow:auto;"></div>
						<div class="alert_side_btn_box maxw" bg="default">
							<div cw="100%">
								<div class="ly_btn_radius width100 mr_25px submit pointer" bg="main" size="small">${$.lang.global.save}</div>
								<div class="ly_btn_radius width100 return pointer" border="default" bg="white" size="small">${$.lang.global.back}</div>
							</div>
						</div>
					</div>
				`,
				css: {right:0, width:500},
				init(el){
					$.async('POST', '?ma=email/config&e=form', {}, result=>{
						var body = $.htmlbody(result, true)
						el.find('.body').html(body)
					})
					el.on('click', '.submit', function(){
						var form = el.find('form')
						var formdata = new FormData(form[0]);
					    $.async('POST', '/manage/?ma=email/config&d=post', {newFormData:formdata}, result=>{
					        // console.log(result);
					        WP.$.alert(result.msg, 2000);
					        change_email_config.name(form.json())
					        if (result.ret==1) {
					        	el.popup_remove()
					        }
					    }, 'json');
					})
					el.on('click', '.return', function(){
						el.popup_remove()
					})
				},
			})
		})
	</script>

	<div class="_dbs_box" cw="750">
		<div class="_dbs_item ly-h4"><?=language('{/panel.email_orders_notice/}')?></div>
		<div class="_dbs_item">
			<?php
				$orders_email = db::query("select * from wb_email_list where Type='orders'");
				while($v = db::result($orders_email)){
			?>
				<div class="wcb_module_table flex-middle2" data-id="<?=$v['Id']?>">
					<div class="flex-1"><?=$v[ln('Name')]?></div>
					<a class="edit mr_20px" href="/manage/?ma=email/list&d=edit&Id=<?=$v['Id']?>"><?=language('{/panel.mod_email/}')?></a>
					<label class="swi ly_switchery">
						<input type="checkbox" <?=$v['Open']?'checked':''?> fn="email_list_open">
						<input type="hidden" name="Open" value="1">
					</label>
				</div>
			<?php } ?>
		</div>
	</div>
	<!--  -->
	<div class="_dbs_box" cw="750">
		<div class="_dbs_item ly-h4"><?=language('{/panel.email_customer_notice/}')?></div>
		<div class="_dbs_item">
			<?php
				$orders_email = db::query("select * from wb_email_list where Type='member'");
				while($v = db::result($orders_email)){
			?>
				<div class="wcb_module_table flex-middle2" data-id="<?=$v['Id']?>">
					<div class="flex-1"><?=$v[ln('Name')]?></div>
					<a class="edit mr_20px" hr-ef="/manage/?ma=email/list&d=edit&Id=<?=$v['Id']?>"><?=language('{/panel.mod_email/}')?></a>
					<label class="swi ly_switchery">
						<input type="checkbox" <?=$v['Open']?'checked':''?> fn="email_list_open">
						<input type="hidden" name="Open" value="1">
					</label>
				</div>
			<?php } ?>
			<!--  -->
		</div>
	</div>

	<script>
		var email_list_open = {
			click(el, checked){
				var parent = el.parents('[data-id]')
				var id = parent.attr('data-id')
				$.async('POST', "/manage/?ma=email/list&d=post", {Id:id, Open:checked?1:0}, result=>{
					console.log(result)
				})
			}
		}
	</script>


</body>
</html>