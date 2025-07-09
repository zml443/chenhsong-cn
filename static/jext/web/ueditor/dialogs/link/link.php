<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link type="text/css" href="../../../../css/global.css" rel="stylesheet">
<script type='text/javascript' src='../../../../jext.js' ></script>
<?php
	if(!isset($_GET['ddLinks'])){
		echo '<script type="text/javascript" src="../internal.js"></script>';
	}
?>
<style type="text/css">
	/**{margin:0;padding:0;color: #333;}*/
	table{font-size: 12px;margin: 10px;line-height: 30px}
	.txt{width:300px;height:21px;line-height:21px;border:1px solid #d7d7d7;}

	.dd-iframe{margin:17px}
	.dd-iframe .m1{width:147px; height:200px; padding-left:3px; border-right:#e0e3e5 1px solid;}
	.dd-iframe .m1 li{height:40px; line-height:40px; background:url(/images/lo3.jpg) left center no-repeat; color:#333; font-size:14px; padding-left:24px; cursor:pointer;}
	.dd-iframe .m1 li:hover ,
	.dd-iframe .m1 li.cur{background:url(/images/lo2.jpg) left center no-repeat;}
	.dd-iframe .m2{width:298px;}
	.dd-iframe .m2 .m2-0 span{ color:#999999; font-size:14px; padding-top:0;}
	.dd-iframe .m2 .m2-0 img{margin-bottom:20px;}
	/*.dd-iframe .m2 .m2-1{width:285px; height:200px; margin:0 auto;}*/
	.dd-iframe .m2 .m2-1 [mcscroll]{max-height:200px;}
	.dd-iframe .m2 .m2-1 .m2-1-0{color:#4fa4df; font-size:12px; padding:0 0 15px;}
	.dd-iframe .m2 .m2-1 .m2-1-1{/*width:285px;*/ border-bottom:#e0e3e5 1px solid; padding-bottom:13px; color:#333333; font-size:16px; background:url(/images/lo5.jpg) 255px 8px no-repeat; cursor:pointer;}
	.dd-iframe .m2 .m2-0 ,
	.dd-iframe .m2 .m2-1 ,
	.dd-iframe .m2 .m2-2 ,
	.dd-iframe .m2 .m2-3{/*width:285px;*/ height:200px; margin-left:20px;}
	.dd-iframe .m2 .m2-2 .m2-2-0 ,
	.dd-iframe .m2 .m2-3 .m2-3-0{color:#4fa4df; font-size:12px; margin-bottom:15px;}
	.dd-iframe .m2 .m2-2 .m2-2-1 ,
	.dd-iframe .m2 .m2-3 .m2-3-1{/*width:285px;*/ border-bottom:#e0e3e5 1px solid; padding-bottom:13px;}
	.dd-iframe .m2 .m2-2 .m2-2-1 input ,
	.dd-iframe .m2 .m2-3 .m2-3-1 input{width:90%; border:none; /*color:#cccccc;*/ font-size:14px;}
</style>
</head>
<body>
<?php
	session_start();
	if(@$_SESSION['Web']['WebId']){
?>

	<div class='mid dd-iframe'>
		<div class='fl m1 m-pic text-left'>
		    <ul v-middle inline-block tab='[link-style-edit]' fn='chooseLink()'>
	            <li trans class='cur'>无链接</li>
	            <li trans>网页</li>
	            <li trans>网址</li>
	            <li trans>电子邮件</li>
		    </ul>
	    </div>
	    <div class='fl m2' link-style-edit>
            <div class='m2-0'>
            	<div m-pic maxh>
            		<span inline-block maxw v-middle>
		                <img src='/images/lo4.jpg' /><br />这个元素未链接
		                <input type='hidden' value='javascript:;'>
            		</span>
            	</div>
            </div>
            <div class='m2-1' hide>
            	<div m-pic text-left maxh>
            		<span inline-block maxw v-middle>
		                <div class='m2-1-0'>选择页面</div>
		                <div class='m2-1-1'>首页</div>
            		</span>
	                <span class='m2-1-2 hide v-middle' mcscroll></span>
	                <input type='hidden'>
            	</div>
            </div>
            <div class='m2-2' hide>
            	<div m-pic text-left maxh>
            		<span inline-block maxw v-middle>
		                <div class='m2-2-0'>网址</div>
		                <div class='m2-2-1'>
		                    <input type='text' placeholder='www.vishining.com' name="ddWeb" />
		                </div>
            		</span>
            	</div>
            </div>
            <div class='m2-3' hide>
            	<div m-pic text-left maxh>
            		<span inline-block maxw v-middle>
		                <div class='m2-3-0'>邮箱地址</div>
		                <div class='m2-3-1'><input type='text' placeholder='Bruce@szlianya.com' name="ddEmail" /></div>
            		</span>
            	</div>
            </div>
	    </div>
	    <div class='clean'></div>
	</div>
	<input class="txt" id="href" type="text" hide />
	<input class="txt" id="text" type="text" hide disabled="true"/>
	<input class="txt" id="title" type="text" hide />
	<input id="target" type="checkbox" hide />
	<input id="msg" hide />
	<style>
		.navpage{vertical-align:middle; display:inline-block;}
		.navpage .one .a,
		.navpage .one .b,
		.navpage .one .e,
		.navpage .one .d{display:none;}
		.navpage .one{height:36px;}
		.navpage .one .c{line-height:36px; color:#333; font-size:15px;}
	</style>
	<script>
		function chooseLink(){
			var i=this.attr('index');
			var a=$(this.parent().attr('tab')).find('[index="'+i+'"]');
			var u=a.find('input').val();
			if(i=='1'){
				$('#href').val('/'+u);
			}else{
				$('#href').val(u);
			}
			console.log(u);
		}
	</script>

<?php }else{?>

    <table>
        <tr>
            <td><label for="text"> <var id="lang_input_text"></var></label></td>
            <td><input class="txt" id="text" type="text" disabled="true"/></td>
        </tr>
        <tr>
            <td><label for="href"> <var id="lang_input_url"></var></label></td>
            <td><input class="txt" id="href" type="text" /></td>
        </tr>
        <tr>
            <td><label for="title"> <var id="lang_input_title"></var></label></td>
            <td><input class="txt" id="title" type="text"/></td>
        </tr>
        <tr>
             <td colspan="2">
                 <label file-selector='manage' fn='WP.upload_fn' style='font-size:12px;color:#0899ea;'>选择文件</label>
             </td>
        </tr>
        <tr>
             <td colspan="2">
                 <label for="target"><var id="lang_input_target"></var></label>
                 <input id="target" type="checkbox"/>
                 　　
                 <label for="target">rel="nofllow"</label>
                 <input id="rel_nofllow" type="checkbox"/>
             </td>
        </tr>
        <tr>
            <td colspan="2" id="msg"></td>
        </tr>
    </table>
    <script>
	    WP.upload_fn = {
	    	change: function(obj, files){
		        var href_obj =  obj.parents('table').find('#href');
		        var target_obj =  obj.parents('table').find('#target');
		        var files_url = files[0].path;
		        href_obj.val(files_url);
		        target_obj.attr('checked', 'checked');
		    }
	    };
    </script>

<?php }?>

	<script>
		function changeLink(links){
			links=links || '';
			links=links.toString();
			var i=3;
			var u=links.indexOf('/')==0?links.substring(1):links;
			var page=$('.m2-1 .m2-1-2').find('dd[jump-page="'+u+'"]');
			if(links.indexOf("mailto:")>=0){
				i=3;
				$('[name=ddEmail],#href').val(links.replace("mailto:",""));
		　　}else if(page.size()){
				i=1;
				$('.m2-1 .m2-1-1').html(page.find('[nav-name]').text());
				$('.m2-1 input').val(u);
				$('#href').val('/'+u);
		　　}else if(links && links!='javascript:;'){
				i=2;
				$('[name=ddWeb],#href').val(links.replace("<?='http://'.$_SERVER['HTTP_HOST'].'/ly200/'?>",""));
			}else{
				i=0;
				$('#href').val('javascript:;');
			}
			$(".dd-iframe").find("li:eq("+i+")").addClass('cur').siblings().removeClass("cur");
		}
		if(typeof(WP.Nav.data)!='undefined'){
			$('.m2-1 .m2-1-2').html(WP.Nav.data).find('[jump-page]').click(function(){
				var u=$(this).attr('jump-page'); 
				var n=$(this).find('[nav-name]').text();
				$('#href').val('/'+u);
				$('.m2-1 .m2-1-0,.m2-1 .m2-1-1').removeClass('hide');
				$('.m2-1 .m2-1-2').addClass('hide').removeClass('inline-block');
				$('.m2-1 .m2-1-1').html(n);
				$('.m2-1').find('input').val(u);
			});
			if(!$('.m2-1 input').val()){
				$('.m2-1 .m2-1-2 [jump-page]:eq(0)').click();
			}
			$('.m2-1 .m2-1-1').click(function(){
				$('.m2-1 .m2-1-0,.m2-1 .m2-1-1').addClass('hide');
				$('.m2-1 .m2-1-2').removeClass('hide').addClass('inline-block');
			});
		}
	</script>

	<?php if(isset($_GET['ddLinks'])){ ?>
		<script>
			// 按钮的链接设置
			changeLink(WP.LINKFN.TO.val());
			WP.LINKFN.POP.bd.find('[yes]').click(function(){
				var a = $('.dd-iframe .m2>.cur input');
				var v = a.val();
				if(a.attr('name')=='ddEmail'){
					WP.LINKFN.CALLBACK('mailto:'+v);
				}else{
					WP.LINKFN.CALLBACK(v);
				}
			});
		</script>
	<?php }?>


	<script type="text/javascript">
		var range = editor.selection.getRange(),
			link = range.collapsed ? editor.queryCommandValue( "link" ) : editor.selection.getStart(),
			url,
			text = $G('text'),
			rangeLink = domUtils.findParentByTagName(range.getCommonAncestor(),'a',true),
			orgText;
		link = domUtils.findParentByTagName( link, "a", true );

		$('[name=ddWeb],[name=ddEmail]').on('keydown keyup blur', function(){
			var v=$(this).val();
			if($(this).attr('name')=='ddEmail'){
				$('#href').val('mailto:'+v);
			}else{
				$('#href').val(v);
			}
		});

		if(link){
			url = utils.html(link.getAttribute( '_href' ) || link.getAttribute( 'href', 2 ));
			if(rangeLink === link && !link.getElementsByTagName('img').length){
				text.removeAttribute('disabled');
				orgText = text.value = link[browser.ie ? 'innerText':'textContent'];
				var newurl = rangeLink.getAttribute('href');
				changeLink(newurl);
			}else{
				text.setAttribute('disabled','true');
				text.value = lang.validLink;
			}
		}else{
			if(range.collapsed){
				text.removeAttribute('disabled');
				text.value = '';
			}else{
				text.setAttribute('disabled','true');
				text.value = lang.validLink;
			}
		}
		$G("title").value = url ? link.title : "";
		$G("href").value = url ? url: '';
		$G("target").checked = url && link.target == "_blank" ? true :  false;
		$focus($G("href"));

		function handleDialogOk(){
			var href =$G('href').value.replace(/^\s+|\s+$/g, '');
			if(href){
				/*if(!hrefStartWith(href,["http","/","ftp://",'#'])) {
					href  = "http://" + href;
				}*/
				/*if(href.search(':|^//')<0) {
					href  = "http://" + href;
				}*/
				var obj = {
					'href' : href,
					'target' : $G("target").checked ? "_blank" : '_self',
					'title' : $G("title").value.replace(/^\s+|\s+$/g, ''),
					'_href':href
				};
				if ($G("rel_nofllow").checked) obj.rel = 'nofllow';
				//修改链接内容的情况太特殊了，所以先做到这里了
				//todo:情况多的时候，做到command里
				if(orgText && text.value != orgText){
					link[browser.ie ? 'innerText' : 'textContent'] =  obj.textValue = text.value;
					range.selectNode(link).select()
				}
				if(range.collapsed){
					obj.textValue = text.value;
				}
				editor.execCommand('link',utils.clearEmptyAttrs(obj) );
				dialog.close();
			}
		}
		dialog.onok = handleDialogOk;
		$G('href').onkeydown = $G('title').onkeydown = function(evt){
			evt = evt || window.event;
			if (evt.keyCode == 13) {
				handleDialogOk();
				return false;
			}
		};
		$G('href').onblur = function(){
			if(!hrefStartWith(this.value,["http","/","ftp://",'#'])){
				$G("msg").innerHTML = "<span style='color: red'>"+lang.httpPrompt+"</span>";
			}else{
				$G("msg").innerHTML = "";
			}
		};

		function hrefStartWith(href,arr){
			href = href.replace(/^\s+|\s+$/g, '');
			for(var i=0,ai;ai=arr[i++];){
				if(href.indexOf(ai)==0){
					return true;
				}
			}
			return false;
		}
	</script>
</body>
</html>
