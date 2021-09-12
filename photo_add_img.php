<?php
define('SCRIPT','photo_add_img');
session_start();
define('IN_TG',TRUE);
if(!isset($_COOKIE['username']))
{
	echo "<script>alert('请先登录');history.back();</script>";
	exit();
}

require "includes/common.inc.php";
require_once("includes/reg.func.php");
require "includes/globa.fun.php";
require_once("includes/mysql.func.php");
require "includes/header.inc.php";
require "includes/title.inc.php";

//写入数据库
if($_GET['action']=='photo_add')
{
	if(!!$_rows = _fetch_array("SELECT tg_uniqid FROM ta_user WHERE tg_username = '{$_COOKIE['username']}' LIMIT 1"))
	{
		_check_unqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
	
		
	$_clean = array();
	$_clean['from_user'] = $_COOKIE['username'];
	$_clean['name'] = _check_username($_POST['name'],2,20);
	$_clean['dir'] = _check_url($_POST['url']);
	$_clean['content'] = $_POST['content'];
	$_clean['sid'] = $_POST['sid'];

	
	$_clean = _mysql_string($_clean);
	//写入数据库
	_query("INSERT INTO tg_picture 
			                (
			                tg_from_user,
			                tg_name,
			                tg_dir,
			                tg_sid,
			                tg_date,
			                tg_content) 
			        VALUES(
			                '{$_clean['from_user']}',
			                '{$_clean['name']}',
			                '{$_clean['dir']}',
			                '{$_clean['sid']}',
			                NOW(),
			                '{$_clean['content']}')");
	if(_affected_rows()==1)
	{
		mysql_close();
		echo "<script>alert('图片添加成功');location.href='photo_show.php?id={$_clean['sid']}';</script>";
	}else {
		
		mysql_close();
		echo "<script>alert('图片添加失败');history.back();</script>";
	}
			                		
	}	
			
	
}

if(isset($_GET['id']))
{
	if(!!$_rows = _fetch_array("SELECT tg_id,tg_dir FROM tg_photo WHERE tg_id='{$_GET['id']}' LIMIT 1"))
	{
		$_html = array();
		$_html['id'] = $_rows['tg_id'];
		$_html['dir'] = $_rows['tg_dir'];
		$_html = _html($_html);
	}

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<title><?php echo $_system['webname']?>--图片上传</title>
</head>

<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/photo_add_img.css" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script type="text/javascript" src="js/photo_add_img.js"></script>
<body>
<div id="photo_add">
<h2>图片上传</h2>
<form action="?action=photo_add" method="POST">
 <dl>
 
	<dd>图片名称：<input name="name" class="text" type="text" /></dd>
	<dd class="url">图片目录：<input name="url" id="url" class="text" type="text" readonly="readonly">&nbsp&nbsp<a href="javascript:;" title="<?php echo $_html['dir']?>" id="up">浏览</a></dd>
	<dd><input name="sid" type="hidden" value="<?php echo $_html['id']?>"></dd>
	<dd>图片描述：<textarea name="content"></textarea></dd>
	<dd><input type="submit" name="submit" value="上传" class="upload" /></dd>

 </dl>
</form>
 </div>
<?php 
require 'includes/footer.inc.php';

?>
</body>
</html>

