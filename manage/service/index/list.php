<?php
(function_exists('c') && $_GET['d']=='list') || exit();

$orderby = db::get_order_by($this->orderby);
$this->row = db::all("select * from ".$this->table." order by {$orderby}");

?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body bg="default">

	<?php $lyCssConf=['class'=>'p_30_0px', 'cw'=>'1400']; include c('dbs.inc').'app-title.php'; ?>

	<div bg="white" cw="1400">
		<div class="" ly-sticky="top">
			<div class="flex-middle2 flex-between p_20px" bg="white">
				<?php $lyCssConf=[]; include c('dbs.inc').'tool.php'; ?>
				<a class='flex-middle2 xuan_ze_feng_ge' color="main" hr-ef="?u=<?=$_GET['u']?>&ma=service/index&L=type">
					<i class="lyicon-modular mr_5px"></i>
					<span><?=language('{/global.change_type/}')?></span>
				</a>
			</div>
		</div>
		<!--  -->
		<section>
			<table class='ly_table_list maxw'>
				<thead>
					<tr>
						<td class="w_1 sticky"><label class="ly_checkbox lyicon-select-bold" size="big"><input type='checkbox' all='[name=Id]'></label></td>
						<?php if ($this->permit['myorder']) { ?><td d='myorder'><?=language('{/global.my_order/}')?></td><?php } ?>
						<?php foreach ($this->layout as $k => $v) { ?>
							<td d="<?=strtolower($k)?>" nowrap><?=$v['name']?></td>
						<?php } ?>
						<?php if ($this->permit['_ope']) { ?><td class="nowrap sticky"></td><?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($this->row as $k => $v) {
							$v = str::code($v);
					?>
						<tr>
							<td class="w_1 sticky"><label class="ly_checkbox lyicon-select-bold" size="big"><input type='checkbox' name='Id' value='<?=$v['Id']?>'></label></td>
							<?php if ($this->permit['myorder']) { ?><td class="w_1 sticky"><?=$this->li('_MyOrder', $v)?></td><?php } ?>
							<?php foreach ($this->layout as $k1 => $v1) { ?>
								<td class="<?=$v1['class']?>">
									<?php
										foreach ($v1['field'] as $k2 => $v2) {
											echo $this->li($k2, $v);
										}
									?>
								</td>
							<?php } ?>
							<?php if ($this->permit['_ope']) { ?><td class="nowrap sticky"><?=$this->li('_Ope', $v)?></td><?php } ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</section>
		<!--  -->
	</div>

	<script>
		var color_selector = {
			confirm(el, color){
				$.async('POST', '/manage/?ma=site/page/color', {color:color.rgb}, result=>{
					WP.$.alert(result.msg, 3000);
				}, 'json')
			}
		}
		WP.page_choice = {
			popup(result){
				var pop = this.pop = WP.$(`
					<div class="popup hidden">
						<form class="themes_preview flex-max2">
							<div class="close lyicon-close"></div>
							<div class="flex-wrap">
								${result.map(v=>{
									return `
										<label class="li">
											<div class="ifr scrollbar"><img class="maxw" src="${v.Picture}" /></div>
											<input class="hide" type="radio" name="Id" value="${v.Id}" ${v.cur=='1'?'checked':''} />
										</label>
									`
								}).join('')}
							</div>
						</form>
					</div>
				`)
				WP.$('body').append(pop)
				pop.popup()
				pop.on('click', ".el-popup-bg, .close", function(){
					pop.popup_remove()
				})
			}
		}
		$(document).on('click', '.xuan_ze_feng_ge', function(){
			var lo = $.alert('loading')
			$.async('POST', '?ma=site/page/web', $('.edit_page_type').serializeArray(), result=>{
				lo.popup_remove(()=>{
					WP.page_choice.popup(result)
				})
			}, 'json')
		});
		WP.$(WP.document).on('click', '.themes_preview .li input', function(){
			var formdata = new FormData(WP.$('.themes_preview')[0]);
			$.async('POST', '/manage/?ma=site/page/change', {newFormData:formdata}, result=>{
				location.reload()
				WP.page_choice.pop.popup_remove()
			}, 'json')
		});
	</script>
	
</body>
</html>