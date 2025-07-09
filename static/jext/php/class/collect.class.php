<?php 
/*
 * 采集功能的整理
 * By zinn
 * 
 */

class collect {

	public static function create_article_images_task($ImagesAry, $AId, $FromType=0){//将图片添加到采集任务
		foreach((array)$ImagesAry as $img){
			db::insert('jext_collect_article_images', array(
					'FromType'	=>	$FromType,
					'AId'		=>	$AId,
					'SourceUrl'	=>	addslashes(stripslashes($img))
				)
			);
		}
	}

	// 整理网站域名
	public static function www($url){
		$www=explode('/',$url);
		return "{$www[0]}/{$www[1]}/{$www[2]}/";
	}

	// 采集注册网站的seo关键词
	public static function seo($url){
		$www=explode('/',$url);
		return "{$www[0]}/{$www[1]}/{$www[2]}/";
	}

	public static function body ($pageBody) {
		preg_match("/<body.*?>(.*?)<\/body>/is", $pageBody, $res);
		return $res[0];
	}
	
	// 过滤Emoji表情
	public static function filter_emoji($str){
		$str = preg_replace_callback( '/./u',
			function (array $match) {
				return strlen($match[0]) >= 4 ? '' : $match[0];
			},
		$str);
		return $str;
	}

	




	/************************************************采集百度新闻(start)************************************************/
	public static function collect_baidu_url($pageBody,$url){//采集Yahoo搜索列表链接
		$urlAry=array();
		phpQuery::newDocumentHtml($pageBody);
		if(!pq('#content_left a')->length()){//搜索页面列表数据为空，采集完毕！
			return $urlAry;
		}
		foreach(pq('#content_left a') as $a){
			$url=pq($a)->attr('href');
			if(substr_count($url, 'baijiahao.baidu.com')){
				$url=urldecode($url);
				if(!$url || strlen($url)>500) continue;
				$urlAry[]=$url;
			}
		}
		return $urlAry;
	}
	public static function collect_baidu_article($articleBody,$url){//采集baidu文章
		phpQuery::newDocumentHtml(self::body($articleBody));
		$content=pq('#article');
		$www=self::www($url);
		foreach(pq($content)->find('a') as $a){//将站内链接替换成外部链接
			$href=pq($a)->attr('href');
			if(!strstr("^{$href}",'^http')&&!strstr("^{$href}",'^//')){
				$u=$www.ltrim($href,'/');
				pq($a)->attr('href',$u);
			}
		}
		$ImagesAry=array();
		//采集处理图片
		foreach(pq($content)->find('img') as $img){//采集图片
			$src=pq($img)->attr('src');
			if(!strstr("^{$src}",'^http')&&!strstr("^{$src}",'^//')){
				$src=$www.ltrim($src,'/');
			}
			pq($img)->attr('src',$src);
			$ImagesAry[]=$src;
		}
		$Author=pq('.author-name')->text();
		$Time=strtotime(pq('.article-source .date')->text().' '.pq('.article-source .time')->text());
		$Title=pq('.article-title')->text();
		$Contents=pq($content)->find('.article-content')->html();
		$result=array(
			'Author'	=>	$Author,
			'PostTime'	=>	$Time,
			'Title'		=>	addslashes($Title),
			'Contents'	=>	addslashes(self::filter_emoji($Contents)),
			'ImagesAry'	=>	$ImagesAry
		);
		
		return $result;
	}
	/************************************************采集百度新闻(end)************************************************/






	/************************************************采集凤凰网新闻(start)************************************************/
	public static function collect_ifeng_url($pageBody,$url){//采集Yahoo搜索列表链接
		$urlAry=array();
		phpQuery::newDocumentHtml($pageBody);
		if(!pq('.mainM a')->length()){//搜索页面列表数据为空，采集完毕！
			return $urlAry;
		}
		foreach(pq('.mainM a') as $a){
			$url=pq($a)->attr('href');
			if(substr_count($url, 'feng.ifeng.com') || substr_count($url, 'wemedia.ifeng.com')){
				$url=urldecode($url);
				if(!$url || strlen($url)>500) continue;
				$urlAry[]=$url;
			}
		}
		return $urlAry;
	}
	public static function collect_ifeng_article($articleBody,$url){//采集baidu文章
		phpQuery::newDocumentHtml($articleBody);
		if (pq('#__INITIAL_STATE__')->length()) {
			// 比较奇葩，是个json格式的数据
			$con=@explode("var",pq('#__INITIAL_STATE__')->html());
			foreach($con as $k=>$v){
				$val=rtrim(trim(trim(trim($v),"\t"),"\r\n"),';');
				if($val) break;
			}
			$val=ltrim(strstr($val,'='),'=');
			$con=str::json($val);
			$con=$con['originData'];
			$Title=$con['title'];
			$Time=strtotime($con['newsTime']);
			$Author=$con['source'];
			$Contents="<div><div>{$con['contentList'][0][0]['data']}</div></div>";
			$content=pq($Contents);
		} else if (pq('.yc_con_l .yc_con_txt')->length()) {
			$content=pq('.yc_con_l .yc_con_txt');
			$Title=pq('.yc_tit h1')->text();
			$Time=strtotime(pq('.yc_tit .clearfix > span')->text());
			$Author=pq('.yc_tit .clearfix > a:eq(1)')->text();
			// $Contents=pq($content)->html();
		} else {
			$content=pq('.detailBox-2ms7ofXz');
			$Title=pq('.title-14yWv8ay')->text();
			$Time=strtotime(pq('.time-M6w87NaQ')->text());
			$Author=pq('.bref-1X8yFzwh')->text();
			// $Contents=pq($content)->html();
			// $Contents = str_replace(' data-lazyload', ' src', $Contents);
		}
		$www=self::www($url);
		foreach(pq($content)->find('a') as $a){//将站内链接替换成外部链接
			$href=pq($a)->attr('href');
			if(!strstr("^{$href}",'^http')&&!strstr("^{$href}",'^//')){
				$u=$www.ltrim($href,'/');
				pq($a)->attr('href',$u);
			}
		}
		$ImagesAry=array();
		//采集处理图片
		foreach(pq($content)->find('img') as $img){//采集图片
			$src=pq($img)->attr('data-lazyload');
			$src || $src = pq($img)->attr('src');
			if(!strstr("^{$src}",'^http')&&!strstr("^{$src}",'^//')){
				$src=$www.ltrim($src,'/');
			}
			pq($img)->attr('src',$src);
			$ImagesAry[]=$src;
		}
		$Contents=pq($content)->html();
		$result=array(
			'Author'	=>	addslashes($Author),
			'PostTime'	=>	$Time,
			'Title'		=>	addslashes($Title),
			'Contents'	=>	addslashes(self::filter_emoji($Contents)),
			'ImagesAry'	=>	$ImagesAry
		);
		return $result;
	}
	/************************************************采集凤凰网新闻(end)************************************************/



	/************************************************采集新浪新闻(start)************************************************/
	public static function collect_sina_url($pageBody,$url){//采集搜索列表链接
		$urlAry=array();
		$pageBody = self::body($pageBody);
		phpQuery::newDocumentHtml($pageBody);
		if(!pq('#result a')->length()){//搜索页面列表数据为空，采集完毕！
			return $urlAry;
		}
		foreach(pq('#result a') as $a){
			$url=pq($a)->attr('href');
			if(substr_count($url, 'finance.sina.com.cn') || substr_count($url, 'cj.sina.com.cn') || substr_count($url, 't.cj.sina.com.cn') || substr_count($url, 'k.sina.com.cn') || substr_count($url, 'mil.news.sina.com.cn')){
				$url=urldecode($url);
				if(!$url || strlen($url)>500) continue;
				$urlAry[]=$url;
			}
		}
		return $urlAry;
	}
	public static function collect_sina_article($articleBody,$url){//采集文章	
		phpQuery::newDocumentHtml($articleBody);
		if(substr_count($url,'mil.news.sina.com.cn')){
			$content=pq('#article');
			$Title=pq('.main-title')->text();
			$Time=strtotime(pq('.date-source .date')->text());
			$Author=pq('.date-source .source')->text();
			$Contents=pq($content)->html();
		}else{
			$content=pq('#artibody');
			$Title=pq('.main-title')->text();
			$Time=strtotime(pq('.date-source .date')->text());
			$Author=pq('.date-source .source')->text();
			$Contents=pq($content)->html();
		}
		$www=self::www($url);
		foreach(pq($content)->find('a') as $a){//将站内链接替换成外部链接
			$href=pq($a)->attr('href');
			if(!strstr("^{$href}",'^http')&&!strstr("^{$href}",'^//')){
				$u=$www.ltrim($href,'/');
				pq($a)->attr('href',$u);
			}
		}
		$ImagesAry=array();
		//采集处理图片
		foreach(pq($content)->find('img') as $img){//采集图片
			$src=pq($img)->attr('src');
			if(!strstr("^{$src}",'^http')&&!strstr("^{$src}",'^//')){
				$src=$www.ltrim($src,'/');
			}
			pq($img)->attr('src',$src);
			$ImagesAry[]=$src;
		}
		$result=array(
			'Author'	=>	addslashes($Author),
			'PostTime'	=>	$Time,
			'Title'		=>	addslashes($Title),
			'Contents'	=>	addslashes(self::filter_emoji($Contents)),
			'ImagesAry'	=>	$ImagesAry
		);
		return $result;
	}
	/************************************************采集新浪新闻(end)************************************************/



	/************************************************采集知乎专栏(start)************************************************/
	public static function collect_zhihu_url($pageBody,$url){//采集Yahoo搜索列表链接
		$urlAry=array();
		$alinks=str::json($pageBody);
		foreach((array)$alinks['data'] as $a){
			$url=$a['url'];
			if(substr_count($url, 'zhuanlan.zhihu.com')){
				$url=urldecode($url);
				if(!$url || strlen($url)>500) continue;
				$urlAry[]=$url;
			}
		}
		return $urlAry;
	}
	public static function collect_zhihu_article($articleBody,$url){//采集baidu文章	
		phpQuery::newDocumentHtml($articleBody);
		$content=pq('.Post-RichTextContainer');
		$Title=pq('.Post-Header .Post-Title')->text();
		$Time=strtotime(ltrim(pq('.ContentItem-time')->text(),'发布于 '));
		$Author=pq('.AuthorInfo-name')->text();
		$Contents=pq($content)->html();

		$www=self::www($url);
		foreach(pq($content)->find('a') as $a){//将站内链接替换成外部链接
			$href=pq($a)->attr('href');
			if(!strstr("^{$href}",'^http')&&!strstr("^{$href}",'^//')){
				$u=$www.ltrim($href,'/');
				pq($a)->attr('href',$u);
			}
		}
		$ImagesAry=array();
		//采集处理图片
		foreach(pq($content)->find('img') as $img){//采集图片
			$src=pq($img)->attr('src');
			if(!strstr("^{$src}",'^http')&&!strstr("^{$src}",'^//')){
				$src=$www.ltrim($src,'/');
			}
			pq($img)->attr('src',$src);
			$ImagesAry[]=$src;
		}

		$result=array(
			'Author'	=>	addslashes($Author),
			'PostTime'	=>	$Time,
			'Title'		=>	addslashes($Title),
			'Contents'	=>	addslashes(str::filter_emoji($Contents)),
			'ImagesAry'	=>	$ImagesAry
		);
		
		return $result;
	}
	/************************************************采集知乎专栏(end)************************************************/

}
?>

