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
 	exit('access delined');
 }
 //��֤�����֤
 function _check_code($_start,$end)
 {
 	if($_start!=$end)
 	{
 		echo "<script>alert('��֤�벻��ȷ��');location.href='login.php';</script>";
 		mysql_close();
 		
 	}
 }
 function _check_username($_string,$_min_num,$_max_num )
 {
 	//ȥ�����߿ո�
 	$_string = trim($_string);
 	//����С����λ���ߴ��ڶ���λ
 	if((mb_strlen($_string,'utf-8')<$_min_num)||(mb_strlen($_sting,'utf-8')>$_max_num))
 	{
 		echo "<script>alert('�û������Ȳ���С��".$_min_num."��λ���ߴ���".$_max_num."');location.href='login.php';</script>";
        mysql_close();
 	}
 	//���������ַ�
 	$_mode = '/[<>\'\"\ \ ]/';
 	if(preg_match($_mode,$_string))
 	{
 		echo "<script>alert('�û����а��������ַ�');location.href='login.php';</script>";
 	    mysql_close();
 	}
 
 	//ת�壬��Ч��ֹsqlע��,ȱ��һ��������Ժ��������ݿ�ʱ�ټ��ϣ�������Ч
 	
 	return mysql_real_escape_string($_string);
 }
 function _check_password($_first,$_min_num)
 {
 	//�ж�����
 	if(mb_strlen($_first)<6)
 	{
 		echo "<script>alert('���벻��С��".$_min_num."λ');location.href='login.php';</script>";
 	    mysql_close();
 	}
 
 
 	//ת��,
 	
 	return sha1($_first);
 }
 
 /*
  * ����cookie
  * @param string
  * @param string
  */
 function  _setcookie($_username,$_uniqid,$_time)
 {
 	switch($_time)
 	{
 		case '0': //������
		 	 setcookie('username',$_username);
		 	 setcookie('uniqid',$_uniqid);
	         break;
 		case '1': //����һ��
 			setcookie('username',$_username,time()+86400);
 			setcookie('uniqid',$_uniqid,time()+86400);
 			break;
 		case '2':
 			setcookie('username',$_username,time()+604800);
 			setcookie('uniqid',$_uniqid,time()+604800);
 			break;
 		case '3': //����ʮ��
 			setcookie('username',$_username,time()+864000);
 			setcookie('uniqid',$_uniqid,time()+864000);
 			break;
 	}
 }
?>