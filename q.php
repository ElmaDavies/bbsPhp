<?php
/*
*TestGuest Version 1.0
* ==========================================
* Copy 2016-2016 mook
* ===========================================
* Author:mo
* Date:2016-8-27
*/
//定义常量授权调用includes里的文件


define('IN_TG',true);
if(isset($_GET['num'])&&isset($_GET['path']))
{
	$_path = './'.$_GET['path'];
  
}else {
	echo "<script>alert('非法登录');history.back();</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title><?php echo $_system['webname']?>--Q图选择</title>
<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/q.css" />


<script type="text/javascript" src="js/qopener.js"></script>
</head>

<body>
<div id="q">
<h3>q图选择</h3>
<dl>

<?php foreach(range(0,$_GET['num'])as $_num){?>
<dd><img src="<?php echo $_path.'/'.$_num; ?>.gif" alt="./<?php echo $_path.'/'.$_num;?>.gif" title="<?php echo $_num;?>" /></dd>
<?php } ?>

</dl>
</div>

</body>
</html>