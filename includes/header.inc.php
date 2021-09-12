<?php
/*
*TestGuest Version 1.0
* ==========================================
* Copy 2016-2016 mook
* ===========================================
* Author:mo
* Date:2016-8-27
*/
//防止恶意调用
//session_start();
if(!defined('IN_TG'))
{
	exit('Acess Defined');
}

//require dirname(__FILE__).'/common.inc.php';

//$_start_time = _runtime();
?>
<div id="header">
 <h1><a href="index.php">网络安全协会官方论坛</a></h1>
 <ul>
 <li><a href="index.php">首页</a></li>
 <?php echo "\n"; ?>
 <li><a href="photo.php">相册</a></li> 
	 <?php 
	 if(isset($_COOKIE['username']))
	 {
	 	
	 	
	 	echo '<li><a href="member.php">'.$_COOKIE['username'].'的个人中心</a></li><li><a href="member_message.php">'.$_message_html.'</a></li>';
	 }
	 else{
	 	echo "<li><a href='reg.php'>注册</a></li>";
	 	echo "\n";
	 	echo "<li><a href='login.php'>登录</a><li>";
	 }
	 ?>
 
   <?php 
    
    if(isset($_COOKIE['username'])&&isset($_SESSION['admin']))
    	echo '<li><a href="admin.php">管理</a></li>';
   ?>

 <li><a href='blog.php'>好友</a></li>

 <?php 
 if(isset($_COOKIE['username']))
 {
 	echo '<li><a href="logout.php">退出</a></li>';
 }
 ?>
 </ul>
 </div>