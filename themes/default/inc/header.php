
<?php include './themes/default/inc/top.php';?>

<!-- PC端 -->
<section id="header" class="fixed trans5 <?=$navTwoId=="media_Detail"?'detail':''?>">
    <div class="cw1680">
        <div class="header-box flex-between">
			<a href="/" class="logo m-pic block">
				<img src="<?=$head['logo']?>" width="100%" alt="<?=$seo[ln('SeoTitle')];?>">
			</a>
            
            <div class="hattr">
                <div class="hnav flex-between flex-middle2">
                    <?php foreach((array)$nav as $k => $v){?>
                        <div class="one-nav trans-inter relative <?=$v['cur']?>">
                            <a href="<?=$v['href']?>" class="nav-a trans block" target="<?=$v['target']?>">
								<?=$v['name']?>
							</a>
							
                            <?php if($v['children']){?>
								<?php 
									// 产品
									if($v['is_pro']){
								?>
									<div class="two-nav pro_menu fixed trans5">
										<div class="hnavbg h cw1680">    
											<div class="pro_cont flex-top2">
												<? // 分类 ?>
												<div class="pro_tab" tab="{hover:1}" to="#header .hattr .hnav .two-nav .hnavbg .bind">
													<?php foreach((array)$v['children'] as $k1=>$v1){?>
														<div class="pro_name trans nowrap text-over pointer"><?=$v1['name']?></div>	
													<?php }?>
													<?/*?>
													<a href="/smart-factory-mold" class="pro_name block trans nowrap text-over pointer"><?=l('模具与产品','Mold and Product');?></a>
													<?*/?>
												</div>
												
												<? // 产品 ?>
												<div class="bind">
													<?php 
														foreach((array)$v['children'] as $k1 => $v1){
														$nav_pro = db::get_all('wb_products',"Language = '{$c['lang']}' and wb_products_category_id = '{$v1['Id']}' and IsSaleOut != 1",'*','MyOrder asc, AddTime desc');
													?>
														<div class="pro_list flex-middle2 flex-between">
															<?php if($nav_pro){?>
																<div class="btn m-pic trans prev">
																	<img src="/images/icon/prev.svg" class="svg trans" alt="<?=$seo[ln('SeoTitle')];?>" />
																</div>
																<div class='container' observer observeParents loading page="none" view="3" 
																	h5="{321:{view:2, space:20, group:2},1281:{view:2, space:35, group:2},1537:{view:3, space:58, group:3}}" 
																	prev="#header .hnav .pro_menu .hnavbg .bind .pro_list .prev" 
																	next="#header .hnav .pro_menu .hnavbg .bind .pro_list .next"
																>
																	<div class='wrapper'>
																		<?php foreach((array)$nav_pro as $prok => $prov){
																			$pic = str::json($prov['Pictures'], 'decode');
																		?>
																			<a href="<?=url::set($prov,'wb_products.detail')?>" class="slide b-pic block">
																				<div class="pic m-pic over">
																					<img class="absolute max" src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" />
																				</div>
																				<div class="name trans text-over">
																					<?=$prov['Name']?>
																				</div>
																			</a>
																		<?php }?>
																	</div>
																</div>
																<div class="btn m-pic trans next">
																	<img src="/images/icon/next.svg" class="svg trans" alt="<?=$seo[ln('SeoTitle')];?>" />
																</div>
															<?php } else {?>
																<div class="not_tip text-center"><?=l('目前没有产品信息','There is currently no product information available!')?></div>
															<?php }?>
														</div>
													<?php }?>
													<div></div>
												</div>
											</div>
										</div>
									</div>
								<?php } else {?>
									<div class="two-nav absolute trans5">
										<div class="hnavbg h">    
											<?php foreach((array)$v['children'] as $k1=>$v1){?>
												<a href="<?=$v1['href']; ?>" target="<?=$v1['target']?>" class="tnav-a trans block"><?=$v1['name'];?></a>
											<?php }?>
										</div>
									</div>
								<?php }?>
                            <?php }?>
                        </div>
                    <?php }?>
                </div>
            </div>

            <div class="hright flex-middle2">
				
				<div class="search trans pointer m-pic block" <?=server::mobile()?'':'ly-search-popup="{}" url="/search"'?>>
					<img src="/images/icon/search.svg" class="svg trans i1" alt="<?=$seo[ln('SeoTitle')];?>" />
					<img src="/images/icon/menu-close.svg" class="svg trans i2 hide" alt="<?=$seo[ln('SeoTitle')];?>" />
				</div>

				<div class="lang trans pointer flex-middle2" lang-popup>
					<div class="icon  m-pic">
						<img src="/images/icon/lang.svg" class="svg trans" alt="<?=$seo[ln('SeoTitle')];?>" />
					</div>
					<div class="txt">Language(<?=c('lang')=='en'?'EN':'ZH'?>)</div>
				</div>

                <div class="menu pointer m-pic">
					<img src="/images/icon/menu-list.svg" class="svg trans i1" alt="<?=$seo[ln('SeoTitle')];?>" />
					<img src="/images/icon/menu-close.svg" class="svg trans i2 hide" alt="<?=$seo[ln('SeoTitle')];?>" />
				</div>
            </div>
        </div>
    </div>
</section>

<section id="header-blank"></section>

<!-- 移动端下拉菜单 -->
<section id="m-nav" class="fixed trans5 ">
    <div class="nav">
        <?php foreach ((array)$nav as $k => $v) { ?>
        <div class="one-nav <?=$v['children']?'':'nobg' ?> trans5">
            <div class="one trans5">
                <a class="one-a" href="<?=$v['href'];?>" target="<?=$v['target']?>"><?=$v['name']; ?></a>
            </div>
            <?php if($v['children']){ ?>
                <div class="two-nav hide two">
                    <?php foreach ((array)$v['children'] as $k1 => $v1) { 
						$nav_pro = db::get_all('wb_products',"Language = '{$c['lang']}' and wb_products_category_id = '{$v1['Id']}' and IsSaleOut != 1",'*','MyOrder asc,AddTime desc');
						?>
						<?php 
							// 产品
							if($v['is_pro']){
						?>
							<div class="two-box two-pro">
								<div class="two-li <?=$nav_pro?'':'nobg' ?>">
									<div class="two-a trans5 block"><?=$v1['name']; ?></div>
								</div>

								<div class="pro-box hide">
									<?php foreach((array)$nav_pro as $prok => $prov){
										$pic = str::json($prov['Pictures'], 'decode');
									?>
										<a href="<?=url::set($prov,'wb_products.detail')?>" class="pro-name"><?=$prov['Name']?></a>
									<?php } ?>
								</div>
							</div>
							<div class="two-box two-pro">
								<div class="two-li nobg" style="background: none;">
									<a href="/smart-factory-mold" class="two-a trans5 block"  style="background: none;"><?=l('模具与产品','Mold and Product');?></a>
								</div>
							</div>
						<?php } else {?>
							<div class="two-li <?=$v['is_pro']?'':'nobg' ?>">
								<a class="two-a two-other trans5 block" href="<?=$v1['href'];?>" target="<?=$v1['target']?>"><?=$v1['name']; ?></a>
							</div>
						<?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>

    <div class="bot-box flex-center flex-middle2">
		<div class="lang trans pointer flex-middle2" lang-popup>
			<div class="icon  m-pic">
				<img src="/images/icon/lang.svg" class="svg trans" alt="<?=$seo[ln('SeoTitle')];?>" />
			</div>
			<div class="txt">Language(<?=c('lang')=='en'?'EN':'ZH'?>)</div>
		</div>
    </div>
</section>

<section id="search-box" class="fixed">
    <div class="content">
        <form action="/search" class="form-box flex-between">
            <div class="input"><input Name='keyword' type="text" placeholder="<?=l('输入关键字搜索','Enter keyword search'); ?>"></div>
            <label class="submit pointer m-pic">
				<input type="submit" value="" class="hide">
				<img src="/images/icon/search.svg" class="svg trans" alt="<?=$seo[ln('SeoTitle')];?>" />
			</label>
        </form>
    </div>
</section>


<?php include './themes/default/inc/lang.php';?>

<script>
	header.nav();
	header.m_nav();
	header.search();
</script>

