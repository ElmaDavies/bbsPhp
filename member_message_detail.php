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
if(!isset($_COOKIE['username']))
{
	echo "<script>alert('请先登录');history.back();<script>";
}
define('IN_TG',TRUE);
define('SCRIPT',member_message_detail.php);
require "includes/reg.func.php";
require "includes/common.inc.php";
require "includes/globa.fun.php";
//短信删除模块
if($_GET['action'] == 'delete' && isset($_GET['id']))
{
	$_sql = "SELECT tg_id FROM tg_message WHERE tg_id='{$_GET['id']}'";
	$_result = mysql_query($_sql);
	$_rows = mysql_fetch_array($_result);
	//短信存在性验证
	if($_rows)
	{
		
		
		
		//对唯一标识符进行验证，防止cookie伪造
		
		if(!!$_rows2 = _fetch_array("SELECT tg_uniqid FROM ta_user WHERE tg_username='{$_COOKIE['username']}'"))
		{
			_check_unqid($_COOKIE['uniqid'],$_rows2['tg_uniqid']);
			//删除操作
			mysql_query("DELETE FROM tg_message WHERE tg_id = '{$_GET['id']}' LIMIT 1");
			if(_affected_rows()==1)
			{
				mysql_close();
				
				echo "<script>alert('删除成功');location.href='member_message.php';</script>";
				
			}
			else{
				mysql_close();
				
				echo "<script>alert('删除失败！');history.back();</script>";
				
			}
			
			
		}else 
		{
			echo "<script>alert('非法操作');history.back();</script>";
		}
	}else {
		echo "<script>alert('此条短信不存在');history.back();</script>";
	}
	
}
if(isset($_GET['id']))
{
	$_sql = "SELECT tg_id,tg_to_user,tg_from_user,tg_date,tg_content,tg_state FROM tg_message WHERE tg_id='{$_GET['id']}'";
	$_result = mysql_query($_sql);
	$_rows = mysql_fetch_array($_result);
	if($_rows)
	{
		if(empty($_rows['tg_state']))
		{
			mysql_query("UPDATE tg_message SET tg_state=1  WHERE tg_id='{$_GET['id']}' LIMIT 1");
	
		}
		if(!_affected_rows())
		{
			echo "<script>alert('异常');history.back();</script>";
		}
	}
	$_html = array();
	$_html['id'] = $_rows['tg_id'];
	$_html['username'] = $_rows['tg_from_user'];
	$_html['content'] = $_rows['tg_content'];
	$_html['date'] = $_rows['tg_date'];
	$_html=_html($_html);
	
	
}
else
{
	echo "<script>alert('该短信不存在');history.back();</script>";
}

?>
<?php 
require "includes/header.inc.php";
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<title><?php echo $_system['webname']?>--短信查看</title>
</head>

<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/member.css" />
<link rel="stylesheet" type="text/css" href="style/1/member_message.css" />
<script type="text/javascript" src="js/member_message_detail.js"></script>
<body>


<div id="member">
  <div id="daohanglan">
    <h2>导航栏</h2>
      <dl>
        <dt>个人中心</dt>
        <dd><a href="member.php">个人资料</a></dd>
        <dd><a href="member_modiefy.php">资料修改</a></dd>
        <dd><a href="face_modiefy.php">头像上传</a></dd>
        
      </dl>
      <dl>
        <dt>其他导航</dt>
        <dd><a href="member_message.php">短信查阅</a></dd>
        <dd><a href="member_frenid.php">好友设置</a></dd>
        <dd><a href="member_flower.php">送花查询</a></dd>
        <dd><a href="###">个人相册</a></dd>
        
      </dl>
  </div>
  
 
    <div id="main">
      <h2>短信详情中心</h2>
      <dl>
          <dd>发&nbsp送&nbsp者：<?php echo $_html['username'];?></dd>
          <dd>短信内容：<?php echo $_html['content'];?></dd>
          <dd>发送时间：<?php echo $_html['date'];?></dd>
          <dd class="input"><input class="back" type="button" value="返回列表" id="return" /><input class="del" type="button" name="<?php echo $_html['id']?>" value="删除短信" id="delete"></dd>
      </dl>
     </div>
 </div>
 </body>
 </html>
 <?php 
 require "includes/footer.inc.php";
 ?>