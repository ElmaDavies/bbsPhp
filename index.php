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
define('SCRIPT',index);
require_once("includes/common.inc.php");
require "includes/globa.fun.php";
//读取xml文件
$_html=_html(_get_xml('new.xml'));
//从数据库里提取数据
$_nums = mysql_num_rows(mysql_query('SELECT tg_id FROM tg_article'));
//分页参数
$_sysstem['article'] = 10;
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
//$_sysstem['article']每页数据；
//$_page_num每页开始的数据
//$nums取得总共的数据
//如果数据数为零
if($_nums == 0)
{
	$_pagesolute = 1;
}else{
	$_pagesolute = ceil($_nums/$_system['article']); //ceil 取得的显示数据的页数并进位进位
}
if($_page > $_pagesolute)
{
	$_page = $_pagesolute;
}
$_page_num = ($_page-1)*$_system['article'];



$sql = "SELECT tg_id,tg_username,tg_content,tg_title,tg_type,tg_read_count,tg_comment_count,tg_date FROM tg_article ORDER BY tg_id DESC LIMIT $_page_num,{$_system['article']}";
$_result = mysql_query($sql);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_system['webname']?>--首页</title>
</head>
<script type="text/javascript" src="js/blog.js"></script>
<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<body>
<?php
require "includes/header.inc.php";
?>
<?php
require "includes/feilei.inc.php";
?>
<div id="user">
<h2>新增用户</h2>
<dl>
<dd class="user"><?php echo $_html['username']?>(<?php echo $_html['sex']?>)</dd>
<dt><img src="<?php echo $_html['face']?>" alt="<?php echo $_html['username']?>" /></dt>
<dd class="friend"><a href='javcscript:;' name='frenid' title=<?php echo $_html['id']?>>加好友</a></dd>
<dd class="flower"><a href='javascript:;' name='flower' title=<?php echo $_html['id']?>>给他送花</a></dd>
<dd class="message"><a href='javascript:;' name='message' title=<?php echo $_html['id']?>>发消息</a></dd>
<dd class="guest">写留言</dd>
</dl>
</div>
<div id="list">
<h2>帖子列表</h2>
 <a href="post.php" class="post"></a>
  <ul class="article">
     <?php 
     $_htmllist = array();
     while(!!$_rows = mysql_fetch_array($_result)){
     	$_htmllist['id'] = $_rows['tg_id'];
     	$_htmllist['type'] = $_rows['tg_type'];
     	$_htmllist['title'] = $_rows['tg_title'];
     	$_htmllist['read_count'] = $_rows['tg_read_count'];
     	$_htmllist['comment_count'] = $_rows['tg_comment_count'];
     	$_htmllist = _html($_htmllist);
   
     echo '<li class="icon'.$_htmllist['type'].'"><em>评论(<strong>'.$_htmllist['comment_count'].'</strong>)阅读(<strong>'.$_htmllist['read_count'].'</strong>)</em><img src="images/'.$_htmllist['type'].'"><a href="article.php?id='.$_htmllist['id'].'">'._title($_htmllist['title'],20).'</a></li>';
     }
     ?>
   
  
   </ul>
  </div>
  
  
  
     
 


<div id="news">
<h2>协会新闻</h2>
</div>

  
 <div id="page_text">
    <ul>
	  <li><?php echo $_page?>/<?php echo $_pagesolute?>页| </li>
	  <li>共有<strong><?php echo $_nums;?></strong>条帖子| </li>
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
  
<?php
require "includes/footer.inc.php";
?>
</body>
</html>