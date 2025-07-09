<?php


// 有效时间
if($_POST['EfTimeType'] == 'FixedTime' && (!$_POST['EfTime0'] || !$_POST['EfTime1'])) {
    exit(str::json(array(
        'ret' => 0,
        'msg' => str_replace("{{name}}", $this->dbc['EfTime']['Name'], language('notes.notnull')),
    )));
}
if ($_POST['EfTime1']) {
    if (strpos($_POST['EfTime1'],'-')) {
        $_POST['EfTime1'] = strtotime($_POST['EfTime1']) + 86399;
    } else {
        $_POST['EfTime1'] = strtotime(date('Y-m-d', $_POST['EfTime1'])) + 86399;
    }
}


if($_POST['EfTimeType'] == 'GetTime' && (!$_POST['EfTimeNumber'] || !$_POST['EfTimeUnit'])) {
    exit(str::json(array(
        'ret' => 0,
        'msg' => str_replace("{{name}}", $this->dbc['EfTime']['Name'], language('notes.notnull')),
    )));
}
$_POST['EfTimeType'] != 'FixedTime' && $_POST['EfTime0'] = '';
$_POST['EfTimeType'] != 'FixedTime' && $_POST['EfTime1'] = '';
$_POST['EfTimeType'] != 'GetTime' && $_POST['EfTimeNumber'] = '';
$_POST['EfTimeType'] != 'GetTime' && $_POST['EfTimeUnit'] = '';




// 适用顾客
if($_POST['MemberType'] == 'group' && !$_POST['MemberGroupType']) {
    exit(str::json(array(
        'ret' => 0,
        'msg' => str_replace("{{name}}", language('{/panel.select_member.check.group/}'), language('notes.notnull')),
    )));
}
if($_POST['MemberType'] == 'tag' && !$_POST['MemberTag']) {
    exit(str::json(array(
        'ret' => 0,
        'msg' => str_replace("{{name}}", language('{/panel.select_member.check.tag/}'), language('notes.notnull')),
    )));
}
if($_POST['MemberType'] == 'id' && !$_POST['MemberId']) {
    exit(str::json(array(
        'ret' => 0,
        'msg' => str_replace("{{name}}", language('{/panel.select_member.check.id/}'), language('notes.notnull')),
    )));
}
$_POST['MemberType'] != 'group' && $_POST['MemberGroupType'] = '';
$_POST['MemberType'] != 'tag' && $_POST['MemberTag'] = '';
$_POST['MemberType'] != 'id' && $_POST['MemberId'] = '';



// 适用产品
if($_POST['UseProType'] == 'id' && !$_POST['UseProId']) {
    exit(str::json(array(
        'ret' => 0,
        'msg' => str_replace("{{name}}", language('{/panel.select_products.id/}'), language('notes.notnull')),
    )));
}
if($_POST['UseProType'] == 'category' && !$_POST['UseProCategory']) {
    exit(str::json(array(
        'ret' => 0,
        'msg' => str_replace("{{name}}", language('{/panel.select_products.category/}'), language('notes.notnull')),
    )));
}
$_POST['UseProType'] != 'id' && $_POST['UseProId'] = '';
$_POST['UseProType'] != 'category' && $_POST['UseProCategory'] = '';



// 优惠类型
if($_POST['FreeType'] == 'Money' && !$_POST['FreeMoney']) {
    exit(str::json(array(
        'ret' => 0,
        'msg' => str_replace("{{name}}", language('{/panel.free.free_money/}'), language('notes.notnull')),
    )));
}
if($_POST['FreeType'] == 'Discount' && !$_POST['FreeDiscount']){
    exit(str::json(array(
        'ret' => 0,
        'msg' => str_replace("{{name}}", language('{/panel.free.free_discount/}'), language('notes.notnull')),
    )));
}
$_POST['FreeType'] != 'Money' && $_POST['FreeMoney'] = '';
$_POST['FreeType'] != 'Discount' && $_POST['FreeDiscount'] = '';



// 优惠券使用条件
if($_POST['FullType'] == 'Money' && !$_POST['FullMoney']) {
    exit(str::json(array(
        'ret' => 0,
        'msg' => str_replace("{{name}}", language('{/panel.free.full_money/}'), language('notes.notnull')),
    )));
}
if($_POST['FullType'] == 'Number' && !$_POST['FullNumber']){
    exit(str::json(array(
        'ret' => 0,
        'msg' => str_replace("{{name}}", language('{/panel.free.full_number/}'), language('notes.notnull')),
    )));
}
$_POST['FullType'] != 'Money' && $_POST['FullMoney'] = '';
$_POST['FullType'] != 'Number' && $_POST['FullNumber'] = '';


// 发放量
if(!$_POST['DistributionQty'] && !$_POST['DistributionQtyType']) {
    exit(str::json(array(
        'ret' => 0,
        'msg' => str_replace("{{name}}", $this->dbc['DistributionQty']['Name'], language('notes.notnull')),
    )));
}


// 没人限定使用次数
if(!$_POST['UseQty'] && !$_POST['UseQtyType']) {
    exit(str::json(array(
        'ret' => 0,
        'msg' => str_replace("{{name}}", $this->dbc['UseQty']['Name'], language('notes.notnull')),
    )));
}




// d($_POST);
// // 不允许系统自动修改数据
// exit;