<?php

class wb_service{
	// 普通对外字段整理
	public static function fields($v){
		if(!strstr($v['Number'],':') || !preg_match('#^//#',$v['Number'])){
			switch ($v['Type']) {
				case 'qq':
					$v['Href'] = "http://wpa.qq.com/msgrd?v=3&uin={$v['Number']}&site=qq&menu=yes";
					break;
				case 'skype':
					$v['Href'] = "skype:{$v['Number']}?call";
					break;
				case 'email':
					$v['Href'] = "mailto:{$v['Number']}";
					break;
				case 'mobile':
				case 'tel':
					$v['Href'] = "tel:{$v['Number']}";
					break;
				case 'feedback':
					if ($v['IsPopup']) $v['Href'] = "lysaas-feedbackSide:0";
					break;
			}
		}
		if (preg_match('#^(https?:)?//#',$v['Number'])) {
			$v['Target'] = '_blank';
		}else{
			$v['Target'] = '_top';
		}
		$v['Icon'] = '/static/images/side_fload/02/'.$v['Type'].'.svg';
		return $v;
	}

	// 全部
	public static function all($_ARG=array()){
		$where = "Language='' or Language='".c('lang')."' and IsOpen=1";
		$res = db::query("select * from wb_service where $where order by MyOrder asc,Id asc");
		$row = array();
		while ($v=db::result($res)) {
			$row[] = self::fields($v);
		}
		return $row;
	}

	// 全部
	public static function url($_ARG=array()){
		$where = "Language='' or Language='".c('lang')."'";
		$res = db::query(" select * from wb_service where $where order by MyOrder asc,Id asc ");
		$row = array();
		while ($v=db::result($res)) {
			$v = self::fields($v);
			$row[] = array(
				// 'label' => $v['Name'].'【'.lang('language.jianxie.'.$v['Language']).'】',
				'label' => $v['Name'],
				'type' => 'wb_service',
				'value' => 'lysaas-service:'.$v['Id']
			);
		}
		return $row;
	}

	// id
	public static function id($_ARG=array()){
		$id = (int)$_ARG['id'];
		$row = db::result("select * from wb_service where Id=$id limit 0,1");
		$row && $row = self::fields($row);
		return $row;
	}

}
?>