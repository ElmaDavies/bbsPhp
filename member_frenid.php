<?php
/*
 *TestGuest Version 1.0
* ==========================================
* Copy 2016-2016 mook
* ===========================================
* Author:mook
* Date:2016-8-21
*/
session_start();
define('IN_TG',TRUE);
define('SCRIPT',member_frenid);
require "includes/reg.func.php";
require "includes/common.inc.php";
require "includes/globa.fun.php";

//好友验证模块
if($_GET['action'] == 'check' && isset($_GET['id']))
{
	if(!!$_rows2 = _fetch_array("SELECT tg_uniqid FROM ta_user WHERE tg_username='{$_COOKIE['username']}'"))
	{
		_check_unqid($_COOKIE['uniqid'],$_rows2['tg_uniqid']);
		_query("UPDATE tg_frenid SET tg_state=1 WHERE tg_id='{$_GET['id']}'");
		if(_affected_rows()==1)
		{
			mysql_close();
		
			echo "<script>alert('好友验证成功');location.href='member_frenid.php';</script>";
		
		}
		else{
			mysql_close();
		
			echo "<script>alert('验证失败！');history.back();</script>";
		
		}
	}else 
	{
		echo "<script>alert('非法登录');history.back();<script>";
	}
	
}
//好友删除模块

if($_GET['action'] == 'delall' && isset($_POST['ids']))
{
	$_clean = array();
	$_clean['ids'] = _mysql_string(implode(',',$_POST['ids']));
	//短信存在性验证，防止cookie伪造
	if(!!$_rows2 = _fetch_array("SELECT tg_uniqid FROM ta_user WHERE tg_username='{$_COOKIE['username']}'"))
	{
		_check_unqid($_COOKIE['uniqid'],$_rows2['tg_uniqid']);
		mysql_query("DELETE FROM tg_frenid WHERE tg_id  IN({$_clean['ids']}) ");
		if(_affected_rows())
		{
			mysql_close();

			echo "<script>alert('删除成功');location.href='member_frenid.php';</script>";

		}
		else{
			mysql_close();

			echo "<script>alert('删除失败！');history.back();</script>";

		}
			

	}else{
		echo "<script>alert('非法登录');history.back();</script>";
	}

	exit();
}
//分页模块

$_nums = mysql_num_rows(mysql_query("SELECT tg_id,tg_to_user FROM tg_frenid WHERE tg_to_user='{$_COOKIE['username']}' OR tg_from_user='{$_COOKIE['username']}'"));
//分页参数
$_pagesize = 12;
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



$sql = "SELECT tg_id,tg_to_user,tg_state,tg_from_user,tg_date,tg_content FROM tg_frenid WHERE tg_to_user='{$_COOKIE['username']}' OR tg_from_user = '{$_COOKIE['username']}' ORDER BY tg_date DESC LIMIT $_page_num,$_pagesize";
$_result = mysql_query($sql);

?>



<?php
require "includes/header.inc.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>个人中心---好友列表</title>
<script type="text/javascript" src="js/member_message.js"></script>
</head>
<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/member.css"  />
<link rel="stylesheet" type="text/css" href="style/1/member_message.css" />
<body>


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
        <dd><a href="###">送花查询</a></dd>
        <dd><a href="###">个人相册</a></dd>
        
      </dl>
  </div>
  
 
  <div id="main">
  <h2><?php echo $_system['webname']?>--好友管理中心</h2>
  <form method="post" action="?action=delall">
  <table cellspacing="1">
  <tr><th>好友</th><th>验证内容</th><th>发送时间</th><th>状态</th><th>操作</th></tr>
  <?php while(!!$rows=mysql_fetch_array($_result)){
  	$_html = array();
  	$_html['id'] = $rows['tg_id'];
  	$_html['to_user'] = $rows['tg_to_user'];
  	$_html['from_user'] = $rows['tg_from_user'];
  	$_html['date'] = $rows['tg_date'];
  	$_html['content'] = $rows['tg_content'];
  	$_html['state'] = $rows['tg_state'];
  	if($_html['to_user']==$_COOKIE['username']) //别人添加登录者
  	{
  		$_html['frenid']=$_html['from_user'];
  		if(empty($_html['state']))
  		{
  			$_html['state']= '<a href="?action=check&id='.$_html[id].'" style="color:blue;">你未验证</a>';
  		}else {
  			$_html['state'] = '<span style="color:green;">通过</span>';
  		}
  	}
  	elseif($_html['from_user']==$_COOKIE['username'])  //登录者添加别人
  	 {
  		$_html['frenid']=$_html['to_user'];
  	    if(empty($_html['state']))
  		{
  			$_html['state']= '<span style="color:red;">等待验证</span>';
  		}else {
  			$_html['state'] = '<span style="color:green;">通过</span>';
  		}
  	 }
  	
  	
  
  ?>
  <tr><td><?php echo $_html['frenid'];?></td><td  title='<?php echo $_html['content'];?>'><?php echo _title($_html['content'],12);?></td><td><?php echo $_html['date']?></td><td><?php echo $_html['state']?><td><input name="ids[]" value="<?php echo $_html['id']?>" type="checkbox" /></td></tr>
  <?php 
  }?>
  <tr><td colspan=5><label for="all">全选<input name="checkall" type="checkbox" id="all" /></label> <input type="submit" name="delall" value="删除所选" /></td></tr>
  </table>
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
	  <li>共有<strong><?php echo $_nums;?></strong>个好友| </li>
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