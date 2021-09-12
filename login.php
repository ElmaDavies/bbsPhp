<?php
/*
*TestGuest Version 1.0
* ==========================================
* Copy 2016-2016 mook
* ===========================================
* Author:Mook
* Date:2016-8-21
*/


define('IN_TG',TRUE);
require 'includes/common.inc.php';
require 'includes/globa.fun.php';

_login_state();
session_start();
_select_db();
if($_GET['action']=='login')
{
	require "includes/login.func.php";
	if(!empty($_system['code']))
	{
	_check_code($_POST['yzm'],$_SESSION['code']);
	}
	$_clean = array();
	$_clean['username'] = _check_username($_POST['username'],2,20);
	$_clean['password'] = _check_password($_POST['password'],6);
	$_clean['timer'] = $_POST['timer'];
	//数据库验证
	if(!!$_rows=_fetch_array("SELECT tg_username,tg_uniqid,tg_level FROM ta_user WHERE tg_username='{$_clean['username']}' and tg_password='{$_clean['password']}' and tg_active='' LIMIT 1"))
	{
		_query("UPDATE ta_user SET
				       tg_login_count=tg_login_count+1,
				       tg_login_time=NOW(),
				       tg_last_ip='{$_SERVER['REMOTE_ADDR']}'
		         WHERE 
		             tg_username='{$_rows['tg_username']}'
		");
		
		
		
		//生成cookie
		//清除session
		//session_destroy();
		//生成session以便管理登录验证
		if($_rows['tg_level'])
		{
			$_SESSION['admin'] = $_rows['tg_username'];
		}else {
		   session_destroy();
		}
		
		_setcookie($_rows['tg_username'],$_rows['tg_uniqid'],$_clean['timer']);
		mysql_close();
		header('location:index.php');

	
	}
	else
	{
		mysql_close();
		//清除session
		
		
		//跳转
		echo "<script>alert('账户或密码错误或者该用户未被激活，请重新登录');location.href='login.php';</script>";
	}
		
	
}
?>

<?php 
require "includes/header.inc.php";
require "includes/title.inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html xmins="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_system['webname']?>--登录页面</title>
</head>
<script type="text/javascript" src="js/login.js"></script>
<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/login.css" />
<body>
<div id="login">
<h2>登录</h2>
<form method="POST" name="login" action="login.php?action=login">


<dl>
<dd>用 户 名 <input type="text" name="username" class="text" /></dd>
<dd>密&nbsp&nbsp&nbsp码 <input type="password" name="password" class="text" /></dd>
<dd>保&nbsp&nbsp&nbsp留<input type="radio" name="timer" value="0"  checked="checked"/>不保留<input type="radio" name="timer" value="1" />保留一天<input type="radio" name="timer" value="2" />保留一周<input type="radio" name="timer" value="3" />保留十天</dd>
<?php if(!empty($_system['code'])){?>
<dd>验 证 码 <input type="text" name="yzm" class="text yzm">&nbsp<img src="code.php" id="code" onclick="javascript:this.src='code.php?tm='+Math.random()" /></dd>
<?php }?>
<dd><input type="submit" name="login" class="submit" value="登录" /> <input name="reg" type="submit" id="jump" class="button" value="注册" />
 
</dl>

</form>
</div>
</body>
</html>
<?php 
require "includes/footer.inc.php";
?>