/**
 * 
 */
window.onload = function()
{
	var ubb=document.getElementById('ubb');
	var ubbimg = ubb.getElementsByTagName('img');
	var fm=document.getElementsByTagName('form')[0];
	var q = document.getElementById('q_image');
	var qa = q.getElementsByTagName('a');
	qa[0].onclick = function()
	{
		window.open('q.php?num=99&path=biaoqing/1/','q','width=400 height=400px');
	}
	qa[1].onclick = function()
	{
		window.open('q.php?num=99&path=biaoqing/2/','q','width=400 height=400px');
	}
	qa[2].onclick = function()
	{
		window.open('q.php?num=8&path=biaoqing/3/','q','width=400 height=400px');
	}
	//字体变大;
	var size=10;
	ubbimg[0].onclick=function()
	{
		if(size<48)
		{
		 size+=2;
		 document.getElementsByTagName('form')[0].content.value+='[size='+size+'][/size]'
		}
		};
    //字体变小;
	ubbimg[2].onclick = function()
	{
		content('[b][/b]');
	}
	ubbimg[4].onclick = function()
	{
		content('[i][/i]');
	}
	ubbimg[6].onclick = function()
	{
		content('[u][/u]');
	}
	ubbimg[8].onclick = function()
	{
		content('[s][/s]');
	}
	ubbimg[12].onclick = function()
	{
		var url=prompt('请输入网址','http://');
		if(url)
			{ 
			  
			   content('[url]'+url+'[/url]');
			}
		 
		
	}
	ubbimg[14].onclick = function()
	{
		var email = prompt('请输入邮件地址','')
		if(email)
			{
			   content('[email]'+email+'[/email]');
			}
	}
	ubbimg[16].onclick = function()
	{
		var flash = prompt('请输入flash地址','http://');
		if(flash)
			{
			  content('[flash]'+flash+'[/flash]');
			}
	}
	ubbimg[18].onclick = function()
	{
		var image = prompt('请输入图片地址','http://');
		if(image)
			{
			  content('[image]'+flash+'[/image]');
			}
	}
	ubbimg[20].onclick = function()
	{
		var vedio = prompt('请输入视频地址','http://');
		if(vedio)
			{
			  content('[vedio]'+vedio+'[/vedio]');
			}
	}
	ubbimg[28].onclick = function()
	{
		fm.content.rows+=2;
	}
	ubbimg[30].onclick = function()
	{
		fm.content.rows-=2;
	}
	ubbimg[34].onclick = function()
	{ 
		if(size>2){
		size-=2;
		document.getElementsByTagName('form')[0].content.value+='[size='+size+'][/size]'
		}
	}
	
	function content(string)
	{
		fm.content.value+=string;
		
	}
	
};
