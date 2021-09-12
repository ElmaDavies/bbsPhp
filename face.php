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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html xmins="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>网络安全协会----头像选择</title>
<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/face.css" />


<script type="text/javascript" src="js/opener.js"></script>
</head>

<body>
<div id="face">
<h3><?php echo $_system['webname']?>--头像选择</h3>
<dl>

<?php foreach(range(1,9)as $num){?>
<dd><img src="face/0<?php echo $num; ?>.jpg" alt="face/0<?php echo $num;?>.jpg" title="<?php echo $num;?>" /></dd>
<?php } ?>
<?php foreach(range(10,70)as $num){?>
<dd><img src="face/<?php echo $num; ?>.jpg" alt="face/<?php echo $num;?>.jpg" title="<?php echo $num;?>" /></dd>
<?php } ?>
</dl>
</div>

</body>
</html>