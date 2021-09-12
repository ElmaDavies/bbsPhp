<?php

define('IN_TG',true);

require "includes/common.inc.php";
require_once 'includes/globa.fun.php';
if(isset($_GET['filename']))
{
   _thumb($_GET['filename'],150,150 );
}
if(isset($_GET['file']))
{
	_thumb($_GET['file'],70,85);
}
	
?>

