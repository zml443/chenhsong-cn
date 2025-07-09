<?php

/*
 * 一个比较简单的自制爬虫程序
 * 需要结合 js
 * By Zinn
**/
include '../../../php/init.php';

/*
 * 导入数据表
 * 
**/
set_time_limit(0);


function escapeXML($str){ 
	$translation=get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
	foreach($translation as $key=>$value){
		$translation[$key]='&#'.ord($key).';';
	}
	$translation[chr(38)]='&';
	return preg_replace("/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,3};)/","&#38;",strtr($str, $translation));
}



$xmlHtml='';
$xmlHtml.='<?xml version="1.0" encoding="UTF-8"?>';
$xmlHtml.='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';




$row = db::query("select * from jext_sitemap");

$i=0;
while ($v = db::result($row)) {
	if ($v['Status']!='200') {
		continue;
	}
	$i++;
	// if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $v['Href'])) continue;
	if(preg_match('/[^a-zA-Z0-9_\-\/\\\\\'"!@#$%\^&\*\(\)=\+;:<>.,\?\\[\\]\\{\\}\|`~\s]/u', $v['Href'])) continue;
	$xmlHtml.='<url>';
		$xmlHtml.='<loc>'.escapeXML($v['Href']).'</loc>';
		$xmlHtml.='<changefreq>weekly</changefreq>';
	$xmlHtml.='</url>';
}
$xmlHtml.='</urlset>';

if ($i) {
	if (c('HostType')=='saas') {
		file_put_contents(c('root').'website/'.c('HostName').'/sitemap.xml', $xmlHtml);
	} else {
		file_put_contents(c('root').'sitemap.xml', $xmlHtml);
	}
}
unset($xmlHtml);

db::query("truncate jext_sitemap");

str::msg('ok', 1);