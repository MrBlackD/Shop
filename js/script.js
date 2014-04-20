window.onload=function(){
	var newimg = document.getElementById("newimg");
	var flag =document.getElementById("change");
	if(newimg&&flag)
	{
		flag.onclick=function(){
			flag.setAttribute("disabled",1);
			newimg.parentNode.innerHTML="<br><input type='file' name='img'>"
		}
	}
}
