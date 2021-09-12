<?php
/*
*TestGuest Version 1.0
* ==========================================
* Copy 2016-2016 mook
* ===========================================
* Author:lee
* Date:2016-8-21
*/

//防止恶意调用
if(!defined('IN_TG'))
{
	exit('Acess Defined');
}


//转换硬路径常量
//define('ROOT_PATH',substr(dirname(__FILE__),0,-8));
//拒绝php低版本
if(PHP_VERSION<'4.1.0')
{
	exit('Version is too Low');
}
define('GQC',get_magic_quotes_gpc());

//数据库连接
require_once("includes/mysql.func.php");


_connect();
_select_db();
_set_names();
//短信提醒模块

$_message = _fetch_array("SELECT COUNT(tg_id) AS count FROM tg_message WHERE tg_state=0 AND tg_to_user='{$_COOKIE['username']}'  ");
if(empty($_message['count']))
{
	$_message_html = '<strong class="read">(0)</strong>';
}else {
	$_message_html = '<strong class="unread">('.$_message['count'].')</strong>';
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
	$_system = array();
	$_system['webname'] = $_rows['tg_webname'];
	$_system['blog'] = $_rows['tg_blog'];
	$_system['article'] = $_rows['tg_article'];
	$_system['photo'] = $_rows['tg_photo'];
	$_system['string'] = $_rows['tg_string'];
	$_system['code'] = $_rows['tg_code'];
	$_system['reg'] = $_rows['tg_reg'];
	$_system = _system($_system);
}


?>