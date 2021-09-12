<?php

/*
 *TestGuest Version 1.0
* ==========================================
* Copy 2016-2016 mook
* ===========================================
* Author:Mook
* Date:2016-8-21
*/
define('SCRIPT','photo_detail');
session_start();
define('IN_TG',TRUE);
require "includes/common.inc.php";
require "includes/globa.fun.php";
require_once 'includes/reg.func.php';
require "includes/header.inc.php";
require "includes/title.inc.php";
require_once 'includes/mysql.func.php';
//评论内容
if(isset($_GET['id'])&&($_GET['action']=='re_photo'))
{
	if(isset($_COOKIE['username']))
	{
		//验证码正误判断
		_check_code($_POST['yzm'],$_SESSION['code']);
		//验证唯一标识符，防止cookie伪造
		if(!!$_rows=_fetch_array("SELECT tg_uniqid FROM ta_user WHERE  tg_username='{$_COOKIE['usernamne']}'"))
		{
			if($_rows['tg_uniqid']!=$_COOKIE['uniqid'])
			{
				echo "<script>alert('唯一标识符异常');history.back();</script>";
			}
				
	
		}
		
		$_clean = array();
		$_clean['pid'] = $_GET['id'];
		$_clean['username'] = $_COOKIE['username'];
		$_clean['content'] = _check_post_content($_POST['content'],0);
		
		_query("INSERT INTO tg_photo_comment
				                             (tg_comment,
				                              tg_username,
				                              tg_pid,
				                              tg_date
				                           ) 
				                     VALUES(
				                             '{$_clean['content']}',
				                             '{$_clean['username']}',
				                             '{$_clean['pid']}',
				                             NOW()
				                             )");
		if(_affected_rows()==1)
		{
			_query("UPDATE tg_picture SET tg_comment=tg_comment+1 WHERE tg_id='{$_GET['id']}'");
		
			mysql_close();
			//session_destroy();
			echo "<script>alert('回复成功');location.href='photo_detail.php?id=".$_GET['id']."';</script>";
		}
		else
		{
			mysql_close();
			//session_destroy();
			echo "<script>alert('回复失败');history.back();</script>";
		}
		
	}else {
		
		echo "<script>alert('请先登录');history.back();</script>";
	}
	
}

if(isset($_GET['id'])||(!empty($_GET['id'])))
{
	if(!!$_rows = _fetch_array("SELECT tg_id,tg_dir,tg_name,tg_from_user,tg_content,tg_read,tg_comment,tg_date,tg_sid FROM tg_picture WHERE tg_id='{$_GET['id']}' LIMIT 1"))
	{
		$_html = array();
		$_html['id'] = $_rows['tg_id'];
		$_html['read'] = $_rows['tg_read'];
		$_html['comment'] = $_rows['tg_comment'];
		$_html['name'] = $_rows['tg_name'];
		$_html['dir'] = $_rows['tg_dir'];
		$_html['from_user'] = $_rows['tg_from_user'];
		$_html['content'] = $_rows['tg_content'];
		$_html['date'] = $_rows['tg_date'];
		$_html['sid'] = $_rows['tg_sid'];
		$_html = _html($_html);

	}
	_query("UPDATE tg_picture SET tg_read = tg_read+1 WHERE tg_id = '{$_GET['id']}'");
	//读取评论
	$_result = mysql_query("SELECT tg_id FROM tg_photo_comment WHERE tg_pid='{$_html['id']}'");
	$_nums = mysql_num_rows($_result);
	//分页参数
	if(!!$_rows = _fetch_array("SELECT tg_id,
	
			tg_face,
			tg_sex
			
			
			FROM
			ta_user
			WHERE
			tg_username='{$_html['username']}'")){
	
		  
		  
			$_html['userid'] = $_rows['tg_id'];
			$_html['face'] = $_rows['tg_face'];
			$_html['sex'] = $_rows['tg_sex'];
			$_html = _html($_html);
	}
	
	
	
	
	$_pagesize = 8;
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
	//$_pagesize每页数据；
	//$_page_num每页开始的数据
	//$nums取得总共的数据
	//如果数据数为零
	if($_nums == 0)
	{
		$_pagesolute = 1;
	}else{
		$_pagesolute = ceil($_nums/$_pagesize); //ceil 取得的显示数据的页数并进位进位
	}
	if($_page > $_pagesolute)
	{
		$_page = $_pagesolute;
	}
	$_page_num = ($_page-1)*$_pagesize;
	
	//取得上一页的数据
	$_html['pre_id'] = _fetch_array("select min(tg_id) as id from tg_picture where tg_sid = '{$_html['sid']}' and tg_id >'{$_html['id']}'");
	$_pre_id = $_html['pre_id']['id'];
	if(!empty($_html['pre_id']['id']))
	{
		$_html['pre'] = '<a href="photo_detail.php?id='.$_pre_id.'" #img>上一页</a>';
	}else {
		
		$_html['pre'] = '<span style="color:#f60;font-size:16px;font-family:STXinWei;font-weight:bold;padding:10px;">没有了</span>';
	}
	
    //取得下一页数据
	$_html['next_id'] = _fetch_array("select max(tg_id) as id from tg_picture where tg_sid = '{$_html['sid']}' and tg_id <'{$_html['id']}'");
	$_next_id = $_html['next_id']['id'];
	if(!empty($_html['next_id']['id']))
	{
		$_html['next'] = '<a href="photo_detail.php?id='.$_next_id.'" #img>下一页</a>';
	}else {
	
		$_html['next'] = '<span style="color:#f60;font-size:16px;font-family:STXinWei;font-weight:bold;padding:10px;">没有了</span>';
	}
	$result = _query("SELECT
							tg_id,
							tg_username,
							tg_comment,
							tg_pid,
							
							tg_date
						FROM
							tg_photo_comment
						WHERE
							tg_pid='{$_html['id']}'
						ORDER BY
						tg_date ASC
							LIMIT $_page_num,$_pagesize");

}else 
{
	echo "<script>alert('不存在此图片');history.back();</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<title><?php echo $_system['webname']?>--图片展示</title>
</head>
<script src="js/blog.js" type="text/javascript" ></script>
<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/photo_detail.css" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<body>

<div id="photo_detail">
<h2>图片详情</h2>
<a name="#img"></a>
<dl class="detail">
 <dd class="name">图片名称：<?php echo $_html['name']?></dd>
 <dt><?php echo $_html['pre'];?><img src="<?php echo $_html['dir']?>"/><?php echo  $_html['next'];?></dt>
 <dd><a href="photo_show.php?id=<?php echo $_html['sid']?>">[返回列表]</a></dd>
 <dd class="read">浏览量(<?php echo $_html['read']?>)&nbsp&nbsp评论量(<?php echo $_html['comment']?>)&nbsp&nbsp发表于&nbsp<?php echo $_html['date']?>&nbsp&nbsp上传者：<?php echo $_html['from_user']?></dd>
  <dd class="content">图片简介：<?php echo $_html['content']?></dd>
</dl>
<p class="line"></p>
<?php 
   $_html_re = array();
  
   $_html_user = array();
   $_i=2; //楼层计数；
   while(!!$_rows = mysql_fetch_array($result)){
   	
   	$_html_re['id'] = $_rows['tg_id'];
   	$_html_re['username'] = $_rows['tg_username'];
   	$_html_re['content'] = $_rows['tg_comment'];
   	$_html_re['date'] = $_rows['tg_date'];
   	$_html_re = _html($_html_re);
   	if($_COOKIE['username'])
   	{
   		
   			$_html['re'] = '<span style="font-size:12px;">[<a href="#ree" name="re" title="回复 '.($_i+(($_page-1)*($_pagesize))).'楼的'.$_html_re['username'].'" style="color:blue;">回复</a>]</span>';
   		
   	}else {
   		$_html['re'] = '游客登录后回复';
   	}
   	
   	
   	if(!!$_rows_user=_fetch_array("SELECT  tg_id,
							   		  tg_username,
							   		  tg_face
   			                          
   			                          
							   	FROM
							   			ta_user
							   			WHERE tg_username='{$_html_re['username']}'"))
   	{
   		
   		$_html_user['id'] = $_rows_user['tg_id'];
   		
   		
   		$_html_user['face'] = $_rows_user['tg_face'];
   		
   	    
   		
   	}else {
   		//该用户已被删除
   	}
   	
   	?>
     <div id="subject">
     <dl>
		<dd class="user"><?php echo $_html_re['username'];?></dd>
		<dt><img src="<?php echo $_html_user['face'];?>" alt="头像" /></dt>
		<dd class="friend"><a href='javcscript:;' name='frenid' title="<?php echo $_html_user['id'];?>">加好友</a></dd>
		<dd class="flower"><a href='javascript:;' name='flower' title="<?php echo $_html_user['id'];?>">给他送花</a></dd>
		<dd class="message"><a href='javascript:;' name='message' title="<?php echo $_html_user['id'];?>">发消息</a></dd>
		<dd class="guest">写留言</dd>
    </dl>
    </div>
   <div class="content">
      <div class="use">
       <span ><?php echo $_i+(($_page-1)*($_pagesize))?>#</span><?php echo $_html_re['username'];?>|发表于<?php echo $_html_re['date'];?>&nbsp<?php echo $_html['re']?>
      </div>
      
      <div class="detail">
         <?php echo $_html_re['content']; ?>
         <?php
         if($_html_user['switch']==1)
         {
         	echo '<p class="sign">'.$_html['sign_content'].'</p>';
         }
         ?>
      </div>
  
    
      
    </div>
  
   <p class="line"></p>
   
 <?php 
 $_i++;

   }
   ?>  
<div id="page_text">
    <ul>
	  <li><?php echo $_page?>/<?php echo $_pagesolute?>页| </li>
	  <li>共有<strong><?php echo $_nums;?></strong>条回复| </li>
	  <?php 
	  if($_page == 1)
	  {
	  	echo '<li>首页| </li>';
	  	echo '<li>上一页| </li>';
	  }else
	  {
	  	echo '<li><a href="'.SCRIPT.'.php?id='.$_html['id'].'&page=1">首页| </a></li>';
	  	echo '<li><a href="'.SCRIPT.'.php?id='.$_html['id'].'&page='.($_page-1).'">上一页|</a></li>';
	  }
	  if($_page == $_pagesolute)
	  {
	  	echo '<li>下一页|</li>';
	  	echo '<li>尾页|</li>';
	  }else 
	  {
	  	echo '<li><a href="'.SCRIPT.'.php?id='.$_html['id'].'&page='.($_page+1).'">下一页|</li>';
	  	echo '<li><a href="'.SCRIPT.'.php?id='.$_html['id'].'&page='.$_pagesolute.'">尾页</li>';
	  }
	  ?>
	</ul>
  </div>
<?php if(isset($_COOKIE['username'])){?>
<div id="re_photo">
<a name="ree"></a>
  <form action="photo_detail.php?id=<?php echo $_html[id];?>&&action=re_photo" method="POST" name="reply">
   <dl class="re_photo">
   <dd><textarea class="content" name="content"  value=""></textarea></dd>
   <dd><input type="text" name="yzm" class="text yzm" /><img src="code.php"  onclick="javascript:this.src='code.php?tm='+Math.random()" class="yzm" /><input type="submit" name="submit" class="submit" value="回复"></dd>
  </dl>
  </form>
</div>
<?php }?>
 </div>
<?php 
require 'includes/footer.inc.php';


?>
</body>
</html>