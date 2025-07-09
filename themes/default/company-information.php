<?php
// 关于我们-投资者关系-公司资料
// 防止胡乱进入
isset($c) || exit;

$navId = 'about';
$navTwoId = 'invest';
$navThreeId = 'information';
$footer_back = 'white';
$seo = db::seo('invest');

$invest_info = db::get_all('wb_invest_information', "1", "*", 'MyOrder asc, Id asc');

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
                <div id="invest_info" class="info over">
                    <div id="inv_title" class="title" wow="fadeInUp"><?=$nav[$navId]['children'][8]['children'][2]['name']; ?></div>

                    <div class="list">
                        <?php 
                        $count = 0; 
                        foreach((array)$invest_info as $k => $v) { 
                            if ($count % 2 == 0) {
                                echo '<div class="line">'; 
                            } 
                            ?>
                            <div class="item" wow="fadeInUp"> 
                                <div class="tit"><?=$v[ln('Name')]; ?></div> 
                                <div class="ul"> 
                                    <?php 
                                    $str = nl2br($v[ln('BriefDescription')]);
                                    $lines = explode('<br />', $str);
                                    foreach($lines as $line){
                                        echo "<div class='li'>$line</div>";
                                    }
                                    ?>
                                </div> 
                            </div> 
                            <?php $count++; 
                            if ($count % 2 == 0 || $count == count($invest_info)) {
                                echo '</div>'; 
                                } 
                            } 
                        ?>
                    </div>
                </div>

                <?php include 'inc/invest-contact.php'; ?>
            </div>
        </div>
    </section>

	<?php include 'inc/footer.php'; ?>
	
</body>
</html>