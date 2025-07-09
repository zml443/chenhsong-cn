<?php
// 防止胡乱进入
isset($c) || exit;

$navId = 'media';
$navTwoId = 'media_Detail';
$footer_back = 'white';

$BId = (int)$_GET['bid'];
// $info = db::get_one('wb_blog', "Id = '{$BId}' and Language = '{$c['lang']}' and IsSaleOut != 1", '*');
// if(!$info){return false;}

$info = db::get_one('wb_blog', "Id = '{$BId}' and IsSaleOut = 0 and Language='{$c['lang']}'", '*');
$monitor = db::get_one('wb_blog',"Id = '{$BId}' and IsSaleOut = 0",'*');

if($monitor && !$info){
    header("Location: /");
}elseif(!$info){
    return false;
}

$seo = db::seo('wb_blog',$BId);
$info_name = $info['Name']; 
$CateId = $info['wb_blog_category_id'];
$InfoCate = db::get_one('wb_blog_category', "Id = '{$CateId}'", "Id,".ln('Name'));
$editor = db::editor('wb_blog', $BId, 'Detail');

$prev = db::get('wb_blog::prev',array('id'=>$BId));
$next = db::get('wb_blog::next',array('id'=>$BId));
$prevName = $prev?$prev['Name']:l('无', 'Not');
$nextName = $next?$next['Name']:l('无','Not');

// 相关资讯
$blog_id = $info['wb_blog_id'];
if($blog_id){
	$where = "Id in ({$blog_id}) and IsSaleOut != 1 and Language = '{$c['lang']}'";
	$rel_blog = db::get_limit('wb_blog', $where, '*', 'MyOrder asc, AddTime desc',0,5);
}else{
	$where = "wb_blog_category_id = '{$CateId}' and IsSaleOut != 1 and Language = '{$c['lang']}'";
	$rel_blog = db::get_limit('wb_blog', $where, '*', 'MyOrder asc, AddTime desc',0,5);
}
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
            <a href="/blog"><?=l('媒体中心','Media Center'); ?></a>
            <span>/</span>
            <?php if($InfoCate) {?>
            <a href="<?=url::set($InfoCate, 'wb_blog_category'); ?>"><?=$InfoCate[ln('Name')]; ?></a>
            <span>/</span>
            <?php } ?>
            <a href="javascript:;"><?=l('详情','Detail'); ?></a>
        </div>
    </section>

	<section id="media-activity-detail">
        <div class="cw1400">
            <div class="content flex-between">
                <div class="word">
                    <div class="top" wow='fadeInUp'>
                        <div class="name" wow='fadeInUp'><?=$info_name; ?></div>
                        <div class="time" wow='fadeInUp'><?=date('Y.m.d', (int)$info['AddTime']); ?></div>
                    </div>

                    <div class="detail" wow='fadeInUp'><?=nl2br($editor); ?></div>

                    <div class="btn_box" wow='fadeInUp'>
                        <div class="btn"><img src="/images/activity/weixin.svg" class="svg wechat trans" share='wechat' alt=""></div>
                        <div class="btn"><img src="/images/activity/sina.svg" class="svg sina trans" share='sina' alt=""></div>
                        <div class="btn"><img src="/images/activity/facebook.svg" class="svg facebook trans" share='facebook' alt=""></div>
                        <div class="btn"><img src="/images/activity/linkedin.svg" class="svg linkedin trans" share='linkedin' alt=""></div>
                    </div>
                </div>

                <div class="related" wow='fadeInUp'>
                    <div class="title" wow='fadeInUp'><?=l('相关资讯','Related Information')?></div>

                    <div class="ul">
                        <?php foreach((array)$rel_blog as $k => $v){ 
							$url = $v['Url'] ? $v['Url'] : url::set($v, 'wb_blog.detail');
                            $pic = str::json($v['Pictures'], 'decode');
                            ?>
                            <div class="box block b-pic" wow='fadeInUp'>
                                <div class="img i-pic over">
                                    <a href="<?=$url; ?>" <?=$v['Url'] ?"target='_blank'":''; ?> ><img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" class="max absolute"></a>

                                    <?php if(img::get($v['Video'])){ ?>
                                        <div class="play trans5 absolute m-pic pointer" ly-video src="<?=img::get($v['Video']); ?>">
                                            <img src="/images/icon/play.svg" class="svg trans" alt="<?=$v['Name']?>" />
                                        </div>
                                    <?php }?>
                                </div>
                                <a href="<?=$url; ?>" <?=$v['Url'] ?"target='_blank'":''; ?>  class="name block trans"><?=$v['Name']; ?></a>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>

            <div class="page" wow='fadeInUp'>
                <a href="<?=$prev['Href']?$prev['Href']:'javascript:;'; ?>" class="pn block">
                    <div class="text"><?=l('上一篇', 'Prev'); ?></div>
                    <div class="name trans text-over"><?=$prevName; ?></div>
                </a>
                <a href="<?=$next['Href']?$next['Href']:'javascript:;';?>" class="pn block">
                    <div class="text"><?=l('下一篇', 'Next'); ?></div>
                    <div class="name trans text-over"><?=$nextName; ?></div>
                </a>
			</div>
            
            <div class="related mobile">
                <div class="title"><?=l('相关资讯','Related Information')?></div>
                <div class="ul">
                    <?php foreach((array)$rel_blog as $k => $v){ 
                        $url = $v['Url'] ? $v['Url'] : url::set($v, 'wb_blog.detail');
                        $pic = str::json($v['Pictures'], 'decode');
                        ?>
                        <div class="box block b-pic">
                            <div class="img i-pic">
                                <a href="<?=$url; ?>" <?=$v['Url'] ?"target='_blank'":''; ?> ><img  src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" class="max absolute"></a>
                                
                                <?php if(img::get($v['Video'])){ ?>
                                    <div class="play trans5 absolute m-pic pointer" ly-video src="<?=img::get($v['Video']); ?>">
                                        <img src="/images/icon/play.svg" class="svg trans" alt="<?=$v['Name']?>" />
                                    </div>
                                <?php }?>
                            </div>
                            <a href="<?=$url; ?>" <?=$v['Url'] ?"target='_blank'":''; ?>  class="name trans"><?=$v['Name']; ?></a>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </section>

	<?php include 'inc/blog-rel.php';?>

	<?php include 'inc/footer.php';?>
</body>
</html>