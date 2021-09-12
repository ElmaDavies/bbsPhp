<?php
function _file_up($_MAX_SIZE=2000000,$url){

	
    

	
	
	if($_FILES['face']['error']>0)
	{
		switch($_FILES['face']['error'])
		{
		 case 1:
		 	echo "<script>alert('文件上传超过约定值');history.back();</script>";
		 	break;
		 case 2:
		 	echo "<script>alert('文件上传超过约定值');history.back();</script>";
		 	break;
		 case 3:
		 	echo "<script>alert('文件上传不完整');history.back();</script>";
		 	break;
		 case 4:
		 	echo "<script>alert('未上传任何文件');history.back();</script>";
		 	break;
		}
		exit();
	}

	if($_FILES[name][size]>MAX_SIZE) 
	{
		echo "<script>alert('文件大小不得超过2M');history.back();</script>";
	    exit();
	}

	switch($_FILES['face']['type'])
	{
		case 'image/jpeg':
			break;
		case 'image/jpg':
			break;
		case 'image/png':
			break;
		case 'image/x-png':
			break;
		case 'image/gif':
			break;
		case 'image/bmp':
			break;
		
		default:
		echo "<script>alert('文件上传类型出错');history.back();</script>";
		exit;
	}

	if(!is_dir(URL))
	{
		mkdir(URL,0777); 
	}
	if(is_uploaded_file($_FILES['face']['tmp_name']))
	{

		move_uploaded_file($_FILES['face']['tmp_name'],$url.'/'.$_FILES['face']['name']);
		
	}
    if(!@(is_uploaded_file($_FILES['face']['tmp_name'])))
	{
		echo "<script>alert('移动失败');history.back();</script>";
		exit;
	
	}
	
	else
	{
		echo "<script>alert('找不到文件位置');history.back();</script>";
		exit();
	
	}
	
	
    

}
?>