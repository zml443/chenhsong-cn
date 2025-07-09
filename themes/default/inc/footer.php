
<?php 
	$footer = g('wb_set');
?>
<section id="footer" class="<?=$footer_back == 'white'?'white':''; ?>">
    <div class="cw1680">
        <div class="ftop flex-between">
            <div class="fleft">
				<div class="fleft_top">
					<div class="tip"><?=l('震雄“服务易”24小时热线','Chen Hsong 24-Hour Service Hotline<br/>Get in touch'); ?></div>
					<div class="fphone"><?=$head[ln('hotline')]?></div>
					<div class="share flex-middle2">
						<div class="left_icon relative">

							<div class="s_left flex-middle2">
								<div class="txt"><?=l('分享','Share'); ?></div>
								<div class="icon m-pic pointer">
									<img src="/images/icon/share.svg" class="svg trans" alt="<?=$seo[ln('SeoTitle')];?>">
								</div>
							</div>

							<div class="two_cont absolute trans">
								<div class="ul trans">
									<?php if(c('lang') == 'en') {?>
										<a share='linkedin' class="li pointer flex-middle2">
											<div class="pic m-pic"><img class="svg trans" src="/images/footer-icon3.svg" /></div>
											<div class="name trans"><?=l('领英','Linkedin'); ?></div>
										</a>
										<a share='sina' class="li pointer flex-middle2">
											<div class="pic m-pic"><img class="svg trans" src="/images/footer-icon2.svg" /></div>
											<div class="name trans"><?=l('新浪','Sina'); ?></div>
										</a>
										<a share='facebook' class="li pointer flex-middle2">
											<div class="pic m-pic"><img class="svg trans" src="/images/activity/facebook.svg" /></div>
											<div class="name trans">Facebook</div>
										</a>
										<a share='twitter' class="li pointer flex-middle2">
											<div class="pic m-pic"><img class="svg trans" src="/images/activity/linkedin.svg" /></div>
											<div class="name trans">X</div>
										</a>
									<?php } else {?>
										<a share='qq' class="li pointer flex-middle2">
											<div class="pic m-pic"><img class="svg trans" src="/images/footer-icon1.svg" /></div>
											<div class="name trans">QQ</div>
										</a>
										<a share='sina' class="li pointer flex-middle2">
											<div class="pic m-pic"><img class="svg trans" src="/images/footer-icon2.svg" /></div>
											<div class="name trans"><?=l('新浪','Sina'); ?></div>
										</a>
										<a share='linkedin' class="li pointer flex-middle2">
											<div class="pic m-pic"><img class="svg trans" src="/images/footer-icon3.svg" /></div>
											<div class="name trans"><?=l('领英','Linkedin'); ?></div>
										</a>
										<a share='wechat' class="li pointer flex-middle2">
											<div class="pic m-pic"><img class="svg trans" src="/images/footer-icon4.svg" /></div>
											<div class="name trans">微信</div>
										</a>
									<?php }?>
								</div>
							</div>
						</div>

						<div class="line">|</div>
						
						<div class="s_right flex-middle2">
							<div class="txt"><?=l('关注','Follow'); ?></div>

							<?php if(c('lang') == 'en') {?>
								<a href="<?=$head['link_facebook'] ? $head['link_facebook'] : 'javascript:;';?>" <?=$head['link_facebook']?"target='_blank'; ":"";?> class="icon relative wx m-pic">
									<img src="/images/activity/facebook.svg" class="svg trans" alt="<?=$seo[ln('SeoTitle')];?>">
								</a>
								<a href="<?=$head['link_tiktok'] ? $head['link_tiktok'] : 'javascript:;';?>" <?=$head['link_tiktok']?"target='_blank'; ":"";?> class="icon relative m-pic">
									<img src="/images/TikTok.svg" class="svg trans" alt="<?=$seo[ln('SeoTitle')];?>">
								</a>
								<a href="<?=$head['link_linkedin'] ? $head['link_linkedin'] : 'javascript:;';?>" <?=$head['link_linkedin']?"target='_blank'; ":"";?> class="icon relative m-pic">
									<img src="/images/footer-icon3.svg" class="svg trans" alt="<?=$seo[ln('SeoTitle')];?>">
								</a>
							<?php } else { ?>
								<div class="icon relative wx m-pic">
									<img src="/images/icon/wx.svg" class="svg trans" alt="<?=$seo[ln('SeoTitle')];?>">

									<div class="code absolute trans hide m-pic"><img src="<?=$head['code_wx']?>" alt="<?=$seo[ln('SeoTitle')];?>" /></div>
								</div>
								<div class="icon relative m-pic">
									<img src="/images/icon/dy.svg" class="svg trans" alt="<?=$seo[ln('SeoTitle')];?>">

									<div class="code absolute trans hide m-pic"><img src="<?=$head['code_dy']?>"  alt="<?=$seo[ln('SeoTitle')];?>"/></div>
								</div>
							<?php }?>
						</div>
					</div>
				</div>
				<div class="qrcode flex-top2">
					<div class="code">
						<div class="img m-pic">
							<img src="<?=$head['code_gzh']?>" alt="<?=$seo[ln('SeoTitle')];?>">
						</div>
						<div class="txt text-center"><?=l('震雄公众号','Chen Hsong office account'); ?></div>
					</div>
					<div class="code">
						<div class="img m-pic">
							<img src="<?=$head['code_sph']?>" alt="<?=$seo[ln('SeoTitle')];?>">
						</div>
						<div class="txt text-center"><?=l('震雄视频号','Chen Hsong video account'); ?></div>
					</div>
				</div>
            </div>
            <div class="fright flex-between">
                <?php foreach ((array)$nav as $k => $v) {
					?>
                    <div class="fnav trans">
                        <div class="fnav-one trans <?=$v['children']?"":"nobg"?>">
                            <a class="one-a block trans" href="<?=$v['href']; ?>"><?=$v['name']; ?></a>
                        </div>
                        <?php if($v['children']){?>
                            <div class="fnav-two trans ">
								<?php if($v['is_Sol']){?>
									<div class="list h trans is_Sol flex-column flex-wrap">
										<?php foreach ((array)$v['children'] as $k1 => $v1) { ?>	
											<a class="two-a trans block" href="<?=$v1['href']; ?>"><?=$v1['name']; ?></a>
										<?php } ?>
									</div>
								<?php } else if($v['is_pro']){?>
									<div class="list h trans">
										<?php foreach ((array)$v['children'] as $k1 => $v1) { 
											$nav_pro = db::get_all('wb_products',"Language = '{$c['lang']}' and wb_products_category_id = '{$v1['Id']}' and IsSaleOut != 1",'*','MyOrder asc,AddTime desc');
											?>	
											<div class="list-pro <?=$nav_pro?"":"nobg"?>">
												<div class="pro-one">
													<a class="two-a trans block" href="<?=$v1['href']; ?>"><?=$v1['name']; ?></a>
												</div>
												<div class="pro-box hide">
													<?php foreach((array)$nav_pro as $prok => $prov){
														$pic = str::json($prov['Pictures'], 'decode');
													?>
														<a href="<?=url::set($prov,'wb_products.detail')?>" class="pro-name"><?=$prov['Name']?></a>
													<?php } ?>
												</div>
											</div>
										<?php } ?>
									</div>
								<?php }else{?>
									<div class="list h trans">
										<?php foreach ((array)$v['children'] as $k1 => $v1) { ?>	
											<a class="two-a trans block" href="<?=$v1['href']; ?>" target="<?=$v1['target']?>"><?=$v1['name']; ?></a>
										<?php } ?>
									</div>
								<?php }?>
                            </div>
                        <?php }?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="fbot flex-between flex-middle2">
			<div class="fbot_left flex-middle2">
            	<div class="txt"><?=ly200::copyright()?></div>
				<?php if(c('lang') == 'cn') {?>
				<div class="txt shu">|</div>
            	<div class="txt"><?=ly200::icp()?></div>
				<?php }?>
				<div class="txt shu">|</div>
            	<div class="txt"><?=ly200::tech_support(1)?></div>
			</div>
            <div class="fbot_right _flex-middle2">
				<div class="txt"><?=ly200::icp2()?></div>
			</div>
        </div>
    </div>
</section>

<!--流量统计-->
<script src="/themes/api/analytics/index.js"></script>
<?php include 'side_fload.php'; ?>
<?php include 'third.php'; ?>