<?php
// 智能工厂 自动化
// 防止胡乱进入
isset($c) || exit;

$navId = 'factory';
$navTwoId = $navBanId = 'automation';
$seo = db::seo('automation');

$automation_cate = db::get_all('wb_factory_category', 'Dept = 1', "*", 'MyOrder asc, Id asc');
$CateId = (int)$_GET['aid']?$_GET['aid']:$automation_cate[0]['Id'];

$where = "Language='{$c['lang']}'";
$CateId && $where .= " and wb_automation_category_id = '{$CateId}'";
$pg = (int)$_GET['pg'];
$page_list = db::get_limit_page('wb_factory_automation', $where,'*',db::get_order_by('new','wb_factory_automation'),$pg, 2,
	array(
		'prev' => '<div class="pn box m-pic trans l"><img src="/images/pn.svg" alt="" class="svg trans"></div>',
		'next' => '<div class="pn box m-pic trans r"><img src="/images/pn.svg" alt="" class="svg trans"></div>',
		)
	);
if($pg>$page_list['total_page']){return false;}

?>
<!DOCTYPE html>
<html lang="zh-cn">
<?php include 'inc/style_script.php';?>
<body class="auto_back">
	<?php include 'inc/header.php';?>
	
	<div class="menuBox relative">
		<?php include 'inc/banner.php'; ?>
		<?php include 'inc/menu.php'; ?>
	</div>

	<section id="automation">
		<div class="cw1600">
			<div class='container choose mobile' view="auto" page="none" loading wow='fadeInUp'>
				<div class='wrapper <?=!server::mobile(1) && count($automation_cate)<4?'flex-center':'';?>'>
					<?php foreach((array)$automation_cate as $k => $v) {?>
						<a href="javascript:;" data-id='<?=$v['Id']; ?>' class='slide box trans <?=$CateId == $v['Id'] ?'cur':''; ?>'><?=$v[ln('Name')]; ?></a>
					<?php }?>
				</div>
			</div>

			<div class="content contBox" wow='fadeInUp' ajax-attr>
				<?php foreach((array)$page_list['row'] as $k => $v) {
					$pic = str::json($v['Picture'], 'decode');
				?>
					<div class="list" wow='fadeInUp'>
						<div class="word">
							<div class="name"><?=$v['Name']; ?></div>
							<div class="ul">
								<div class="li">
									<div class="tit"><?=l('核心价值','Core Values'); ?>：</div>
									<div class="brief"><?=nl2br($v['BriefDescription']); ?></div>
								</div>
								<div class="li">
									<div class="tit"><?=l('技术特点','Technical Characteristics'); ?>：</div>
									<div class="brief"><?=nl2br($v['Point']); ?></div>
								</div>
							</div>
						</div>
						<div class="img m-pic b-pic"><img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" class="max absolute" /></div>
					</div>
				<?php }?>
			</div>

			<?php include 'inc/page.php';?>
		</div>
	</section>
	
	<?php include 'inc/footer.php';?>
</body>
</html>
<script>

	function go_url(){
		setTimeout(function(){
			var href ='?pg=1';
			var id = $('#automation .choose .box.cur').data('id');
			href += '&aid='+id;

			$('body').append('<a to="#automation .contBox" ajax-href="" href="'+href+'" class="paging_btn flex-max2 pages">1</a>');
			
			// setTimeout(function(){
			// 	$("body>.pages").click().remove();
			// },100);
		},1)
	};
	$(document).on('hover',"#automation .choose .box",function(e){
		$(this).addClass('cur').siblings().removeClass('cur');
		e.stopPropagation();
		go_url();
	});

	// $(document).on('hover','#automation .choose .box',function(){
	// 	$(this).addClass('cur').siblings().removeClass('cur');
    //     var id = $(this).data('id');

    //     $.post('smart-factory-automation', {id:id}, function(html){
    //         // $('#automation .ajaxBox').html(html);
    //     },'html');
    //     return false;
	// });
</script>