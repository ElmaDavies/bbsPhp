<?php 



define('IN_TG',true);
session_start();
require "includes/common.inc.php";
require_once("includes/reg.func.php");
require "includes/globa.fun.php";
require_once("includes/mysql.func.php");
if(!isset($_COOKIE['username']))
{
	echo "<script>alert('非法操作');history.back();</script>";
	exit();
}


if($_GET['action']=='up')
{
	if(!!$_rows = _fetch_array("SELECT
			tg_uniqid
			FROM
			ta_user
			WHERE
			tg_username='{$_COOKIE['username']}'

			LIMIT 1"))
	{
		_check_unqid($_COOKIE['uniqid'], $_rows['tg_uniqid']);
		//设置文件上传类型
		$_file = array('image/jpeg','image/pjpge','image/png','image/x-png','image/gif');
		//验证上传文件类型
		if(is_array($_file))
		{
			if(!in_array($_FILES['file']['type'],$_file))
			{
				echo "<script>alert('本站不允许上传此类文件');history.back();</script>";
	            exit();
			}
		}
		//判断上传出错类型
		if($_FILES['file']['error']>0)	
		{
			switch($_FILES['file']['error'])
			{
				case 1:

				    echo "<script>alert('上传文件大小超过约定值1');history.back();</script>";
				    exit();
				break;
				case 2:
					echo "<script>alert('上传文件大小超过约定值2');history.back();</script>";
					exit();
					break;
				case 3:
					echo "<script>alert('部分文件被上传');history.back();</script>";
					exit();
				break;
				case 4:
					echo "<script>alert('没有任何文件被上传');history.back();</script>";
					exit();
				break;
					
					
					
			}
			exit();
		}
		//判断文件大小
		if($_FILES['file']['size']>1000000)
		{
			echo "<script>alert('文件大小不得大于1MB');history.back();</script>";
			exit();
		}
		//获取文件后缀名
		$_n = explode('.',$_FILES['file']['name']);
		$_name = $_POST['dir'].'/'.time().'.'.$_n[1];
		
		//移动文件
		if(is_uploaded_file($_FILES['file']['tmp_name']))
		{
			if(!@move_uploaded_file($_FILES['file']['tmp_name'],$_name))
			{
				echo "<script>alert('移动失败');history.back();</script>";
				exit();
			
			}else {
				echo "<script>alert('上传成功');window.opener.document.getElementById('url').value='$_name';window.close();</script>";
				
			}
		}else {
			
			echo "<script>alert('临时文件不存在');history.back();</script>";
			exit();
			
		}
		


	}else {

		echo "<script>alert('非法登录');history.back();</script>";
		exit();
	}

}


?>
<html>
<head>
<title>网络安全协会--图片上传</title>
</head>
<body>
<div id="up_img" style="padding:10px;">
<form enctype="multipart/form-data" action="?action=up" method="POST">
<input name="MAX_FILE_SIZE" type="hidden" value="1000000" />
<input name="dir" type="hidden" value="<?php echo $_GET['dir']?>" />
图片选择：<input name="file" type="file" />
<input name="send" type="submit" value="上传" />
</form>
</div>
</body>
</html>