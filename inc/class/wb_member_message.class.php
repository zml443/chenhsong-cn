<?php

class wb_member_message{
	//获取消息
	public static function get_message(){
		$member_row = db::get_one('wb_member',"Id='".member('Id')."'");
		$last_msg_row = db::get_one('wb_member_message',"wb_member_id='{$member_row['Id']}'","*","AddTime desc");
		$where = 1;
		$where.=" and IsDel='0'";
		$where.=" and ( MemberType='all' or (MemberType='level' and FIND_IN_SET(".$member_row['Level'].",Level)) or ( MemberType='user' and FIND_IN_SET(".$member_row['Id'].",MemberId) ) )";
		$where.=" and AddTime<='".c('time')."'";
		$where.=" and AddTime>'{$last_msg_row['AddTime']}'";
		$message_row = db::get_all('wb_member_message_log',$where,"*","AddTime asc");
		foreach((array)$message_row as $k=>$v){
			db::insert("wb_member_message",array(
				'AddTime'=>$v['AddTime'],
				'Message'=>$v['Message'],
				'UId'=>'0,',
				'Dept'=>1,
				'wb_member_id'=>$member_row['Id']
			));
		}
	}
	
	//获取列表
	public static function lists($pg,$total=10){
		return db::get_limit_page('wb_member_message',"wb_member_id='".member('Id')."' and UId='0,'","*","AddTime desc",$pg,$total);
	}
}
?>