<?php
/*
 *TestGuest Version 1.0
 * ==========================================
 * Copy 2016-2016 mook
 * ===========================================
 * Author:Mook
 * Date:2016-8-21
 */
define('SCRIPT','photo');
session_start();
define('IN_TG',TRUE);
if(!isset($_COOKIE['username']))
{
	echo "<script>alert('非法登录');history.back();</script>";
	exit();
}
require "includes/common.inc.php";
require_once("includes/reg.func.php");
require "includes/globa.fun.php";
require_once("includes/mysql.func.php");
require "includes/header.inc.php";
require "includes/title.inc.php";
//相册修改]
if($_GET['action'] == 'photo_modiefy')
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
		$_html['name'] = $_POST['name'];
		
		$_html['name'] = _check_username($_html['name'],2,20);
				
		
		
		$_html['type'] = $_POST['public']; //相册类型
		
		if(!empty($_clean['password']))
		{
			$_html['password'] = _check_password($_POST['pass']);
		}
		$_clean['content'] = $_POST['content'];
		$_html['face'] = $_POST['face'];
		$_html =_mysql_string($_html);
		
		//更新数据库
		if($_html['type']==1)
		{
	 	_query("UPDATE tg_photo SET
	 			                tg_name='{$_html['name']}',
	 			                tg_type = '{$_html['type']}',
	 			                tg_password = '{$_html['password']}',
	 			                tg_content = '{$_html['content']}',
	 			                tg_face = '{$_html['face']}'
	 			       WHERE    tg_id ='{$_GET['id']}'
					 LIMIT 1         
	 			  " )or die('sql'.mysql_error());
		}else 
		{
			_query("UPDATE tg_photo SET
					tg_name='{$_html['name']}',
					tg_type = '{$_html['type']}',
					
					tg_content = '{$_html['content']}',
					tg_face = '{$_html['face']}'
		      WHERE tg_id = '{$_GET['id']}'
					 		LIMIT 1
					")or die('sql'.mysql_error());
		}
		if(_affected_rows()==1)
		{
			echo "<script>alert('相册修改成功');location.href='photo.php';</script>";
			mysql_close();
			
		}else
		{
			echo "<script>alert('相册修改成功');hisory.back();</script>";
			mysql_close();
		}
		
	}
	
}
if(isset($_GET['id']))
{
	
         if(!!$_rows = _fetch_array("SELECT 
				                           tg_id,
				                           tg_name,
				                           tg_face,
				                           tg_type,
				                           tg_dir,
         		                           tg_password,
				                           tg_content
				                      FROM 
				                           tg_photo 
				                     WHERE 
				                           tg_id='{$_GET['id']}' 
				                     LIMIT 
         1"))
		{
			$_clean = array();
			$_clean['id'] = $_rows['tg_id'];
			$_clean['name'] = $_rows['tg_name'];
			$_clean['type'] = $_rows['tg_type'];
			$_clean['dir'] = $_rows['tg_dir'];
			$_clean['face'] = $_rows['tg_face'];
			$_clean['content'] = $_rows['tg_content'];
			$_clean = _html($_clean);
			if($_clean['type']==0)
			{
				$_clean['type'] = '<input name="public" type="radio" value=0  class="pub" checked="checked" />公开&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input name="public" type="radio" value=1 class="pri" />私密';
				
			}else {
				
				$_clean['type']='<input name="public" type="radio" value=0  class="pub"  />公开&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input name="public" type="radio" value=1 class="pri" checked="checked" />私密';
			    $_style = 'style="display:block;"';
			}
			
		}
		
	
		
	
	
}else {
	
	echo "<script>alert('非法登录');hisory.back();</script>";
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
<form action="?id=<?php echo $_clean['id'];?>&action=photo_modiefy" method="POST">
 <dl>
 
	<dd>相册名称：<input name="name" class="text" type="text" value="<?php echo $_clean['name']?>"/></dd>
	<dd class="type">相册类型：<?php echo $_clean['type'];?></dd>
	<dd id="pass" <?php echo $_style;?>>相册密码：<input name="pass" type="password"  /></dd>
	<dd>相册封面：<input name="face" type="text" value="<?php echo $_clean['face'];?>"/></dd>
	<dd>&nbsp相册描述：<textarea name="content"><?php echo $_clean['content']?></textarea></dd>
	<dd><input type="submit" name="submit" value="修改" class="upload" /></dd>

 </dl>
</form>
 </div>
<?php 
require 'includes/footer.inc.php';

?>
</body>
</html>