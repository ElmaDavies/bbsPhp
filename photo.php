<?php
/*
 *TestGuest Version 1.0
 * ==========================================
 * Copy 2016-2016 mook
 * ===========================================
 * Author:Mook
 * Date:2016-8-21
 */
define('SCRIPT','photo'); 
define('IN_TG',TRUE);
require "includes/common.inc.php";
require "includes/globa.fun.php";
require_once 'thumb.php';
require "includes/header.inc.php";
require "includes/title.inc.php";

//分页模块

$_nums = mysql_num_rows(mysql_query('SELECT tg_id FROM tg_photo'));
//分页参数
$_system['photo'] = 10;
if(isset($_GET['page'])) //容错处理
{

	$_page = $_GET['page'];
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



$sql = "SELECT tg_id,tg_name,tg_type,tg_face FROM tg_photo ORDER BY tg_time DESC  LIMIT $_page_num,{$_system['photo']}";
$_result = mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<title><?php echo $_system['webname']?>--相册列表</title>
</head>

<link rel="shortcut icon" href="1.ico" />

<link rel="stylesheet" type="text/css" href="style/1/picture.css" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<body>
<div id="picture" style="height:650px;">
<h2>相册列表</h2>
<?php while(!!$rows=mysql_fetch_array($_result)){
 $_html['id'] = $rows['tg_id'];
 $_html['name'] = $rows['tg_name'];
 $_html['type'] = $rows['tg_type'];
 
 if(empty($_html['type']))
 {
 	$_html_type = '(公开)';
 }else
 {
 	$_html_type = '(私密)';
 }
 
 $_html['min_id'] = _fetch_array("SELECT max(tg_id) as id FROM tg_picture WHERE tg_sid = '{$_html['id']}'");
 $_html['photo_count'] = _fetch_array("SELECT COUNT(*) as count FROM tg_picture WHERE tg_sid = '{$_html['id']}'");
 if(!!$_rows_dir = _fetch_array("SELECT tg_dir FROM tg_picture WHERE tg_sid = '{$_html['id']}' AND tg_id = '{$_html['min_id']['id']}'"))
 {
 	$_html['face'] = $_rows_dir['tg_dir'];
 }

 $_html = _html($_html);
?>
 <dl>
  <dt><a href='photo_show.php?id=<?php echo $_html['id'];?>'><img src="thumb.php?file=<?php echo $_html['face']?>" alt="添加图片" /></a></dt>
   <dd><a href='photo_show.php?id=<?php echo $_html['id'];?>'><?php echo $_html['name'].$_html_type.($_html['photo_count']['count']);?></a></dd>
   <dd>[<a href='photo_modiefy.php?id=<?php echo $_html['id']?>'>修改</a>][删除]</dd>
 </dl>
<?php }?>

<p><a href="photo_add.php">添加相册</a></p>

  
  <div id="page_text">
    <ul>
	  <li><?php echo $_page?>/<?php echo $_pagesolute?>页| </li>
	  <li>共有<strong><?php echo $_nums;?></strong>个相册| </li>
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

?>
</body>
</html>