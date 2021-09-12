<?php
/*
 *TestGuest Version 1.0
 * ==========================================
 * Copy 2016-2016 mook
 * ===========================================
 * Author:Mook
 * Date:2016-8-21
 */
session_start();
define('SCRIPT','article'); 
define('IN_TG',TRUE);
require "includes/common.inc.php";
require "includes/globa.fun.php";
require "includes/reg.func.php";
//处理回帖
if(($_GET['action'] == "reply")&&(isset($_GET['id'])))
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
		    $_clean['article_id'] = $_GET['id'];
		    $_clean['username'] = $_COOKIE['username'];
		    $_clean['content'] = _check_post_content($_POST['content'],0);
					
					
					//写入数据库
			_query("INSERT INTO tg_reply 
							                (
							                 tg_article_id,
							                 tg_username,
							                 tg_content,
							                 tg_date
							                  )
							        VALUES('{$_clean['article_id']}',
					                       '{$_clean['username']}',
					                       '{$_clean['content']}',
					                         NOW()
					                        )"
					 
					);
				if(_affected_rows()==1)
				{
					_query("UPDATE tg_article SET tg_comment_count=tg_comment_count+1 WHERE tg_id='{$_clean['article_id']}'");
					   
						mysql_close();
						//session_destroy();
						echo "<script>alert('回复成功');location.href='article.php?id=".$_GET['id']."';</script>";
					}
					else
					{
						mysql_close();
						//session_destroy();
						echo "<script>alert('回复失败');history.back();</script>";
					}
			
		
		
		
		
	}else {
		echo "<script>alert('游客，请先登录！');history.back();</script>";
	}

	
}


 
//判断id是否存在
if(isset($_GET['id']))
{
	if(!!$_rows=_fetch_array("SELECT  tg_id,
			                          tg_username,
			                          tg_title,
			                          tg_content,
			                          tg_type,
			                          tg_read_count,
			                          tg_comment_count,
			                          tg_date
			                     
			                    FROM
			                          tg_article
			                    WHERE tg_id='{$_GET['id']}'"))
	{
	  $_html = array();
	  $_html['id'] = $_rows['tg_id'];
	  $_html['username'] = $_rows['tg_username'];
	  $_html['title'] = $_rows['tg_title'];
	  $_html['content'] = $_rows['tg_content'];
	  $_html['type'] = $_rows['tg_type'];
	  $_html['read_count'] = $_rows['tg_read_count'];
	  $_html['comment_count'] = $_rows['tg_comment_count'];
	  $_html['date'] = $_rows['tg_date'];
	  //读取回复:
	  $_nums = mysql_num_rows(mysql_query("SELECT tg_id FROM tg_reply WHERE tg_article_id='{$_html['id']}'"));
	  //分页参数
	 
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
	  
	  //修改帖子
	  if($_html['username']==$_COOKIE['username'])
	  {
	  	$_html['username_modiefy']='[<a href="article_modiefy.php?id='.$_html['id'].'">修改</a>]';
	  }
	 
	  $_result = _query("SELECT 
	  		                  tg_id,
	  		                  tg_username,
	  		                  tg_content,
	  		                  tg_article_id,
	  		                  tg_content,
	  		                  tg_date
	  		             FROM 
	  		                  tg_reply 
	  		            WHERE 
	  		                  tg_article_id='{$_html['id']}' 
	                    ORDER BY 
	                          tg_date ASC 
	                          LIMIT $_page_num,$_pagesize"
	                          		);
	  
	  $_result_user = _query("SELECT tg_id,tg_face FROM ta_user WHERE tg_id = '{$_html['id']}'");
	  //阅读量统计
	  
	  _query("UPDATE tg_article SET tg_read_count=tg_read_count+1 WHERE tg_id='{$_GET['id']}'");
	  //提取用户信息
	  
	  if(!!$_rows = _fetch_array("SELECT tg_id,
									     
									      tg_face,
									      tg_sex,
	  		                              tg_switch,
	  		                              tg_sign_content
									 FROM
									  		ta_user
									 WHERE
									  		tg_username='{$_html['username']}'")){
	    	
	    
	    
	  	$_html['userid'] = $_rows['tg_id'];
	  	$_html['face'] = $_rows['tg_face'];
	  	$_html['sex'] = $_rows['tg_sex'];
	  	$_html['switch']  =$_rows['tg_switch'];
	  	$_html['sign_content'] = $_rows['tg_sign_content'];
	  	if($_html['switch']==1)
	  	{
	  		$_html['tg_sign_content'] = '<p class="sign">'.$_html['sign_content'].'</p>';
	  	}
	  	
	  }
	  
	  else
	  {
	  	//此用户已被删除！
	  }
	 
	}
	else
	{
		echo "<script>alert('数据读取错误！');history.back();</script>";
	}


}else {
	echo "<script>alert('非法操作,请重新尝试！');history.back();</script>";
}

require "includes/header.inc.php";
require "includes/title.inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.O Transitional/EN" "http://www.w3.otg/IR/xhtml1/DTD/Xhtmll-transitional.dtd">
<html>
<head>
<title><?php echo $_system['webname']?>--帖子查看</title>
</head>
<script src="js/blog.js" type="text/javascript" ></script>
<link rel="shortcut icon" href="1.ico" />
<link rel="stylesheet" type="text/css" href="style/1/index.css" />
<link rel="stylesheet" type="text/css" href="style/1/article.css" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<body>
<div id="article">
<h2>文章详情</h2>
  <div id="subject">
    <dl>
		<dd class="user"><?php echo $_html['username'];?>[楼主]</dd>
		<dt><img src="<?php echo $_html['face'];?>" alt="头像" /></dt>
		<dd class="friend"><a href='javcscript:;' name='frenid' title="<?php echo $_html['userid'];?>">加好友</a></dd>
		<dd class="flower"><a href='javascript:;' name='flower' title="<?php echo $_html['userid'];?>">给他送花</a></dd>
		<dd class="message"><a href='javascript:;' name='message' title="<?php echo $_html['userid'];?>">发消息</a></dd>
		<dd class="guest">写留言</dd>
   </dl>
  </div>
  <div class="content">
      <div class="use">
       <span><?php echo $_html['username_modiefy'];?>&nbsp1#</span><?php echo $_html['username'];?>|发表于<?php echo $_html['date'];?>
      </div>
      <h3><?php echo $_html['title'];?><img src="images/<?php echo $_html['type']?>.gif" /></h3>
      <div class="detail">
          <?php echo _ubb($_html['content']);?>
          <?php echo $_html['tg_sign_content']?>
      </div>
      <div class="read_comment">
                   阅读量:(<?php echo $_html['read_count']?>) 评论量:(<?php echo $_html['comment_count']?>)
      </div>
     
      
  </div>
   <p class="line"></p>
   <?php 
   $_html_re = array();
  
   $_html_user = array();
   $_i=2; //楼层计数；
   while(!!$_rows = mysql_fetch_array($_result)){
   	
   	$_html_re['id'] = $_rows['tg_id'];
   	$_html_re['username'] = $_rows['tg_username'];
   	$_html_re['content'] = $_rows['tg_content'];
   	$_html_re['date'] = $_rows['tg_date'];
   	$_html_re = _html($_html_re);
   	if($_COOKIE['username'])
   	{
   		
   			$_html['re'] = '<span style="font-size:12px;color:blue;">[<a href="#ree" name="re" title="回复 '.($_i+(($_page-1)*($_pagesize))).'楼的'.$_html_re['username'].'">回复</a>]</span>';
   		
   	}else {
   		$_html['re'] = '游客登录后回复';
   	}
   	
   	
   	if(!!$_rows_user=_fetch_array("SELECT  tg_id,
							   		  tg_username,
							   		  tg_face,
   			                          tg_switch,
   			                          tg_sign_content
							   	FROM
							   			ta_user
							   			WHERE tg_username='{$_html_re['username']}'"))
   	{
   		
   		$_html_user['id'] = $_rows_user['tg_id'];
   		$_html_user['switch'] = $_rows_user['tg_switch'];
   		$_html_user['sign_content'] = $_rows_user['tg_sign_content'];
   		$_html_user['face'] = $_rows_user['tg_face'];
   		
   	    
   		
   	}else {
   		//该用户已被删除
   	}
   	
   ?>
   
   <div id="re_acrticle">
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
       <span><?php echo $_i+(($_page-1)*($_pagesize))?>#</span><?php echo $_html_re['username'];?>|发表于<?php echo $_html_re['date'];?>&nbsp<?php echo $_html['re']?>
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
  <a name="ree"></a>
   <form action="article.php?id=<?php echo $_html[id];?>&&action=reply" method="POST" name="reply">
   <div id="reply">
   <dd><textarea class="content" name="content"  rows=4 value=""></textarea></dd>
   <dd><input type="text" name="yzm" class="text yzm" /><img src="code.php" id="code" onclick="javascript:this.src='code.php?tm='+Math.random()" /><input type="submit" name="submit" class="submit" value="回复"></dd>
  </div>
  </form>
 
</div>

<?php }?>
<?php
require 'includes/footer.inc.php';
//结果集的销毁

?>
</body>
</html>