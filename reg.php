<?php

/*
*TestGuest Version 1.0
* ==========================================
* 
* ===========================================
*
* Date:2016-8-21
*/
define('IN_TG',true);
//定义常量授权调用includes里的文件
require "includes/common.inc.php";

//开始激活处理





//选择数据库
mysql_select_db(DB_NAME) or die('指定的数据库不存在！');
//选择字符集
mysql_query('SET NAMES UTF8') or die('字符集选择失败！');


//引入公共文件
session_start();

define('SCRIPT',reg);
require "includes/globa.fun.php";
_login_state();
if($_GET['action']=='reg')
{
	if(empty($_system['reg']))
	{
		exit('不要非法注册');
	}
		//引入函数文件,在代码内部引用一般用include
	require "includes/reg.func.php";
	//验证码的验证
	if(!empty($_system['code']))
	{
		_check_code($_POST['yzm'],$_SESSION['code']);
	}
	//可以通过唯一标识符防止恶意注册，跨站攻击
	
	$_clean=array();
	$_clean['unqid'] = _check_unqid($_POST['unqid'],$_SESSION['unqid']);
	//创建一个二次唯一标识符，方便用户注册时激活帐户，方可登陆
	$_clean['active'] = sha1(uniqid(rand(),true));
	$_clean['username']=_check_username($_POST['username'],2,20);
	$_clean['password'] = _check_password($_POST['password'],$_POST['notpassword'],6);
	$_clean['question'] = _check_question($_POST['question'],4,20); 
	$_clean['answer'] = _check_answer($_POST['answer'],$_POST['qusetion'],2,20);
	$_clean['sex'] = _check_sex($_POST['sex']);
	$_clean['face'] = _check_face($_POST['face']);
	$_clean['email']= _check_email($_POST['email']);
	$_clean['qq'] = _check_qq($_POST['qq']);
	//新增用户
    $_username=$_clean['username'];

	if(_fetch_array("SELECT tg_username FROM ta_user WHERE tg_username='$_username' LIMIT 1"))
	{
	  echo 	"<script>alert('该用户名已被占用!');history.back();</script>";
	}
	
	
	else{
		mysql_query("INSERT INTO ta_user(
                                 tg_uniqid,
								 tg_active,
                                 tg_username,
								 tg_password,
								 tg_question,
								 tg_answer,
								 tg_sex,
								 tg_face,
								 tg_email,
								 tg_qq,
								 tg_reg_time,
								 tg_login_time,
								 tg_last_ip) 
                                VALUES(
							          '{$_clean['unqid']}',
									  '{$_clean['active']}',
									  '{$_clean['username']}',
									  '{$_clean['password']}',
									  '{$_clean['question']}',
									  '{$_clean['answer']}',
									  '{$_clean['sex']}',
									  '{$_clean['face']}',
									  '{$_clean['email']}',
									  '{$_clean['qq']}',
									  NOW(),
									  NOW(),
									  '{$_SERVER["REMOTE_ADDR"]}'
										   )") or die('sql'.mysql_error()
										   );
		if(_affected_rows()==1)
		{
			$_clean['id']=mysql_insert_id();
			mysql_close();
			//session_destroy();
			//生成xml
			
			_set_xml('new.xml',$_clean);
			echo "<script>alert('恭喜你注册成功');location.href='active.php?active=".$_clean['active']."';</script>";
			
		}
		else{
			mysql_close();
			//session_destroy();
			echo "<script>alert('对不起，注册失败！');location.href='reg.php';</script>";
			
		}
	}
	
		
}

else{
		
$_SESSION['unqid']= $_unqid = sha1(uniqid(rand(),true));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<title><?php echo $_system['webname']?>--注册</title>
<script type="text/javascript";src="js/register.js"></script>

<?php
require "includes/title.inc.php";

?>

<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/reg.css" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>

<script type="text/javascript" src="js/register.js"></script>
<?php
include "includes/header.inc.php";

?>

<div id="reg">
<h2>会员注册</h2>
<?php if(!empty($_system['reg'])){?>
<form method="post" name="reg" action="reg.php?action=reg">
 <input type='hidden' name='unqid' value=<?php echo $_unqid;?>>
 <dl>
 <dt>请认真填写以下内容</dt>
 <dd>用 户 名:<input type="text" name="username" class="text" /></dd>
 <dd>密&nbsp&nbsp码:<input type="password" name="password" class="text" /></dd>
 <dd>确认密码:<input type="password" name="notpassword" class="text" /></dd>
 <dd>密码提示:<input type="text" name="question" class="text" /></dd>
 <dd>密码回答:<input type="text" name="answer" class="text" /></dd>
 <dd>性&nbsp&nbsp&nbsp别:<input type="radio" name="sex" value="男" checked="checked"/>男<input type="radio" name="sex" value="女"/>女</dd>
 <dd class="face"><input type="hidden" name="face" value="face/01.jpg" id="face"><img src="face/01.jpg" alt="头像选择" id="faceimg"></dd>
 <dd>电子邮件:<input type="text" name="email" class="text" /></dd>
 <dd>QQ:&nbsp&nbsp&nbsp<input type="text" name="qq" class="text" /></dd>
 <?php if(!empty($_system['code'])){?>
 <dd>验 证 码:<input type="text" name="yzm" class="text yzm"><img src="code.php" id="code" onclick="javascript:this.src='code.php?tm='+Math.random()" /></dd>

 <?php } ?>
 

 <dd><input type="submit" name="submit" class="submit"value="注册"></dd>
 <?php }else {
?>
<dd style="text-align:center;padding:20px">本站已关闭注册</dd>
<?php }?>
 </dl>
</form>

</div>
<?php
require "includes/footer.inc.php";
mysql_close();
?>
</body>
</html>
