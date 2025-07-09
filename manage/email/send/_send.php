<?php
// 
$p_Content=stripslashes($_POST['Body']);
$p_Subject=$_POST['Subject'];
// 
if (!$p_Subject || !$p_Content) {
	str::msg('请填写完整',0);
}
// 
$same=substr_count($p_Subject,'{Email}')||substr_count($p_Subject,'{FullName}')||substr_count($p_Content,'{Email}')||substr_count($p_Content,'{FullName}');
// 
$Email=$_POST['Email'];
$Email_ary=explode("\r\n", $Email);
$Email_ary=array_unique($Email_ary);//删除重复
// 本站文件 加上域名
$p_Content=preg_replace("~([\"|'|(|=])/file/upload/~i", '$1'.server::domain(1).'/file/upload/', $p_Content);
// 
foreach((array)$Email_ary as $k=>$v){
	if(!$v) continue;
	$v=explode('/', str_replace(';', '', $v));
	$ToAry[] = $to = trim($v[0]);
	$NameAry[] = $to_name = trim($v[1]);
	//邮件内容不相同
	if ($same) {
		$p_Subject = str_replace(array('{Email}', '{FullName}'), array($to, $to_name), $p_Subject);
		$p_Content = str_replace(array('{Email}', '{FullName}'), array($to, $to_name), $p_Content);
		ly200::sendmail($to, $p_Subject, $p_Content);
	}
}
$ToAry||str::msg('请填写发送邮箱',0);
if(!$same && $ToAry){//邮件内容相同
	ly200::sendmail($ToAry, $p_Subject, $p_Content);
}
log::manage('wb_email_log', '发送邮件');
db::insert('wb_email_log', array(
	'AddTime' => c('time'),
	'Subject' => $_POST['Subject'],
	'Body' => $_POST['Body'],
	'Email' => @implode(',', $ToAry)
));
str::msg(language('notes.ok'), 1);
// 这里会退出程序执行，也避免了 wb_email_send 的数据添加
?>