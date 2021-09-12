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
			_opener(this.alt);
			
		};
		}
	
	
};
function _opener(src){
	var faceimg = opener.document.getElementById('faceimg');
	faceimg.src = src;
	opener.document.reg.face.value=src;
	
}