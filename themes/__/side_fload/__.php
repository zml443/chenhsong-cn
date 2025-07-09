<?php

// $lyicon = array(
//     'fax' => 'thicon-chuanzhen2',
//     'tel' => 'thicon-dianhuaphone-fill',
//     'consult' => 'thicon-kefu',
//     'facebook' => 'thicon-facebook',
//     'skype' => 'thicon-skype',
//     'qq' => 'thicon-QQ',
//     'qrcode' => 'thicon-QRcode',
//     'wechat' => 'thicon-weixin',
//     'email' => 'lyicon-email',
//     'link' => 'lyicon-link',
// );

// $row = db::all("select * from wb_service order by MyOrder asc,Id asc");
$row = wb_service::all();
// d($row);
?>
<style>
    .lysidefloadbox{
        --sideBgColor:var(--mainColor);
        z-index: 20;
    }
</style>