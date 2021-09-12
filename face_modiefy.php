<?php
define('IN_TG',true);
session_start();
require "includes/common.inc.php";

require 'includes/reg.func.php';

require 'includes/globa.fun.php';
if(isset($_COOKIE['username']))
{
	$_rows = mysql_fetch_array(mysql_query("SELECT tg_face FROM ta_user WHERE tg_username = '{$_COOKIE['username']}'"));
    if($_GET['action'] == 'face_change')
    {
    	define('MAX_SIZE',2000000);
    	define('URL',dirname(__FILE__).'\face');
    	if($_FILES['userfile']['error']>0)
    	{
    		switch($_FILES['userfile']['error'])
    		{
    			case 1:
    				echo "<script>alert('文件上传大小超过约定值');history.back();</script>";
    				break;
    			case 2:
    				echo "<script>alert('文件上大小超过最大值');history.back();</script>";
    				break;
    			case 3:
    				echo "<script>alert('文件上传不完整');history.back();</script>";
    				break;
    			case 4:
    				echo "<script>alert('未上传任何文件');history.back();</script>";
    				break;
    				
    				
    		}
    		exit;
    	}
    	
    	if($_FILES['userfile']['size']>MAX_SIZE)
    	{
    		echo "<script>alert('图片大小不得大于2M');history.back();</script>";
    		exit;
    	}
    	
    	if(!is_dir(URL))
    	{
    		mkdir(URL,0777);
    		
    	}
    	if(is_uploaded_file($_FILES['userfile']['tmp_file']))
    	{
    		move_uploaded_file($_FILES['userfile']['tmp_name'],URL.'/'.$_FILES['userfile']['name']);
    		
    	}
    	elseif(!@is_uplaoded_file($_FILES['userfile']['tmp_file']))
    	{
    		echo "<script>alert('找不到文件位置');history.back();</script>";
    		exit;
    	}
    	else {
    		echo "<script>alert('文件移动失败');history.back();</script>";
    		exit;
    	}
    }
    mysql_query("UPDATE ta_user SET tg_face='face/{$_FILES['userfile']['name']}' WHERE tg_name = '{$_COOKIE['name']}'");
    
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $_system['webname']?>--头像上传</title>
</head>

<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/face_modiefy.css" />
<link rel="shortcut icon" href="1.ico" />
<body>
<?php
require "includes/header.inc.php";

?>
<div id="face">
<h2>会员管理中心</h2>
   <div id="daohanglan_modiefy">
    <h2>导航栏</h2>
      <dl>
        <dt>账号管理</dt>
        <dd><a href="member.php">个人中心</a></dd>
        <dd><a href="member_modiefy.php">修改资料</a></dd>
        <dd><a href="face_modiefy.php">头像上传</a></dd>
        </dl>
        <dl>
        <dt>其他管理</dt>
        <dd><a href="###">短信查阅</a></dd>
        <dd><a href="###">好友设置</a></dd>
        <dd><a href="###">送花查询</a></dd>
        <dd><a href="###">个人相册</a></dd>
        
      </dl>
   </div>
<form name='upload' action="face_modiefy.php?action=face_change" method='post'>

<div id='face_modiefy'>
<h2>头像选择</h2>
   <dd><img src=<?php echo $_rows['tg_face'];?> /></dd>
   <dt><input type="hidden" name="MAX_FILE_SIZE" value="2000000" />上传文件：<input type="file" name="userfile"/><input type="submit" value="上传"></dt>
 </div>
 
 </form>
</div>
<?php 
require 'includes/footer.inc.php';
?>
</body>
</html>