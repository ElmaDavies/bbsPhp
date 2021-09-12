<?php
/*
 *TestGuest Version 1.0
 * ==========================================
 * Copy 2016-2016 mook
 * ===========================================
 * Author:mao
 * Date:2016-8-27
 */

define('IN_TG',true);
require_once("includes/common.inc.php");
require 'includes/globa.fun.php';
if(!isset($_COOKIE['username'])||!isset($_SESSION['admin']))
{
	echo "<script>alert('非法登录');history.back();</script>";
}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_system['webname']?>--个人中心</title>
</head>
<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/admin.css" />
<body>
<?php
require "includes/header.inc.php";
?>
<div id="member">
  <div id="daohanglan">
    <h2>管理导航</h2>
      <dl>
        <dt>后台管理</dt>
        <dd><a href="admin.php">系统信息</a></dd>
        <dd><a href="admin.php">后台首页</a></dd>
         <dd><a href="admin_set.php">系统设置</a></dd>
         </dl>
       <dl>
        <dt>会员管理</dt>
        <dd><a href="member_list.php">会员列表</a></dd>
        <dd><a href="member_set.php">会员设置</a></dd>
      </dl>
      
      
  </div>
  <div id="main">
   <h2>服务中心</h2>
     <dl>
      <dd>服务器主机名称：<?php echo $_SERVER['SERVER_NAME'];?></dd>
      <dd>服务器版本：<?php echo $_ENV['OS'];?></dd>
      <dd>通信协议名称/版本：<?php  echo $_SERVER['SERVER_PROTOCOL'];?></dd>
      <dd>服务器ip：<?php echo $_SERVER['SERVER_ADDR'];?></dd>
      <dd>客户端ip：<?php echo $_SERVER['REMOTE_ADDR']; ?></dd>
      <dd>服务器端口：<?php echo $_SERVER['SERVER_PORT'];?></dd>
      <dd>客户端端口：<?php echo $_SERVER['REMOTE_PORT']; ?></dd>
      <dd>管理员邮箱：<?php echo $_SERVER['SERVER_ADMIN']; ?></dd>
      <dd>HOST头部内容：<?php echo $_SERVER['HTTP_HOST']; ?></dd>
      <dd>服务器主目录：<?php echo $_SERVER['DOCUMENT_ROOT']; ?></dd>
      <dd>服务系统盘：<?php echo $_ENV['SystemRoot']; ?></dd>
      <dd>脚本执行的绝对路径：<?php echo $_SERVER['SCRIPT_FILENAME']?></dd>
      <dd>Apache及PHP版本：<?php echo $_SERVER['SERVER_SOFTWARE']?></dd>
     </dl>
  
  </div>
  
</div>

<?php
require "includes/footer.inc.php";
?>
</body>
</html>