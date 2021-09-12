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
define('SCRIPT',member_set);
require "includes/reg.func.php";
require "includes/common.inc.php";
require "includes/globa.fun.php";
if(!isset($_COOKIE['username'])||!isset($_SESSION['admin']))
{
	echo "<script>alert('非法登录');history.back();</script>";
}

//添加管理员

if($_GET['action']=='add')
{
	$_clean = array();
	$_clean['manage'] = $_POST['manage'];
	mysql_query("UPDATE ta_user SET tg_level=1 WHERE tg_username = '{$_clean['manage']}'");
	if(_affected_rows()==1)
	{
		
		mysql_close();
		echo "<script>alert('管理员添加成功');history.back();</script>";
		
		
	}else{
		mysql_close();
		echo "<script>alert('管理员添加失败');history.back();</script>";
		
	}
	
}
//管理员辞职
if($_GET['action']=='del_job' && isset($_GET['id']))
{ 
	$_clean = array();
	$_clean['id'] = $_GET['id'];
	
	mysql_query("UPDATE ta_user SET tg_level=0 WHERE tg_id='{$_GET['id']}' AND tg_username = '{$_COOKIE['username']}' ");
	if(_affected_rows()==1)
	{
		session_destroy();
		mysql_close();
		echo "<script>alert('辞职成功');location.href='index.php';</script>";
		
	}
	else 
	{
		mysql_close();
		echo "<script>alert('辞职失败');history.back();</script>";
	}
	
}
//分页模块

$_nums = mysql_num_rows(mysql_query("SELECT tg_username,tg_email,tg_reg_time FROM ta_user WHERE tg_level=1"));
//分页参数
$_pagesize = 10;
if(isset($_GET['page'])) //容错处理
{

	$_page=$_GET['page'];
	if(empty($_page)||($_page<0)||!is_numeric($_page))
	{
		$_page = 1;
	}else {
		$_page = intval($_page); //取整数
	}
}else
{
	$_page = 1;
}
//$_pagesize每页数据；
//$_page_num每页开始的数据
//$nums取得总共的数据
//如果数据数为零
if($_nums == 0)
{
	$_pagesolute = 1;
}else{
	$_pagesolute = ceil($_nums/$_pagesize); //ceil 取得的显示数据的页数并进位进位
}
if($_page > $_pagesolute)
{
	$_page = $_pagesolute;
}
$_page_num = ($_page-1)*$_pagesize;



$sql = "SELECT tg_id,tg_username,tg_email,tg_reg_time FROM ta_user WHERE tg_level=1 ORDER BY tg_reg_time DESC LIMIT $_page_num,$_pagesize";
$_result = mysql_query($sql);

?>



<?php
require "includes/header.inc.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>个人中心---短信查阅</title>
<script type="text/javascript" src="js/member_message.js"></script>
</head>
<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/member.css"  />
<link rel="stylesheet" type="text/css" href="style/1/member_message.css" />
<body>


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
        <dd><a href="member_set.php">职务设置</a></dd>
      </dl>
      
      
  </div>
  
 
  <div id="main">
  <h2><?php echo $_system['webname']?>--会员管理中心</h2>

  <table cellspacing="1">
  <tr><th>会员昵称</th><th>会员邮件</th><th>注册时间</th><th>操作</th></tr>
  <?php 
  $_html = array();
  while(!!$rows=mysql_fetch_array($_result)){
  
  	$_html['id'] = $rows['tg_id'];
  	$_html['username'] = $rows['tg_username'];
  	$_html['date'] = $rows['tg_reg_time'];
  	$_html['email'] = $rows['tg_email'];
  	if($_COOKIE['username'] == $_html['username'])
  	{
  		$_html['job'] = '<a href="?action=del_job&id='.$_html['id'].'">辞职</a>';
  	}else {
  		$_html['job'] = '权限不足';
  	}
 
  ?>
  <tr><td><?php echo $_html['username'];?></td><td><?php echo $_html['email']?></td><td><?php echo $_html['date']?></td><td><?php echo $_html['job']?></td></tr>
  <?php 
  }?>
  </table>
  
  <form action="?action=add" method="POST" style="position:relative;top:40px;text-align:center" >
  <input name="manage" type="text" />&nbsp&nbsp<input name="submit" value="添加管理员" type="submit">
  </form>
   <div id="page_num">
   <ul>
  
   <?php for($i=0;$i<$_pagesolute;$i++){
   	
   	if($_page==($i+1)){
    echo '<li><a href="'.SCRIPT.'.php?page="'.($i+1).' class="selected" >'.($i+1).'</a></li>';
   }
   else {
   	echo '<li><a href="'.SCRIPT.'.php?page='.($i+1).'  ">'.($i+1).'</a></li>';
   }
  }
   ?>
   
    </ul>
    </div>
  
  <div id="page_text">
    <ul>
	  <li><?php echo $_page?>/<?php echo $_pagesolute?>页| </li>
	  <li>共有<strong><?php echo $_nums;?></strong>条数据| </li>
	  <?php 
	  if($_page == 1)
	  {
	  	echo '<li>首页| </li>';
	  	echo '<li>上一页| </li>';
	  }else
	  {
	  	echo '<li><a href="'.SCRIPT.'.php?page=1">首页| </a></li>';
	  	echo '<li><a href="'.SCRIPT.'.php?page='.($_page-1).'">上一页|</a></li>';
	  }
	  if($_page == $_pagesolute)
	  {
	  	echo '<li>下一页|</li>';
	  	echo '<li>尾页|</li>';
	  }else 
	  {
	  	echo '<li><a href="'.SCRIPT.'.php?page='.($_page+1).'">下一页|</li>';
	  	echo '<li><a href="'.SCRIPT.'.php?page='.$_pagesolute.'">尾页</li>';
	  }
	  ?>
	  </ul>
	</div>
   
  </div>
</div>
</body>
</html>
<?php 
require "includes/footer.inc.php";
?>