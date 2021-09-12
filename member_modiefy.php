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
session_start();
require "includes/common.inc.php";



require 'includes/globa.fun.php';


//修改资料
if($_GET['action']=='modiefy')
{
	include 'includes/reg.func.php';
	if(!empty($_system['code']))
	{
	_check_code($_POST['yzm'],$_SESSION['code']);
	}
	//唯一标识符验证
	if(!!$_rows=_fetch_array("SELECT tg_uniqid FROM ta_user WHERE  tg_username='{$_COOKIE['usernamne']}'"))
	{
		if($_rows['tg_uniqid']!=$_COOKIE['uniqid'])
		{
			echo "<script>alert('唯一标识符异常');history.back();</script>";
		}
		
	
	}
		
	
		
		$_clean = array();
		$_clean['tg_sex'] = _check_sex($_POST['sex']);
		$_clean['tg_qq'] = _check_qq($_POST['m_qq']);
		$_clean['tg_email']= _check_email($_POST['m_email']);
		$_clean['tg_face'] = _check_face($_POST['face']);
		$_clean['password'] = _check_modiefy_password($_POST['n_password'],6);
		$_clean['switch'] = $_POST['switch'];
		$_clean['sign'] = _check_post_sign($_POST['sign'],200);
		
	
		if(empty($_clean['password']))
		{
			_query("UPDATE ta_user 
					    SET tg_qq='{$_clean['tg_qq']}',
					        tg_face='{$_clean['tg_face']}',
					        tg_email='{$_clean['tg_email']}',
					        tg_sex='{$_clean['tg_sex']}',
					        tg_switch = '{$_clean['switch']}',
					        tg_sign_content = '{$_clean['sign']}'
					     WHERE tg_username='{$_COOKIE['username']}'");
		}
		else 
		{
			_query("UPDATE ta_user
					SET tg_qq='{$_clean['tg_qq']}',
					tg_password='{$_clean['password']}',
					tg_face='{$_clean['tg_face']}',
					tg_email='{$_clean['tg_email']}',
					tg_sex='{$_clean['tg_sex']}'
					tg_switch = '{$_clean['switch']}',
					tg_sign_content = '{$_clean['sign']}'
					WHERE tg_username='{$_COOKIE['username']}'");
		}
	
	if(_affected_rows()==1)
	{
			mysql_close();
			//session_destroy();
			echo "<script>alert('恭喜你，修改成功');location.href='member.php';</script>";
	}else
		{
			mysql_close();
			//session_destroy();
			echo "<script>alert('很遗憾，没有任何修改');location.href='member_modiefy.php';</script>";
		}
	
}
if(isset($_COOKIE['username']))
{
   $_rows = _fetch_array("SELECT tg_username,tg_password,tg_sex,tg_qq,tg_email,tg_switch,tg_sign_content FROM ta_user WHERE tg_username='{$_COOKIE['username']}'",MYSQL_ASSOC);
   if(isset($_rows)){
   	$_html = array();
   	$_html['username'] = $_rows['tg_username'];
   	$_html['sex'] = $_rows['tg_sex'];
   	$_html['qq'] = $_rows['tg_qq'];
   	$_html['face'] = $_rows['tg_face'];
   	$_html['email'] = $_rows['tg_email'];
   	$_html['switch'] = $_rows['tg_switch'];
   	$_html['sign_content'] = $_rows['tg_sign_content'];
   	
   
   	$_html = _html($_html);
   	//性别选择
   	if($_html['sex']=='男'){
   		$_html['sex_html']="<input type='radio' name='sex' value='男' checked='checked' />男<input type='radio' value='女'name='sex' />女";
   	}else
   	{
   		$_html['sex_html']="<input type='radio' name='sex' value='男' />男<input type='radio' value='女'name='sex' checcked='checked' />女";
   	}
   	//签名设置
   	if($_html['switch']==0)
   	{
   		$_html['sign_switch'] = '<input type="radio" name="switch" value="0" checked="checked"/>禁用<input type="radio" name="switch" value="1" />启用';
   		$_html['sign_content'] = null;
   	}elseif($_html['switch']==1)
   	{
   		$_html['sign_switch'] = '<input type="radio" name="switch" value="0" />禁用<input type="radio" name="switch" value="1" checked="checked"/>启用 ';
   	}
   	//头像选择
   	$_html['face_html']='<select name="face">';
   	foreach(range(1,9) as $_num)
   	{
   		$_html['face_html'].='<option value="face/0'.$_num.'.jpg">face/0'.$_num.'.jpg</option>';
   		
   	}
   	foreach(range(10,70) as $_num)
   	{
   		$_html['face_html'].='<option value="face/'.$_num.'.jpg">face/'.$_num.'.jpg</option>';
   		 
   	}
   	$_html['face_html'].='</select>';
   	
}else {
	echo "<script>alert('非法登录');history.back();</script>";
}
}

else 
{
	echo "<script>alert('该用户不存在');history.back();</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $_system['webname']?>--修改资料</title>
</head>
<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/member.css" />
<link rel="stylesheet" type="text/css" href="style/1/member_modiefy.css" />

<body>
<?php
require "includes/header.inc.php";

?>

<div id="member_modiefy">
  <div id="daohanglan_modiefy">
    <h2>会员管理中心</h2>

      <dl>
        <dt>账号管理</dt>
        <dd><a href="member.php">个人中心</a></dd>
        <dd><a href="member_modiefy.php">修改资料</a></dd>
        <dd><a href="face_modiefy.php">头像上传</a></dd>
        
        
      </dl>
      <dl>
        <dt>其他管理</dt>
        <dd><a href="member_message.php">短信查阅</a></dd>
        <dd><a href="member_frenid.php">好友设置</a></dd>
        <dd><a href="###">送花查询</a></dd>
        <dd><a href="###">个人相册</a></dd>
        
      </dl>
  </div>
  <div id="main_modiefy">
  <form action="member_modiefy.php?action=modiefy" method='post'>
   <h2>个人信息</h2>
     <dl>
      <dd>用&nbsp户&nbsp名：<?php echo $_rows['tg_username'];?></dd>
      <dd>修改密码：<input name="n_password" class="m_password" type="password" />(若不修改则为空)</dd>
      <dd>头&nbsp&nbsp&nbsp&nbsp像：<?php echo $_html['face_html'];?></dd>
      <dd>性&nbsp&nbsp&nbsp&nbsp别：<?php echo $_html['sex_html'];?></dd>
      <dd>邮&nbsp&nbsp&nbsp&nbsp箱：<input name='m_email' class='email' value='<?php  echo $_html['email'];?>' type='text'></dd>
      <dd>QQ：&nbsp&nbsp&nbsp&nbsp&nbsp<input name='m_qq' type='text' class='qq' value='<?php echo $_html['qq'];?>' /></dd>
      <dd>个性签名：<?php echo $_html['sign_switch']?>
        <p><textarea name="sign" ><?php echo $_html['sign_content']?></textarea></p>
      </dd>
      <?php if(!empty($_system['code'])){?>
      <dd>验&nbsp证&nbsp码：<input type="text" name="yzm" class="m_code" />&nbsp<img src="code.php" id="code" onclick="javascript:this.src='code.php?tm='+Math.random()" /></dd>
      <?php }?>
      <dd><input type='submit' class='submit' value='修改资料' /></dd>
     </dl>
  </form>
  
  </div>
  
</div>

<?php

require "includes/footer.inc.php";

?>
</body>
</html>