/**
 *头像的选择与显示
 */

window.onload = function()
{
	//取得节点
	var img = document.getElementsByTagName('img');
	for(i=0;i<img.length;i++)
		{
		img[i].onclick=function()
		{
			_opener(this.src);
			
		};
		}
	
	
};
function _opener(src){
	
	opener.document.getElementsByTagName('form')[0].content.value+='[img]'+src+'[/img]';
	
}