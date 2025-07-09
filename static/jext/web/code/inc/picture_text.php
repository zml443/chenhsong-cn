<?php 
 /**  
 * 图片合并  
 **/  
include '../../../php/init.php';

//  全部图片
 $pic_list  = array(
    array(
        'number' => '01',
        'tag' => array('皮卡丘', '黄色')
    ),
    array(
        'number' => '02',
        'tag' => array('杰尼龟', '蓝色', 'glass')
    ),
    array(
        'number' => '03',
        'tag' => array('小火龙', '红色')
    ),
    array(
        'number' => '04',
        'tag' => array('大眼蝇', '紫色')
    ),
    array(
        'number' => '05',
        'tag' => array('宝石海星', '棕色')
    ),
    array(
        'number' => '06',
        'tag' => array('丘狐', '棕色')
    ),
    array(
        'number' => '07',
        'tag' => array('胖丁', '粉色')
    ),
    array(
        'number' => '08',
        'tag' => array('蛋蛋', '黄色')
    ),
    array(
        'number' => '09',
        'tag' => array('乘龙', '蓝色')
    ),
    array(
        'number' => '10',
        'tag' => array('瓦斯', '紫色')
    ),
    array(
        'number' => '11',
        'tag' => array('可达鸭', '橙色')
    ),
    array(
        'number' => '12',
        'tag' => array('蒜头王八', '绿色')
    ),
    array(
        'number' => '13',
        'tag' => array('鲤鱼王', '红色')
    ),
    array(
        'number' => '14',
        'tag' => array('三磁体', '蓝色')
    ),
    array(
        'number' => '15',
        'tag' => array('喵喵', '黄色')
    ),
 );

// 随机图
    // 随机9张图
    $pic_list_rand_img = array();
    // 随机9张图里全部不重复的tag
    $all_tab = array();
    for($i=0;$i<9;$i++){
        $num = mt_rand(0,count($pic_list)-1);
        if(!in_array($pic_list[$num], $pic_list_rand_img)){
            $pic_list_rand_img[] = $pic_list[$num];

            foreach ($pic_list[$num]['tag'] as $v) {
                if(!in_array($v, $all_tab)){
                    $all_tab[] = $v;
                }
            }
        }else{
            $i--;
        }
    }

    // 随机9张图 的序号
    $all_tab_rand_number = array();

//  随机需要验证的标签
    $all_tab_rand = $all_tab[mt_rand(0,count($all_tab)-1)];

//  通过标签去选中的9张图里拿取标签对应的 图片序号
    foreach ($pic_list_rand_img as $key => $value) {
        $all_tab_rand_number[] = $value['number'];
        foreach($value['tag'] as $v_tag){
            if($all_tab_rand == $v_tag){
                // 需要验证的图片序号
                $all_tab_rand_index[] = $key+1;
            }
        }
    }

// 生成九宫格图片的图片序号
 $_SESSION['PCodeNumber_'.$_GET['name']] = implode(',',$all_tab_rand_number);
// 存储验证图片的序号
 $_SESSION['PictureCode_'.$_GET['name']] = implode(',',$all_tab_rand_index);

 exit(str::json(array(
    'msg' => "请选择以下标签:$all_tab_rand",
    'tag' => $all_tab_rand,
    'ret' => 1
 )));
?>