;
/*
	快递100物流查询接口
	作者：林庭
	
	【调用说明】
		示例：<div kd100="快递单号" com="单号对应的物流公司编号"></div>
		1、必须传递快递单号以及物流公司编号
		2、物流公司编号请参考该文件所在目录下的文档
		3、配置可在后台开启物流接口配置。也可以在在jext插件目录下的PHP文件夹内kd100.php中配置
		
	【必须的参数】
		kd100：快递单号
		
	【可选的参数】
		com：单号对应的物流公司编号
*/
$.include($.path+'/web/kd100/kd100.css');
$.token(function(VCodeID){
	$("[kd100]").each(function(){
		var box = $(this).attr('box') || this;
		var v = {
			typeCom: $(this).attr('com'),
			typeNu: $(this).attr('kd100'),
			VCodeID: VCodeID
		};
		if (v.typeNu && v.VCodeID) {
			$.post($.path + "php/api/kd100/kd100.php", v, function (html) {
				$(box).html(html);
			},'html');
		}
	});
});