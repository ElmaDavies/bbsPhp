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
require "includes/common.inc.php";
require 'includes/globa.fun.php';
if(!isset($_COOKIE['username'])||!isset($_SESSION['admin']))
{
	echo "<script>alert('非法登录');history.back();</script>";
}

if(!!$_rows = _fetch_array("SELECT 
		                           tg_webname,
		                           tg_blog,
		                           tg_article,
		                           tg_blog,
		                           tg_photo,
		                           tg_string,
		                           tg_code,
		                           tg_reg
		                   FROM
		                           tg_system
		                   WHERE   
		                           tg_id=0") )
{
	$_html = array();
	$_html['webname'] = $_rows['tg_webname'];
	$_html['blog'] = $_rows['tg_blog'];
	$_html['article'] = $_rows['tg_article'];
	$_html['photo'] = $_rows['tg_photo'];
	$_html['string'] = $_rows['tg_string'];
	$_html['code'] = $_rows['tg_code'];
	$_html['reg'] = $_rows['tg_reg'];
	$_html = _html($_html);
	if($_html['blog']==15)
	{
		$_html['blog_number'] = '<select name="blog"><option value="15" selected="selected">每页显示15条数据</option><option value="20">每页显示20条数据</option></select>';
		
	}elseif($_html['blog']==20)
	{
		$_html['blog_number'] = '<select name="blog"><option value="20" selected="selected">每页显示20条数据</option><option value="15">每页显示15条数据</option></select>';
	}
	if($_html['article']==10)
	{
		$_html['article_number'] = '<select name="article"><option value="10" selected="selected">每页显示10条数据</option><option value=12>每页显示12条数据</option></select>';
	
	}elseif($_html['article']==12)
	{
		$_html['article_number'] = '<select name="article"><option value="12" selected="selected">每页显示12条数据</option><option value=10>每页显示10条数据</option></select>';
	}
	if($_html['photo']==12)
	{
		$_html['photo_number'] = '<select name="photo"><option value="12" selected="selected">每页显示12条数据</option><option value=16>每页显示16条数据</option></select>';
	
	}elseif($_html['photo']==16)
	{
		$_html['photo_number'] = '<select name="photo"><option value="12" >每页显示12条数据</option><option selected="selected" value="16">每页显示16条数据</select>';
	}
	//验证码
	if($_html['code']==1)
	{
		$_html['code_html'] = '<input type="radio" name="code" value="1" checked="checked"/>启用&nbsp&nbsp&nbsp<input name="code" type="radio" value="0" />禁用';
	}else{
		$_html['code_html'] = '<input type="radio" name="code" value="1" />启用&nbsp&nbsp&nbsp<input name="code" type="radio" value="0" checked="checked" />禁用';
	}
	//开放注册
	if($_html['reg']==1)
	{
	   	$_html['reg_html'] = '<input type="radio" name="reg" value="1" checked="checked"/>开放注册&nbsp&nbsp&nbsp<input type="radio" name="reg" value="0" />关闭注册';
	}else {
		$_html['reg_html'] = '<input type="radio" name="reg" value="1" />开放注册&nbsp&nbsp&nbsp<input name="reg" value="0" checked="checked" type="radio" />关闭注册';
	}
}else {
	echo "<script>alert('数据出现错误！');history.back();</script>";
}
//修改数据

if($_GET['action']=='admin_set')
{

	//验证唯一标识符，防止cookie伪造
	
	if(!!$_rows=_fetch_array("SELECT tg_uniqid FROM ta_user WHERE  tg_username='{$_COOKIE['usernamne']}'"))
	{
		if($_rows['tg_uniqid']!=$_COOKIE['uniqid'])
		{
			echo "<script>alert('唯一标识符异常');history.back();</script>";
		}
		
	
	
	}
	$_clean = array();
	$_clean['webname'] = $_POST['webname'];
	$_clean['blog'] = $_POST['blog'];
	$_clean['photo'] = $_POST['photo'];
	$_clean['article'] = $_POST['article'];
	$_clean['string_filter'] = $_POST['string_filter'];
	$_clean['code'] = $_POST['code'];
	$_clean['reg'] = $_POST['reg'];
     _mysql_string($_clean);
     _query("UPDATE 
     		       tg_system
     		SET 
     		        tg_webname = '{$_clean['webname']}',
     		        tg_blog = '{$_clean['blog']}',
     		        tg_photo = '{$_clean['photo']}',
     		        tg_article = '{$_clean['article']}',
     		        tg_string = '{$_clean['string_filter']}',
     		        tg_code = '{$_clean['code']}',
     		        tg_reg = '{$_clean['reg']}'
     		        
     		        
     		WHERE 
     		       tg_id = 0
     		LIMIT
     		       1");
     if(_affected_rows()==1)
     {
     	mysql_close();
     	echo "<script>alert('系统设置成功');location.href='admin.php';</script>";
     	
     }else {
     	mysql_close();
     	echo "<script>alert('系统设置失败');history.back();</script>";
     	
     }
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_system['webname']?>--系统设置</title>
</head>
<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/admin.css" />
<body>
<?php
require "includes/header.inc.php";
?>
<div id="member">
  <div id="daohanglan">
    <h2>管理导航</h2>
      <dl>
        <dt>后台管理</dt>
        <dd><a href="admin.php">系统信息</a></dd>
        <dd><a href="member_modiefy.php">后台首页</a></dd>
         <dd><a href="admin_set.php">系统设置</a></dd>
       </dl>
       <dl>
        <dt>会员管理</dt>
        <dd><a href="member_list.php">会员列表</a></dd>
        <dd><a href="member_set.php">会员设置</a></dd>
      </dl>
      
  </div>
  <div id="main">
   <h2>系统中心</h2>
   <form method="POST" action="?action=admin_set">
     <dl>
     
          <dd>网       站      名    称：<input name="webname" type="text" style="border:#999 1px solid;width:180px;height:20px" value=".<?php echo $_html['webname']?>." /></dd>
          <dd>文章每页列表数：  <?php echo $_html['article_number']?></dd>
          <dd>博友每页列表数： <?php echo $_html['blog_number']?></dd>
          <dd>相册每页列表数： <?php echo $_html['photo_number']?></dd>
          <dd>非法·字符·过滤：<input name="string_filter" type="text" style="border:#999 1px solid;width:180px;height:20px" value=".<?php echo $_html['string']?>." /></dd>
          <dd>是否启用验证码： <?php echo $_html['code_html']?></dd>
          <dd>是 否 开 放 注 册：<?php echo $_html['reg_html']?></dd>
          <dd style="line-height:30px"><input style="width:120px;height:25px;cursor:pointer" name="modiefy" type="submit" value="修改系统设置" /></dd>
     
     </dl>
  </form>
  </div>
  
</div>

<?php
require "includes/footer.inc.php";
?>
</body>
</html>