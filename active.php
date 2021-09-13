<?php
/*
*TestGuest Version 1.0
* ==========================================
* Copy 2016-2016 mook
* ===========================================
* 
* Date:2016-8-21
*/
define('IN_TG',true);
require "includes/common.inc.php";

if(isset($_GET['action'])&&isset($_GET['active'])&&$_GET['action']=='ok')
{
		$_active = $_GET['active'];
	if(_fetch_array("SELECT tg_active FROM ta_user WHERE tg_active='$_active' LIMIT 1" ))
	{
		_query("UPDATE ta_user SET tg_active=NULL WHERE tg_active='$_active' LIMIT 1");
		if(_affected_rows()==1)
		{
			mysql_close();
			echo "<script>alert('成功激活');location.href='login.php';</script>";
		}
		else
		{
			mysql_close();
			echo "<script>alert('激活失败，请重新注册！');location.href='reg.php';</script>";
	
        }
	}
	else{
		echo "<script>alert('非法操作');location.href='index.php';</script>";
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title><?php echo $_system['webname']?>--账户激活</title>
</head>
<link rel="shortcut icon" href="1.ico" />

<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/active.css" />

<body>
<?php
require "includes/header.inc.php";


?>
<div id="active">
 <h2>激活帐户</h2>
 <p>点击以下链接激活您的账号！</p>
 <a href='active.php?action=ok&amp;active=<?php echo $_GET['active']?>'>这个链接</a>
</div>
<?php
require "includes/footer.inc.php";
?>
</body>
</html>
