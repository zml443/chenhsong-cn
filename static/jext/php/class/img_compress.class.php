<?php
/**
 * 图片压缩类：通过缩放来压缩。
 * 如果要保持源图比例，把参数$percent保持为1即可。
 * 即使原比例压缩，也可大幅度缩小。数码相机4M图片。也可以缩为700KB左右。如果缩小比例，则体积会更小。
 *
 * 结果：可保存、可直接显示。
 */
class img_compress{
    private $src;
    private $image;
    private $imageinfo;
    private $percent = 0.5;
    /**
     * 图片压缩
     * @param $src 源图
     * @param float $percent  压缩比例
     */
    public function __construct($src, $percent=1){
        $this->src = $src;
        $this->percent = $percent;
    }
    /** 
     * 高清压缩图片
     * @param string $saveName  提供图片名（可不带扩展名，用源图扩展名）用于保存。或不提供文件名直接显示
     */
    public function init($saveName=''){
        ini_set('memory_limit', '2000M');
        ini_set('gd.jpeg_ignore_warning', true);
        $this->_openImage();
        if(!empty($saveName)) $this->_saveImage($saveName);  //保存
        else $this->_showImage();
    }
    /**
     * 内部：打开图片
     */
    private function _openImage(){
        $info = getimagesize($this->src);
        list($width, $height, $type, $attr) = $info;
        if($info['mine'] == 'image/png'){
            $limitSize = 1920;
        }else
            $limitSize = 2500;
        // 限制宽度&尺寸
        if($width > $limitSize) {
            $this->percent = $limitSize / $width;
        }
        $info['width'] = $width;
        $info['height'] = $height;
        $info['type'] = image_type_to_extension($type,false);
        $info['attr'] = $attr;
        $this->imageinfo = $info;

        // 创建不同类型的图像
        if(preg_match('/jpe?g/i',$info['mime'])){
			$this->image=imagecreatefromjpeg($this->src);
		}elseif(preg_match('/png/i',$info['mime'])){
			$this->image=imagecreatefrompng($this->src);
		}elseif(preg_match('/gif/i',$info['mime'])){
			$this->image=imagecreatefromgif($this->src);
		}
        $this->_thumpImage();
    }
    /**
     * 内部：操作图片
     */
    private function _thumpImage(){
        $new_width = $this->imageinfo['width'] * $this->percent;
        $new_height = $this->imageinfo['height'] * $this->percent;
        $image_thump = imagecreatetruecolor($new_width,$new_height);
        // 分配颜色，保留png的透明背景色
        $alpha = imagecolorallocatealpha($image_thump, 0, 0, 0, 127);
        imagefill($image_thump, 0, 0, $alpha);
        //将原图复制带图片载体上面，并且按照一定比例压缩,极大的保持了清晰度
        imagecopyresampled($image_thump,$this->image,0,0,0,0,$new_width,$new_height,$this->imageinfo['width'],$this->imageinfo['height']);
        imagedestroy($this->image);
        $this->image = $image_thump;
    }
    /**
     * 输出图片:保存图片则用saveImage()
     */
    private function _showImage(){
        header('Content-Type: image/'.$this->imageinfo['type']);
        $funcs = "image".$this->imageinfo['type'];
        $funcs($this->image);
    }
    /**
     * 保存图片到硬盘：
     * @param  string $dstImgName  1、可指定字符串不带后缀的名称，使用源图扩展名 。2、直接指定目标图片名带扩展名。
     */
    private function _saveImage($dstImgName){
        if(empty($dstImgName)) return false;
        $allowImgs = array('.jpg', '.jpeg', '.png', '.bmp', '.wbmp','.gif', '.webp');   //如果目标图片名有后缀就用目标图片扩展名 后缀，如果没有，则用源图的扩展名
        $dstExt = strrchr($dstImgName ,".");
        $sourseExt = strrchr($this->src ,".");
        if(!empty($dstExt)) $dstExt =strtolower($dstExt);
        if(!empty($sourseExt)) $sourseExt =strtolower($sourseExt);
        //有指定目标名扩展名
        if(!empty($dstExt) && in_array($dstExt,$allowImgs)){
            $dstName = $dstImgName;
        }elseif(!empty($sourseExt) && in_array($sourseExt,$allowImgs)){
            $dstName = $dstImgName.$sourseExt;
        }else{
            $dstName = $dstImgName.$this->imageinfo['type'];
        }

        // d($this->imageinfo);

        $image = $this->image;
        $type = $this->imageinfo['mime'];
        if($type == 'image/jpeg'){
            imagejpeg($image, $dstName);
        } else if ($type == 'image/gif') {
            if($this->ifTransparent($image)) { // 保留图片透明状态
                imageAlphaBlending($image, true);
                imageSaveAlpha($image, true);
                imagegif($image, $dstName);
            } else
                imagegif($image, $dstName);
        } else if($type == 'image/png'){
            if($this->ifTransparent($image)) {
                imageAlphaBlending($image, true);
                imageSaveAlpha($image, true);
                imagepng($image, $dstName);
            } else
                imagepng($image, $dstName);
        }

        // $funcs = "image".$this->imageinfo['type'];
        // $funcs($this->image,$dstName);
        // d('xxx',$this,'大小：',filesize($this->src),filesize($dstName),'路径：',$this->src,$dstName);
    }
    private function ifTransparent($image) {
        for($x = 0; $x < imagesx($image); $x++)
            for($y = 0; $y < imagesy($image); $y++)
                if((imagecolorat($image, $x, $y) & 0x7F000000) >> 24) return true;
        return false;
    }
    /**
     * 销毁图片
     */
    public function __destruct(){
        imagedestroy($this->image);
    }
}









// class ImgCompressor {

//     /**
//      * 可供压缩的类型
//      */
//     private $setting = [
//         'file_type' => [
//             'image/jpeg',
//             'image/png',
//             'image/gif'
//         ]
//     ];
//     private $imagePath;

//     private $imageCompressPath;

//     /**
//      * [
//      *      "0": 879,
//      *      "1": 623,
//      *      "2": 2,
//      *      "3": "width=\"879\" height=\"623\"",
//      *      "bits": 8,
//      *      "channels": 3,
//      *      "mime": "image/jpeg"
//      *  ]
//      */
//     private $imageInfo;

//     private $res = [
//         'code' => 0,
//         'original' => [
//             'name' => 'oldName',
//             'type' => 'imageType',
//             'size' => 'imageSize'
//         ],
//         'compressed' => [
//             'name' => 'newName',
//             'type' => 'imageType',
//             'size' => 'imageSize'
//         ]
//     ];

//     function __construct($fileType = false) {
//         if ($fileType)
//             $this->setting['file_type'] = $fileType;
//     }

//     public function compress(  $level = 0) {
//         if ($level < 0 || $level > 9)
//             throw new \Exception(__METHOD__ . 'Compression level: [0, 9]');

//         $compressImageName = $this->imageCompressPath;

//         $type = $this->imageInfo['mime'];

//         $image = ( 'imagecreatefrom' . basename($type) )($this->imagePath);

//         if($type == 'image/jpeg'){
//             imagejpeg($image, $compressImageName, (100 - ($level * 10)) );
//         } else if ($type == 'image/gif') {
//             if($this->ifTransparent($image)) { // 保留图片透明状态
//                 imageAlphaBlending($image, true);
//                 imageSaveAlpha($image, true);
//                 imagegif($image, $compressImageName);
//             } else
//                 imagegif($image, $compressImageName);

//         } else if($type == 'image/png'){
//             if($this->ifTransparent($image)) {
//                 imageAlphaBlending($image, true);
//                 imageSaveAlpha($image, true);
//                 imagepng($image, $compressImageName, $level);
//             } else
//                 imagepng($image, $compressImageName, $level);
//         }

//         // 销毁图片
//         imagedestroy($image);

//         $this->res['compressed']['size'] = filesize($compressImageName);

//         return $this;
//     }

//     private function ifTransparent($image) {
//         for($x = 0; $x < imagesx($image); $x++)
//             for($y = 0; $y < imagesy($image); $y++)
//                 if((imagecolorat($image, $x, $y) & 0x7F000000) >> 24) return true;
//         return false;
//     }


//     public function set($image, $compressImageName)
//     {
//         try {
//             $this->imageInfo = getImageSize($image);
//         } catch (\Exception $e) {
//             throw new \Exception('不是图片类型');
//         }

//         $this->imagePath = $image;
//         $this->imageCompressPath = $compressImageName;

//         $this->res['original'] = [
//             'name' => $this->imagePath,
//             'type' => $this->imageInfo['mime'],
//             'size' => filesize($this->imagePath)
//         ];

//         $this->res['compressed'] = [
//             'name' => $this->imageCompressPath,
//             'type' => $this->imageInfo['mime'],
//             'size' => ''
//         ];

//         if( in_array($this->imageInfo['mime'], $this->setting['file_type']) )
//             return $this;

//         throw new \Exception(__METHOD__);
//     }

//     function resize($width, $height) {

//         if($width == 0 && $height > 0) {
//             $width = ( $height / $this->imageInfo['1'] ) * $this->imageInfo['0'] ;
//         } else if ($width > 0 && $height == 0) {
//             $height = ( $width / $this->imageInfo['0'] ) * $this->imageInfo['1'] ;
//         } else if ($width <= 0 && $height <= 0) {
//             throw new \Exception('illegal size!');
//         }

//         $imageSrc = ( 'imagecreatefrom' . basename($this->imageInfo['mime']) )($this->imagePath);

//         $image = imagecreatetruecolor($width, $height); //创建一个彩色的底图
//         imagecopyresampled($image, $imageSrc, 0, 0, 0, 0,$width, $height, $this->imageInfo[0], $this->imageInfo[1]);

//         ( 'image' . basename($this->imageInfo['mime']) )($image, $this->imageCompressPath);

//         $this->imagePath = $this->imageCompressPath;

//         $this->res['compressed']['size'] = filesize($this->imageCompressPath);

//         imagedestroy($image);
//         imagedestroy($imageSrc);

//         return $this;
//     }

//     /**
//      * 获取结果
//      * 
//      * @return array
//      * @author 19/1/17 CLZ.
//      */
//     public function get()
//     {
//         return $this->res;
//     }
// }