<?php
/*
 *TestGuest Version 1.0
 * ==========================================
 * Copy 2016-2016 mook
 * ===========================================
 * Author:Mook
 * Date:2016-8-21
 */
define('SCRIPT','blog'); 
define('IN_TG',TRUE);
require "includes/common.inc.php";
require "includes/globa.fun.php";
//从数据库里提取数据
$_nums = mysql_num_rows(mysql_query('SELECT tg_id FROM ta_user'));
//分页参数
$_system['article'] = 15;
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
	$_pagesolute = ceil($_nums/$_system['blog']); //ceil 取得的显示数据的页数并进位进位
}
if($_page > $_pagesolute)
{
	$_page = $_pagesolute;
}
$_page_num = ($_page-1)*$_system['blog'];



$sql = "SELECT tg_id,tg_username,tg_sex,tg_face FROM ta_user LIMIT $_page_num,{$_system['blog']}";
$_result = mysql_query($sql);

?>
<?php 
require "includes/header.inc.php";
require "includes/title.inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<title><?php echo $_system['webname']?>--好友列表</title>
</head>
<script type='text/javascript' src='js/blog.js'></script>
<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/photo.css" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<body>
<div id="blog">
<h2><?php echo $_system['webnaem']?>--好友列表</h2>
<?php while(!!$rows=mysql_fetch_array($_result)){
 $_html['id'] = $rows['tg_id'];
 $_html['username'] = $rows['tg_username'];
 $_html['sex'] = $rows['tg_sex'];
 $_html['face'] = $rows['tg_face'];
 $_html = _html($_html);
?>
<dl>
<dd class="user"><?php echo $_html['username'];?>(<?php echo $_html['sex'];?>)</dd>
<dt><img src="<?php echo $_html['face'];?>" alt="头像" /></dt>
<dd class="friend"><a href='javcscript:;' name='frenid' title="<?php echo $_html['id'];?>">加好友</a></dd>
<dd class="flower"><a href='javascript:;' name='flower' title="<?php echo $_html['id'];?>">给他送花</a></dd>
<dd class="message"><a href='javascript:;' name='message' title="<?php echo $_html['id'];?>">发消息</a></dd>
<dd class="guest">写留言</dd>
</dl>
<?php }?>

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
	  <li>共有<strong><?php echo $_nums;?></strong>个会员| </li>
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

<?php 
require 'includes/footer.inc.php';
//结果集的销毁
mysql_free_result($_result);
?>
</body>
</html>