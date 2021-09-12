<?php
//防止恶意调用
if(!defined('IN_TG'))
{
	exit('Acess Defined');
}

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PWD','1234');
define('DB_NAME','tg_user');
//数据库连接

function _connect()
{
	global $_conn,$_system;
	if(!$_conn = @mysql_connect(DB_HOST,DB_USER,DB_PWD))
	{
		exit('数据库连接失败！');
	}

}





function _select_db()
{
	if(!mysql_select_db(DB_NAME))
	{
		exit('找不到指定的数据库！');
	}
}


function _fetch_array($_sql)
{
	return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}
 function _affected_rows()
{
	return mysql_affected_rows();
}
function _set_names()
{
	if(!mysql_query('SET NAMES UTF8'))
	{
		exit('字符集设置错误！');

	}
}

function _query($_sql)
{
	if(!$_result = mysql_query($_sql))
	{
		exit('sql执行错误！');
	}else
	{
		return $_result;
	}
}


function _system($_str) //等价于_html()函数
{

	if(is_array($_str))
	{
		foreach($_str as $_key => $_value)
		{
			$_str[$_key] = _system($_value);
		}
	}else
	{
		$_str = htmlspecialchars($_str);
	}

	return $_str;

}

?>