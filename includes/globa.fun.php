<?php

/**
*验证码函数
*@pubic _code()
*@return void 返回值为空值
*@parmar int $_width 表示验证码长度
*@parmar int $_height 表示验证码高度
*@parmar int $_num 表示验证码位数
@parmar  bool $_flag 表示验证码是否有边框
**/
//验证码函数
include_once("common.inc.php");
session_start();
function _code($_width=75,$_height=25,$_num=4,$_flag=false)
{
	for($i=0;$i<$_num;$i++){
   $_nmsg.=dechex(mt_rand(0,15));
}
//保存在session
$_SESSION['code']=$_nmsg;
//创建一个真彩色图片
header("Content-Type:image/png");

$_img=imagecreatetruecolor($_width,$_height);
$_white=imagecolorallocate($_img,255,255,255);
imagefill($_img,0,0,$_white);
//创建一个黑色边框

if($_flag){
$black=imagecolorallocate($_img,0,0,0);
imagerectangle($_img,0,0,$_width-1,$_height-1,$black);
}
//随机画出线条
for($i=0;$i<6;$i++)
{
	$_mt_rand=imagecolorallocate($_img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
	imageline($_img,mt_rand(0,$_width),mt_rand(1,$_height),mt_rand(0,$_width),mt_rand(0,$_height),$_mt_rand);
}
//随机雪花
for($i=0;$i<100;$i++)
{
	$_mt_cor=imagecolorallocate($_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
	imagestring($_img,1,mt_rand(1,$_width-2),mt_rand(1,$_height-2),"*",$_mt_cor);
}
//输出验证码
for($i=0;$i<strlen($_SESSION['code']);$i++)
{
	$_rand_color=imagecolorallocate($_img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200));
	imagestring($_img,5,$i*$_width/strlen($_SESSION['code'])+mt_rand(1,10),mt_rand(1,$_height/2),$_SESSION['code'][$i],$_rand_color);
}
imagepng($_img);
//验证码返回函数


imagedestroy($_img);
}
//cookie函数
function _cookie_del()
{
	setcookie('username','',time()-1);
	setcookie('username','',time()-1);
	
	header('location:index.php');
	
}
//登录状态页面处理
function _login_state()
{
	if(isset($_COOKIE['username']))
	{
		echo "<script>alert('登录状态无法进行本次操作！');history.back();</script>";
	}
}
/*
 * _html() 函数表示对字符串进行过滤，如果是数组就用`数组的方法
 * 否则就用字符串的方法
 * @parmar $_string
 **/
function _html($_string)
{
	
		if(is_array($_string))
		{
			foreach($_string as $_key => $_value)
			{
				 $_string[$_key] = _html($_value);
			}
		}else 
		{
			$_string = htmlspecialchars($_string);
		}
	
   return $_string;
	
}
function _mysql_string($_string)
{
	if(!GPC)
	{
		if(is_array($_string))
		{
			foreach($_string as $_key => $_value)
			{
				$_string[$_key] = _html($_value);
			}
		}else
		{
			$_string = mysql_real_escape_string($_string);
		}
		
	}
	return $_string;
}
/*
 * 字符串截取函数
 * @$_string 截取之前的的字符串
 * @$_strlen 截取的长度
 * @return 返回截取之后的字符串
 */
function _title($_string,$_strlen){
	if(mb_strlen($_string,'utf-8')>$_strlen)
	{
		$_string=mb_substr($_string,0,$_strlen,'utf-8');
	}
	return $_string;
}
//生成xml函数
function _set_xml($_xmlfile,$_clean)
{
	$_fp = @fopen('new.xml','w');
	if(!$_fp)
	{
		echo '文件不存在';
		exit();
	}
	flock($_fp,LOCK_EX);
	$_string= "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
	fwrite($_fp, $_string,strlen($_string));
	$_string= "\t<vip>\r\n";
	fwrite($_fp, $_string,strlen($_string));
	$_string= "\t<id>{$_clean['id']}</id>\r\n";
	fwrite($_fp, $_string,strlen($_string));
	$_string= "\t<username>{$_clean['username']}</username>\r\n";
	fwrite($_fp, $_string,strlen($_string));
	$_string= "\t<sex>{$_clean['sex']}</sex>\r\n";
	fwrite($_fp, $_string,strlen($_string));
	$_string= "\t<face>{$_clean['face']}</face>\r\n";
	fwrite($_fp, $_string,strlen($_string));
	$_string= "\t</vip>";
	fwrite($_fp, $_string,strlen($_string));
	flock($_fp,LOCK_UN);
	fclose($_fp);
	
}
//xml文件读取
function _get_xml($_xml)
{
	
	$_html=array();
	
	if(file_exists($_xml))
	{
		$_xmlfile=file_get_contents($_xml);
		preg_match_all('/<vip>(.*)<\/vip>/s',$_xmlfile,$dom);
		foreach($dom[1] as $value)
		{
			preg_match_all('/<id>(.*)<\/id>/s',$value,$id);
			preg_match_all('/<username>(.*)<\/username>/s',$value,$username);
			preg_match_all('/<sex>(.*)<\/sex>/s',$value,$sex);
			preg_match_all('/<face>(.*)<\/face>/s',$value,$face);
			$_html['id']=$id[1][0];
			$_html['username']=$username[1][0];
			$_html['sex']=$sex[1][0];
			$_html['face']=$face[1][0];
		}
	
	}else {
		echo "文件不存在";
	}
	return $_html;
}
//ubb解析函数
function _ubb($_string){
	$_string = nl2br($_string);
	$_string = preg_replace('/\[size=(.*)\](.*)\[\/size\]/U','<span style="font-size:\1px">\2</span>',$_string);
	$_string = preg_replace('/\[b\](.*)\[\/b\]/U','<strong>\1</strong>',$_string);
	$_string = preg_replace('/\[i\](.*)\[\/i\]/U','<em>\1</em>',$_string);
	$_string = preg_replace('/\[u\](.*)\[\/u\]/U','<span style=text-decoration:underline>\1</span>',$_string);
	$_string = preg_replace('/\[s\](.*)\[\/s\]/U','<span style="text-decoration:line-through">\1</span>',$_string);
	$_string = preg_replace('/\[url\](.*)\[\/url\]/U','<a href="\1" target="_blank">\1</a>',$_string);
	$_string = preg_replace('/\[email\](.*)\[\/email\]/U','<a href="mailto:1\">\1</a>',$_string);
	$_string = preg_replace('/\[img\](.*)\[\/img\]/U','<img src="\1" alt="图片">',$_string);
	$_string = preg_replace('/\[flash\](.*)\[\/flash\]/U','<embed sytle="width:780px;height:400px;" src="\1" />',$_string);
	$_string = preg_replace('/\[vedio\](.*)\[\/vedio\]/U','<embed sytle="width:700px;height:540px;" src="\1" />',$_string);
	return $_string;
}

//内容验证
function _check_article($_string)
{
	if($_string=='')
	{
		echo "<script>alert('任何内容都没有回复');history.back();</script>";
	}
}
//时间间隔验证
function _check_time($_now_time,$_pre_time,$_second)
{
	if(($_now_time-$_pre_time)<$_second)
	{
		echo "<script>alert('请休息两分钟再继续');history.back();</script>";
	
	}
}

//图像处理函数
function _thumb($_filename,$_new_width,$_new_height)
{
	
	//生成png文件
	header('Content-Type:image/png');
	
	$_n = explode('.',$_filename);
	
	//获取文件的大小信息
	list($_width,$_height) = getimagesize($_filename);
	
	//生成新的图片尺寸
	//$_new_width = $_width*$_precent;
	//$_new_height = $_height*$_precent;
	
	//生成一个新的图片画布
	
	$_new_image = imagecreatetruecolor($_new_width, $_new_height);
	
	switch($_n[1])
	{
		case 'jpg':
			$_image = imagecreatefromjpeg($_filename);
			break;
		case 'png':
			$_image = imagecreatefrompng($_filename);
			break;
		case 'gif':
			$_image = imagecreatefromgif($_filename);
			break;
	
	}
	
	
	
	imagecopyresampled($_new_image, $_image, 0, 0, 0, 0, $_new_width, $_new_height, $_width, $_height);
	
	imagepng($_new_image);
	
	imagedestroy($_new_image);
	
}
?>