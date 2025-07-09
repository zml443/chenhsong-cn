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

 
 $path_str = $_SESSION['PCodeNumber_'.$_GET['name']];
//  $path_str = '01,03,05,06,10,11,12,13,14';
 $path_arr = explode(",",$path_str);

 foreach ($path_arr as $value) {
    $pic_list_rand_path[] = 'images/'.$value.'.jpg';
 }


 $pic_list = $pic_list_rand_path;

//  $pic_list = array_slice($pic_list, 0, 9); // 只操作前9个图片  
   
 $bg_w = 300; // 背景图片宽度  
 $bg_h = 300; // 背景图片高度  
   
 $background = imagecreatetruecolor($bg_w,$bg_h); // 背景图片  
 $color = imagecolorallocate($background, 202, 201, 201); // 为真彩色画布创建白色背景，再设置为透明  
 imagefill($background, 0, 0, $color);  
 imageColorTransparent($background, $color);  
   
 $pic_count = count($pic_list);  
 $lineArr = array(); // 需要换行的位置  
 $space_x = 0;  
 $space_y = 0;  
 $line_x = 0;  
 switch($pic_count) {  
    case 1: // 正中间  5
        $start_x = intval($bg_w/4); // 开始位置X  
        $start_y = intval($bg_h/4); // 开始位置Y  
        $pic_w = intval($bg_w/2); // 宽度  
        $pic_h = intval($bg_h/2); // 高度  
    break;  
    case 2: // 中间位置并排  4
        $start_x = 0;  
        $start_y = intval($bg_h/4) ;  
        $pic_w = intval($bg_w/2) ;  
        $pic_h = intval($bg_h/2) ;  
        // $space_x = 5;  
    break;  
    case 3:  //2?
        $start_x = 40; // 开始位置X  
        $start_y = 0; // 开始位置Y  
        $pic_w = intval($bg_w/2) ; // 宽度  
        $pic_h = intval($bg_h/2) ; // 高度  
        $lineArr = array(2);  
        // $line_x = 4;  
    break;  
    case 4:  //3
        $start_x = 0; // 开始位置X  
        $start_y = 0; // 开始位置Y  
        $pic_w = intval($bg_w/2) ; // 宽度  
        $pic_h = intval($bg_h/2) ; // 高度  
        $lineArr = array(3);  
        // $line_x = 4;  
    break;  
    case 5:  
        $start_x = 30; // 开始位置X  
        $start_y = 30; // 开始位置Y  
        $pic_w = intval($bg_w/3) ; // 宽度  
        $pic_h = intval($bg_h/3) ; // 高度  
        $lineArr = array(3);  
        // $line_x = 5;  
    break;  
    case 6:  //7
        $start_x = 5; // 开始位置X  
        $start_y = 30; // 开始位置Y  
        $pic_w = intval($bg_w/3) ; // 宽度  
        $pic_h = intval($bg_h/3) ; // 高度  
        $lineArr = array(4);  
        // $line_x = 5;  
    break;  
    case 7:  //
        $start_x = 53; // 开始位置X  
        $start_y = 0; // 开始位置Y  
        $pic_w = intval($bg_w/3) ; // 宽度  
        $pic_h = intval($bg_h/3) ; // 高度  
        $lineArr = array(2,5);  
        // $line_x = 5;  
    break;  
    case 8:  
        $start_x = 30; // 开始位置X  
        $start_y = 0; // 开始位置Y  
        $pic_w = intval($bg_w/3) ; // 宽度  
        $pic_h = intval($bg_h/3) ; // 高度  
        $lineArr = array(3,6);  
        // $line_x = 5;  
    break;  
    case 9:  
        $start_x = 0; // 开始位置X  
        $start_y = 0; // 开始位置Y  
        $pic_w = intval($bg_w/3) ; // 宽度  
        $pic_h = intval($bg_h/3) ; // 高度  
        $lineArr = array(4,7);  
        // $line_x = 5;  
    break;  
}  
foreach( $pic_list as $k=>$pic_path ) {  
    $kk = $k + 1;  
    if ( in_array($kk, $lineArr) ) {  
        $start_x = $line_x;  
        $start_y = $start_y + $pic_h + $space_y;  
    }  
    $pathInfo = pathinfo($pic_path);  
    switch( strtolower($pathInfo['extension']) ) {  
        case 'jpg':  
        case 'jpeg':  
            $imagecreatefromjpeg = 'imagecreatefromjpeg';  
        break;  
        case 'png':  
            $imagecreatefromjpeg = 'imagecreatefrompng';  
        break;  
        case 'gif':  
        default:  
            $imagecreatefromjpeg = 'imagecreatefromstring';  
            $pic_path = file_get_contents($pic_path);  
        break;  
    }  
    $resource = $imagecreatefromjpeg($pic_path);  
    // $start_x,$start_y copy图片在背景中的位置  
    // 0,0 被copy图片的位置  
    // $pic_w,$pic_h copy后的高度和宽度  
    imagecopyresized($background,$resource,$start_x,$start_y,0,0,$pic_w,$pic_h,imagesx($resource),imagesy($resource)); // 最后两个参数为原始图片宽度和高度，倒数两个参数为copy时的图片宽度和高度  
    $start_x = $start_x + $pic_w + $space_x;  
}  
   
header("Content-type: image/jpg");  
imagejpeg($background); 
imagegif($background, "./hero_gam.png");  

?>