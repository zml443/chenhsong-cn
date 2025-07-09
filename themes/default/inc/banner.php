<?php 
	if($navBanId){
		if($navBanId == 'blog'){
			$Cate =  db::get_one('wb_blog_category',"Id = '{$CateId}'",'*');
			$banner_pc = str::json($Cate['pc'], 'decode');
			$banner_mobile = str::json($Cate['mobile'], 'decode');
		}else{
			$banner = g('wb_ad_'.$navBanId);
			$banner && $banner_pc = $banner['pc'];
			$banner && $banner_mobile = $banner['mobile'];
		}
		$banner = server::mobile()?$banner_mobile:$banner_pc;
	}else if($navId){
		if($navId=='index'){
			$banner = g('wb_ad');
			$banner && $banner_pc = $banner[ln('pc')];
			$banner && $banner_mobile = $banner[ln('mobile')];
			$banner = server::mobile()?$banner_mobile:$banner_pc;
		}else{
			$banner = g('wb_ad_'.$navId);
			$banner && $banner_pc = $banner['pc'];
			$banner && $banner_mobile = $banner['mobile'];
			$banner = server::mobile()?$banner_mobile:$banner_pc;
		}
	}
?>

<?php if ($navId =='index'){ ?>
	<section id="index-swiper">
		<div class="swiper1 relative">
			<div class="container" view="1" speed='1' _loop delay="5" fn="banner_swiper" prev="#index-swiper .prev" next="#index-swiper .next">
				<div class="wrapper">
					<?php foreach ((array)$banner as $k => $v){ ?>
						<div class="slide trans over">
							<div class="slide-inner maxw trans">
								<?php if (file::ext_name($v['path'])=='mp4'){ ?>
									<div class="img">
										<div class="pic m-pic relative <?=server::mobile(1)?'mobile':''?>">
											<div class="absolute v">
												<video src="<?=$v['path']?>" muted autoplay loop webkit-playsinline="true" playsinline="true" x5-video-player-type="h5" x5-video-player-fullscreen="true"></video>
											</div>
											<?php if($v['img']){?>
											<div class="top_pic absolute max i-pic" style="z-index: 1;"><img src="<?=$v['img']?>" /></div>
											<?php }?>
										</div>
									</div>
								<?php }else{ ?>
									<a href="<?=$v['url']?$v['url']:'javascript:;'?>" <?=$v['url']?'target="_blank"':''?> class="img block">
										<div class="pic m-pic relative <?=server::mobile()?'mobile':''?>">
											<img src="<?=$v['path']?>" alt="<?=$v['alt']?>" title="<?=$v['title']?>" class="absolute max">
										</div>
										<div class="cont_text absolute max text-center">
											<div class="cw1680 maxh table">
												<div class="table-cell v-top">
													<?php if($v['tit1']){?>
													<div class="title" wow="fadeInUp"><?=$v['tit1'];?></div>
													<?php } ?>
													<?php if($v['tit2']){?>
													<div class="brief" wow="fadeInUp"><?=$v['tit2'];?></div>
													<?php } ?>
												</div>
											</div>
										</div>
									</a>
								<?php } ?>
							</div>
						</div>
					<?php }?>
				</div>
			</div>
			<div class="prev m-pic pointer absolute pn trans">
				<img src="/images/icon/prev.svg" class="svg trans" alt="">
			</div>
			<div class="next m-pic pointer absolute pn trans">
				<img src="/images/icon/next.svg" class="svg trans" alt="">
			</div>
		</div>
	</section>
<?php }else{?>
	<section id="inner-banner" class="relative over">
		<div class="img m-pic">
			<?php if (file::ext_name(img::get($banner))=='mp4'){ ?>
				<video src="<?=img::get($banner)?>" muted autoplay loop webkit-playsinline="true" playsinline="true" x5-video-player-type="h5" x5-video-player-fullscreen="true"></video>
			<?php } else {?>
				<img src="<?=img::get($banner)?>" width="100%" alt="<?=$banner[0][ln('alt')];?>" title="<?=$banner[0][ln('title')];?>">
			<?php }?>
		</div>

		<div class="cont absolute max">
			<div class="cw1600">
				<?php if($navBanId == 'blog'){ ?>
					<div class="txt1"><?=c('lang')=='en'?$Cate['Name_en']:$Cate['Name_cn']?></div>
					<div class="txt2"><?=c('lang')=='en'?'':$Cate['Name_en']?></div>
				<?php } else {?>
					<div class="txt1"><?=c('lang')=='en'?$banner[0]['tit_en']:$banner[0]['tit_cn']?></div>
					<div class="txt2"><?=c('lang')=='en'?'':$banner[0]['tit_en']?></div>
				<?php }?>
			</div>
		</div>
	</section>
<?php }?>

<script>
	var video = $("video");
	if(video.length){
		video[0].play();
		document.addEventListener("WeixinJSBridgeReady",function(){
			video[0].play();
		},false);
		document.addEventListener('YixinJSBridgeReady', function() {
			video[0].play();  
		}, false);
	}
</script>