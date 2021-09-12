/**
 * 
 */
window.onload = function()
{
	var message = document.getElementsByName('message');
	var frenid =  document.getElementsByName('frenid');
	var flower =  document.getElementsByName('flower');
	var re = document.getElementsByName('re');

	for(var i=0;i<message.length;i++)
		{
		  message[i].onclick = function()
		  {
			  centerWindow('message.php?id='+this.title,'message',250,400);
		  };
		}
	
	for(var i=0;i<frenid.length;i++)
		{
		  frenid[i].onclick = function()
		  {
			  centerWindow('frenid.php?id='+this.title,'frenid',250,400);
		  };
		}
	for(var i=0;i<flower.length;i++)
	{
	  flower[i].onclick = function()
	  {
		  centerWindow('flower.php?id='+this.title,'flower',250,400);
	  };
	


	}
	for(var i=2;i<re.length;i++)
		{
		   re[i].onclick = function()
		   {
			  document.getElementsByTagName('form')[0].content.value = this.title+':';
			   
		   };
		}

function centerWindow(url,name,height,width)
{
	var left = (screen.width-width)/2;
	var top = (screen.height-height)/2;
	window.open(url,name,'height='+height+',width='+width+' top='+top+',left='+left);
	
	}
function content(string)
{
	fm.content.value+=string;
	
}
};