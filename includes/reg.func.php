<?php 

/**TestGuest Version 1.0
* ==========================================
* Copy 2016-2016 mook
* ===========================================
* Author:mo
* Date:2016-8-27
*/

if(!defined('IN_TG'))
{
	exit('Acess Defined');
}
require_once("includes/common.inc.php");
require_once("mysql.func.php");
//验证码的验证
function _check_code($_start,$end)
{
	if($_start!=$end)
	{
		echo "<script>alert('验证码不正确！');location.href='reg.php';</script>";
		mysql_close();
	}
}
//字符串转义问题
function _check_mysql_string($_string)
{
	if(!GQC)
	{
		return _check_mysql_string($_string,$conn);
		
	}
	else
	{
		return $_string;
	}
	
}
/*
*_check_username() 表示检测并过滤用户名
*@access public
*@ parmar sting $_string 用户输入的原始用户名
*@ parmar int $_min_num, 允许的最小位数
*@ parmar int $_max_num, 允许的最大位数
*@ retuen string $_string 返回值为过滤后的用户名
*/


/*
*_check_password() 表示验证并加密密码
*@access public 
*@ parmar sting $_first 用户输入的原始密码
*@ parmar string $_end 用户输入的验证密码
*@ parmar int $_min_num, 允许的最小位数
*@ retuen string $_string 返回值为加密后的密码
*/


/*
*_check_question() 表示验证密码提问
*@access public 
*@ parmar sting $_question 用户输入的密码问题
*
*@ parmar int $_min_num, 允许的最小位数
*@ parmar int $_max_num, 允许的最大位数
*@ retuen string $_string 返回值为数据库转以后的字符串
*/



/*
*
*_check_answer() 表示验证并加密密码
*@access public 
*@ parmar sting $_answe 用户输入的密码回答
*@ parmar string $_quest 用户输入的密码问题
*@ parmar int $_min_num, 允许的最小位数
*@ retuen string $_answe 返回值为加密后的密码
*/
function _check_unqid($_start_unqid,$_end_unqid)
{
	if((strlen($_start_unqid)<40)||($_start_unqid!=$_end_unqid))
	{
	  echo	"<script>alert('唯一标识符异常！');history.back();</script>";
	}
	return $_start_unqid;
}
function _check_username($_string,$_min_num,$_max_num )
{
	global $_system,$_conn;
	//去掉两边空格
	$_string = trim($_string);
	//长度小于两位或者大于而是位
	if((mb_strlen($_string,'utf-8')<$_min_num)||(mb_strlen($_sting,'utf-8')>$_max_num))
	{
		echo "<script>alert('用户名长度不得小于".$_min_num."两位或者大于".$_max_num."');history.back();</script>";
		
	}
	//过滤敏感字符
	$_mode = '/[<>\'\"\ ]/';
	if(preg_match($_mode,$_string))
	{
		echo "<script>alert('用户名中包含敏感字符');location.href='reg.php';</script>";
		mysql_close();
	}
	//限制敏感用户名
	$_mg = explode('|',$_system['string']);
	/*foreach($_mg as $value)
	{
		$_mg_string.='['.$value.']'.'\n';
	}
	*/
	if(in_array($_string,$_mg))
	{
		
		echo "<script>alert('以上敏感用户名不得注册'.);location.href='reg.php';</script>";
		mysql_close();
	}
	//转义，有效防止sql注入,缺少一个句柄，以后连接数据库时再加上，函数生效
	return _check_mysql_string($_string);
	//return $_string;
}

function _check_password($_first,$_end,$_min_num)
{
	//判断密码
	if(mb_strlen($_first)<6)
	{
		echo "<script>alert('密码不得小于".$_min_num."位');location.href='reg.php';</script>";
		mysql_close();
	}
	
	if($_first!=$_end)
	{
		echo "<script type='text/javascript'>alert('密码与确认密码不一致');location.href='reg.php';</script>";
		mysql_close();
	}
	
	//转义,
	return _check_mysql_string(sha1($_first)); 
	//return sha1($_first);
	
}

function _check_question($_question,$_min_num,$_max_num)
{
	$_question = trim($_question);
	if((mb_strlen($_question,'utf-8')<$_min_num)||(mb_strlen($_question,'utf-8')>$_max_num))
	{
		echo "<script>alert('密码提示不得小于".$_min_num."为或者大于".$_max_num."位');location.href='reg.php';</script>";
		mysql_close();
	}
	//转义，有效防止sql注入,缺少一个句柄，以后连接数据库时再加上，函数生效
	return _check_mysql_string($_question);
	//return $_question;
}
function _check_answer($_answe,$_quest,$_min_num,$_max_num)
{
	$_answe = trim($_answe);
	if(mb_strlen($_answe,'utf-8')<$_min_num||mb_strlen($_answe,'utf-8')>$_max_num)
	{
		echo "<script>alert('密码回答不得小于".$_min_num."为或者大于".$_max_num."位');location.href='reg.php';</script>";
		mysql_close();
		
	}
	if($_answe==$_quest)
	{
		echo "<script>alert('密码回答与提示不得相同！');location.href='reg.php';</script>";
		mysql_close();
	
	}
	//转义，有效防止sql注入
	return _check_mysql_string(sha1($_answe));

	
	
}

function _check_sex($_string)
{
	return _check_mysql_string($_string);
}

function _check_face($_string)
{
	return _check_mysql_string($_string);
}
/*
*_check_email() 验证邮箱是否合法
* @access public
*@parmar string $_email, 要求验证的邮箱
*@return string $_email， 验证后的邮箱
*
*/

function _check_email($_email)
{
	
	//正则匹配
	$_mode = '/^[\w\.\-]+@[\w\-\.]+(\.\w+)+$/';
	if(!preg_match($_mode,$_email))
	{
		echo "<script>alert('邮箱格式不正确！');location.href='reg.php';</script>";
		mysql_close();
		
	}
	
	
	return $_email;
	
}

//验证QQ
/*
* _check_qq() 验证QQ
* @acess public
*@ parmar string $_string 验证前输入的字符串
*@ return string $_string 返回验证后的字符串
*/


function _check_qq($_string)
{
	$mode = '/^[1-9]{1}[0-9]{4,9}$/';
	if(!preg_match($mode,$_string))
	{
		echo "<script>alert('QQ号码不正确');location.href='reg.php';</script>";
		mysql_close();
	}
	else{
	return $_string;
	}
	
}
//验证修改后的密码
function _check_modiefy_password($_new_password,$_min_num)
{
	
	if(!empty($_new_password))
	{
		if(strlen($_new_password)<6)
		{
			echo "<script>alert('新密码不得小于六位');history.back();</script>";
			mysql_close();
		}
		return sha1($_new_password);
	}else {
		return null;
	}
	
	
	
		
	
	
}

//短信内容长度验证
function _check_content($_string,$_max_num)
{
	if(strlen($_string)>$_max_num)
	{
		echo "<script>alert('内容不得大于".$_max_num."');history.back();</script>";
		mysql_close();
	}
	return $_string;
	
}

//帖子标题长度验证
function _check_post_title($_string,$_min_num,$_max_num)
{
	$_string = trim($_string);
	if(mb_strlen($_string,'utf-8')<$_min_num||mb_strlen($_string,'utf-8')>$_max_num)
	{
		echo "<script>alert('帖子标题不得小于".$_min_num."为或者大于".$_max_num."位');location.href='reg.php';</script>";
		mysql_close();
	
	}
	return $_string;
}

//帖子内容验证
function _check_post_content($_string,$_min_num)
{
	if(strlen($_string)<$_min_num)
	{
		echo "<script>alert('帖子内容不得小于".$_min_num."位');history.back();</script>";
		mysql_close();
	}
	return $_string;
	
}
//签名长短验证
function _check_post_sign($_string,$_max_num)
{
	if(strlen($_string > $_max_num))
	{
		echo "<script>alert('签名内容不得大于于".$_max_num."位');history.back();</script>";
		mysql_close();
	}
	return $_string;
}

//检查目录是否为空
function _check_url($_string)
{
	if(empty($_string))
	{
		echo "<script>alert('图片地址不得为空');history.back();</script>";
		mysql_close();
	}else {
		return $_string;
	}
}
?>