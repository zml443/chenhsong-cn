<?php
namespace phpanalysis;
use str;
use db;

/*
+--------------------------------------------
| 采集函数整理
| by 深圳联雅
+--------------------------------------------
*/
class analysis{
	// 
	public static function i($str){
		ini_set('memory_limit', '1024M');
		global $c;
		//岐义处理
	    $do_fork=false;
	    //新词识别
	    $do_unit=false;
	    //多元切分
	    $do_multi=false;
	    //词性标注
	    $do_prop=true;
	    //是否预载全部词条
	    $pri_dict=false;
	    //初始化类
	    require_once $c['root_path'].'inc/class/phpanalysis/analysis.class.php';
	    PhpAnalysis::$loadInit=false;
	    $pa = new PhpAnalysis('utf-8', 'utf-8', $pri_dict);
	    //载入词典
	    $pa->LoadDict();   
	    //执行分词
	    $pa->SetSource(strip_tags($str));
	    $pa->differMax=$do_multi;
	    $pa->unitWord=$do_unit;
	    $pa->SetResultType(2);
	    $pa->StartAnalysis($do_fork);
	    $okresult=$pa->GetFinallyResult(' ', $do_prop);
	    return self::k(explode(' ',$okresult));
	}

	public static function k($data){
		$keywords='';
	    $word = $allword = $allkey = array();
	    foreach($data as $k=>$v){
	        $x=explode('/',$v);
	        if(isset($x[1])){
	            $x[1]='.'.$x[1];
	        }else continue;
	        if(!in_array($x[0],$word)){
	            $allword[]=$x[0];
	        }
	        if(strlen($x[0])==1){
	            continue;
	        }
	        //排除长度为2的非英文词
	        elseif(strlen($x[0])==2 && !preg_match('/[^0-9a-zA-Z]/', $x[0])){
	            continue;
	        }
	        //排除单个中文字
	        elseif(strlen($x[0]) < 4 && !preg_match('/[a-zA-Z]/', $x[0])){
	            continue;
	        }elseif(strstr($x[1],'.xs') && strlen($x[0])<=9){
	        	continue;
	        }elseif(in_array($x[0], array('ldquo','rdquo'))){
	        	continue;
	        }
	        if(!in_array($x[0],$word)){
	            $word[]=$x[0];
	            $allkey[$x[0]]=strlen($x[0])>9 ? 3 : 1;
	        }else if(isset($allkey[$x[0]])){
	        	$allkey[$x[0]]++;
	        }
	    }
	    arsort($allkey);
	    $i=0;
	    foreach($allkey as $k=>$v){
	        if($i>20) break;$i++;
	        $keywords.="{$k},";
	    }
	    return array(
	    	'word'		=>	$word,
	    	'allword'	=>	$allword,
	    	'keywords'	=>	$keywords,
	    );
	}
}