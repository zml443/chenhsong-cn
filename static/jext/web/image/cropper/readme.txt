var image = document.getElementById("image");
        var cropper = new Cropper(image,{
            //裁剪框的比例1/1
            aspectRatio:NaN,
            //视图模式
            viewMode:1,//0，1-,2-,3让图片填满画布
            //开启预览效果
            preview:'.small',
            //拖拽模式
            // dragMode:'crop',//参数：move-可以移动图片和框，crop-拖拽新建框
            dragMode:'move',//参数：move-可以移动图片和框，crop-拖拽新建框
            
            //在调整窗口大小时，会重新渲染cropper
            responsive:true,
            //在调整窗口大小时，恢复裁剪区
            restore:true,
            //检查图片是否为跨域图片
            checkCrossOrigin:true,
            //是否开启遮罩，将未选中的地方暗色处理
            modal:true,
            //是否显示裁剪的虚线
            guides:true,
            //将选中的区域亮色处理
            highlight:true,//默认
            //是否显示网格背景
            background:true,
            //裁剪框是否在图片的中心
            center:true,
            //当初始化的时候（是否自动显示裁剪框）.
            autoCrop:true,
            //当初始化时，裁剪框的大小与原图的比例
            autoCropArea:0.8,//0.8是默认，1是1比1
            //是否允许移动图片
            movable:true,//默认为true
            //是否允许旋转图片(函数调用时)()
            rotatable:true,
            //是否允许翻转图片(问题)
            scalable:true,
            //是否可以缩放图片
         
            zoomable:true,//false为不能放大缩小 
            //是否可以通过触摸的形式来放大图片(手机端)
            zoomOnTouch:true,    

            //是否允许用鼠标来放大货缩小图片
            zoomOnWheel:true,
            //设置鼠标控制缩放的比例
            wheelZoomRatio:0.2,  
            
            //是否可以移动裁剪框
            cropBoxMovable:true,//裁剪框不动，图片动。当movable:true  
            //是否可以调整裁剪框的大小，默认true
            cropBoxResizable:true,

            //设置dragMode 是否可以相互切换（条件：双击鼠标可以切换）
            toggleDragModeOnDblclick:true,

            //设置Container的w和h
            minContainerWidth:0,
            minContainerHeight:200,
            //设置canvas的w和h
            // canvas太大Container装不下
            minCanvasWidth:0,
            minCanvasHeight:0,
            //设置裁剪层
            minCropBoxWidth:0,
            minCropBoxHeight:100,

            //一.crop开始-过程-结束的函数
            //1.当插件准备完成时,执行此函数
            ready:function(e){
                // alert("ready");
            },
            //2.当裁剪框开始移动的时候会执行的函数
            cropstart:function(e){
                // console.log("start");
            },
            //3.裁剪框移动的时候会执行的函数(每一帧都会调用)
            cropmove:function(e){
                // console.log("move");
            },
            //3.裁剪框移动结束的时候会执行的函数
            cropend:function(e){
                // console.log("end");
            },

            //二、重置与清除函数
            //1.在裁剪框发生变化的时候会调用的函数
            crop:function(e){
                // console.log("cropChange"); 
            }
        })

























//将图像以及裁剪重置为初始状态
cropper.reset();
//清除裁剪框
cropper.clear();
//替换图片,参数1：替换的图片，参数二，boolean是否保持原来的比例
cropper.replace("../images/picture.jpg",false);
//解锁
cropper.enable();
//锁定
cropper.disable();
//销毁cropper，并在图像中将整个cropper销毁(将插件销毁)
cropper.destroy();
//移动x轴坐标,移动图片.相对自己的位置
cropper.move(1,0);
//移动y轴坐标
cropper.move(0,1);
//移动到x,有一个具体的坐标
cropper.moveTo(2,0);
//移动到y
cropper.moveTo(0,2);
//放大
cropper.zoom(0.1);
//缩小
cropper.zoom(-0.1);

//放大到，原来的两倍
cropper.zoomTo(2);
//缩小到
cropper.zoomTo(0.2);
//逆时针旋转，度数
cropper.rotate(-45);
//顺时针旋转（正数）
cropper.rotate(45);

//逆时针旋转到（正数）
cropper.rotate(-45);
//顺时针旋转（正数）
cropper.rotate(45);

//沿y轴翻转,当前轴不变，另一轴为-1
cropper.scale(-1,1);

//沿x轴翻转
cropper.scale(1,-1);
//缩放图片x坐标
cropper.scale(-1);
 //缩放图片X坐标
cropper.scaleX(0.5);
//缩放图片Y坐标
cropper.scaleY(2);

//获取数据信息(裁剪框的数据)
console.log(cropper.getData());
//获取数据信息(裁剪框的数据)
cropper.setData({width:200,height:100});
//获取Container的数据信息,没有setContainerData函数console.log(cropper.getContainerData());
//获取image的数据信息,就是图片大小
console.log(cropper.getImageData());
//获取Canvas的数据信息
console.log(cropper.getCanvasData());
//设置Canvas的数据信息
console.log(cropper.setCanvasData({left:0,top:0,width:200,height:200}));
//获得裁剪框的详细数据
console.log(cropper.getCropBoxData());
//获得裁剪框的详细数据
console.log(cropper.setCropBoxData({left:0,top:100,width:00,height:200}));
//获得裁剪后的图片,裁剪后的base64编码 **********重要***********
$("#message").append(cropper.getCroppedCanvas());
//修改裁剪框的长宽比
cropper.setAspectRatio(1/1);
//设置拖拽模式，none,crop,move
cropper.setDragMode("crop");
//获取canvas绘制的剪裁图像。
在这之后，你可以直接将canvas作为图片显示，或使用canvas.toDataURL方法获取图像的数据链接，或者使用canvas.toBlob方法获取一个blob，并通过FormData方法将它更新到服务器上（如果浏览器支持这些API）
cropper.getCroppedCanvas()