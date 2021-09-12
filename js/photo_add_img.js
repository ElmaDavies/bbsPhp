/**
 * 
 */
window.onload = function()
{
	
	var up = document.getElementById('up');
	up.onclick = function()
	{
		CenterWindow('up_img.php?dir='+this.title,'up_img',200,410);
	}
	
	
};

function CenterWindow(url,name,height,width)
{
	
	var left = (screen.width-width)/2;
	var top = (screen.height-height)/2;
	window.open(url,name,'height='+height+',width='+width+' top='+top+',left='+left);
	}