<?php
/**TestGuest Version 1.0
 * ==========================================
 * Copy 2016-2016 mook
 * ===========================================
 * Author:mo
 * Date:2016-8-27
 */
 if(!defined('IN_TG'))
 {
 	exit('access delined');
 }
 //验证码的验证
 function _check_code($_start,$end)
 {
 	if($_start!=$end)
 	{
 		echo "<script>alert('验证码不正确！');location.href='login.php';</script>";
 		mysql_close();
 		
 	}
 }
 function _check_username($_string,$_min_num,$_max_num )
 {
 	//去掉两边空格
 	$_string = trim($_string);
 	//长度小于两位或者大于而是位
 	if((mb_strlen($_string,'utf-8')<$_min_num)||(mb_strlen($_sting,'utf-8')>$_max_num))
 	{
 		echo "<script>alert('用户名长度不得小于".$_min_num."两位或者大于".$_max_num."');location.href='login.php';</script>";
        mysql_close();
 	}
 	//过滤敏感字符
 	$_mode = '/[<>\'\"\ \ ]/';
 	if(preg_match($_mode,$_string))
 	{
 		echo "<script>alert('用户名中包含敏感字符');location.href='login.php';</script>";
 	    mysql_close();
 	}
 
 	//转义，有效防止sql注入,缺少一个句柄，以后连接数据库时再加上，函数生效
 	
 	return mysql_real_escape_string($_string);
 }
 function _check_password($_first,$_min_num)
 {
 	//判断密码
 	if(mb_strlen($_first)<6)
 	{
 		echo "<script>alert('密码不得小于".$_min_num."位');location.href='login.php';</script>";
 	    mysql_close();
 	}
 
 
 	//转义,
 	
 	return sha1($_first);
 }
 
 /*
  * 生成cookie
  * @param string
  * @param string
  */
 function  _setcookie($_username,$_uniqid,$_time)
 {
 	switch($_time)
 	{
 		case '0': //不保留
		 	 setcookie('username',$_username);
		 	 setcookie('uniqid',$_uniqid);
	         break;
 		case '1': //保留一天
 			setcookie('username',$_username,time()+86400);
 			setcookie('uniqid',$_uniqid,time()+86400);
 			break;
 		case '2':
 			setcookie('username',$_username,time()+604800);
 			setcookie('uniqid',$_uniqid,time()+604800);
 			break;
 		case '3': //保留十天
 			setcookie('username',$_username,time()+864000);
 			setcookie('uniqid',$_uniqid,time()+864000);
 			break;
 	}
 }
?>