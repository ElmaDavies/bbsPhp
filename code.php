<?php
//创建一个验证码函数
define('IN_TG',true);
session_start();
require "includes/globa.fun.php";
//默认长度为75，高度为25，大小可以设置,验证码长度为4为；
//边框可以根据自己要求设置是否为true
//例如 _code(int $_width,int $_height,int $_num,bool $_flag)
_code();

?>