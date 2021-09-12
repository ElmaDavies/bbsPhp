/**
 * 
 */
//等待网页加载完毕
window.onload = function()
{
	var faceimg = document.getElementById('faceimg');
	faceimg.onclick = function()
	{
		window.open('face.php','face','width=400px,height=400px,top=0,left=0,scorallbars=1');
	};

//表单验证
	var fm = document.getElemenstTagName('form')[0];
	fm.onsubmit = function()
	{
		//表单验证
		if(fm.username.value.length<2||fm.username.value.length>20)
		{
			alert('用户名不得小于2位或者大于20位');
			fm.username.value = ''; //清空表单
			fm.username.focus(); //移动表单指针指表单首
			return false;
			
		}
		if(/[\.\'\"\ <>]/.test(fm.username.value)) //用户名正则检测
		{
			alert('不得包含非法字符');
			fm.username.value='';
			fm.username.focus();
			return false;
		}
		return true;
		//密码验证
		if(fm.password.value.length<6)
		{
			alert('密码不得小于六位');
			fm.password.value = ''; 
			fm.password.focus(); 
			return false;
		}
		if(fm.password.value!=fm.notpassword.value)
		{
		alert('密码与确认密码不相同');
		fm.notpassword.value='';
		fm.notpassword.focus();
		return false;
		}
		if(fm.question.value.length<2||fm.question.value.length>20)
		{
			alert('密码提问不得小于2位或者大于20位');
			fm.question.value = ''; 
			fm.question.focus(); 
			return false;
		}
		if(fm.answer.value.length<2)
		{
			alert('密码回答不得小于2位');
			fm.answer.value='';
			fm.answer.focus();
			return false;
		}
		if(fm.answer.value==fm.question.value)
		{
			alert('密码会答与密码提问不得相同');
			fm.answer.value='';
			fm.answer.focus();
			
		}
		if(!/^[\w\.\-]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value))
		{
			alert('邮箱格式不正确，请重新检查');
			fm.email.value='';
			fm.email.focus();
			return false;
		}
		if(!/^[1-9]{1}[0-9]{4,9}$/.test(fm.qq.value))
		{
			alert('qq号码格式不正确！');
			fm.qq.value='';
			fm.qq.focus();
			return false;
		}
	return true;
	};
	
};