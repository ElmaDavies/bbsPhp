<?php
/*
 *TestGuest Version 1.0
 * ==========================================
 * Copy 2016-2016 mook
 * ===========================================
 * Author:Mook
 * Date:2016-8-21
 */
define('SCRIPT','photo_show'); 
define('IN_TG',TRUE);
require "includes/common.inc.php";
require "includes/globa.fun.php";
require_once 'includes/mysql.func.php';
require "includes/header.inc.php";
require "includes/title.inc.php";
$_nums = mysql_num_rows(mysql_query("SELECT tg_id FROM tg_picture WHERE tg_sid='{$_GET['id']}'"));
//分页参数
$_system['photo'] = 8;

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
//$_system['article']每页数据；
//$_page_num每页开始的数据
//$nums取得总共的数据
//如果数据数为零
if($_nums == 0)
{
	$_pagesolute = 1;
}else{
	$_pagesolute = ceil($_nums/$_system['photo']); //ceil 取得的显示数据的页数并进位进位
}
if($_page > $_pagesolute)
{
	$_page = $_pagesolute;
}
$_page_num = ($_page-1)*$_system['photo'];



$sql = "SELECT tg_id,tg_from_user,tg_dir,tg_name,tg_date,tg_read,tg_comment,tg_sid FROM tg_picture WHERE tg_sid ='{$_GET['id']}' ORDER BY tg_date DESC LIMIT $_page_num,{$_system['photo']}";
$_result = mysql_query($sql);
if(isset($_GET['id']))
{
	if(!!$_rows = _fetch_array("SELECT tg_id,tg_dir,tg_name,tg_type FROM tg_photo WHERE tg_id='{$_GET['id']}' LIMIT 1"))
	{
		$_html = array();
		$_html['id'] = $_rows['tg_id'];
		$_html['name'] = $_rows['tg_name'];
		$_html['dir'] = $_rows['tg_dir'];
		$_html['type'] = $_rows['tg_type'];
		$_html = _html($_html);
		
	}
	
}
$_id = 'id='.$_GET['id'].'&';
if($_GET['action']=='password')
{
	if($_rows=_fetch_array("SELECT tg_id FROM tg_photo WHERE tg_password= '".sha1($_POST['password'])."' LIMIT 1"))
	{
		@setcookie('photo',$_html['name']);
		
	}else {
		
		echo "<script>alert('相册密码不正确');history.back();</script>";
	}
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<title><?php echo $_system['webname']?>--图片展示</title>
</head>

<link rel="shortcut/icon" href="1.ico" />

<link rel="stylesheet" type="text/css" href="style/1/photo_show.css" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<body>
<div id="picture">
<?php if(empty($_html['type'])||isset($_COOKIE['photo'])||isset($_SESSION['admin'])){?>
<h2><?php echo $_html['name']?></h2>

<?php 
$_html = array();
while(!!$rows = mysql_fetch_array($_result)){
	$_html['id'] = $rows['tg_id'];
	$_html['from_user'] = $rows['tg_from_user'];
	$_html['dir'] = $rows['tg_dir'];
	$_html['name'] = $rows['tg_name'];
	$_html['read'] = $rows['tg_read'];
	$_html['comment'] = $rows['tg_comment'];
	$_html = _html($_html);
	$_filename= $_html['dir'];
	
?>

<dl>
<dt><a href="photo_detail.php?id=<?php echo $_html['id']?>"><img src="thumb.php?filename=<?php echo $_filename?>" /></a><dt>
<dd>图片名称：<?php echo $_html['name']?></dd>
<dd>阅(<?php echo $_html['read']?>)评(<?php echo $_html['comment']?>)上传者:<?php echo $_html['from_user']?></dd>
</dl>
<?php }?>
<p><a href='photo_add_img.php?id=<?php echo $_GET['id']?>'>图片上传</a></p>
<div id="page_text">
    <ul>
	  <li><?php echo $_page?>/<?php echo $_pagesolute?>页| </li>
	  <li>共有<strong><?php echo $_nums;?></strong>张图片| </li>
	  <?php 
	  if($_page == 1)
	  {
	  	echo '<li>首页| </li>';
	  	echo '<li>上一页| </li>';
	  }else
	  {
	  	echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page=1">首页| </a></li>';
	  	echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'">上一页|</a></li>';
	  }
	  if($_page == $_pagesolute)
	  {
	  	echo '<li>下一页|</li>';
	  	echo '<li>尾页|</li>';
	  }else 
	  {
	  	echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'">下一页|</li>';
	  	echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.$_pagesolute.'">尾页</li>';
	  }
	  ?>
	</ul>
  </div>
  <?php 
     


    }else {
  
  	echo "<form action='?action=password' method='POST'>";
  	echo "<dd style='text-align:center;padding-top:40px;font-size:20px;font-family:STXinWei;'>请输入相册密码</dd>";
  	echo "<dd style='text-align:center;padding-top:10px'><input name='password' type='password' />&nbsp&nbsp<input type='submit' name='submit' value='确认' style='cursor:pointer;width:40px'></dd>";
  	echo "</form>";
  	
  	
  }?>
  </div>
<?php 
require 'includes/footer.inc.php';
//结果集的销毁

?>
</body>
</html>