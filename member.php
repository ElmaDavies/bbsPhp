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
require "includes/common.inc.php";
require 'includes/globa.fun.php';
if(isset($_COOKIE['username']))
{

	  $_rows = mysql_fetch_array(mysql_query("SELECT tg_username,tg_sex,tg_qq,tg_face,tg_email,tg_level,tg_reg_time FROM ta_user WHERE tg_username = '{$_COOKIE['username']}'"));
	  if(isset($_rows)){
		  $_html = array();
		  $_html['username'] = $_rows['tg_username'];
		  $_html['sex'] = $_rows['tg_sex'];
		  $_html['qq'] = $_rows['tg_qq'];
		  $_html['face'] = $_rows['tg_face'];
		  $_html['email'] = $_rows['tg_email'];
		  $_html['reg_time'] = $_rows['tg_reg_time'];
		  $_html['level'] = $_rows['tg_level'];
		  $_html = _html($_html);
		  switch($_html['level'])
		  {
		  	case 0:
		  		$_html['level'] = '普通会员';
		  		break;
		  	case 1:
		  		$_html['level']= '管理员';
		  		break;
		  	default:
		  		break;
		  		
		  }
  }
}else 
{
	echo "<script>alert('非法登录');location.href='index.php';</script>";
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html xmins="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_system['webname']?>--个人中心</title>
</head>
<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/member.css" />
<body>
<?php
require "includes/header.inc.php";
?>
<div id="member">
  <div id="daohanglan">
    <h2>中心导航</h2>
      <dl>
        <dt>账号管理</dt>
        <dd><a href="member.php">个人信息</a></dd>
        <dd><a href="member_modiefy.php">修改资料</a></dd>
         <dd><a href="face_modiefy.php">头像上传</a></dd>
        
      </dl>
      <dl>
        <dt>其他管理</dt>
        <dd><a href="member_message.php">短信查阅</a></dd>
        <dd><a href="member_frenid.php">好友设置</a></dd>
        <dd><a href="member_flower.php">送花查询</a></dd>
        <dd><a href="###">个人相册</a></dd>
        
      </dl>
  </div>
  <div id="main">
   <h2>个人中心</h2>
     <dl>
      <dd>用 &nbsp户&nbsp名：<?php echo $_html['username'];?></dd>
      <dd>性&nbsp&nbsp&nbsp&nbsp别：<?php echo $_html['sex'];?></dd>
      <dd>邮&nbsp&nbsp&nbsp&nbsp箱：<?php  echo $_html['email'];?></dd>
      <dd>Q   Q:<?php echo $_html['qq'];?></dd>
      <dd>头&nbsp&nbsp&nbsp&nbsp像：<img src="<?php echo $_html['face']; ?>" alt="头像" /></dd>
      <dd>注册时间：<?php echo $_html['reg_time'];?></dd>
      <dd>身&nbsp&nbsp&nbsp&nbsp份:<?php echo $_html['level']; ?></dd>
     </dl>
  
  </div>
  
</div>

<?php
require "includes/footer.inc.php";
?>
</body>
</html>