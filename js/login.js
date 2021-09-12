/**
 * 登录验证
 */
window.onload = function(){
	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function(){
	//用户名验证
	
	if(fm.username.value.length<2||fm.username.value.length>20)
	{
		alert('用户名不得小于两位或者大于二十位');
		fm.username.value = ''; //位置清空
		fm.username.focus(); //光标移动至表单首
		return false;
		
	}
	if(/[\.\'\"\ <>]/.test(fm.username.value)) //用户名过滤
	{
		alert('不得包含非法字符');
		fm.username.value='';
		fm.username.focus();
		return false;
	}
	
	//密码验证
	if(fm.password.value.length<6)
	{
		alert('密码不得小于六位');
		fm.password.value = ''; 
		fm.password.focus(); 
		return false;
	}
	//验证吗验证
	if(fm.yzm.value.length!=4)
		{
		alert('验证码必须是4位');
		fm.yzm.value='';
		fm.yzm.focus();
		}
};
};