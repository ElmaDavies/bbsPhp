/**
 * 消息批量删除
 */
window.onload = function()
{
	var form = document.getElementsByTagName('form')[0];
	var all = document.getElementById('all');
	all.onclick = function()
	{
		for(var i=0;i<form.elements.length;i++)
			{
			 if(form.elements[i].name!='checkall')
				 {
				   form.elements[i].checked = form.checkall.checked;
				 }
			}
	};
	form.onsubmit = function()
	{
		if(confirm('确定删除？'))
			{
			return true;
			}else
				{
				return false;
				}
	};
};