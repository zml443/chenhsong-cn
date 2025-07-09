<?php
// 关于我们-投资者关系-最新公告
// 防止胡乱进入
isset($c) || exit;

$navId = 'about';
$navTwoId = 'invest';
$navThreeId = 'announcements';
$footer_back = 'white';
$seo = db::seo('invest');

$All_Year = db::get_all('wb_invest_category', "1", "*", 'MyOrder asc, Id asc');
$All_Type = db::get_all('wb_invest_category2', "1", "*", 'MyOrder asc, Id asc');

$CateId = (int)$_GET['aid']?(int)$_GET['aid']:$All_Type[0]['Id'];
$YearId = (int)$_GET['year'];

$where = "Language='{$c['lang']}' and IsSaleOut != 1";
$CateId && $where .= " and wb_type_id = '{$CateId}'";
$YearId && $where .= " and wb_year_id = '{$YearId}'";

$cate = db::get_one('wb_invest_category2', "Id = '{$CateId}'", "*");

$pg = (int)$_GET['pg'];
$page_list = db::get_limit_page('wb_invest_announcements', $where,'*',db::get_order_by('new','wb_invest_announcements'),$pg, 6,
array(
	'prev' => '<div class="pn box trans m-pic l"><img src="/images/pn.svg" alt="" class="svg trans"></div>',
	'next' => '<div class="pn box trans m-pic r"><img src="/images/pn.svg" alt="" class="svg trans"></div>',
	)
);
if($pg>$page_list['total_page']){return false;}


?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<body>
	
	<?php include 'inc/header.php'; ?>

    <div class="menuBox relative">
	    <?php include 'inc/banner.php'; ?>
        <?php include 'inc/menu.php'; ?>
    </div>

    <section id="invest">
        <div class="box flex-between cw1600">
            <div class="left-menu">
                <?php include 'inc/menu-invest.php'; ?>
            </div>

            <div class="right-cont">
                <div id="announcements" class="info">
                    <div id="inv_title" class="title" wow="fadeInUp"><?=$cate[ln('Name')]; ?> <?=$cate[ln('Tip')]?'<span>('.$cate[ln('Tip')].')</span>':''?></div>

                    <div class="selectBox relative" wow="fadeInUp">
                        <?php if($YearId) {
                            $new_year = db::get_one('wb_invest_category', "Id = '{$YearId}'", "*");
                        ?>
                            <div class="top pointer"><?=$new_year['Name']; ?></div>
                        <?php } else { ?>
                            <div class="top pointer"><?=l('根据年份查看','View by Year'); ?></div>
                        <?php } ?>

                        <div class="two_box hide">
                            <div class="cont">
                                <?php foreach((array)$All_Year as $k => $v) { ?>
                                    <a href="?year=<?=$v['Id']; ?>" class="li trans block"><?=$v['Name']; ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <?php if($page_list['row'] ) {?>
                    <div class="cont">
                        <div class="list">
                            <?php foreach((array)$page_list['row'] as $k => $v) {?>
                                <div class="item trans flex-middle2 flex-between" wow="fadeInUp">
                                    <div class="time">
                                        <div class="day trans text-center"><?=date('d', (int)$v['AddTime']); ?></div>
                                        <div class="year trans text-center"><?=date('Y.m', (int)$v['AddTime']); ?></div>
                                    </div>

                                    <a href="<?=img::get($v['File']); ?>" target="_blank" class="name trans">
                                        <div class="txt"><?=$v['Name']; ?></div>
                                    </a>

                                    <a href="<?=img::get($v['File']); ?>" target="_blank" class="down flex-max2 trans">
                                        <div class="icon m-pic trans"><img class="svg" src="/images/about/invest/down.svg" /></div>
                                        <div class="txt text-center">PDF</div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>

                        <?php include 'inc/page.php'; ?>
                    </div>
                    <?php } else { ?>
                        <div class="not_tip blog block50" wow="fadeInUp"><?=l('暂时没有相关内容，敬请期待！','There is currently no relevant content, please stay tuned!');?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

	<?php include 'inc/footer.php'; ?>
	
</body>
</html>
<script>
    // 点击展开
    $(document).on('click','#announcements .selectBox .top',function(){
        $(this).toggleClass('cur');
        $(this).parents('.selectBox').toggleClass('cur');
        $(this).next('.two_box').slideToggle();
    });

    // 鼠标移出,收起
    $(document).on('mouseleave','#announcements .selectBox .two_box',function(){
        $(this).slideToggle();
    });
</script>