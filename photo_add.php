<?php
/*
 *TestGuest Version 1.0
 * ==========================================
 * Copy 2016-2016 mook
 * ===========================================
 * Author:Mook
 * Date:2016-8-21
 */
define('SCRIPT','photo_add');
session_start();
define('IN_TG',TRUE);
if(!isset($_COOKIE['username'])||(!isset($_SESSION['admin'])))
{
	echo "<script>alert('非法操作');history.back();</script>";
	exit();
}
require "includes/common.inc.php";
require_once("includes/reg.func.php");
require "includes/globa.fun.php";
require_once("includes/mysql.func.php");
require "includes/header.inc.php";
require "includes/title.inc.php";
//相册添加
if($_GET['action'] == 'photo_add')
{
	if(!!$_rows = _fetch_array("SELECT 
			                         tg_uniqid 
			                    FROM 
			                         ta_user 
			                   WHERE 
			                        tg_username='{$_COOKIE['username']}' 
			                   
			                   LIMIT 1"))
	{
		_check_unqid($_COOKIE['uniqid'], $_rows['tg_uniqid']);
	
		$_clean = array();
		$_clean['name'] = $_POST['name'];
		if(!!$rows = _fetch_array("SELECT tg_name FROM tg_photo WHERE tg_name ='{$_clean['name']}' LIMIT 1 "))
		{
			echo "<script>alert('相册名已存在');history.back();</script>";
			mysql_close();
			
		}else
		{
			$_clean['name'] = _check_username($_clean['name'],2,20);
			
		}
		
		$_clean['type'] = $_POST['public']; //相册类型
		if($_clean['type']==1)
		{
		$_clean['password'] = sha1($_POST['pass']); 
		}
		
		$_clean['content'] = $_POST['content'];
		$_clean['dir'] = time(); //创建时间戳目录
		$_clean =_mysql_string($_clean);
		
		if(!is_dir('photo'))
		{
			mkdir('photo',0777);
			
		}
		if(!is_dir('photo/'.$_clean['dir']))
		{
			mkdir('photo/'.$_clean['dir'],0777);
			
		}
		//写入数据库
	    if($_clean['type']==0)
		{
			_query("INSERT INTO tg_photo(
					                          tg_name,
					                          tg_type,
					                          tg_content,
					                          tg_time,
					                          tg_dir
					                        )
					                  VALUES(
					                          '{$_clean['name']}',
					                          '{$_clean['type']}',
					                          '{$_clean['content']}',
					                           NOW(),
					                          'photo/{$_clean['dir']}'
			                                  )
		")  or die('sql'.mysql_error());
		}else {
			_query("INSERT INTO tg_photo(
					                          
					                          tg_name,
					                          tg_password,
					                          tg_type,
					                          tg_time,
					                          tg_content,
					                          tg_dir)
					                 VALUES(
					                           
					                           '{$_clean['name']}',
			                                   '{$_clean['password']}',
			                                   '{$_clean['type']}',
			                                     NOW(),
			                                   '{$_clean['content']}',
			                                   'photo/{$_clean['dir']}'
			                                    )") or die('sql'.mysql_error());

		
		}
		if(_affected_rows()==1)
		{
			
			
			echo "<script>alert('相册添加成功');location.href='photo.php';</script>";
			mysql_close();
		}else {
			
			mysql_close();
				
			echo "<script>alert('相册添加失败');history.back();</script>";
		}
		
	}else {
		echo "<script>alert('非法登录');history.back();</script>";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<title><?php echo $_system['webname']?>--相册列表</title>
</head>

<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/photo_add.css" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script type="text/javascript" src="js/photo_add.js"></script>
<body>
<div id="photo_add">
<h2>添加相册</h2>
<form action="?action=photo_add" method="POST">
 <dl>
 
	<dd>相册名称：<input name="name" class="text" type="text" /></dd>
	<dd class="type">相册类型：<input name="public" type="radio" value=0  class="pub" checked="checked" />公开&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input name="public" type="radio" value=1 class="pri" />私密</dd>
	<dd id="pass">相册密码：<input name="pass" type="password"/></dd>
	<dd>相册描述：<textarea name="content"></textarea></dd>
	<dd><input type="submit" name="submit" value="添加" class="upload" /></dd>

 </dl>
</form>
 </div>
<?php 
require 'includes/footer.inc.php';

?>
</body>
</html>