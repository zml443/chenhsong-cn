<?php
// 防止胡乱进入
isset($c) || exit;

$navId = 'about';
$navTwoId = 'responsibility';
$navTwoId = 'media_Detail';
$footer_back = 'white';

$RId = (int)$_GET['rid'];
$info = db::get_one('wb_about_responsibility', "Id = '{$RId}' and Language = '{$c['lang']}'", '*');
if(!$info){return false;}

$info = db::get_one('wb_about_responsibility', "Id = '{$RId}' and Language='{$c['lang']}'", '*');
$monitor = db::get_one('wb_about_responsibility',"Id = '{$RId}'",'*');

if($monitor && !$info){
    header("Location: /");
}elseif(!$info){
    return false;
}

$seo = db::seo('wb_about_responsibility',$RId);
$info_name = $info['Name']; 
$editor = db::editor('wb_about_responsibility', $RId, 'Detail');

$about_resp = db::get_all('wb_about_responsibility', "Language = '{$c['lang']}'", "*", 'MyOrder asc, AddTime desc');

?>
<!DOCTYPE html>
<html lang="zh-cn">
<?php include 'inc/style_script.php';?>
<body>
	<?php include 'inc/header.php';?>

    <section id="media-bread">
        <div class="cw1400 content" wow='fadeInUp'>
            <a href="/"><?=l('首页','Home'); ?></a>
            <span>/</span>
            <a href="/blog"><?=l('关于我们','About'); ?></a>
            <span>/</span>
            <a href="/responsibility"><?=l('社会责任','Responsibility'); ?></a>
            <span>/</span>
            <a href="javascript:;"><?=l('详情','Detail'); ?></a>
        </div>
    </section>

	<section id="media-activity-detail" class="resp">
        <div class="cw1400">
            <div class="content flex-between">
                <div class="word">
                    <div class="top" wow='fadeInUp'>
                        <div class="name" wow='fadeInUp'><?=$info_name; ?></div>
                    </div>

                    <div class="detail" wow='fadeInUp'><?=nl2br($editor); ?></div>

                    <div class="btn_box" wow='fadeInUp'>
                        <div class="btn m-pic"><img src="/images/activity/weixin.svg" class="svg wechat trans" share='wechat' alt=""></div>
                        <div class="btn m-pic"><img src="/images/activity/sina.svg" class="svg sina trans" share='sina' alt=""></div>
                        <div class="btn m-pic"><img src="/images/activity/facebook.svg" class="svg facebook trans" share='facebook' alt=""></div>
                        <div class="btn m-pic"><img src="/images/activity/linkedin.svg" class="svg linkedin trans" share='linkedin' alt=""></div>
                    </div>
                </div>

                <div class="related resp" wow='fadeInUp'>
                    <div class="title" wow='fadeInUp'><?=l('相关资讯','Related Information')?></div>

                    <div class="ul">
                        <?php foreach((array)$about_resp as $k => $v){ 
                            $url = url::set($v, 'wb_about_responsibility.detail');
                            $pic = str::json($v['Pictures'], 'decode');
                            ?>
                            <a href="<?=$v['Url']?$v['Url']:$url;?>" <?=$v['Url']?"target='_blank'":'';?> class="box block b-pic" wow='fadeInUp'>
                                <div class="img i-pic over"><img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" class="max absolute"></div>
                                <div class="name trans"><?=$v['Name']; ?></div>
                            </a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <i class="ind_line ind_line2 block cw1680"></i>

	<?php include 'inc/footer.php';?>
</body>
</html>