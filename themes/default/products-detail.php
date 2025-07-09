<?php
// 产品
// 防止胡乱进入
isset($c) || exit;

$navId = 'products';

$PId = (int)$_GET['pid'];
if(!$PId){return false;}
// $info = db::get_one('wb_products', "Id = '{$PId}' and Language = '{$c['lang']}' and IsSaleOut != 1", '*');
// if(!$info){return false;}

$info = db::get_one('wb_products', "Id = '{$PId}' and IsSaleOut = 0 and Language='{$c['lang']}'", '*');
$monitor = db::get_one('wb_products',"Id = '{$PId}' and IsSaleOut = 0",'*');

if($monitor && !$info){
    header("Location: /");
}elseif(!$info){
    return false;
}

$seo = db::seo('wb_products',$PId);
$info_name = $info['Name']; 
$CateId = $info['wb_products_category_id'];
$InfoCate = db::get_one('wb_products_category', "Id = '{$CateId}'", "Id,".ln('Name'));

$banner_pic = str::json($info['Pictures2'], 'decode');
$pro_pic = str::json($info['Pictures'], 'decode');

// 菜单
$pro_menu = array(
	'value' => array('href'=>'#pro_value','name'=>l('核心价值','Core Values'),'top'=>'100px'),
	'technology' => array('href'=>'#pro_adv','name'=>l('技术优势','Advantages'),'top'=>'100px'),
	// 'cases' => array('href'=>'#pro_case','name'=>l('应用案例','Cases'),'top'=>'100px'),
	'industry' => array('href'=>'#pro_ind','name'=>l('适用行业','Industry'),'top'=>'100px'),
	'custom' => array('href'=>'#industry-custom','name'=>l('客户案例','Cases'),'top'=>'100px'),
	// 'relevant' => array('href'=>'#industry-relevant','name'=>l('相关技术/自动化','Related'),'top'=>'100px'),
	'form' => array('href'=>'#contact_form','name'=>l('联系我们','Contact Us'),'top'=>'100px'),
);

// 核心价值
$pro_value = str::json($info['Data'], 'decode');
if(empty($pro_value[0]['name'])) {
	$pro_menu['value'] = [];
}

// 技术优势
$pro_technology = str::json($info['Data2'], 'decode');
if(empty($pro_technology[0]['name'])) {
	$pro_menu['technology'] = [];
}

// 应用案例
$pro_cases = db::get_all('wb_products_cases', "wb_products_id = '{$PId}'", '*', 'MyOrder asc, AddTime asc');
if(!$pro_cases){
    $pro_menu['cases'] = [];
}

// 适用行业
$ind_id = $info['wb_industry_id'];
if($ind_id){
    $where = "Id in ({$ind_id})";
    $pro_ind = db::get_all('wb_industry', "Language = '{$c['lang']}' and ".$where, '*', 'MyOrder asc, Id asc');
}
if(!$pro_ind){
    $pro_menu['industry'] = [];
}

// 客户案例
$cases_id = $info['wb_blog_id'];
if($cases_id){
	$where = "Id in ({$cases_id}) and IsSaleOut != 1 and Language = '{$c['lang']}'";
	$rel_cases = db::get_all('wb_blog', $where, '*', 'MyOrder asc, AddTime asc');
}

// else{
// 	$where = "wb_blog_category_id = 4 and IsSaleOut != 1 and Language = '{$c['lang']}'";
// 	$rel_cases = db::get_all('wb_blog', $where, '*', 'MyOrder asc, AddTime asc');

//     if(!$rel_cases){
//         $pro_menu['custom'] = [];
//     }
// }
if(!$rel_cases){
    $pro_menu['custom'] = [];
}

// 相关技术
$rel_tech = db::get_limit('wb_about_technology', "1", '*','MyOrder asc, AddTime asc',0,3);
// 相关自动化
$auto_id = $info['wb_automation_id'];
if($auto_id){
	$where = "Id in ({$auto_id}) and Language = '{$c['lang']}'";
	$rel_auto = db::get_all('wb_factory_automation', $where, '*', 'MyOrder asc, AddTime asc');
}
// if(!$rel_auto){
//     $pro_menu['relevant'] = array('href'=>'#industry-relevant','name'=>l('相关技术','Related'),'top'=>'100px');
// }

?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<body>
	
<div class="products_back">
	<?php include 'inc/header.php'; ?>

    <div class="other_banner relative">
        <section id="pro_banner" class="over" style="background-image: url(<?=server::mobile(1)?img::get($banner_pic[1]['path']):img::get($banner_pic[0]['path'])?>);">
            <div class="cw1600 relative">
                <div class="menu absolute">
                    <a href="/"><?=l('首页','Home');?></a>
                    <span>/</span>
                    <a href="javascript:;"><?=$nav[$navId]['name'];?></a>
                    <span>/</span>
                    <a href="javascript:;"><?=$InfoCate[ln('Name')];?></a>
                </div>

                <div class='big_swi container' thumbs="#pro_banner .thumbs" center loop loading effect="fade" space="4" 
                    <?=server::mobile(1)?'':"page='none' "; ?>
                    fn="products_swi.init()"
                    prev="#pro_banner .right .prev"
                    next="#pro_banner .right .next"
                >
                    <div class='wrapper'>
                        <?php foreach((array)$pro_pic as $k => $v) {?>
                            <div class='slide relative m-pic'>
                                <img src="<?=img::get($v['path']); ?>" alt="<?=$v['alt']?>" title="<?=$v['title']; ?>" />
                            </div>
                        <?php }?>
                    </div>
                </div>

                <div class="right absolute">
                    <div class="btn prev m-pic pointer trans"><img src="/images/products/jt-down.png" /></div>

                    <div class='small_swi container thumbs' vertical center loop loading view="3" space="16" page="none">
                        <div class='wrapper'>
                            <?php foreach((array)$pro_pic as $k => $v) {?>
                                <div class='slide relative m-pic pointer trans' >
                                    <img src="<?=img::get($v['path']); ?>" alt="<?=$v['alt']?>" title="<?=$v['title']; ?>" />
                                </div>
                            <?php }?>
                        </div>
                    </div>

                    <div class="btn next m-pic pointer trans"><img src="/images/products/jt-down.png" /></div>
                </div>

                <div class="pro_info absolute">
                    <div class="slogan" wow="fadeInUp"><?=nl2br($info['BriefDescription']);?></div>
                    <div class="name" wow="fadeInUp"><?=nl2br($info['Name']);?></div>
                    <div class="type" wow="fadeInUp"><?=nl2br($info['Model']);?></div>
                    <?php if($info['Brief']){?>
                    <div class="brief" wow="fadeInUp"><?=nl2br($info['Brief']);?></div>
                    <?php }?>
                </div>
            </div>
        </section>

        <section id="pro_menu">
            <div class="cw1600">
                <div class="nav flex-center relative">
                    <div class='container' free view="auto" page="none" prev="#pro_menu .nav .prev" next="#pro_menu .nav .next">
                        <div class='wrapper'>
                            <?php foreach((array)$pro_menu as $k => $v) {
								if(empty($v)){continue;}
								?>
								<a href="<?=$v['href']; ?>" position-follow-cur="<?=$v['href']; ?>" top="<?=$v['top']; ?>" class="slide text-center trans"><?=$v['name']; ?></a>
							<?php } ?>
                        </div>
                    </div>
                    <div class="prev btn absolute pointer m-pic"><img src="/images/products/jt-down.png" /></div>
                    <div class="next btn absolute pointer m-pic"><img src="/images/products/jt-down.png" /></div>
                </div>
            </div>
        </section>
    </div>

    <?
    // 技术优势 
    if(!empty($pro_menu['value']['name'])) {
    ?>
    <section id="pro_value" class="over">
        <div class="cw1600">
            <!-- <div id="pro_tit" class="text-center"  wow="fadeInUp"><?//=$pro_menu['value']['name']; ?></div> -->

            <div class="cont relative">
                <div class='container' view="auto" page="none" loading 
                    prev="#pro_value .cont .prev" 
                    next="#pro_value .cont .next"
                    >
                    <div class='wrapper <?=count($pro_value)<4?'flex-center':''; ?>'>
                        <?php foreach((array)$pro_value as $k => $v) {?>
                            <div class='slide'  wow="fadeInUp">
                                <div class="icon m-pic"><img src="<?=img::get($v['icon']); ?>" alt="<?=$v['name']; ?>" title="<?=$v['name']; ?>" /></div>
                                <div class="tit text-center"><?=nl2br($v['name']); ?></div>
                                <div class="brief text-center"><?=nl2br($v['brief']); ?></div>
                            </div>
                        <?php }?>
                    </div>
                </div>

                <div class="prev btn pointer absolute m-pic trans"><img src="/images/industry/pn.svg" alt="" class="svg" /></div>
                <div class="next btn pointer absolute m-pic trans"><img src="/images/industry/pn.svg" alt="" class="svg" /></div>
            </div>
        </div>
    </section>
    <?php }?>

    <?
    // 技术优势 
    if(!empty($pro_technology[0]['name'])) {
    ?>
    <section id="pro_adv" class="over">
        <?php foreach((array)$pro_technology as $k => $v) {?>
            <div class="item item<?=($k+1);?> trans relative over flex-right" >
                <div class="info absolute max" wow="fadeInUp">
                    <div class="cw1600">
                        <div class="in">
                            <div class="tit"><?=nl2br($v['name']); ?></div>
                            <div class="txt"><?=nl2br($v['brief']); ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="pic relative over" wow="fadeInRight">
                    <div class="absolute max m-pic"><img src="<?=img::get($v['pic']); ?>" alt="<?=$v['name']; ?>" title="<?=$v['name']; ?>" /></div>
                </div>
            </div>
        <?php } ?>
    </section>
    <?php } ?>

    <?
    /*
    // 应用案例 
    if($pro_cases){
    ?>
    <section id="pro_case" class="over">
        <div class="cw1600">
            <!-- <div id="pro_tit" class="text-center" wow="fadeInUp"><?//=$pro_menu['cases']['name']; ?></div> -->

            <div class="cont">
                <div class='container' view="auto" page="none" loading prev="#pro_case .cont .prev" next="#pro_case .cont .next">
                    <div class='wrapper <?=count($pro_cases)<4?'flex-center':''; ?>'>
                        <?php foreach((array)$pro_cases as $k => $v) {
                            $pic = str::json($v['Pictures'], 'decode');
                            $data = str::json($v['Data'], 'decode');
                        ?>
                            <div class='slide' wow="fadeInUp">
                                <div class="pic relative m-pic">
                                    <img class="absolute max" src="<?=img::get($pic[0]['path']); ?>"  alt="<?=$pic[0]['alt']?>" title="<?=$pic[0]['title']; ?>"/>
                                </div>
                                <div class="info">
                                    <div class="p1"><?=nl2br($v['Name']); ?></div>
                                    <div class="p2"><?=l('机型','Model')?>：<?=nl2br($v['Model']); ?></div>
                                    <div class="ul flex-between flex-wrap">
                                        <?php foreach((array)$data as $v1) {?>
                                        <div class="li"><?=nl2br($v1['name']); ?><?=nl2br($v1['brief']); ?></div>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>

                <div class="flex-max2" wow="fadeInUp">
                    <div class="prev btn pointer m-pic trans"><img src="/images/industry/pn.svg" class="svg" /></div>
                    <div class="next btn pointer m-pic trans"><img src="/images/industry/pn.svg" class="svg" /></div>
                </div>
            </div>
        </div>
    </section>
    <?php }*/?>

    <?
    // 适用行业 
    if($pro_ind){
    ?>
    <section id="pro_ind" class="over">
        <div class="cw1600">
            <!-- <div id="pro_tit" class="text-center" wow="fadeInUp"><?//=$pro_menu['industry']['name']; ?></div> -->

            <div class="cont flex-wrap flex-center">
                <?php foreach((array)$pro_ind as $v){
                    $icon = str::json($v['Pictures3'], 'decode');
                    $url = url::set($v, 'wb_industry.detail');
                ?>
                <a href="<?=$url;?>" class="item flex-max2 trans"  wow="fadeInUp">
                    <div class="icon svg m-pic trans"><img class="svg" src="<?=img::get($icon[0]['path']);?>" alt="<?=$icon[0]['alt']; ?>"  title="<?=$icon[0]['title']; ?>" /></div>
                    <div class="tit text-center trans"><?=$v['Name']?></div>
                </a>
                <?php }?>
            </div>
        </div>
    </section>
    <?php }?>

    <div class="proCont">
        <?php
            // 客户案例
            if($rel_cases) {
        ?>
        <section id="industry-custom" class="products over">
            <div class="cw1600">
                <div class="top flex-between">
                    <div class="title"><?=$pro_menu['custom']['name']; ?></div>
                    <a href="/blog/bid-4.html" class="more trans block"><?=l('更多案例','MORE')?></a>
                </div>

                <div class='container' view="auto" loading wow='fadeInUp'>
                    <div class='wrapper <?=count($rel_cases) < 3 ?'flex-center':'';?>'>
                        <?php foreach((array)$rel_cases as $k => $v){
                            $url = $v['Url'] ? $v['Url'] : url::set($v, 'wb_blog.detail');
                            $pic = str::json($v['Pictures'], 'decode');
                        ?>
                            <div class='slide block b-pic'>
                                <div class="i-pic relative img">
                                    <a href="<?=$url; ?>" <?=$v['Url'] ?"target='_blank'":''; ?> class="absolute block max i-pic">
                                        <img class="absolute max" src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>" title="<?=$pic[0]['title']; ?>" />
                                    </a>

                                    <?php if(img::get($v['Video'])){ ?>
                                        <div class="play trans5 absolute m-pic pointer" ly-video src="<?=img::get($v['Video']); ?>">
                                            <img src="/images/icon/play.svg" class="svg trans" alt="<?=$v['Name']?>" />
                                        </div>
                                    <?php }?>
                                </div>
                                <div class="word">
                                    <a href="<?=$url; ?>" <?=$v['Url'] ?"target='_blank'":''; ?> class="name block trans text-over"><?=$v['Name']?></a>
                                    <div class="brief trans text-line2"><?=$v['BriefDescription']?></div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </section>
        <?php }?>
    
        <i class="cw1600"></i>

        <?/* 相关技术 ?>
        <section id="industry-relevant" class="products over">
            <div class="cw1600">
                <div class="top" wow='fadeInUp'>
                    <div class="choose" tab="{}" to="#industry-relevant .bind" fn="ly2._ly2_tab_">
                        <div class="box trans cur"><?=l('相关技术','Related Technologies')?></div>
                        <?php if($rel_auto) {?>
                            <div class="box trans"><?=l('相关自动化','Related Automation')?></div>
                        <?php }?>
                    </div>
                    <div class="bind">
                        <a href="/technology" class="btn block trans"><?=l('了解更多','Learn More')?></a>
                        <?php if($rel_auto) { ?>
                        <a href="/smart-factory-automation" class="btn block trans"><?=l('了解更多','Learn More')?></a>
                        <?php }?>
                    </div>
                </div>
                <div class="bind" wow='fadeInUp'>
                    <div class="content">
                        <?php foreach((array)$rel_tech as $k => $v){
                            $pic = str::json($v['Pictures2'], 'decode');
						?>
                            <a href="/technology#tech<?=$v['Id']; ?>" class="box b-pic block" wow='fadeInUp'>
                                <div class="name trans text-over"><?=$v[ln('Name')]; ?></div>
                                <div class="brief trans text-line2"><?=$v[ln('Brief')]; ?></div>
                                <div class="img i-pic">
                                    <img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>" title="<?=$pic[0]['title']; ?>"  class="max absolute" />
                                </div>
                            </a>
                        <?php }?>
                    </div>
                    <?php if($rel_auto) { ?>
                    <div class="content <?=count($rel_auto)<3?'flex-center':'';?>">
                        <?php foreach((array)$rel_auto as $k => $v){
                            $pic = str::json($v['Picture'], 'decode');
                        ?>
                            <div class="box b-pic">
                                <div class="name trans text-over"><?=$v['Name']; ?></div>
                                <div class="brief trans text-line2"><?=$v['BriefDescription']; ?></div>
                                <div class="img i-pic">
                                    <img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>" title="<?=$pic[0]['title']; ?>"  class="max absolute"/>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                    <?php }?>
                </div>
            </div>
        </section>
        <?*/?>
    </div>

	<?php include 'inc/contact_form.php'; ?>
	<?php include 'inc/footer.php'; ?>
</div> 
</body>
</html>
<script>
    // 导航滚动固定
$(function(){
	$(window).scroll(function(){
		var s_top = $(window).scrollTop();
		var banner_h = $('#pro_banner').outerHeight();
		var nav_h = banner_h;
		if(s_top >= nav_h){
			$('#pro_menu').addClass('fixed');
		}else{
			$('#pro_menu').removeClass('fixed');
		}

		if($('#pro_menu').length){
			$('[position-follow-cur]').each(function(){
				var obj = $($(this).attr('position-follow-cur'));
				if (obj.size()==0) {
					return;
				}
				var top = obj.offset().top;		
				// if(s_top+nav_h>=top){
                if(s_top + 150>=top){
					$(this).addClass('cur').siblings().removeClass('cur');
				}
			});
		}
		
	});
});
</script>