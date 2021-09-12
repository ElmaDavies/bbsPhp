<?php
/*
 *TestGuest Version 1.0
 * ==========================================
 * Copy 2016-2016 mook
 * ===========================================
 * Author:lee
 * Date:2016-8-21
 */
session_start();
define('IN_TG',TRUE);
define('SCRIPT',message);
require "includes/reg.func.php";
require "includes/common.inc.php";
require "includes/globa.fun.php";

if(!isset($_COOKIE['username']))
{
	echo "<script>alert('请先登录');window.close();</script>";
}
//写短信
if($_GET['action']=='write')
{
	if(!empyt($_system['code']))
	{
	_check_code($_POST['yzm'],$_SESSION['code']);
	}
	if(!!$_rows=_fetch_array("SELECT tg_username,tg_uniqid FROM ta_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1"))
	{
		
		_check_unqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
		$_clean = array();
		$_clean['to_user'] = $_POST['to_user'];
		$_clean['from_user'] = $_COOKIE['username'];
		$_clean['content'] = _check_content($_POST['content'],400);
		$_clean = _mysql_string($_clean);
		//写入数据库
		_query("INSERT INTO tg_message (
										tg_to_user,
										tg_from_user,
										tg_content,
										tg_date) 
										VALUES(
											    '{$_clean['to_user']}',
									             '{$_clean['from_user']}',
									              '{$_clean['content']}',
									              NOW())"
		      );
		if(_affected_rows()==1)
		{
			mysql_close();
			//session_destroy();
			echo "<script>alert('恭喜你发送成功');window.close();</script>";
				
		}
		else{
			mysql_close();
			//session_destroy();
			echo "<script>alert('很遗憾，发送失败');window.close();</script>";
				
		}
		
	}else {
		echo "<script>alert('非法登录');window.close();</script>";
	}
}
if(isset($_GET['id']))
{
	if(!!$_rows = _fetch_array("SELECT tg_username FROM ta_user WHERE tg_id = '{$_GET['id']}' LIMIT 1"))
	{
		$_html['to_user'] = $_rows['tg_username'];
	}else {
		echo "<script>alert('用户不存在');window.close();</script>";
	}
}else
{
	echo "<script>alert('非法操作');window.open();</script>";
}
?>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/message.css" />

<html>
<head>
<title><?php echo $_system['webname']?>--信息</title>
</head>
<body>
<div id='message'>
 <h3>发消息</h3>
 <form method="POST" action="message.php?action=write">
 <input name='to_user' type='hidden' value='<?php echo $_html[to_user];?>' />
 <dl>
 <dd><input name='text' type='text' readonly='readonly' class='text' value=' TO:<?php echo $_html['to_user'];?>'/></dd>
 <dd><textarea name='content' ></textarea></dd>
 <?php if(!empty($_system['code'])){?>
 <dd>验证码:  <input type="text" name="yzm" class="text yzm"><img src="code.php" id="code" onclick="javascript:this.src='code.php?tm='+Math.random()" /><?php }?><input name='submit' type='submit' value='发 送' /></dd>
 </dl>
</form>
</div>
</body>
</html>