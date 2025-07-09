<?php 
$cid = (int)$_POST['cid'];
if($cid == 0){
    $where = 1;
}else{
    $where = "wb_contact_category_id = '{$cid}'";
}
$contact_affiliate = db::get_all('wb_contact_affiliate', $where, "*", 'MyOrder asc, Id asc');
?>

<div class="list flex-wrap">
    <?php foreach((array)$contact_affiliate as $k => $v) {?>
    <div class="li" wow="fadeInUp">
        <div class="name"><?=$v[ln('Name')]; ?></div>
        <a href="mailto:<?=$v['Email']; ?>" class="email inline trans"><?=$v['Email']; ?></a>
    </div>
    <?php }?>
</div>