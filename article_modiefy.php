<?php

/*
*TestGuest Version 1.0
* ==========================================
* Copy 2016-2016 mook
* ===========================================
* 
* Date:2016-8-21
*/
session_start();
define('IN_TG',true);
//定义常量授权调用includes里的文件
require "includes/common.inc.php";
require "includes/reg.func.php";
require "includes/globa.fun.php";

//发帖前登陆
if(!isset($_COOKIE['username']))
{
	echo "<script>alert('修改前请先登录');location.href='login.php';</script>";
}
//数据更新
if($_GET['action']=='modiefy')
{
	//验证码正误判断
	_check_code($_POST['yzm'],$_SESSION['code']);
	//验证唯一标识符，防止cookie伪造
	
	if(!!$_rows=_fetch_array("SELECT tg_uniqid FROM ta_user WHERE  tg_username='{$_COOKIE['usernamne']}'"))
	{
		if($_rows['tg_uniqid']!=$_COOKIE['uniqid'])
		{
			echo "<script>alert('唯一标识符异常');history.back();</script>";
		}
	
	
	}
	
	$_clean=array();
	
	$_clean['title'] =  _check_post_title($_POST['title'],2,40);
	$_clean['type'] =$_POST['type'];
	
	$_clean['content'] = _check_post_content($_POST['content'],10);
	_mysql_string($_clean);
	_query("UPDATE tg_article SET tg_type = '{$_clean['type']}',
	                              tg_title = '{$_clean['title']}',
	                              tg_content = '{$_clean['content']}',
	                              tg_date = NOW()
	                        WHERE tg_id = '{$_GET['id']}'");
	if(_affected_rows()==1)
	{
		$_id = _fetch_array("SELECT tg_id FROM tg_article WHERE tg_username ='{$_COOKIE['username']}' ORDER BY tg_date DESC");
	
		mysql_close();
		//session_destroy();
		echo "<script>alert('帖子修改成功');location.href='article.php?id=".$_id['tg_id']."'</script>";
	}
	else
	{
		mysql_close();
		//session_destroy();
		echo "<script>alert('帖子修改失败,请重新尝试');history.back();</script>";
	}
			
}
if(isset($_GET['id']))
{

   
			if(!!$_rows=_fetch_array("SELECT  tg_id,
											  tg_username,
											  tg_title,
											  tg_content,
											  tg_type,
											  tg_date
										FROM
												tg_article
					                      WHERE 
					                           tg_id='{$_GET['id']}'"))
			{
				$_html = array();
				$_html['id'] = $_rows['tg_id'];
				$_html['username'] = $_rows['tg_username'];
				$_html['title'] = $_rows['tg_title'];
				$_html['content'] = $_rows['tg_content'];
				$_html['type'] = $_rows['tg_type'];
				$_html['date'] = $_rows['tg_date'];
			
			
		
		}
		if($_html['username']!=$_COOKIE['username'])
		{
			echo "<script>alert('你没有权限修改');history.back();</script>";
		}
	
}else {
	echo "<script>alert('非法操作');history.back();</script>";
}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<title><?php echo $_system['webname']?>--帖子修改</title>


<?php
require "includes/title.inc.php";

?>

<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/post.css" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<script src="js/post.js" type="text/javascript"></script>
<body>


<?php
include "includes/header.inc.php";

?>

<div id="post">
<h2>论坛发帖</h2>
<form method="post" name="modiefy" action="article_modiefy.php?id=<?php echo $_html['id']?>&action=modiefy">
 
 <dl>
 
 <dd>类型:
 <?php 
 foreach(range(1,16) as $_num)
 {
 	if($_num==$_html['type'])
 	{
 	  echo '<input name="type" type="radio" value="'.$_num.'" checked="checked" class="title"  />';
 	}else{
 		echo '<input name="type" type="radio" value="'.$_num.'" class="title" />';
 		
 	}
 	echo '<img src="images/'.$_num.'.gif" />';
 	
 }
 ?>
 </dd>
 <dd>标题:<input type="text" name="title" class="text" value="<?php echo $_html['title'];?>" /></dd>
 <dd id="q_image">Q图:<a href="javascript:;">Q图系列[1]</a> &nbsp&nbsp<a href="javascript:;">Q图系列[2]</a>&nbsp&nbsp<a href="javascript:;">Q图系列[3]</a>
 <dd>
  <div id="ubb"> 
    <img src="images/bb_sup.gif" title="字体变大" alt="字体变大 " />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_bold.gif" title="字体加粗" alt="字体加粗" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_italic.gif" title="字体倾斜" alt="字体倾斜" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_underline.gif" title="下划线" alt="下划线" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_remove.gif" title="删除线" alt="删除线" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_color.gif" title="字体颜色" alt="字体颜色" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_url.gif" title="超链接" alt="超链接" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_email.gif" title="邮件" alt="邮件" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_flash.gif" title="flash" alt="flash" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_image.gif" title="图片" alt="图片" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_media.gif" title="视频" alt="视频" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_left.gif" title="居左" alt="居左" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_center.gif" title="居中" alt="居中" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_right.gif" title="居右" alt="居右" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_add.gif" title="区域放大" alt="区域放大" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_sub.gif" title="区域缩小" alt="区域缩小" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/bb_help.gif" title="帮助" alt="帮助" />
    <img src="images/bg_button.gif" title="分割"  />
    <img src="images/fontsub.gif" title="字体变小" alt="字体变小" />
    <img src="images/bg_button.gif" title="分割"  />
    
 </div>
 <textarea class="content" name="content"  rows=12 ><?php echo $_html['content']?></textarea>
 </dd>
 <dd><input type="text" name="yzm" class="text yzm"><img src="code.php" id="code" onclick="javascript:this.src='code.php?tm='+Math.random()" /><input type="submit" name="submit" class="submit"value="帖子修改"></dd>
 
 </dl>
</form>
</div>
<?php
require "includes/footer.inc.php";
mysql_close();
?>
</body>
</html>
